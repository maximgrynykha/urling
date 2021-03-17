<?php

namespace Urling\PartParsers;

use Urling\Core\Utilities\Misc\LogicVerifier;

final class QueryParser extends URLPartParser
{
    // code here

    /**
     * Универсальная функция для isParamExist / isParamsExists
     *
     * @param array<int, string>|string|null $params
     *
     * @return bool
     */
    public function exists($params = null): bool
    {
        if (!isset($params)) {
            return parent::exists();
        }

        if (is_array($params) && count($params)) {
            //
        } elseif (is_string($params) && mb_strlen($params)) {
            //
        }

        return true;
    }

    // $urling->params->exists();
    // $urling->params->exists("username");
    // $urling->params->exists(["username", "project"]);

    /**
     * @param null $params
     *
     * @return bool
     */
    public function contains($params = null): bool
    {
        return true;
    }

    /**
     * @param array<int, string> $names
     *
     * @return bool
     */
    public function isParamsExist(array $names = []): bool
    {
        $params = $this->explode();

        if (LogicVerifier::verify(fn() => LogicVerifier::isNullOrEmpty($params))) {
            return false;
        }

        if (LogicVerifier::verify(fn() => LogicVerifier::isNotNullAndNotEmpty($names))) {
            foreach ($names as $name) {
                if (!$this->isParamExist($name)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function isParamExist(string $name = ""): bool
    {
        $params = $this->getNameValuePairs();

        if (LogicVerifier::verify(fn() => LogicVerifier::isNullOrEmpty($params))) {
            return false;
        }

        if (is_string(array_keys($params)[0]) && is_string(array_values($params)[0])) {
            $varification = (!empty($name)) ? array_key_exists($name, $params) : isset($params);
        } else {
            $varification = (!empty($name)) ? $params[0] === $name : isset($params[0]);
        }

        return $varification;
    }

    /**
     * @return array<string, string|null>|array<int, string|null>|null
     */
    public function explode(): ?array
    {
        $params_string = $this->value;

        if (LogicVerifier::verify(fn() => LogicVerifier::isNotNullAndNotEmpty($params_string))) {
            if (mb_strpos($params_string, "&") !== false) {
                $params = explode("&", $params_string);
                $params = array_filter($params, function (string $param) {
                    return LogicVerifier::verify(fn() => LogicVerifier::isNotNullAndNotEmpty($param));
                });
            } else {
                $params = [$params_string]; # ?param=value
            }
        }

        return $params ?? null;
    }

    /**
     * @return array<string, string>|array<int, string>|null
     */
    public function getNameValuePairs(): ?array
    {
        $param_pairs = [];

        $params = $this->explode();

        if (LogicVerifier::verify(fn() => LogicVerifier::isNullOrEmpty($params))) {
            return null;
        }

        foreach ($params as $param) {
            $name_value_pairs = explode("=", $param);

            // ?param=
            if (count($name_value_pairs) < 2) {
                $param_pairs[$name_value_pairs[0]] = "";
            } else {
                $filter = "#[^a-z0-9?!]#iu";

                $name = preg_replace($filter, "", $name_value_pairs[0]);
                $value = $name_value_pairs[1];

                if (LogicVerifier::verify(fn() => LogicVerifier::isNotNullAndNotEmpty($name))) {
                    $param_pairs[$name] = $value;
                } else {
                    $param_pairs[] = $value;
                }
            }
        }

        return $param_pairs;
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
}
