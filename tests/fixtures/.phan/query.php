<?php

return [
    [
        "type" => "MatchingNode",
        "message" => "Matching Node Message",
        "pattern" => '$cat->meow();',
    ],
    [
        "type" => "MatchingInstanceReceiver",
        "message" => "Matching Instance Receiver Message",
        "pattern" => '<\Foo\Bar\Cat>->meow();',
    ],
    [
        "type" => "MatchingInstanceReceiverWithoutRootNamespace",
        "message" => "Matching Instance Receiver Without Root Namespace Message",
        "pattern" => '<Foo\Bar\Cat>->meow();',
    ],
    [
        "type" => "MatchingInstanceArugument",
        "message" => "Matching Instance Arugument Message",
        "pattern" => '$cat->makeSound(<string>);',
    ],
];
