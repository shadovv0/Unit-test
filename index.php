<?php

declare(strict_types=1);

function reverseWords(string $text): string
{
    return preg_replace_callback(
        '/\p{L}+/u',
        static fn (array $matches): string => reverseWordPreservingCase($matches[0]),
        $text
    ) ?? '';
}

function reverseWordPreservingCase(string $word): string
{
    $chars = mb_str_split($word, 1, 'UTF-8');
    $reversed = array_reverse($chars);
    $result = '';

    foreach ($reversed as $i => $char) {
        $original = $chars[$i];
        $originalUpper = mb_strtoupper($original, 'UTF-8');
        $originalLower = mb_strtolower($original, 'UTF-8');
        $isUpper = $original === $originalUpper && $original !== $originalLower;

        $result .= $isUpper
            ? mb_strtoupper($char, 'UTF-8')
            : mb_strtolower($char, 'UTF-8');
    }

    return $result;
}
