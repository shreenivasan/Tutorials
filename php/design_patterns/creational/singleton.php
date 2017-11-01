<?php
   class Singleton {
      public static function getInstance() {
         static $instance = null;
         
         if (null === $instance) {
             echo "<br> Created obj ";
            $instance = new static();
         }
         return $instance;
      }
      protected function __construct() {
      }
      
      private function __clone() {
      }
      
      private function __wakeup() {
      }
   }
   
   class SingletonChild extends Singleton {
   }
   
   $obj = Singleton::getInstance();
   var_dump($obj === Singleton::getInstance());
   
   $anotherObj = SingletonChild::getInstance();
   var_dump($anotherObj === Singleton::getInstance());
   var_dump($anotherObj === SingletonChild::getInstance()); 
?>

