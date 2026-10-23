<?php

namespace nadar\quill\listener;

use nadar\quill\BlockListener;
use nadar\quill\Lexer;
use nadar\quill\Line;

/**
 * Convert indent attributes into p tags with a Quill `ql-indent-N` class.
 *
 * @since 3.7.1-nc
 */
class Indent extends BlockListener
{
    /**
     * {@inheritDoc}
     */
    public function process(Line $line)
    {
        $indent = !$line->isDone() ? (int) $line->getAttribute('indent') : 0;
        if ($indent > 0) {
            $this->pick($line, ['indent' => $indent]);
            $line->setDone();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function render(Lexer $lexer)
    {
        $this->wrapElement('<p class="ql-indent-{indent}">{__buffer__}</p>', ['indent']);
    }
}
