<?php

namespace App\Traits;

trait SpecialCharacterTrait
{
    public $chars = ['ç', 'Ç', 'ń', 'ñ', 'Ñ', 'Ń', 'ę', 'é', 'è', 'ę', 'ê', 'ē', 'ė', 'ë', 'É', 'È', 'Ê', 'Ę', 'Ë', 'Ė', 'æ', 'â', 'ä', 'æ', 'å', 'á', 'à', 'Å', 'Â', 'Ä', 'Æ', 'Á', 'À', 'ï', 'ì', 'í', 'î', 'ī', 'ī', 'į', 'Ï', 'Í', 'Ì', 'Î', 'Ī', 'Į', 'ú', 'ü', 'û', 'ù', 'ū', 'Ú', 'Ü', 'Û', 'Ù', 'Ū', 'ó', 'ö', 'ô', 'ò', 'õ', 'œ', 'ø', 'ō', 'Ó', 'Ö', 'Ô', 'Ò', 'Õ', 'Œ', 'Ø', 'Ō', '/', '\\'];

    public $replace = ['c', 'C', 'n', 'n', 'N', 'N', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E', 'E', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A', 'A', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I', 'I', 'u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', ' ', ' '];

    public function replaceSpecialCharacters(string $string): string
    {
        return str_replace($this->chars, $this->replace, $string);
    }
}
