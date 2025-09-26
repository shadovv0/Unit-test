<?php

require_once __DIR__ . '/index.php';

use PHPUnit\Framework\TestCase;

class ReverseWordsTest extends TestCase
{
    public function testReverseWords()
    {
        $this->assertEquals('Tac', reverseWords('Cat'));
        $this->assertEquals('Ьшым', reverseWords('Мышь'));
        $this->assertEquals('esuOh', reverseWords('houSe'));
        $this->assertEquals('кимОД', reverseWords('домИК'));
        $this->assertEquals('tnAhPele', reverseWords('elEpHant'));
        
        $this->assertEquals('tac,', reverseWords('cat,'));
        $this->assertEquals('Амиз:', reverseWords('Зима:'));
        $this->assertEquals("si 'dloc' won", reverseWords("is 'cold' now"));
        $this->assertEquals('отэ «Кат» "отсорп"', reverseWords('это «Так» "просто"'));
        
        $this->assertEquals('driht-trap', reverseWords('third-part'));
        $this->assertEquals('nac`t', reverseWords('can`t'));
        
    }
    
    public function testReverseWordsWithMixedContent()
    {
        $this->assertEquals(
            'отэ Ьшым esuOh кимОД tnAhPele!', 
            reverseWords('это Мышь houSe домИК elEpHant!')
        );
        
        $this->assertEquals(
            'driht-trap nac`t отэ "Кат" si-dloc-won.', 
            reverseWords('third-part can`t это "Так" is-cold-now.')
        );
    }
    
    public function testWordsWithMultipleDelimiters()
    {
        $this->assertEquals('driht-part-second', reverseWords('third-trap-dnoces'));
        $this->assertEquals('nac`t-driht`part', reverseWords('can`t-third`trap'));
    }
    
    public function testComplexCasePreservation()
    {
        $this->assertEquals('AbCdEf', reverseWords('FeDcBa')); 
        $this->assertEquals('aBcDeF', reverseWords('fEdCbA'));
        $this->assertEquals('ТеВиРп', reverseWords('ПрИвЕт'));
    }
    
}