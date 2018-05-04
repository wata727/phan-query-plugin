<?php declare(strict_types=1); // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

use Phan\PluginV2;
use Phan\PluginV2\AnalyzeNodeCapability;
use PhanQueryPlugin\Visitor;
use PhanQueryPlugin\Query;

require_once __DIR__ . '/../bootstrap.php';

/**
* This plugin checks whether match user defined pattern,
* which are described in `.phan/query.php`. The following is example syntax:
*
* ```php
* <?php
*
* return [
*     [
*         "type" => "PhanQueryCatMeow",
*         "message" => "$cat Found",
*         "pattern" => "$cat->meow();",
*     ],
*     [
*         "type" => "PhanQueryAllCatMeow",
*         "message" => "Cat Found",
*         "pattern" => "<\Foo\Bar\Cat>->meow();",
*     ],
*     ...
* ];
*
* ```
*
* `type` is used as Phan's issue type. If Phan catches the issue, it outputs `message`.
* `pattern` is PHP-like pattern matching syntax. Please see README.md for details.
*/
class QueryPlugin extends PluginV2 implements AnalyzeNodeCapability // phpcs:ignore PSR1.Classes.ClassDeclaration
{
    /**
     * @return string The name of the visitor that will be called (formerly analyzeNode)
     */
    public static function getAnalyzeNodeVisitorClassName() : string
    {
        return Visitor::class;
    }
}

return new QueryPlugin;
