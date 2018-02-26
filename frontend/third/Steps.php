<?php 
namespace Third;

class Steps{  
  
   
  
    private $all;  
  
    private $count;  
  
    private $curr;  
  
   
  
    function __construct() {  
  
        $this->count = 0;  
  
    }  
  
    // function add() {  
  
    //     $this->count++;  
  
    //     $this->all[$this->count] = $step;  
  
    // }  
  
    function setCurrent($step) {  

        reset($this->all);  
  
        for ($i = 0; $i < $this->count; $i++) {  
  
            if (key($this->all) == $step)  
  
                break;  
  
            next($this->all);  
  
        }  
        $this->curr = key($this->all);  
    }  
  
    function getCurrent() {  
  
        return $this->curr;  
  
    }  
  
    function getNext() {  
  
        self::setCurrent($this->curr);  
  
        next($this->all);  
        return key($this->all);  
  
    }  
  
    function getPrev() {  
  
        self::setCurrent($this->curr);  
        prev($this->all); 
        return key($this->all);  
  
    }  
    function setAll($arr)
    {
        $this->all = $arr;
        $this->count = count($arr);
    }
  
} 
 ?>