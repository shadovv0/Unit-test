<?php

function reverseWords($text)
{
    $parts = preg_split('/(\W+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    
    $result = [];
    foreach ($parts as $part) {
        if (preg_match('/\p{L}/u', $part)) {
            $result[] = reverseWord($part);
        } else {
            $result[] = $part;
        }
    }
    
    return implode('', $result);
}

function reverseWord($word)
{
    $len = mb_strlen($word, 'UTF-8');
    if ($len <= 1) {
        return $word;
    }
    
    $chars = [];
    for ($i = 0; $i < $len; $i++) {
        $chars[] = mb_substr($word, $i, 1, 'UTF-8');
    }
    
    $letterSegments = [];
    $currentSegment = '';
    $segmentIsLetters = false;
    
    foreach ($chars as $char) {
        $isLetter = preg_match('/\p{L}/u', $char);
        
        if ($isLetter !== $segmentIsLetters && $currentSegment !== '') {
            $letterSegments[] = [
                'text' => $currentSegment,
                'isLetters' => $segmentIsLetters
            ];
            $currentSegment = '';
        }
        
        $currentSegment .= $char;
        $segmentIsLetters = $isLetter;
    }
    
    if ($currentSegment !== '') {
        $letterSegments[] = [
            'text' => $currentSegment,
            'isLetters' => $segmentIsLetters
        ];
    }
    
    $result = '';
    foreach ($letterSegments as $segment) {
        if ($segment['isLetters']) {
            $result .= reverseLettersPreservingCase($segment['text']);
        } else {
            $result .= $segment['text'];
        }
    }
    
    return $result;
}

function reverseLettersPreservingCase($str)
{
    $len = mb_strlen($str, 'UTF-8');
    
    $letters = [];
    $nonLetters = [];
    $casePattern = [];
    
    for ($i = 0; $i < $len; $i++) {
        $char = mb_substr($str, $i, 1, 'UTF-8');
        $isLetter = preg_match('/\p{L}/u', $char);
        
        $casePattern[$i] = $isLetter ? (mb_strtolower($char, 'UTF-8') === $char ? 'lower' : 'upper') : null;
        
        if ($isLetter) {
            $letters[] = mb_strtolower($char, 'UTF-8');
        } else {
            $nonLetters[$i] = $char;
        }
    }
    
    if (empty($letters)) {
        return $str;
    }
    
    $reversedLetters = array_reverse($letters);
    
    $result = '';
    $letterIndex = 0;
    
    for ($i = 0; $i < $len; $i++) {
        if (isset($nonLetters[$i])) {
            $result .= $nonLetters[$i];
        } else {
            $newChar = $reversedLetters[$letterIndex];
            if ($casePattern[$i] === 'upper') {
                $newChar = mb_strtoupper($newChar, 'UTF-8');
            }
            $result .= $newChar;
            $letterIndex++;
        }
    }
    
    return $result;
}