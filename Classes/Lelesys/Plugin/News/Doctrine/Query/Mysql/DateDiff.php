<?php

namespace Lelesys\Plugin\News\Doctrine\Query\Mysql;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * DateDiffFunction ::= "DATEDIFF" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class DateDiff extends FunctionNode {

	public $firstDateExpression = null;
	public $secondDateExpression = null;

	/**
	 * Get Sql
	 *
	 * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
	 * @return string
	 */
	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker) {
		return 'DATEDIFF(' .
				$this->firstDateExpression->dispatch($sqlWalker) . ',' .
				$this->secondDateExpression->dispatch($sqlWalker) .
				')';
	}

	/**
	 * Parse the query string
	 *
	 * @param \Doctrine\ORM\Query\Parser $parser
	 * @return void
	 */
	public function parse(\Doctrine\ORM\Query\Parser $parser) {
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);
		$this->firstDateExpression = $parser->ArithmeticPrimary();
		$parser->match(Lexer::T_COMMA);
		$this->secondDateExpression = $parser->ArithmeticPrimary();
		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

}

?>