<?php

namespace Urling\PartParsers;

use Urling\Core\Part;

final class QueryParser extends Part
{
    // code here

    /**
     * $urling->params->contains("param_name");
     * $urling->params->contains(["param_name_1", "param_name_1"]);
     *
     * @param array<int, string>|string $needle
     *
     * @return bool
     */
    public function contains($needle): bool
    {
        if (!$this->value || !$needle) {
            return false;
        }

        $is_contains = false;

        if (is_array($needle)) {
            $is_contains = $this->containParams($needle);
        } elseif (is_string($needle) && mb_strlen($needle)) {
            $is_contains = $this->containParam($needle);
        }

        return $is_contains;
    }

    /**
     * @return array<string, string>|array<int, string>
     */
    public function explode(): array
    {
        $params_string = $this->value;

        if ($params_string) {
            if (mb_strpos($params_string, "&") !== false) {
                $params = explode("&", $params_string);
                $params = array_filter($params, function (string $param) {
                    return $param == true;
                });
            } else {
                $params = [$params_string]; # ?param=value or ?param or ?param=
            }
        }

        return $params ?? [];
    }

    /**
     * @return array<string, string>|array<int, string>
     */
    public function getNameValuePairs(): array
    {
        $params = $this->explode();

        if (!$params) {
            return [];
        }

        foreach ($params as $param) {
            $name_value_pair = explode("=", $param);

            // ?param=
            if (count($name_value_pair) < 2) {
                $param_pairs[$name_value_pair[0]] = "";
            } else {
                $filter = "#[^a-z0-9?!]#iu";

                $name = preg_replace($filter, "", $name_value_pair[0]);
                $value = $name_value_pair[1];

                ($name)
                    ? $param_pairs[$name] = $value
                    : $param_pairs[] = $value;
            }
        }

        return $param_pairs ?? [];
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getValueByName(string $name): ?string
    {
        $params = $this->getNameValuePairs();

        return $params[$name] ?? null;
    }

    /**
     * @param string $value
     *
     * @return string|null
     */
    public function getNameByValue(string $value = ""): ?string
    {
        $params = $this->getNameValuePairs();

        return array_flip($params)[$value] ?? null;
    }

    /**
     * @return array<int, int|string>|null
     */
    public function getNames(): ?array
    {
        $params = $this->getNameValuePairs();

        return array_keys($params) ?? null;
    }

    /**
     * @return array<int, string>|null
     */
    public function getValues(): ?array
    {
        $params = $this->getNameValuePairs();

        return array_values($params) ?? null;
    }

    // $url_parser->params->addParam($position_in_params = 3, $value = "param_value");
    // $url_parser->params->getParam($position_in_params = 3);
    // $url_parser->params->updateParam(position_in_params = 3, $value = "param_value");
    // $url_parser->params->deleteParam(position_in_params = 3);

    /**
     * @param array<int, string> $params
     *
     * @return bool
     */
    private function containParams(array $params): bool
    {
        foreach ($params as $param) {
            if (!($this->containParam($param))) {
                throw new \Exception("Inexistent query param: $param!");
            };
        }

        return true;
    }

    /**
     * @param string $param
     *
     * @return bool
     */
    private function containParam(string $param): bool
    {
        $params = $this->getNameValuePairs();

        if (!$params) {
            return false;
        }

        $is_contains = false;

        if (
            is_string(array_keys($params)[0])
            && is_string(array_values($params)[0])
        ) {
            $is_contains = ($param)
                ? array_key_exists($param, $params)
                : (bool) $params;
        } else {
            $is_contains = ($param)
                ? $params[0] === $param
                : isset($params[0]);
        }

        return $is_contains;
    }
}
