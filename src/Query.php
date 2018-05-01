<?php declare(strict_types=1);

namespace PhanQueryPlugin;

use \ast\Node;

class Query
{
    const CONFIG_FILE = '.phan/query.php';

    private $node;

    public static function load(string $config = self::CONFIG_FILE): Query
    {
        foreach (require($config) as $pattern) {
            $root = \ast\parse_code(self::prepare($pattern['pattern']), 40); // TODO: get AST_VERSION from Phan
        }

        // Drop T_OPEN_TAG
        return new Query($root->children[0]);
    }

    public static function prepare(string $pattern): string
    {
        // TODO: replace meta charactor
        return "<?php " . $pattern;
    }

    public function __construct(Node $node)
    {
        $this->node = $node;
        // TODO: Accept issueType and message
        $this->issueType = "PhanQueryFound";
        $this->message = "Query matched";
    }

    public function match(Node $node): Bool
    {
        return $this->isEqualsWithoutLineno($this->node, $node);
    }

    /**
    * Verify that it is the same except for line number of Node.
    *
    * @param mixed $a Object to compare.
    * @param mixed $b Object to compare.
    * @return boolean Result.
    */
    private function isEqualsWithoutLineno($a, $b): Bool
    {
        if (is_array($a)) {
            if (!is_array($b)) {
                return false;
            }
            foreach ($a as $key => $value) {
                if (!(array_key_exists($key, $b) && $this->isEqualsWithoutLineno($value, $b[$key]))) {
                    return false;
                }
            }
        } elseif ($a instanceof Node) {
            if (!$b instanceof Node) {
                return false;
            }
            if ($a->kind !== $b->kind || $a->flags !== $b->flags) {
                return false;
            }
            return $this->isEqualsWithoutLineno($a->children, $b->children);
        } elseif ($a !== $b) {
            return false;
        }
        return true;
    }
}
