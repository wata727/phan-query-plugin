<?php declare(strict_types=1);

namespace PhanQueryPlugin;

use Phan\PluginV2\PluginAwareAnalysisVisitor;
use ast\Node;

/**
* This plugin's visitor processes a node based on kind of the node.
* If the received node is matched with a query's pattern, this visitor emits a issue.
*
* https://github.com/phan/phan/blob/0.12.5/src/Phan/AST/Visitor/KindVisitorImplementation.php
*/
class Visitor extends PluginAwareAnalysisVisitor
{
    // phpcs:disable
    public function visitArgList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitArray(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitArrayElem(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitAssign(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitAssignOp(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitAssignRef(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitBinaryOp(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitBreak(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitCall(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitCast(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitCatch(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitClass(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitClassConst(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitClassConstDecl(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitClosure(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitClosureUses(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitClosureVar(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitCoalesce(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitConst(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitConstDecl(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitConstElem(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitDeclare(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitDim(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitDoWhile(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitEcho(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitEmpty(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitEncapsList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitExit(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitExprList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitForeach(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitFuncDecl(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitIsset(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitGlobal(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitGreater(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitGreaterEqual(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitGroupUse(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitIf(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitIfElem(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitInstanceof(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitMagicConst(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitMethod(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitMethodCall(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitName(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitNamespace(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitNew(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitParam(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitParamList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitPreInc(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitPrint(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitProp(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitPropDecl(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitPropElem(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitReturn(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitStatic(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitStaticCall(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitStaticProp(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitStmtList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitSwitch(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitSwitchCase(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitSwitchList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitType(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitNullableType(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUnaryMinus(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUnaryOp(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUse(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUseElem(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUseTrait(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitVar(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitWhile(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitAnd(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitCatchList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitClone(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitConditional(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitContinue(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitFor(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitGoto(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitHaltCompiler(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitIncludeOrEval(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitLabel(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitMethodReference(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitNameList(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitOr(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitPostDec(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitPostInc(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitPreDec(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitRef(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitShellExec(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitSilence(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitThrow(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitTraitAdaptations(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitTraitAlias(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitTraitPrecedence(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitTry(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUnaryPlus(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUnpack(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitUnset(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitYield(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }

    public function visitYieldFrom(Node $node)
    {
        $this->emitIssueIfMatch($node);
    }
    // phpcs:enable

    /**
    * A issue emitter interface
    *
    * If the received node is matched with a query's pattern,
    * this method emits a issue based on the query's metadata.
    * All visitor method inheried from PluginAwareAnalysisVisitor calls this method.
    *
    * @param Node $node A node to analyze.
    * @return void
    */
    private function emitIssueIfMatch(Node $node)
    {
        foreach (Query::load() as $query) {
            if ($query->match($this->code_base, $this->context, $node, $query->node)) {
                $this->emit(
                    $query->issueType,
                    $query->message,
                    []
                );
            }
        }
    }
}
