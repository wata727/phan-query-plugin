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
];
