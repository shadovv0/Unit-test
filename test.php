<?php

declare(strict_types=1);

require_once __DIR__ . '/index.php';

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ReverseWordsTest extends TestCase
{
    #[DataProvider('reverseWordsProvider')]
    public function testReverseWords(string $expected, string $input): void
    {
        $this->assertSame($expected, reverseWords($input));
    }

    public static function reverseWordsProvider(): array
    {
        return [
            'latin title case' => ['Tac', 'Cat'],
            'cyrillic' => ['Ьшым', 'Мышь'],
            'mixed latin' => ['esuOh', 'houSe'],
            'mixed cyrillic' => ['кимОД', 'домИК'],
            'longer mixed latin' => ['tnAhPele', 'elEpHant'],
            'trailing comma' => ['tac,', 'cat,'],
            'trailing colon' => ['Амиз:', 'Зима:'],
            'quotes and spaces' => ["si 'dloc' won", "is 'cold' now"],
            'guillemets and quotes' => ['отэ «Кат» "отсорп"', 'это «Так» "просто"'],
            'hyphen' => ['driht-trap', 'third-part'],
            'backtick' => ['nac`t', 'can`t'],
            'sentence mix' => [
                'отэ Ьшым esuOh кимОД tnAhPele!',
                'это Мышь houSe домИК elEpHant!',
            ],
            'mixed delimiters' => [
                'driht-trap nac`t отэ "Кат" si-dloc-won.',
                'third-part can`t это "Так" is-cold-now.',
            ],
            'multiple hyphens' => ['driht-part-second', 'third-trap-dnoces'],
            'mixed hyphen and backtick' => ['nac`t-driht`part', 'can`t-third`trap'],
            'alternating upper' => ['AbCdEf', 'FeDcBa'],
            'alternating lower first' => ['aBcDeF', 'fEdCbA'],
            'cyrillic alternating' => ['ТеВиРп', 'ПрИвЕт'],
            'empty string' => ['', ''],
            'punctuation only' => ['!!!', '!!!'],
            'digits only' => ['123', '123'],
            'single letter' => ['A', 'A'],
            'multiple spaces' => ['tac  od', 'cat  do'],
            'letters then digits' => ['cba123', 'abc123'],
        ];
    }
}
