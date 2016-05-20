<?php

echo __LINE__."<=== current line number  <br>";
echo __FILE__."<=== current File name  <br>";
echo __DIR__."<=== current dir name  <br>";
test();
echo __CLASS__."<=== current class name  <br>";
echo __METHOD__."<=== current method name  <br>";
echo __NAMESPACE__."<=== current namespace name  <br>";


function test()
{
    echo __FUNCTION__."<=== current function name  <br>";
}
