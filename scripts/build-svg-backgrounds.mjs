import { readFile, writeFile } from 'node:fs/promises';

// The host picture media query chooses these frozen SVGs. An object-fit:cover
// image can have a different SVG viewport than the page, so an internal width
// query alone cannot enforce the page's mobile/reduced-motion policy.
for (const name of ['glowing-bg', 'light-bg']) {
  const source = new URL(`../public/images/background/${name}.svg`, import.meta.url);
  const svg = await readFile(source, 'utf8');
  const frozen = svg.replace('</style>', '.glow { animation-play-state: paused !important; will-change: auto !important; }\n  </style>');
  await writeFile(new URL(`../public/images/background/${name}-still.svg`, import.meta.url), frozen);
}
