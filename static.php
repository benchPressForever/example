<?php

class A
{
    public static $a = 'A';

    public static function display()
    {
        echo self::$a;
    }
}

class B extends A{
    public static $a = 'B';

    public static function display(){
        echo self::$a;
    }
}


A::display();
B::display();