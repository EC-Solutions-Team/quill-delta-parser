# EC-Solutions-Team fork

Fork of [nadar/quill-delta-parser](https://github.com/nadar/quill-delta-parser) used by NCWebTemplate.
Branch `nc-patches` is upstream `3.7.1` plus the patches below. Tags are `3.7.1-pN`.

| Patch | Where |
|---|---|
| `Lexer::quillMarkup()` switches on Quill 2 markup (off by default, so upstream tests still pass) | `Lexer`, `Lists`, `Size` |
| `<ol><li data-list="...">` + `ql-ui` span lists | `Lists::$quillMarkup` |
| `ql-size-*` classes instead of inline font-size | `Size::$useClass` |
| `ql-indent-N` paragraphs | new `listener/Indent` |
| `Line::addClassName()`, `getClassNames()`, `setAsInline(bool)` | `Line` |
| Paragraph closing around inline runs | `listener/Text` |
| Don't re-mark done lines as picked; mark inline lines done after pick | `Listener`, `InlineListener` |
| Null / invalid json renders as empty | `Lexer::getJsonArray`, `decodeJson` |

To update: `git fetch upstream --tags && git rebase <new-tag>` on `nc-patches`, run `vendor/bin/phpunit -c actions.phpunit.xml`, tag `<new-tag>-p1`.
