<?php

function reverseWords($text)
{
    if ($text === '') {
        return '';
    }
    
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
    
    $segments = [];
    $currentSegment = '';
    $currentType = null;
    
    foreach ($chars as $char) {
        $isLetter = preg_match('/\p{L}/u', $char);
        
        if ($currentType === null) {
            $currentType = $isLetter;
        }
        
        if ($isLetter !== $currentType) {
            $segments[] = [
                'text' => $currentSegment,
                'isLetters' => $currentType
            ];
            $currentSegment = '';
            $currentType = $isLetter;
        }
        
        $currentSegment .= $char;
    }
    
    if ($currentSegment !== '') {
        $segments[] = [
            'text' => $currentSegment,
            'isLetters' => $currentType
        ];
    }
    
    $result = '';
    foreach ($segments as $segment) {
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
    
    if ($len === 0) {
        return $str;
    }
    
    $letters = [];
    $casePattern = [];
    
    for ($i = 0; $i < $len; $i++) {
        $char = mb_substr($str, $i, 1, 'UTF-8');
        $isLetter = preg_match('/\p{L}/u', $char);
        
        if ($isLetter) {
            $letters[] = mb_strtolower($char, 'UTF-8');
            $casePattern[$i] = (mb_strtolower($char, 'UTF-8') === $char) ? 'lower' : 'upper';
        } else {
            $casePattern[$i] = 'non-letter';
        }
    }
    
    if (empty($letters)) {
        return $str;
    }
    
    $reversedLetters = array_reverse($letters);
    $result = '';
    $letterIndex = 0;
    
    for ($i = 0; $i < $len; $i++) {
        if ($casePattern[$i] === 'non-letter') {
            $result .= mb_substr($str, $i, 1, 'UTF-8');
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