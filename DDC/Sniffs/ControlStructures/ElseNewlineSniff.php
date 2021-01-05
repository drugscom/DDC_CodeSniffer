<?php

namespace DDC\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Checks that else/elseif statements start on a new line.
 * PHP version 5
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   Klaus Purer
 * @link     http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Checks that else/elseif statements start on a new line.
 * Unfortunately we need this sniff because
 * Drupal_Sniffs_ControlStructures_ControlSignatureSniff does not
 * detect this.
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   Klaus Purer
 * @link     http://pear.php.net/package/PHP_CodeSniffer
 */
class ElseNewlineSniff implements Sniff
{

	/**
	 * Returns an array of tokens this test wants to listen for.
	 * @return array
	 */
	public function register()
	{
		return [
			T_ELSE,
			T_ELSEIF,
		];
	}//end register()

	/**
	 * Processes this test, when one of its tokens is encountered.
	 * @param File $phpcsFile The file being scanned.
	 * @param int $stackPtr The position of the current token in the
	 *                                        stack passed in $tokens.
	 * @return void
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();
		$prevNonWhiteSpace = $phpcsFile->findPrevious(
			Tokens::$emptyTokens,
			($stackPtr - 1),
			null,
			true
		);

		if ($tokens[$prevNonWhiteSpace]['line'] === $tokens[$stackPtr]['line']) {
			$error = '%s must start on a new line';
			$data = [$tokens[$stackPtr]['content']];
			$phpcsFile->addError($error, $stackPtr, 'ElseNewline', $data);
		}
	}//end process()

}//end class
