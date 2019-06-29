<?php

declare(strict_types=1);

namespace AdamWojs\PhpCsFixerSingleLineVarPhpdoc\Fixer\Phpdoc;

use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\Fixer\DefinedFixerInterface;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

final class SingleLineVarPhpDocFixer implements DefinedFixerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition('Single line @var phpdoc should be used if no additional description provided', []);
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_DOC_COMMENT);
    }

    /**
     * {@inheritdoc}
     */
    public function isRisky(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        $tokens->rewind();

        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(T_DOC_COMMENT)) {
                continue;
            }

            $docBlock = new DocBlock($token->getContent());

            if (count($docBlock->getLines()) !== 3) {
                continue;
            }

            if (count($docBlock->getAnnotations()) !== 1) {
                continue;
            }

            $annotation = $docBlock->getAnnotation(0);
            if ($annotation->getTag()->getName() === 'var') {
                $source = $annotation->getContent();
                $target = trim(mb_substr($source, strpos($source, '@var ') + 5));

                $comment = sprintf('/** @var %s */', $target);

                $tokens[$index] = new Token([T_DOC_COMMENT, $comment]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'AdamWojs/phpdoc_force_single_line_var';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return -6;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(SplFileInfo $file): bool
    {
        return true;
    }
}
