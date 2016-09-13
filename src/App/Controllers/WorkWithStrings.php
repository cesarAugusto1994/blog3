<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 03/09/16
 * Time: 09:54
 */

namespace App\Controllers;

trait WorkWithStrings
{
    private $target = ['/', '.', '*'];
    private $replace = ['-', '-', '-'];
    
    public function replaceSpecialStrings($string)
    {
        return str_replace($this->target, $this->replace, trim($string));
    }
    
    public function replaceSpecialStringsFromUrl($string)
    {
        array_push($this->target, ' ');
        array_push($this->replace, '-');
        
        $formatedString = str_replace($this->target, $this->replace, trim(substr($string, 0, 45)));
        
        array_pop($this->target);
        array_pop($this->replace);
        
        return $formatedString;
    }
    
}