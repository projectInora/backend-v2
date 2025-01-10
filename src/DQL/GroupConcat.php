<?php

namespace App\DQL;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\TokenType;

class GroupConcat extends FunctionNode
{
    public bool $isDistinct = false;

    public ArithmeticExpression|null $pathExp = null;

    public Node|null $separator = null;

    public OrderByClause|null $orderBy = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(TokenType::T_DISTINCT)) {
            $parser->match(TokenType::T_DISTINCT);

            $this->isDistinct = true;
        }

        // first Path Expression is mandatory
        $this->pathExp = [];
        if ($lexer->isNextToken(TokenType::T_IDENTIFIER)) {
            $this->pathExp[] = $parser->StringExpression();
        } else {
            $this->pathExp[] = $parser->SingleValuedPathExpression();
        }

        while ($lexer->isNextToken(TokenType::T_COMMA)) {
            $parser->match(TokenType::T_COMMA);
            $this->pathExp[] = $parser->StringPrimary();
        }

        if ($lexer->isNextToken(TokenType::T_ORDER)) {
            $this->orderBy = $parser->OrderByClause();
        }

        if ($lexer->isNextToken(TokenType::T_IDENTIFIER)) {
            if (strtolower($lexer->lookahead['value']) !== 'separator') {
                $parser->syntaxError('separator');
            }
            $parser->match(TokenType::T_IDENTIFIER);

            $this->separator = $parser->StringPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        $result = 'GROUP_CONCAT(' . ($this->isDistinct ? 'DISTINCT ' : '');

        $fields = [];
        foreach ($this->pathExp as $pathExp) {
            $fields[] = $pathExp->dispatch($sqlWalker);
        }

        $result .= sprintf('%s', implode(', ', $fields));

        if ($this->orderBy) {
            $result .= ' '.$sqlWalker->walkOrderByClause($this->orderBy);
        }

        if ($this->separator) {
            $result .= ' SEPARATOR '.$sqlWalker->walkStringPrimary($this->separator);
        }

        $result .= ')';

        return $result;
    }
}
