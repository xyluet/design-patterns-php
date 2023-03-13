<?php

namespace Patterns\FactoryMethod;

/**
 * Undocumented interface
 */
interface InputFormatInterface
{
    public function formatText(string $text): string;
}

/**
 * Undocumented class
 */
class TextInput implements InputFormatInterface
{
    public function formatText(string $text): string
    {
        return $text;
    }
}

/**
 * Undocumented class
 */
abstract class AbstractInputFormat implements InputFormatInterface
{
    protected $inputFormat;

    public function __construct(InputFormatInterface $inputFormat)
    {
        $this->inputFormat = $inputFormat;
    }

    public function formatText(string $text): string
    {
        return $this->inputFormat->formatText($text);
    }
}

class PlainTextFilter extends AbstractInputFormat
{
    public function formatText(string $text): string
    {
        $text = parent::formatText($text);

        return strip_tags($text);
    }
}

function displayCommentAsWebsite(InputFormatInterface $inputFormat, string $text)
{
    echo $inputFormat->formatText($text);
}

$dangerousComment = <<<HERE
Hello! Nice blog post!
Please visit my <a href='http://www.iwillhackyou.com'>homepage</a>.
<script src="http://www.iwillhackyou.com/script.js">
  performXSSAttack();
</script>
HERE;

$naiveInput = new TextInput();
displayCommentAsWebsite($naiveInput, $dangerousComment);

$dangerousForumPost = <<<HERE
# Welcome

This is my first post on this **gorgeous** forum.

<script src="http://www.iwillhackyou.com/script.js">
  performXSSAttack();
</script>
HERE;

$inputFormatter = new TextInput();
$inputFormatter = new PlainTextFilter($inputFormatter);
displayCommentAsWebsite($inputFormatter, $dangerousForumPost);
