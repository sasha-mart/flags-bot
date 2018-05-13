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

    public function getUnicode(): string
    {
        $result = $this->_findInFile();

        return $result;
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
