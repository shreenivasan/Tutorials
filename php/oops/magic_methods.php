<?php
class bar
{
    private  $test;
    public function __get($test)        
    {
        echo "<br> I am in GET";
        return $this->test;
    }
    public function __set($dt,$val)        
    {
        echo "<br> I am in SET";
        return $this->$dt=$val;
    }
}
$bar=new bar();
$bar->test="111";
echo $bar->test;

