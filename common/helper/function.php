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

function generateStr($len =8) {

   $chars = array(   
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",    
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",    
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",    
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",    
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",    
        "3", "4", "5", "6", "7", "8", "9"   
    );   
    $charsLen = count ( $chars ) - 1;  
    shuffle ( $chars ); // 将数组打乱  
    $output = "";  
    for($i = 0; $i < $len; $i ++) {  
        $output .= $chars [mt_rand ( 0, $charsLen )];  
    }  
    return $output;  
}


function quickSortByAscii($data)
  {
    $len = count($data);
    if ($len > 1) {
      $tmp = $data[0];
      $x = [];
      $y = [];
      for ($i = 1; $i < $len; $i++){
        if (strcmp($data[$i], $tmp) < 0) {
          $x[] = $data[$i];
        } else {
          $y[] = $data[$i];
        }
      }
      $x = quickSortByAscii($x);
      $y = quickSortByAscii($y);
      $data = array_merge($x, [$tmp], $y);
    }
    return $data;
  }


  function send_curl($url, $data = '', $method = 'GET', $charset = 'utf-8', $timeout = 15)
{
    // 初始化并执行curl请求
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    // 设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    // 设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    // 设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    if (strtoupper($method) == 'POST') {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        if (is_string($data)) { // 发送JSON数据
            $http_header = array(
                'Content-Type: application/json; charset=' . $charset,
                'Content-Length: ' . strlen($data)
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $http_header);
        }
    }
    $result = curl_exec($curl);
    $error = curl_error($curl);
    Yii::info(json_encode([
        'overview' => $url,
        'request' => $data,
        'response' => $result,
        'error' => $error
    ]));
    curl_close($curl);
    // 发生错误，抛出异常
    // if ($error) throw new \Exception('请求发生错误：' . $error);
    // if($error){readdir(C('WEB_URL').C('ERROR_PAGE'));}
    return $result;
}