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
class ArrayFunction
{ 
    /**
     * Build path flat tree like '/parent/child_1/child_1_1' from parent to child
     * @param array $elements
     * @param type $parentId
     * @param type $level
     * @return string
     */
    public static function buildPathFlatTree(array $elements, $parentId = 0, $level = '')
    {
        $branch = array();
        $level_ini = $level;
        foreach ($elements as $element) {
            $level = $level_ini;
            //if ($element['parent_id'] == $parentId   && $element['data_state'] == 11)
            if ($element['parent_id'] == $parentId) 
            {
                //$element ['name'] = '/'.$level.$element ['name'];
                //$level .= '--';
                $title;
                if (!self::keyExists('name', $element, false)) {
                    $title = $element ['tittle'];
                    if ($parentId == 0) {
                        $element ['tittle'] = '/' . $element ['tittle'];
                    } else {
                        $element ['tittle'] = $level . '/' . $element ['tittle'];
                    }
                    $level = $element ['tittle'];

                    $children = self::buildPathFlatTree($elements, $element['id'], $level);
                    $branch[$element['id']] = $element['tittle'];
                }else{
                    $title = $element ['name'];
                    if ($parentId == 0) {
                        $element ['name'] = '/' . $element ['name'];
                    } else {
                        $element ['name'] = $level . '/' . $element ['name'];
                    }
                    $level = $element ['name'];

                    $children = self::buildPathFlatTree($elements, $element['id'], $level);
                    $branch[$element['id']] = $element['name'];
                }
                if ($children) {
                    $branch = self::merge($branch, $children);
                }
            }
        }
        return $branch;
    }
    
    /**
     * Get path flat tree like '/parent/child_1/child_1_1' from child to parent
     * @param array $elements
     * @param type $parentId
     * @return type
     */
    public static function getPathTreeBasedArray(array $elements, $parentId = 0)
    {
        $datas = $elements;
        $dataState = 11;        
        //$path = '/';
        $path = '';
        $done = false;
        
        while($done == false){
            foreach ($datas as $key => $data) {
                if ($data['id'] == $parentId){
                    if($data['data_state'] == 0 || $data['data_state'] == 10)
                        $dataState = 0;

                    //if ($path == '/'){
                    if ($path == ''){
                        $path = $data['slug'];
                    }else{
                        //$path = $data['slug'].'/'.$path;
                        $path = $path.'/'.$data['slug'];
                    }

                    if ($data['parent_id'] == 0){
                        $done = true;
                        //$path = '/'.$path;
                        $path = $path;
                    }
                    $parentId = $data['parent_id'];
                    unset($datas[$key]);
                }
            } 
            if($parentId == 0)
                $done = true;
        }
        return ['dataState' => $dataState, 'path' => $path];
    }
    
    /**
     * Get all child, grandchild etc nodes under parent
     * @param type $src_arr
     * @param type $currentid
     * @param type $parentfound
     * @param type $cats
     * @return type
     */
    public static function fetchRecursive($src_arr, $currentid, $parentfound = false, $cats = array())
    {
        foreach($src_arr as $row)
        {
            if((!$parentfound && $row['id'] == $currentid) || $row['parent_id'] == $currentid)
            {
                $rowdata = array();
                foreach($row as $k => $v)
                    $rowdata[$k] = $v;
                $cats[] = $rowdata;
                if($row['parent_id'] == $currentid)
                    $cats = array_merge($cats, self::fetchRecursive($src_arr, $row['id'], true));
            }
        }
        return $cats;
    }
    
    /**TODO: check
     * change assosiative arra ['key1' => 'value1', 'key1' => 'value2']
     * into [1 => 'value1', 2 => 'value2']
     * @param type $array
     */
    public static function associativeToIndexed($array)
    {
        $tempArr;
        $i=0;
        foreach ($array as $key => $value)
        {
            if (is_array($value)){
                $tempArr[$i] = self::associativeToIndexed($value);
            }else{
                $tempArr[$i] = $value;
            }
            $i++;
        }
        return $tempArr;
    }
}
