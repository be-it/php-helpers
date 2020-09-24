<?php
/**
 * @link -
 * @copyright Copyright (c) 2017 Triawarman
 * @license MIT
 * @author Triawarman <3awarman@gmail.com>
 */
namespace BeIt\PhpHelpers;

/**
 * BasicEnum membuat enum type selain menggunakan php extension SplEnum
 * sumber: https://stackoverflow.com/questions/254514/php-and-enumerations/254543#254543
 * atau : https://github.com/greg0ire/enum
 * 
 * abstract class DaysOfWeek extends BasicEnum {
 *      const Sunday = 0;
 *      const Monday = 1;
 *      const Tuesday = 2;
 *      const Wednesday = 3;
 *      const Thursday = 4;
 *      const Friday = 5;
 *      const Saturday = 6;
 * }
 * 
 */
abstract class BasicEnum {
    private static $constCacheArray = NULL;

    private static function getConstants() {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true) {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}
