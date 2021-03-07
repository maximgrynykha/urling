<?php

namespace Ismaxim\Urling\PartParsers;

final class FragmentParser extends URLPartParser
{
    // code here

    public function createSlug(string $string, string $separator = " ", string $connector = "-") : string
    {
        // Contains only letters in unicode and "$connector"
        $prepared_string = preg_replace("/\PL{$connector}+|[^a-zA-Z]/u", $separator, $string);

        // Replace all whitespaces to single whitespace
        $prepared_string = preg_replace("/\s+/", $separator, mb_strtolower(trim($prepared_string)));

        // Replace separation between part with connector
        $slug = str_replace($separator, $connector, mb_strtolower(trim($prepared_string)));

        return $slug;
    }
}