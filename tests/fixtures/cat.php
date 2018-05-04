<?php

namespace Foo\Bar;

class Cat
{
    public function meow()
    {
        echo "Meow!";
    }

    public function makeSound($msg)
    {
        echo $msg;
    }
}

$cat = new Cat();
$cat->meow();
$msg = "Bowwow!";
$cat->makeSound($msg);
