<?php

interface Shape{
    public function getArea();
}

class Circle implements Shape{
    private $radius;

    public function setRadius($radius = 0){
        $this->radis = $radius;
    }

    public function getRadius(){
        return $this->radius;
    }

    public function getArea() {
        $r = $this->getRadius();
        return ' Area of circle ==> '.(3.14*$r*$r);
    }
}


class Square implements Shape{
    private $side;

    public function setSide($side = 0){
        $this->side = $side;
    }

    public function getSide(){
        return $this->side;
    }

    public function getArea() {
        $l = $this->getSide();
        return ' Area of square ==> '.$l*$l;
    }
}


function calculateArea(Shape $s){
    return $s->getArea();
}

$c = new Circle();
$c->setRadius(10);

$sq = new Square();
$sq->setSide(20);

echo calculateArea($sq);

echo '<br>';

echo calculateArea($c);


