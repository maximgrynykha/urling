<?php

namespace Urling\Core\Utilities\Editors;

use Urling\Core\Exceptions\EditException;
use Urling\Core\Utilities\Misc\LogicVerifier;

trait BasePartEditor
{
    /**
     * Create URL-part and set it value
     *
     * @param string $value
     *
     * @return string|null
     */
    public function add(?string $value): ?string
    {
        $this->_add($value);

        return $this->get();
    }

    /**
     * Return value of URL-part
     *
     * @return string|null
     */
    public function get(bool $with_gluing = false): ?string
    {
        return $this->_get($with_gluing);
    }

    /**
     * Update value of URL-part
     *
     * @param bool $value
     *
     * @return string|null
     */
    public function update(?string $value): ?string
    {
        $this->_update($value);

        return $this->get();
    }

    /**
     * Delete value of URL-part
     *
     * @return string|null
     */
    public function delete(): ?string
    {
        $this->_delete();

        return $this->get();
    }

    protected function _add(?string $value): void
    {
        if (isset($this->value)) {
            throw new EditException(ucfirst($this->name) . " already added. Use 'update'.");
        }

        $this->value = $value;
        $this->sanitize($this->value);
    }

    protected function _get(bool $with_gluing = false): ?string
    {
        return ($with_gluing) ? $this->withGluing() : $this->value;
    }

    protected function _update(?string $value): void
    {
        $this->_delete();
        $this->_add($value);
    }

    protected function _delete(): void
    {
        $this->value = null;
    }

    protected function sanitize(?string $value): void
    {
        if (LogicVerifier::verify(fn() => LogicVerifier::isIssetAndNotEmpty($value))) {
            switch ($this->name) {
                case "scheme":
                    $this->value = preg_replace("#[\:\/]+#iu", "", $value);
                    break;
                case "pass":
                    $this->value = preg_replace("#^[\:]+#iu", "", $value);
                    break;
                case "port":
                    $this->value = preg_replace("#^[\:]+#iu", "", $value);
                    break;
                case "path":
                    $this->value = preg_replace("#^[\/]+#iu", "", $value);
                    break;
                case "query":
                    $this->value = preg_replace("#^[\?]+#iu", "", $value);
                    break;
                case "fragment":
                    $this->value = preg_replace("#^[\#]+#iu", "", $value);
            }
        }
    }

    protected function withGluing(): ?string
    {
        $value = $this->value;

        if (LogicVerifier::verify(fn() => LogicVerifier::isIssetAndNotEmpty($this->value))) {
            switch ($this->name) {
                case "scheme":
                    $value = $value . $this->gluing;
                    break;
                case "pass":
                case "port":
                case "path":
                case "query":
                case "fragment":
                    $value = $this->gluing . $this->value;
            }
        }

        return $value;
    }
}
