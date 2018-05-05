# Phan Query Plugin

[![Build Status](https://travis-ci.org/wata727/phan-query-plugin.svg?branch=master)](https://travis-ci.org/wata727/phan-query-plugin)
[![Latest Stable Version](https://poser.pugx.org/wata727/phan-query-plugin/v/stable)](https://packagist.org/packages/wata727/phan-query-plugin)
[![MIT License](http://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)

A Phan plugin to add a new rule without writing plugins. This plugin inspired by [Querly](https://github.com/soutaro/querly).

## Installation

You can install this plugin with composer.

```
$ composer require --dev wata727/phan-query-plugin
```

After that, Set this plugin path to `.phan/config.php`.

```php
<?php

return [
    "plugins" => [__DIR__."/../vendor/wata727/phan-query-plugin/plugins/QueryPlugin.php"]
];
```

## Quick Start

At first, creates files as follows:

`.phan/config.php`:

```php
<?php

return [
    "plugins" => [__DIR__."/../vendor/wata727/phan-query-plugin/plugins/QueryPlugin.php"]
];
```

`.phan/query.php`:

```php
<?php

return [
    [
        "type" => "PhanQueryCatFound",
        "message" => "Cat Found",
        "pattern" => '$cat->meow();',
    ]
];
```

`test.php`:

```php
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
```

Try following command:

```
$ vendor/bin/phan test.php
```

You can get the result:

```
test.php:12 PhanQueryCatFound Cat Found
```

### What happened?

This plugin loads `.phan/query.php` and searches for your code that matches the defined `pattern` of Query.
In the above example, since the code matching `$cat->meow();` existed in line 12, it was emitted as Phan's issue.

The emitted issue has type and message as well as Phan's original issue. These are `type` and `message` defined in your Query.

### What is the difference with regular expressions?

This plugin uses AST for matching node. For example, `$cat->meow($arg1, $arg2);` matches all of the following:

- `$cat->meow($arg1, $arg2);`
- `$cat->meow($arg1 , $arg2);`
- `$cat->meow($arg1,$arg2);`

## Query Syntax

What kind of syntax can be written in `pattern`? This is PHP-like pattern matching syntax, which satisfying the following:

- The pattern expressions must be valid as PHP
  - For example, a trailing semicolon is required.
- But the `<Klass>` syntax is available in the pattern.

### `<Klass>` Syntax

You can use `<Klass>` syntax in a pattern of Query. If you use it, the following pattern matches `test.php` like the above.

```
<?php

return [
    [
        "type" => "PhanQueryAllCatFound",
        "message" => "Cat Found",
        "pattern" => '<Foo\Bar\Cat>->meow();',
    ]
];
```

This means that the Query checks types of variables when use this pattern. Also, if you specify `<any>`, it matches all variables.

## Testing your Query

You can write a test to make sure the Query works correctly. For example:

```php
<?php

return [
    [
        "type" => "PhanQueryCatFound",
        "message" => "Cat Found",
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
```

The `match` value is the code that matches `pattern`, and the `unmatch` value is the code that not match `pattern`. You can run the tests with the following command:

```
$ vendor/bin/phan_query_test
All 2 tests are passed!
```

## Author

[Kazuma Watanabe](https://github.com/wata727)
