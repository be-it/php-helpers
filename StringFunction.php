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
class StringFunction
{
    /**
     * Generates random alphanumeric characters
     * 
     * @param integer $totalChar
     * @param integer $totalNumber
     * @return string
     */
    public static function generateRandomString($totalChar = 4, $totalNumber = 4)
    {
        $character_set_array = array();
        $character_set_array[] = array('count' => $totalChar, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
        $character_set_array[] = array('count' => $totalNumber, 'characters' => '0123456789');
        $temp_array = array();
        foreach ($character_set_array as $character_set) {
            for ($i = 0; $i < $character_set['count']; $i++) {
                $temp_array[] = $character_set['characters'][mt_rand(0, strlen($character_set['characters']) - 1)];
            }
        }
        shuffle($temp_array);
        return implode('', $temp_array);
    }
    
    /**
     * Slugify words supports for utf8
     * 
     * @param string $string
     * @return string
     */
    public static function slugify($string)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '_', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '_'));
    }
    
    /**
     * Search and dumping empty space
     * 
     * @param string $string
     * @return string
     */
    public static function trim($string)
    {
        return preg_replace('/\s+/','',$string);
    }
    
    /**
     * Check if string is valid JSON
     * 
     * @param string $string
     * @return boolean
     */
    public static function validateJson($string)
    {
        //{"key"="value"}
        //{"name":"John Johnson","street":"Oslo West 16","phone":"555 1234567"}
        return (is_object(json_decode($string)) && json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}
