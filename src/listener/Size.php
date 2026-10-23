<?php

namespace nadar\quill\listener;

use nadar\quill\InlineListener;
use nadar\quill\Line;

/**
 * Convert size attributes into span tag with font-size style.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 3.7.0
 */
class Size extends InlineListener
{
    /**
     * @var boolean If ignore is enabled, the size won't apply. This can be useful if font size is disabled in your quill editor
     * but people copy paste content from somewhere else which will then generate the size attribute.
     */
    public $ignore = false;

    /**
     * @var boolean Emit Quill's `ql-size-<size>` class instead of an inline font-size style.
     * @since 3.7.1-nc
     */
    public $useClass = false;

    /**
     * {@inheritDoc}
     */
    public function process(Line $line)
    {
        if (($size = $line->getAttribute('size'))) {
            if ($this->useClass && !$this->ignore) {
                $class = 'ql-size-' . preg_replace('/[^a-z0-9_-]/i', '-', $size);
                if (strpos($line->getInput(), '<') === false) {
                    // plain text has no tag to carry the class yet
                    $this->updateInput($line, '<span class="' . $class . '">' . $line->getInput() . '</span>');
                } else {
                    $line->addClassName($class);
                }
                return;
            }

            $this->updateInput($line, $this->ignore ? $line->getInput() : '<span style="font-size:'.$line->getLexer()->escape($size).'">'.$line->getInput().'</span>');
        }
    }
}
