import json
from pathlib import Path
import tempfile
import unittest
from unittest.mock import patch

import extract_reports as extractor


class ExtractionTest(unittest.TestCase):
    def extract(self, source):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            path = root / 'report.html'
            path.write_text(source)
            with patch.object(extractor, 'ROOT', root):
                return list(extractor.extract(path))

    def report(self, url):
        return dict(fetchTime='2026-09-16T10:00:00.000Z', finalUrl=url,
                    configSettings={'formFactor': 'mobile'}, lighthouseVersion='13.4.1',
                    audits={metric: {'numericValue': i} for i, metric in enumerate(extractor.METRICS)})

    def test_json_values_preserve_url_device_and_precision(self):
        rows = self.extract(json.dumps(json.dumps(self.report('https://softwareformlm.com/en'), indent=2)))
        self.assertEqual(rows[0]['device'], 'mobile')
        self.assertEqual(rows[0]['timestamp_precision'], 'millisecond')
        self.assertEqual(rows[0]['total-blocking-time'], 2)

    def test_visible_metrics_override_unrelated_embedded_state(self):
        source = json.dumps(json.dumps(self.report('https://unrelated.example/'), indent=2))
        for metric, value in zip(extractor.METRICS, ['2.1&nbsp;s', '4.7 s', '380 ms', '0.015']):
            source += f'<div class="lh-metric lh-metric--fail" id="{metric}"><div class="lh-metric__value">{value}</div></div>'
        source += '<ul class="lh-meta__items">Captured at Sep 16, 2026, 1:01 PM GMT-5 Emulated Moto G Power with Lighthouse 13.4.1</ul>'
        source += '<div>Initial Navigation</div><div title="https://softwareformlm.com/en">Page</div>'
        row = self.extract(source)[0]
        self.assertEqual(row['largest-contentful-paint'], 4700)
        self.assertEqual(row['url'], 'https://softwareformlm.com/en')
        self.assertEqual(row['source'], 'visible-rounded')
        self.assertEqual(row['conflicts'], ['https://unrelated.example/'])

    def test_foreign_json_is_not_counted(self):
        self.assertEqual(self.extract(json.dumps(json.dumps(self.report('https://unrelated.example/'), indent=2))), [])


if __name__ == '__main__':
    unittest.main()
