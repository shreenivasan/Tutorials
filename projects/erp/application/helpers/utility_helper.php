<?php
function load_assets($asset_type,$asset_list)
{
    switch($asset_type)
    {
        case 'css':
            foreach($asset_list as $k=>$v)
            {
                foreach($v as $key=>$value)
                {
                    echo "<link href='".base_url()."assets/".$asset_type.DS.$k.DS.$value.".".$asset_type."' rel='stylesheet' type='text/css' />";
                }
            }
        break;    
        case 'js':
            foreach($asset_list as $k=>$v)
            {
                foreach($v as $key=>$value)
                {
                    echo "<script src='".base_url()."assets/".$asset_type.DS.$k.DS.$value.".".$asset_type."' type='text/javascript'></script>";
                }
            }
        break;    
    }
    
}

function pr($data)
{
    if(is_array($data))
    {
        echo "<pre>"; print_r($data); echo "</pre>";
    }
    else if(is_string($data))
    {
       echo "<pre>"; echo $data; echo "</pre>";
    }
    else if(isJson($data))
    {
       echo "<pre>"; print_r(json_decode($data,true)); echo "</pre>";
    }
}