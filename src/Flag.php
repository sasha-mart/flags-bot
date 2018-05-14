<?php

namespace SashaMart\FlagsBot;

class Flag
{
    public $countryName;
    public $unicodeString;
    private $_file = '';
    private $_instances = [];

    public function __construct(string $countryName)
    {
        $this->countryName = $countryName;

        if (!file_exists('unicode_symbols.txt'))
            $this->_putUnicodeData();
        else
            $this->_file = file_get_contents('unicode_symbols.txt');
    }

    private function _putUnicodeData(): void
    {
        if ($this->_file = file_get_contents('https://unicode.org/Public/emoji/5.0/emoji-sequences.txt')) {
            file_put_contents('unicode_symbols.txt', $this->_file);
        }
    }

    public function getUtf8(): string
    {
        $hex = $this->_findInFile();
        $symbs = explode(' ', $hex);
	    $result = '';
	    foreach ($symbs as $symb) {
	    	if (!empty($symb))
			    $result .= $this->encodeToUtf8(hexdec($symb));
        }

        return $result;
    }

	public function encodeToUtf8($num)
	{
		if($num<=0x7F)       return chr($num);
		if($num<=0x7FF)      return chr(($num>>6)+192).chr(($num&63)+128);
		if($num<=0xFFFF)     return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);
		if($num<=0x1FFFFF)   return chr(($num>>18)+240).chr((($num>>12)&63)+128).chr((($num>>6)&63)+128).chr(($num&63)+128);
		return '';
	}

    private function _findInFile(): string
    {
        $pos = mb_strpos($this->_file, $this->countryName);
        $string = mb_substr($this->_file, 0, $pos);
        $posStartUnicode = mb_strripos($string, "\n");
        $string = mb_substr($string, $posStartUnicode, $pos - $posStartUnicode);
        $posEndUnicode = mb_strpos($string, ';');

        return trim(mb_substr($string, 0, $posEndUnicode));
    }
}
