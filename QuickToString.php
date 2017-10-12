<?php

trait QuickToString
{
    //since we add this type of __toString to most of our classes why not make it a trait?
    function __toString() 
    {    
        $valueArray = array();
        foreach($this as $name => $value)
        {
            array_push($valueArray, $value);     
        }       
        return get_class() . "[" . implode(",", $valueArray) . "]";
    }
}
