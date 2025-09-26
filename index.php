<?php

function reverseWords($text)
{
    if ($text === '') {
        return '';
    }

    preg_match_all('/\p{L}+|\P{L}+/u', $text, $matches);
    $parts = $matches[0];

    $result = [];
    foreach ($parts as $part) {
        if (preg_match('/^\p{L}+$/u', $part)) {
            $result[] = reverseWordPreservingCase($part);
        } else {
            $result[] = $part;
        }
    }

    return implode('', $result);
}

function reverseWordPreservingCase($word)
{
    $chars = mb_str_split($word, 1, 'UTF-8');
    $length = count($chars);

    $isUpper = [];
    for ($i = 0; $i < $length; $i++) {
        $char = $chars[$i];
        $lower = mb_strtolower($char, 'UTF-8');
        $isUpper[$i] = ($char !== $lower);
    }

    $reversed = array_reverse($chars);

    $output = [];
    for ($i = 0; $i < $length; $i++) {
        $char = $reversed[$i];
        if ($isUpper[$i]) {
            $output[] = mb_strtoupper($char, 'UTF-8');
        } else {
            $output[] = mb_strtolower($char, 'UTF-8');
        }
    }

    return implode('', $output);
}