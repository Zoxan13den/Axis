<?php

namespace App\Helpers;

if (!function_exists('transformEnumNames')) {
     function transformEnumNames( $enum): string
    {
        dd($enum);

//        foreach ($enum->names as $name){
//
//        }
        // Преобразование текста
        $text = str_replace('_', ' ', $text);
        $text = strtolower($text);
        $text = ucfirst($text);

        return $text;
    }
}
