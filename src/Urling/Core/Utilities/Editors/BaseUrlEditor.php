<?php

namespace Urling\Core\Utilities\Editors;

use Urling\Core\Exceptions\EditException;
use Urling\Core\Part;
use Urling\Core\Utilities\PartParsers\Storages\AliasesStorage;
use Urling\Core\Utilities\PartParsers\Storages\NamespacesStorage;
use Urling\Core\Utilities\UrlParser;

trait BaseUrlEditor
{
    /**
     * @param string|null $value
     *
     * @return string|null
     */
    public function add(?string $value): ?string
    {
        if ($this->get()) {
            throw new EditException("URL already added. Use 'update'.");
        }

        $this->addParts($value);

        return $this->get();
    }

    /**
     * Return current state of URL
     *
     * @param bool $origin
     *
     * @return string|null
     */
    public function get(bool $origin = false): ?string
    {
        $url = $this->getFullUrl();

        return (!$origin) ? $url : $this->origin;
    }

    /**
     * @param string|null $value
     *
     * @return string|null
     */
    public function update(?string $value): ?string
    {
        $this->updateParts($value);

        return $this->get();
    }

    /**
     * @return string|null
     */
    public function delete(): ?string
    {
        $this->deleteParts();

        return $this->get();
    }

    /**
     * @param string|null $url
     *
     * @return void
     */
    protected function addParts(?string $url): void
    {
        $lexicon = UrlParser::getPartsFromUrl($url);

        $this->scheme->add($lexicon["scheme"]);
        $this->host->add($lexicon["host"]);
        $this->port->add($lexicon["port"]);
        $this->user->add($lexicon["user"]);
        $this->pass->add($lexicon["pass"]);
        $this->path->add($lexicon["path"]);
        $this->query->add($lexicon["query"]);
        $this->fragment->add($lexicon["fragment"]);
    }

    /**
     * @param string|null $url
     *
     * @return void
     */
    protected function updateParts(?string $url): void
    {
        $lexicon = UrlParser::getPartsFromUrl($url);

        $this->scheme->update($lexicon["scheme"]);
        $this->host->update($lexicon["host"]);
        $this->port->update($lexicon["port"]);
        $this->user->update($lexicon["user"]);
        $this->pass->update($lexicon["pass"]);
        $this->path->update($lexicon["path"]);
        $this->query->update($lexicon["query"]);
        $this->fragment->update($lexicon["fragment"]);
    }

    /**
     * @return void
     */
    protected function deleteParts(): void
    {
        $this->scheme->delete();
        $this->host->delete();
        $this->port->delete();
        $this->user->delete();
        $this->pass->delete();
        $this->path->delete();
        $this->query->delete();
        $this->fragment->delete();
    }

    /**
     * Examples:
     * - $urling->getWithout("protocol");
     * - $urling->getWithout($url_parser->protocol);
     *
     * @param mixed $url_part
     *
     * @return string|null
     */
    public function getWithout($url_part): ?string
    {
        $url_parts = $this->getUrlParts();

        $part = null;

        if (is_string($url_part)) {
            $part = AliasesStorage::getNamespaceByAlias($url_part);
        } elseif ($url_part instanceof Part) {
            $part = get_class($url_part);
        }

        if (!in_array($part, array_keys($url_parts))) {
            throw new \Exception("You try to get a URL without the nonexistent part of it!");
        }

        unset($url_parts[$part]);

        return $this->getFullUrl($url_parts);
    }

    /**
     * Returns URL string
     *
     * @param array<string, string|null> $url_parts
     *
     * @return string
     */
    protected function getFullUrl(array $url_parts = []): string
    {
        $full_url = ($url_parts)
            ? implode("", $url_parts)
            : implode("", $this->getUrlParts());

        return $full_url;
    }

    /**
     * Returns URL part values
     *
     * @return array<string, string|null>
     */
    protected function getUrlParts(): array
    {
        $url_parts = [
            $this->scheme->get(true),
            $this->user->get(true),
            ($this->user->get(true))
                ? $this->pass->get(true) . "@"
                : $this->pass->get(true),
            $this->host->get(true),
            $this->port->get(true),
            $this->path->get(true),
            $this->query->get(true),
            $this->fragment->get(true),
        ];

        // return array_combine(NamesStorage::getNames(), $url_parts);
        return array_combine(NamespacesStorage::getAllNamespaces(), $url_parts) ?: [];
    }
}
