<?php

namespace App\Classes;

class RegularFunctions
{

    static function codeGenerator($prfx,$val){
        if($val <= 9){
            return $prfx."00000" . $val;
        }else if($val > 9 && $val <= 99){
            return $prfx."0000" . $val;
        }else if($val > 9 && $val > 99 && $val <= 999){
            return $prfx."000" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val <= 9999){
            return $prfx."00" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val <= 99999){
            return $prfx."0" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val > 99999 && $val <= 999999){
            return $prfx.$val;
        }
    }

    static function repeatCodeGenerator($prfx,$val,$rep){
        if($val <= 9){
            return $prfx."00000" . $val .'_'.$rep;
        }else if($val > 9 && $val <= 99){
            return $prfx."0000" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val <= 999){
            return $prfx."000" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val > 999 && $val <= 9999){
            return $prfx."00" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val <= 99999){
            return $prfx."0" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val > 99999 && $val <= 999999){
            return $prfx.$val .'_'.$rep;
        }
    }

}
