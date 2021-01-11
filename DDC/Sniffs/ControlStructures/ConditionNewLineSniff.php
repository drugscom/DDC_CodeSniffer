<?php
/**
 * Verifies that a new line is present between a closing bracket and a condition.
 *
 * @author    Andre Sencioles <andre.sencioles@drugs.com>
 */

namespace DDC\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class ConditionNewLineSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = [
        'PHP',
        'JS',
    ];


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return int[]
     */
    public function register()
    {
        return [
            T_CATCH,
            T_FINALLY,
            T_ELSE,
            T_ELSEIF,
        ];

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File    $phpcsFile The file being scanned.
     * @param integer $stackPtr  The position of the current token in the
     *                           stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens   = $phpcsFile->getTokens();
        $closer   = $phpcsFile->findPrevious(T_CLOSE_CURLY_BRACKET, ($stackPtr - 1));
        $newlines = ($tokens[$stackPtr]['line'] - $tokens[$closer]['line']);

        // Condition must be on the line following the close bracket.
        if ($newlines !== 1) {
            $keyword = $tokens[$stackPtr]['content'];
            $error   = 'Expected 1 newline before condition keyword '.strtoupper($keyword).'; %s found';
            $data    = [$newlines];
            $fixable = true;

            // Error is fixable as long as there is no code between the closing bracket and the condition.
            $prevCode = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 1), $closer, true);
            if ($prevCode !== $closer) {
                $fixable = false;
            }

            if ($fixable !== true) {
                $phpcsFile->addError($error, $stackPtr, 'ConditionNewLine', $data);
                return;
            }

            $fix = $phpcsFile->addFixableError($error, $stackPtr, 'ConditionNewLine', $data);
            if ($fix === true) {
                $phpcsFile->fixer->beginChangeset();

                // Remove empty tokens between closing bracket and condition.
                for ($i = ($stackPtr - 1); $i > $closer; $i--) {
                    $phpcsFile->fixer->replaceToken($i, '');
                }

                $phpcsFile->fixer->addNewlineBefore($stackPtr);
                $phpcsFile->fixer->endChangeset();
            }//end if
        }//end if

    }//end process()


}//end class
