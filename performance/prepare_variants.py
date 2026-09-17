#!/usr/bin/env python3
"""Prepare disposable, single-change diagnostic previews; never edit the baseline.

python3 performance/prepare_variants.py --output /tmp/sfmlm-diagnostics
Serve each directory with php -S, then use benchmark.py --device mobile.
Tracked dependencies come from the revision; missing vendor/.env use local symlinks.
"""
import argparse
import io
from pathlib import Path
import re
import shutil
import subprocess
import tarfile

ROOT = Path(__file__).resolve().parents[1]


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--output', type=Path, required=True)
    parser.add_argument('--baseline', default='4d4fc18')
    args = parser.parse_args()
    archive = subprocess.check_output(['git', 'archive', args.baseline], cwd=ROOT)
    for variant in ['fonts', 'hero', 'motion', 'tracking']:
        target = args.output / variant
        target.mkdir(parents=True, exist_ok=False)
        with tarfile.open(fileobj=io.BytesIO(archive)) as source:
            source.extractall(target, filter='data')
        for name in ['vendor', '.env']:
            if not (target / name).exists():
                (target / name).symlink_to(ROOT / name, target_is_directory=name == 'vendor')
        header = target / 'app/Views/layouts/header.php'
        home = target / 'app/Views/templates/home.php'
        if variant == 'fonts':
            header.write_text(re.sub(r'^  <link rel="preload".*?as="font".*\n', '', header.read_text(), flags=re.M))
        elif variant == 'hero':
            shutil.copyfile(ROOT / 'src/helpers.php', target / 'src/helpers.php')
            index = target / 'index.php'
            code = index.read_text()
            start = code.index('  // Preload only')
            end = code.index('  $method =', start)
            index.write_text(code[:start] + code[end:])
            header.write_text(header.read_text().replace('  <!-- CSS -->', '  <?= responsive_image_preload($heroImage, $heroSizes) ?>\n  <!-- CSS -->'))
            code = home.read_text()
            current = (ROOT / 'app/Views/templates/home.php').read_text()
            definitions = current[current.index('// Match the square'):current.index("require __DIR__ . '/../layouts/header.php';")]
            code = code.replace("require __DIR__ . '/../layouts/header.php';", definitions + "require __DIR__ . '/../layouts/header.php';")
            code = code.replace("responsive_image('/public/images/home/bo-computer.webp'", 'responsive_image($heroImage')
            code = code.replace("'(min-width: 1088px) 45vw, min(80vw, 576px)'", '$heroSizes')
            home.write_text(code)
        elif variant == 'motion':
            for name in ['glowing-bg', 'light-bg', 'glowing-bg-still', 'light-bg-still']:
                shutil.copyfile(ROOT / f'public/images/background/{name}.svg', target / f'public/images/background/{name}.svg')
            current = (ROOT / 'app/Views/templates/home.php').read_text()
            picture = re.search(r'    <picture>.*?</picture>', current, re.S)[0]
            home.write_text(re.sub(r'    <img class="background"[^>]*glowing-bg.svg[^>]*>', lambda _: picture, home.read_text(), count=1))
            shutil.copyfile(ROOT / 'app/Views/components/fixedBackground.php', target / 'app/Views/components/fixedBackground.php')
        else:
            shutil.copyfile(ROOT / 'public/assets/js/third-parties.js', target / 'public/assets/js/third-parties.js')
        print(target)


if __name__ == '__main__':
    main()
