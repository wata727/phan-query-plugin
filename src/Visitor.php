<?php declare(strict_types=1);

namespace PhanQueryPlugin;

use Phan\AST\ContextNode;
use Phan\PluginV2\PluginAwareAnalysisVisitor;
use ast\Node;

class Visitor extends PluginAwareAnalysisVisitor {
    // TODO: Implement

    // A plugin's visitors should NOT implement visit(), unless they need to.
    /**
     * @param Node $node
     * A node to analyze
     *
     * @return void
     *
     * @override
     */
    public function visitMethodCall(Node $node)
    {
        // $ctx = new ContextNode($this->code_base, $this->context, $node);
        // var_dump($ctx->getQualifiedNameList());
        $query = Query::load();

        if ($query->match($node)) {
            // $this->emitIssue(
            //     $query->issueType,
            //     $node->lineno,
            //     $query->message
            // );
        }
    }
}
