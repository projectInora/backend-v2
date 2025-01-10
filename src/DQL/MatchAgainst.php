<?php
/**
 * MatchAgainst
 *
 * Definition for MATCH AGAINST MySQL instruction to be used in DQL Queries
 *
 * Usage: MATCH_AGAINST(column[, column, ;;.], :text)
 *
 * @author jeremy.hubert@infogroom.fr
 * using work of http://groups.google.com/group/doctrine-user/browse_thread/thread/69d1f293e8000a27
 */
namespace App\DQL;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\TokenType;

/**
 * "MATCH_AGAINST" "(" {StateFieldPathExpression ","}* Literal ")"
 */
class MatchAgainst extends FunctionNode {
    public array $columns = array();
    public Literal $needle;

    /**
     * @throws QueryException
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        do {
            $this->columns[] = $parser->StateFieldPathExpression();
            $parser->match(TokenType::T_COMMA);
        }
        while ($parser->getLexer()->isNextToken(TokenType::T_IDENTIFIER));
        $this->needle = $parser->Literal();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        $haystack = null;
        $first = true;
        foreach ($this->columns as $column) {
            $first ? $first = false : $haystack .= ', ';
            $haystack .= $column->dispatch($sqlWalker);
        }
        return "MATCH(" .
            $haystack .
            ") AGAINST (" .
            $this->needle->dispatch($sqlWalker) .
            " IN NATURAL LANGUAGE MODE )";
    }
}