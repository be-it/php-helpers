<?php
/**
 * @link -
 * @copyright Copyright (c) 2017 Triawarman
 * @license MIT
 * @author Triawarman <3awarman@gmail.com>
 */
namespace BeIt\PhpHelpers;

/**
 * 
 */
class Cast
{
    /**
     * Cast string 'true' or 'false into (boolean) true or false.
     * 
     * @param string $value
     * @return boolean
     */
    public static function stringBooleanToBoolean($value)
    {
        return (strtolower(trim($value)) === 'true' ? true : false);
    }
    
    /**
     * Cast int 1 or 0 into (boolean) true or false.
     * 
     * @param integer $value
     * @return boolean
     */
    public static function intBooleanToBoolean($value)
    {
        return ((int) $value === 1 ? true : false);
    }
    
    /**
     * Cast int 1 or 0 into (string) true or false.
     * 
     * @param integer $value
     * @return boolean
     */
    public static function intBooleanToStringBoolean($value)
    {
        return ((int) $value === 1 ? 'true' : 'false');
    }
    
    /**
     * Cast array [1, 9] into (string) '(1, 9)'
     * 
     * @param array $value
     * @return string
     */
    public static function arrayOfIntToStringArrayOfInt($value)
    {
        return '('.implode(", ", $value).')';
    }
    
    /**
     * Cast array ['a', 'b', 'd'] into (string) '("a", "b", "d")'
     * 
     * @param array $value
     * @return string
     */
    public static function arrayOfStringToStringArrayOfString($value)
    {
        //return '(\''.implode("', '", ['en', 'asd', 'sdasd']).'\')';
        return '(\''.implode("', '", $value).'\')';
    }
    
    /**
     * Cast array into (string) array.
     * 
     * @param integer $value
     * @return boolean
     */
    public static function arrayToString($value, $stringContainer = '"')
    {
        if(!is_array($value))
            throw new InvalidConfigException(Me::t ('message', 'INPUT_ONLY_ACCEPT_ARRAY'));
        $string = json_encode($value);
        $string = preg_replace('/\[/', '(', $string);
        $string = preg_replace('/\]/', ')', $string);
        if($stringContainer != '"')
            $string = preg_replace('/\"/', '\'', $string);
        return $string;
    }
    
    /**
     * Modified from \yii\helpers\ArragHelper add support change json to array
     * 
     * @param json | array | object $value
     * @param array $properties
     * @param boolean $recursive
     * @return 
     */
    public static function ensureToArray($data, $properties = [], $recursive = true)
    {
        if(is_string($data)){
            if(!StringFunction::validateJson($data)){
                return $data;
            }else{
                $data = json_decode($data);
                if (is_array($data) || is_object($data))
                    $data = static::ensureToArray($data, $properties, true);             
                if($recursive)
                    foreach ($data as $key => $value) {
                        if (is_array($value) || is_object($value) || StringFunction::validateJson($value)) {
                            $data[$key] = static::ensureToArray($value, $properties, true);
                        }else
                            $data[$key] = $value;
                    }
                return $data;
            }
        } elseif (is_array($data)) {
            if ($recursive) {
                foreach ($data as $key => $value) {
                    //if (is_array($value) || is_object($value)) {
                    if (is_array($value) || is_object($value) || StringFunction::validateJson($value)) {
                        $data[$key] = static::ensureToArray($value, $properties, true);
                    }
                }
            }

            return $data;
        } elseif (is_object($data)) {
            if (!empty($properties)) {
                $className = get_class($data);
                if (!empty($properties[$className])) {
                    $result = [];
                    foreach ($properties[$className] as $key => $name) {
                        if (is_int($key)) {
                            $result[$name] = $data->$name;
                        } else {
                            $result[$key] = static::getValue($data, $name);
                        }
                    }

                    return $recursive ? static::ensureToArray($result, $properties) : $result;
                }
            }
            if ($data instanceof Arrayable) {
                $result = $data->ensureToArray([], [], $recursive);
            } else {
                $result = [];
                foreach ($data as $key => $value) {
                    if (is_string($value))
                        if (StringFunction::validateJson($value))
                            $value = static::ensureToArray($value, $properties, true);
                        
                    $result[$key] = $value;
                }
            }

            return $recursive ? static::ensureToArray($result, $properties) : $result;
        }

        return [$data];
    }
}
