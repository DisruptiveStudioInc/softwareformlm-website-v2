<?php

$markdownDirectory = __DIR__ . '/md';

$normalizeTermsText = static function (string $text): string {
  $text = str_replace(['\\.', '**'], ['.', ''], trim($text));
  return preg_replace('/\s+/', ' ', $text) ?? $text;
};

$isStandaloneSubheading = static function (string $line): bool {
  if (preg_match('/[.?!;:]$/', $line)) {
    return false;
  }

  if (preg_match('/^\d+\.\d+/', $line)) {
    return false;
  }

  $words = preg_split('/\s+/', trim($line));
  $wordCount = is_array($words) ? count($words) : 0;

  if ($wordCount === 0 || $wordCount > 8) {
    return false;
  }

  return preg_match('/^[\p{Lu}0-9][\p{L}0-9\/().,&\'" -]+$/u', $line) === 1;
};

$parseTermsMarkdown = static function (string $markdown) use ($normalizeTermsText, $isStandaloneSubheading): array {
  $terms = [
    'page' => 'Terms and Conditions',
    'updated_at' => '',
    'intro' => [],
    'sections' => [],
  ];

  if (trim($markdown) === '') {
    return $terms;
  }

  $lines = preg_split("/\r\n|\n|\r/", trim($markdown)) ?: [];
  $currentSection = null;
  $paragraphBuffer = [];
  $listBuffer = [];
  $expectList = false;

  $pushBlock = static function (array $block) use (&$currentSection, &$terms): void {
    if ($currentSection !== null) {
      $currentSection['blocks'][] = $block;
      return;
    }

    if (($block['type'] ?? null) === 'paragraph') {
      $terms['intro'][] = $block['text'];
    }
  };

  $flushParagraph = static function () use (&$paragraphBuffer, &$expectList, $normalizeTermsText, $pushBlock): void {
    if ($paragraphBuffer === []) {
      return;
    }

    $text = $normalizeTermsText(implode(' ', $paragraphBuffer));
    $pushBlock([
      'type' => 'paragraph',
      'text' => $text,
    ]);

    $paragraphBuffer = [];
    $expectList = str_ends_with($text, ':');
  };

  $flushList = static function () use (&$listBuffer, &$expectList, $pushBlock): void {
    if ($listBuffer === []) {
      return;
    }

    $pushBlock([
      'type' => 'list',
      'items' => $listBuffer,
    ]);

    $listBuffer = [];
    $expectList = false;
  };

  $flushBlocks = static function () use ($flushParagraph, $flushList): void {
    $flushParagraph();
    $flushList();
  };

  foreach ($lines as $line) {
    $line = trim($line);

    if ($line === '') {
      $flushBlocks();
      continue;
    }

    if (preg_match('/^#\s+\*\*(.+)\*\*$/', $line, $matches) === 1) {
      $terms['page'] = $normalizeTermsText($matches[1]);
      continue;
    }

    if (preg_match('/^\*\*(Last Updated|Última actualización):\s*(.+?)\*\*$/u', $line, $matches) === 1) {
      $terms['updated_at'] = $normalizeTermsText($matches[1] . ': ' . $matches[2]);
      continue;
    }

    if (preg_match('/^###\s+\*\*(.+)\*\*$/', $line, $matches) === 1) {
      $flushBlocks();

      if ($currentSection !== null) {
        $terms['sections'][] = $currentSection;
      }

      $currentSection = [
        'title' => $normalizeTermsText($matches[1]),
        'blocks' => [],
      ];
      continue;
    }

    if (preg_match('/^\*\*(.+)\*\*$/', $line, $matches) === 1) {
      $flushBlocks();
      $pushBlock([
        'type' => 'subheading',
        'text' => $normalizeTermsText($matches[1]),
      ]);
      continue;
    }

    if ($isStandaloneSubheading($line)) {
      $flushBlocks();
      $pushBlock([
        'type' => 'subheading',
        'text' => $normalizeTermsText($line),
      ]);
      continue;
    }

    if (preg_match('/^[-*]\s+(.+)$/', $line, $matches) === 1 || preg_match('/^[a-z]\.\s+(.+)$/i', $line, $matches) === 1) {
      $flushParagraph();
      $listBuffer[] = $normalizeTermsText($matches[1]);
      $expectList = true;
      continue;
    }

    if ($expectList) {
      $listBuffer[] = $normalizeTermsText($line);
      continue;
    }

    $flushList();
    $paragraphBuffer[] = $line;
  }

  $flushBlocks();

  if ($currentSection !== null) {
    $terms['sections'][] = $currentSection;
  }

  return $terms;
};

$loadTermsMarkdown = static function (string $filename) use ($markdownDirectory, $parseTermsMarkdown): array {
  $path = $markdownDirectory . '/' . $filename;
  $markdown = file_exists($path) ? file_get_contents($path) : '';

  return $parseTermsMarkdown($markdown === false ? '' : $markdown);
};

return [
  'es' => $loadTermsMarkdown('terms-es.md'),
  'en' => $loadTermsMarkdown('terms.md'),
];
