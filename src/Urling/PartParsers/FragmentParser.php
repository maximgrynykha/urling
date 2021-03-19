<?php

namespace Urling\PartParsers;

use Urling\Core\Part;

final class FragmentParser extends Part
{
    // code here

    /**
     * @param string $context
     * @param string $separator
     * @param string $connector
     *
     * @return string
     */
    public function createSlug(string $context, string $separator = " ", string $connector = "-"): string
    {
        // Contains only letters in unicode and "$connector"
        $prepared_context = preg_replace("/\PL{$connector}+|[^a-zA-Z]/u", $separator, $context);

        // Replace all whitespaces to single whitespace
        $prepared_context = preg_replace("/\s+/", $separator, mb_strtolower(trim((string) $prepared_context)));

        // Replace separation between part with connector
        $slug = str_replace($separator, $connector, mb_strtolower(trim((string) $prepared_context)));

        return $slug;
    }
}
