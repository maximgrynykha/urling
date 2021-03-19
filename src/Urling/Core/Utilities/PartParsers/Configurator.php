<?php

namespace Urling\Core\Utilities\PartParsers;

use Urling\Core\Part;
use Urling\Core\Utilities\PartParsers\Storages\NamesStorage;
use Urling\Core\Utilities\PartParsers\Storages\GluingsStorage;
use Urling\Core\Utilities\PartParsers\Storages\AliasesStorage;

trait Configurator
{
    public static function getName(Part $part_parser): string
    {
        return NamesStorage::getName(get_class($part_parser));
    }

    public static function getGluing(Part $part_parser): string
    {
        return GluingsStorage::getGluing(get_class($part_parser));
    }

    public static function getAliases(Part $part_parser): string
    {
        return AliasesStorage::getAliases(get_class($part_parser));
    }
}
