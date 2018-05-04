<?php declare(strict_types=1);

namespace PhanQueryPlugin;

use Phan\CodeBase;
use Phan\Language\Context;
use Phan\AST\ContextNode;
use \ast\Node;

class PatternSyntaxError extends \Exception {} // phpcs:ignore

/**
* Query is a PHP-like pattern matching syntax object.
* The pattern parsed as PHP scripts by `php-ast`. But a part of
* the pattern processed as a meta character like the following:
*
* - AnyInstanceOfClass
*     <\Namespace\Klass> => $_PRQ_ANY_INSTANCE_OF_PRQ_NSNamespacePRQ_NSKlass
*
* The meta characters are matched a node based on its meaning.
*/
class Query // phpcs:ignore PSR1.Classes.ClassDeclaration
{
    /** The location of query file */
    const CONFIG_FILE = '.phan/query.php';

    /** @var Node A node of the query parsed by `php-ast` */
    public $node;
    /** @var string A Phan issue type emitted when the query is matched */
    public $issueType;
    /** @var string A message of the issue */
    public $message;
    /** @var Query[] caches of Query object */
    private static $queries;

    const T_ANY_INSTANCE_OF = "_PRQ_ANY_INSTANCE_OF_";
    const T_NS = "PRQ_NS";

    /**
    * Load `.phan/query.php` and return Query objects.
    *
    * @param string $config The location of query file.
    * @return Query[] Loaded Query objects.
    */
    public static function load(string $config = self::CONFIG_FILE): array
    {
        // Processing cache
        if (empty(self::$queries)) {
            foreach (require($config) as $pattern) {
                self::$queries[] = new Query($pattern['pattern'], $pattern['type'], $pattern['message']);
            }
        }

        return self::$queries;
    }

    /**
    * Initialize Query object, parse the received pattern syntax.
    *
    * @param string $pattern   A pattern matching syntax.
    * @param string $issueType A Phan issue type emitted when the query is matched.
    * @param string $message   A messge of the issue.
    * @throws PatternSyntaxError When the pattern is invalid syntax.
    */
    public function __construct(string $pattern, string $issueType, string $message)
    {
        $pattern = $this->prepare($pattern);
        try {
            // Using Phan AST version when parse the pattern
            $root = \ast\parse_code($pattern, \Phan\Config::AST_VERSION);
        } catch (\ParseError $error) {
            throw new PatternSyntaxError("The pattern of ".$issueType." is invalid syntax. Parsed code: ".$pattern." Error message: ".$error->getMessage());
        }

        // Drop T_OPEN_TAG
        $this->node = $root->children[0];
        $this->issueType = $issueType;
        $this->message = $message;
    }

    /**
    * Do lexical analysis and replace meta characters.
    *
    * @param string $pattern A pattern matching syntax.
    * @return string A processed pattern.
    */
    public function prepare(string $pattern): string
    {
        $pattern = preg_replace_callback(
            /**
            * Detecting AnyInstanceOfClass meta characters (<\Namespace\Klass>)
            * @see https://secure.php.net/manual/en/language.oop5.basic.php
            */
            "/<([a-zA-Z_\x7f-\xff\\\\][a-zA-Z0-9_\x7f-\xff\\\\]*)>/",
            function ($matches) {
                // Replace namespace separater because `\` is invalid as a variable name
                $klass = preg_replace("/\\\\/", self::T_NS, $matches[1]);
                return '$'.self::T_ANY_INSTANCE_OF.$klass;
            },
            $pattern
        );

        // Adding T_OPEN_TAG for valid PHP syntax
        return "<?php ".$pattern;
    }

    /**
    * Whether a Query matches a node.
    * In order to process meta characters, this method receive a context
    * and code base analyzed by Phan.
    *
    * @param CodeBase $code_base A code base received from Phan.
    * @param Context  $context   A context analyzed by Phan.
    * @param mixed    $target    A object used for matching.
    * @param mixed    $query     A object used for matching.
    * @return boolean result
    */
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

    /**
    * Whether a Query node matches a node.
    * In order to process meta characters, this method receive a context
    * and code base analyzed by Phan.
    *
    * @param CodeBase $code_base A code base received from Phan.
    * @param Context  $context   A context analyzed by Phan.
    * @param Node     $target    A node used for matching.
    * @param Node     $query     A node used for matching.
    * @return boolean result
    */
    private function matchNode(CodeBase $code_base, Context $context, Node $target, Node $query): Bool
    {
        // If target node is variable, resolving types of the variable.
        if ($target->kind === \ast\AST_VAR && $query->kind === \ast\AST_VAR) {
            $ctx_node = new ContextNode($code_base, $context, $target);
            $types = array_map(function ($type) {
                return $type->__toString();
            }, $ctx_node->getVariable()->getUnionType()->getTypeSet());

            // If the query has AnyInstanceOfClass meta character, checking whether match with type.
            if (preg_match('/'.self::T_ANY_INSTANCE_OF.'(.*)/', $query->children['name'], $matches) === 1) {
                $klass = $matches[1];

                if ($klass === "any") {
                    // `<any>` is matched with any instance
                    return true;
                } else {
                    $klass = str_replace(self::T_NS, "\\", $klass);
                    // It also supports omitting the root namespace.
                    return in_array($klass, $types, true) || in_array("\\".$klass, $types, true);
                }
            }
        }
        if ($target->kind !== $query->kind || $target->flags !== $query->flags) {
            return false;
        }
        return $this->match($code_base, $context, $target->children, $query->children);
    }
}
