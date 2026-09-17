#!/usr/bin/env python3
"""Interleave Lighthouse runs against already-running revision previews.

Example: CHROME_PATH=/path/to/chrome python3 performance/benchmark.py \
  --lighthouse /path/to/lighthouse/cli/index.js --target round1=http://localhost:8086/en \
  --target pre-round2=http://localhost:8087/en --target current=http://localhost:8088/en \
  --target candidate=http://localhost:8085/en --output performance/runs/day1

Use the same URLs/settings the following day with a new output directory.
Local PHP serves uncompressed assets: these comparisons are diagnostic, not
production release gates. Do not pool local results with PSI or field data.
"""
import argparse
import base64
import json
import os
from pathlib import Path
import statistics
import signal
import subprocess
import sys


def run_lighthouse(command):
    """Clean up the CLI and its browser children when a run is interrupted."""
    process = subprocess.Popen(command, env=os.environ, start_new_session=True)
    try:
        code = process.wait(timeout=180)
        if code:
            raise subprocess.CalledProcessError(code, command)
    finally:
        # Snapshot descendants before terminating the CLI, while parent links exist.
        pairs = [tuple(map(int, line.split())) for line in
                 subprocess.check_output(['ps', '-eo', 'pid=,ppid='], text=True).splitlines()]
        owned = {process.pid}
        while True:
            children = {pid for pid, parent in pairs if parent in owned}
            if children <= owned:
                break
            owned.update(children)
        for pid in reversed(sorted(owned)):
            try:
                os.kill(pid, signal.SIGTERM)
            except ProcessLookupError:
                pass
        try:
            process.wait(timeout=10)
        except subprocess.TimeoutExpired:
            process.kill()
            process.wait()


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--lighthouse', required=True)
    parser.add_argument('--target', action='append', required=True)
    parser.add_argument('--output', type=Path, required=True)
    parser.add_argument('--runs', type=int, default=5)
    parser.add_argument('--device', action='append', choices=['mobile', 'desktop'])
    args = parser.parse_args()
    signal.signal(signal.SIGTERM, lambda signum, frame: sys.exit(128 + signum))
    if args.runs < 1:
        parser.error('--runs must be positive')
    if any(args.output.glob('*.json')):
        parser.error('output already contains reports; use a new directory')
    args.output.mkdir(parents=True, exist_ok=True)
    targets = [target.split('=', 1) for target in args.target]
    rows = []
    devices = args.device or ['mobile', 'desktop']
    for run in range(1, args.runs + 1):
        for device in devices:
            # Rotate revision order to reduce order/temperature bias.
            offset = (run - 1) % len(targets)
            for name, url in targets[offset:] + targets[:offset]:
                output = args.output / f'{name}-{device}-{run}.json'
                command = ['node', args.lighthouse, url, '--quiet', '--output=json',
                           '--only-categories=performance', '--save-assets',
                           '--chrome-flags=--headless --no-sandbox --disable-dev-shm-usage',
                           '--no-enable-error-reporting', '--max-wait-for-load=35000',
                           '--extra-headers={"Accept-Language":"en-US,en;q=0.9"}',
                           '--output-path=' + str(output)]
                if device == 'desktop':
                    command.append('--preset=desktop')
                print(f'Running {name} {device} {run}/{args.runs}', flush=True)
                run_lighthouse(command)
                report = json.loads(output.read_text())
                if report.get('runtimeError'):
                    raise RuntimeError(report['runtimeError'])
                screenshot = report['audits'].get('final-screenshot', {}).get('details', {}).get('data')
                if screenshot:
                    output.with_suffix('.jpg').write_bytes(base64.b64decode(screenshot.split(',', 1)[1]))
                row = dict(name=name, device=device, run=run, url=url,
                           timestamp=report['fetchTime'], version=report['lighthouseVersion'],
                           settings=report['configSettings'], warnings=report.get('runWarnings', []))
                for key in ['largest-contentful-paint', 'total-blocking-time', 'cumulative-layout-shift']:
                    row[key] = report['audits'][key]['numericValue']
                rows.append(row)
                (args.output / 'measurements.json').write_text(json.dumps(rows, indent=2))
    lines = ['# Local diagnostic benchmark', '', '| Revision | Device | Runs | Median LCP ms | Median TBT ms | Max CLS |', '|---|---|---:|---:|---:|---:|']
    for name, _ in targets:
        for device in devices:
            group = [row for row in rows if row['name'] == name and row['device'] == device]
            lcp = statistics.median(r['largest-contentful-paint'] for r in group)
            tbt = statistics.median(r['total-blocking-time'] for r in group)
            cls = max(r['cumulative-layout-shift'] for r in group)
            lines.append(f'| {name} | {device} | {len(group)} | {lcp:.0f} | {tbt:.0f} | {cls:.3f} |')
    (args.output / 'summary.md').write_text('\n'.join(lines) + '\n')


if __name__ == '__main__':
    main()
