<?php

return [
    [
        "type" => "MatchingNode",
        "message" => "Matching Node Message",
        "pattern" => '$cat->meow();',
         "test" => [
             "match" => <<<'EOD'
<?php

namespace Foo\Bar;

class Cat
{
    public function meow()
    {
        echo "Meow!";
    }
}

$cat = new Cat();
$cat->meow();
EOD
             ,
             "unmatch" => <<<'EOD'
<?php

namespace Foo\Bar;

class Cat
{
    public function meow()
    {
        echo "Meow!";
    }
}

$dog = new Cat();
$dog->meow();
EOD
         ],
    ],
];
