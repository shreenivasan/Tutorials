<?php

function csv_export($data, $filename, $attachment = true, $headers = true)
{		
    if(count($data) > 0)
    {
        if($attachment) 
        {
            header( 'Content-Type: text/csv; charset=utf-8' );	            
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } 
        else 
        {
            $fp = fopen($filename, 'w');
        }

        fputcsv($fp, array_keys($data[0]));
        foreach ($data as $rows) 
        {				
            fputcsv($fp, $rows);
        }
        fclose($fp);		
    }

}

function site_url($url = '')
{
    if(empty($url))
    {
        return ROOT_URL;
    }
    else
    {
        return ROOT_URL.'/'.$url;
    }
}
        
function xss_encode($string, $charset = 'UTF-8')
{
    $replace = "";
    $search = array('{','}','(',')');
    $string = str_ireplace($search, $replace, $string);
    $string = htmlentities($string, ENT_QUOTES, $charset);
    return $string;
} 

function xss_decode($string, $charset = 'UTF-8')
{
    $string = html_entity_decode($string, ENT_QUOTES, $charset);
    $string = urldecode($string);
    return $string;
}
