<?php 

 /**
 * [quick_sort 对二维数组快速排序]
 * @ckhero
 * @DateTime 2017-05-19
 * @param    [type]     $data [description]
 * @param    [type]     $key  [description]
 * @return   [type]           [description]
 */
function quick_sort($data, $key)
{
    reset($data);
    $first = current($data);
    $first_key = key($data);
    if (!is_array($data) || empty($data)) {

        return false;
    }

    $num = count($data);
    if ($num <= 1) {
        return $data;
    }

    $x = array();
    $y = array();

    foreach ($data as $k => $val) {

        if ($k == $first_key) {

            continue;
        }
        if ($val[$key] < $first[$key]) {

            $x[] = $val;
        } else {

            $y[] = $val;
        }
    }
    $x = quick_sort($x, $key);
    $y = quick_sort($y, $key);
    if (empty($x)) {

        $x = array();
    }
    if (empty($y)) {

        $y = array();
    }
    return array_merge($x, array($first), $y);
}

 function array_unset_tt($arr,$key){     
        //建立一个目标数组  
        $res = array();        
        foreach ($arr as $value) {           
           //查看有没有重复项  
             
           if(isset($res[$value[$key]])){  
                 //有：销毁  
                  
                 unset($value[$key]);  
                   
           }  
           else{  
                  
                $res[$value[$key]] = $value;  
           }    
        }  
        return $res;  
    }  


function uuid($prefix = null):string
{

   $str = md5(uniqid(mt_rand(), true));
   return substr($str, 0, 8).'-'.
          substr($str, 8, 4).'-'.
          substr($str, 12, 4).'-'.
          substr($str, 16, 4).'-'.
          substr($str, 20, 12);
}

function uploadPath($dir)
{
    if (!is_dir($dir)) {
        mkdir($dir);
    } 
    return $dir;
}