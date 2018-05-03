<?php declare(strict_types=1);

namespace PhanQueryPlugin;

use Phan\CodeBase;
use Phan\Language\Context;
use Phan\AST\ContextNode;
use \ast\Node;

class Query
{
    const CONFIG_FILE = '.phan/query.php';

    public $node;

    public static function load(string $config = self::CONFIG_FILE): Query
    {
        foreach (require($config) as $pattern) {
            $query = new Query($pattern['pattern'], $pattern['type'], $pattern['message']);
        }

        return $query;
    }

    public function __construct(string $pattern, string $issueType, string $message)
    {
        $root = \ast\parse_code($this->prepare($pattern), \Phan\Config::AST_VERSION);

        // Drop T_OPEN_TAG
        $this->node = $root->children[0];
        $this->issueType = $issueType;
        $this->message = $message;
    }

    public function prepare(string $pattern): string
    {
        // @see https://secure.php.net/manual/en/language.oop5.basic.php
        $pattern = preg_replace_callback(
            "/<([a-zA-Z_\x7f-\xff\\\\][a-zA-Z0-9_\x7f-\xff\\\\]*)>/",
            function ($matches) {
                $klass = preg_replace("/\\\\/", "PRQ_NS", $matches[1]);
                return '$_PRQ_ANY_INSTANCE_OF_' . $klass;
            },
            $pattern
        );
        return "<?php " . $pattern;
    }

    public function match(CodeBase $code_base, Context $context, $target, $query): Bool
    {
        if (is_array($target)) {
            if (!is_array($query)) {
                return false;
            }
            foreach ($target as $key => $value) {
                if (!(array_key_exists($key, $query) && $this->match($code_base, $context, $value, $query[$key]))) {
                    return false;
                }
            }
        } elseif ($target instanceof Node) {
            if (!$query instanceof Node) {
                return false;
            }
            return $this->matchNode($code_base, $context, $target, $query);
        } elseif ($target !== $query) {
            return false;
        }
        return true;
    }

    private function matchNode(CodeBase $code_base, Context $context, Node $target, Node $query): Bool
    {
        if ($target->kind === \ast\AST_VAR && $query->kind === \ast\AST_VAR) {
            $ctx_node = new ContextNode($code_base, $context, $target);
            $types = array_map(function($type) {
                return $type->__toString();
            }, $ctx_node->getVariable()->getUnionType()->getTypeSet());

            if (preg_match('/_PRQ_ANY_INSTANCE_OF_(.*)/', $query->children['name'], $matches) === 1) {
                $klass = preg_replace("/PRQ_NS/", "\\", $matches[1]);
                return in_array($klass, $types, true);
            }
        }
        if ($target->kind !== $query->kind || $target->flags !== $query->flags) {
            return false;
        }
        return $this->match($code_base, $context, $target->children, $query->children);
    }
}
