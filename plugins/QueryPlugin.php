<?php declare(strict_types=1);

use Phan\PluginV2;
use Phan\PluginV2\AnalyzeNodeCapability;
use PhanQueryPlugin\Visitor;
use PhanQueryPlugin\Query;

// TODO: autoload, bootstrap, etc
require_once __DIR__ . '/../src/Visitor.php';
require_once __DIR__ . '/../src/Query.php';

class QueryPlugin extends PluginV2 implements AnalyzeNodeCapability
{
    /**
     * @return string - The name of the visitor that will be called (formerly analyzeNode)
     */
    public static function getAnalyzeNodeVisitorClassName() : string
    {
        return Visitor::class;
    }
}

return new QueryPlugin;
