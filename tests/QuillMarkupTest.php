<?php

namespace nadar\quill\tests;

use nadar\quill\Lexer;
use PHPUnit\Framework\TestCase;

class QuillMarkupTest extends TestCase
{
    public function testBulletListUsesQuillMarkup()
    {
        $lexer = (new Lexer([
            ['insert' => 'Foo'], ['insert' => "\n", 'attributes' => ['list' => 'bullet']],
            ['insert' => 'Bar'], ['insert' => "\n", 'attributes' => ['list' => 'ordered']],
        ]))->quillMarkup();

        $this->assertSame(
            '<ol><li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>Foo</li>'
            . '<li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>Bar</li></ol>',
            str_replace(PHP_EOL, '', $lexer->render())
        );
    }

    public function testSizeUsesClass()
    {
        $lexer = (new Lexer([
            ['insert' => 'Big', 'attributes' => ['size' => 'large']], ['insert' => "\n"],
        ]))->quillMarkup();

        $this->assertSame('<p><span class="ql-size-large">Big</span></p>', str_replace(PHP_EOL, '', $lexer->render()));
    }

    public function testIndentedParagraph()
    {
        $lexer = new Lexer([['insert' => 'Hi'], ['insert' => "\n", 'attributes' => ['indent' => 2]]]);

        $this->assertSame('<p class="ql-indent-2">Hi</p>', str_replace(PHP_EOL, '', $lexer->render()));
    }

    public function testNullJsonRendersEmpty()
    {
        $this->assertSame('', trim((string) (new Lexer(null))->render()));
    }

    public function testUpstreamDefaultsStayUnchanged()
    {
        $lexer = new Lexer([['insert' => 'Foo'], ['insert' => "\n", 'attributes' => ['list' => 'bullet']]]);

        $this->assertStringStartsWith('<ul>', $lexer->render());
    }
}
