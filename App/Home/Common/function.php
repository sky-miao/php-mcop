<?php

function stringFilter($text) {
    //过滤标签
    $text = htmlspecialchars_decode($text);
    $text = nl2br($text);
    $text = trim($text);
    return $text;
}


function stringCode($len=48) { 
   
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   
    $str =''; 
    $chars_length =strlen($chars) -1;
    for ( $i = 0; $i < $len; $i++ ) 
    { 
        $str .= $chars[ mt_rand(0, $chars_length) ]; 
    } 
    return $str; 
}