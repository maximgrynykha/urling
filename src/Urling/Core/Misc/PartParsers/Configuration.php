<?php

namespace Urling\Core\Misc\PartParsers;

use Urling\Core\Part;
use Urling\Core\Misc\PartParsers\Storages\NamesStorage;
use Urling\Core\Misc\PartParsers\Storages\GluingsStorage;
use Urling\Core\Misc\PartParsers\Storages\AliasesStorage;

/**
 * Facade for configuring each specific component of Url
 */
final class Configuration
{
    private string $component;

    public function __construct(Part $component)
    {
        $this->component = get_class($component);
    }

    /**
     * Factory method to get name for specific component of Url
     * 
     * @return string
     */
    public function getName(): string
    {
        return NamesStorage::getName($this->component);
    }

    /**
     * Factory method to get gluing for specific component of Url
     * 
     * @return string
     */
    public function getGluing(): string
    {
        return GluingsStorage::getGluing($this->component);
    }

    /**
     * Factory method to get aliases for specific component of Url
     * 
     * @return string
     */
    public function getAliases(): string
    {
        return AliasesStorage::getAliases($this->component);
    }
}
