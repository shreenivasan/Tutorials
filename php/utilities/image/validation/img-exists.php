<?php

/*
 * This function will where img exists or not
 * Param : url of img
 * Return type : true if exists otherwise false
 */
function img_exists($file)
{
    $url=getimagesize($file);
    if(is_array($url))
    {
        return true;
    }
    else 
    {
        return false;
    }
}

$file='http://i1.pepperfry.com/media/catalog/product/c/a/800x400/canon-red-recliner-by-alcanes-canon-red-recliner-by-alcanes-u6yqbb.jpg';

echo img_exists($file)?"Y":"N";
