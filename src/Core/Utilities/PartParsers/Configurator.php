<?php

namespace Ismaxim\Urling\Core\Utilities\PartParsers;

use Ismaxim\Urling\PartParsers\URLPartParser;
use Ismaxim\Urling\Core\Utilities\PartParsers\Storages\NamesStorage;
use Ismaxim\Urling\Core\Utilities\PartParsers\Storages\GluingsStorage;
use Ismaxim\Urling\Core\Utilities\PartParsers\Storages\AliasesStorage;

trait Configurator
{
    public static function getName(URLPartParser $part_parser) : ?string
    {
        return NamesStorage::getName(get_class($part_parser));
    }

    public static function getGluing(URLPartParser $part_parser) : ?string
    {
        return GluingsStorage::getGluing(get_class($part_parser));
    }

    public static function getAliases(URLPartParser $part_parser) : ?string
    {
        return AliasesStorage::getAliases(get_class($part_parser));
    }
}