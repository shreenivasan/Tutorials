<?php

class B
{
    public $bname='B';
    public function getName()
    {
        echo $this->bname;
    }
}

class A extends B
{
    private $aname='A';
    public function getName()
    {
        echo parent::getName();
        echo $this->aname;
    }
}

$aobj=new A();
echo $aobj->getName();
