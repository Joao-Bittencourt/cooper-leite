<?php

namespace core;

class Validate {

    public static $erros = [];

    public static function execute($fields = [], $data = [], ?Model $Model = null) {

        $erros = [];
        foreach ($fields as $field => $validates) {

            foreach ($validates as $validate => $propriedades) {

                if (method_exists($Model::class, $validate)) {

                    if (!$Model->$validate(array_get($data, $field), array_get($propriedades, 'args'))) {
                        static::$erros[$field][] = $propriedades['message'];
                    }
                }
                
                if (method_exists(Validate::class, $validate)) {

                    if (!self::$validate(array_get($data, $field), array_get($propriedades, 'args'))) {
                        static::$erros[$field][] = $propriedades['message'];
                    }
                }
            }
        }

        if (!empty(static::$erros)) {
            return static::$erros;
        }
    }

    public static function custom($check, $regex = null) {
        if (!is_scalar($check)) {
            return false;
        }
        if ($regex === null) {
            static::$erros[] = 'You must define a regular expression for Validation::custom()';
            return false;
        }

        return static::_check($check, $regex);
    }

    public static function notEmpty($check): bool {

        if (empty($check) && !is_bool($check) && !is_numeric($check)) {
            return false;
        }

        return static::_check($check, '/[^\s]+/m');
    }

    public static function equalTo($check, $comparedTo) {
        return ($check === $comparedTo);
    }

    protected static function _check($check, $regex) {
        if (is_string($regex) && is_scalar($check) && preg_match($regex, $check)) {
            return true;
        }
        return false;
    }

}
