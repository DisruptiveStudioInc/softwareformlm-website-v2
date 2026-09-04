import { readdir, stat } from "node:fs/promises";
import { parse, relative } from "node:path";
import { fileURLToPath } from "node:url";
import sharp from "sharp";

const root = new URL("../public/images/", import.meta.url);

async function needsBuild(inputPath, outputPath) {
  try {
    const [inputStats, outputStats] = await Promise.all([stat(inputPath), stat(outputPath)]);
    return outputStats.mtimeMs < inputStats.mtimeMs;
  } catch {
    return true;
  }
}
const targets = [
  { directory: "home", match: /^(bo-computer|bo-mobile)\.webp$/, widths: [384, 640, 850] },
  { directory: "services/solutions", match: /(?:_1_big|mlm_desktop)\.webp$/, widths: [480, 768] },
  { directory: "services/ips", match: /_hero\.webp$/, widths: [480, 768] },
  { directory: "blog", match: /\.webp$/, widths: [480, 960] },
  { directory: "background", match: /^blog-cover-[0-2]\.webp$/, widths: [480, 960] },
];

for (const target of targets) {
  const directoryUrl = new URL(`${target.directory}/`, root);
  let entries = [];
  try {
    entries = await readdir(directoryUrl, { withFileTypes: true });
  } catch {
    continue;
  }

  for (const entry of entries) {
    if (!entry.isFile() || !target.match.test(entry.name) || entry.name.includes("-w")) continue;
    const input = new URL(entry.name, directoryUrl);
    const inputPath = fileURLToPath(input);
    const metadata = await sharp(inputPath).metadata();
    if (!metadata.width) continue;
    const parsed = parse(entry.name);

    let generated = false;
    for (const width of target.widths.filter((value) => value <= metadata.width)) {
      const base = fileURLToPath(new URL(`${parsed.name}-w${width}`, directoryUrl));
      const avifPath = `${base}.avif`;
      const webpPath = `${base}.webp`;
      const jobs = [];

      if (await needsBuild(inputPath, avifPath)) {
        jobs.push(sharp(inputPath).resize({ width, withoutEnlargement: true }).avif({ quality: 58, effort: 5 }).toFile(avifPath));
      }
      if (await needsBuild(inputPath, webpPath)) {
        jobs.push(sharp(inputPath).resize({ width, withoutEnlargement: true }).webp({ quality: 76, effort: 5 }).toFile(webpPath));
      }

      if (jobs.length > 0) {
        generated = true;
        await Promise.all(jobs);
      }
    }
    if (generated) {
      console.log(`optimized ${relative(fileURLToPath(root), inputPath)} (${metadata.width}px)`);
    }
  }
}
