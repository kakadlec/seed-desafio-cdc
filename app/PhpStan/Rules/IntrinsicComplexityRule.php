<?php

declare(strict_types=1);

namespace App\PhpStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Class_> */
class IntrinsicComplexityRule implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     * @return list<\PHPStan\Rules\RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $icp = $this->countIcps($node, $scope);
        if ($icp > 10) {
            return [
                RuleErrorBuilder::message(sprintf(
                    'Class %s has %d Intrinsic Complexity Points, exceeding the limit of 10.',
                    $node->name->toString(),
                    $icp
                ))->build(),
            ];
        }

        return [];
    }

    private function countIcps(Class_ $class, Scope $scope): int
    {
        $count = 0;
        $visitor = new class($scope, $count) extends NodeVisitorAbstract {
            private Scope $scope;
            public int $count;

            public function __construct(Scope $scope, int &$count)
            {
                $this->scope = $scope;
                $this->count = &$count;
            }

            public function enterNode(Node $node)
            {
                // Branches
                if (
                    $node instanceof Node\Stmt\If_
                    || $node instanceof Node\Stmt\ElseIf_
                    || $node instanceof Node\Stmt\For_
                    || $node instanceof Node\Stmt\Foreach_
                    || $node instanceof Node\Stmt\While_
                    || $node instanceof Node\Stmt\Do_
                    || $node instanceof Node\Stmt\Switch_
                ) {
                    $this->count++;
                }

                // Conditions
                if (
                    $node instanceof Node\Expr\BinaryOp\BooleanAnd
                    || $node instanceof Node\Expr\BinaryOp\BooleanOr
                    || $node instanceof Node\Expr\BinaryOp\Greater
                    || $node instanceof Node\Expr\BinaryOp\Smaller
                ) {
                    $this->count++;
                }

                // Exception handling
                if ($node instanceof Node\Stmt\TryCatch) {
                    $this->count++;
                }

                // Internal coupling (new App\* classes)
                if (
                    $node instanceof Node\Expr\New_
                    && $node->class instanceof Node\Name
                    && str_starts_with((string) $node->class, 'App\\')
                ) {
                    $this->count++;
                }

                return null;
            }
        };

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($class->stmts);

        return $count;
    }
}
