<?php

namespace Wexample\PhpHtml\Dom;

class LinkTag extends HtmlTag
{
    protected string $tagName = 'link';

    public function __construct()
    {
        $this->attr('rel', 'stylesheet');
    }

    public function href(string $href): static
    {
        return $this->attr('href', $href);
    }

    public function rel(string $rel): static
    {
        return $this->attr('rel', $rel);
    }

    public function media(string $media): static
    {
        return $this->attr('media', $media);
    }

    public function crossorigin(string $crossorigin): static
    {
        return $this->attr('crossorigin', $crossorigin);
    }

    public function integrity(string $integrity): static
    {
        return $this->attr('integrity', $integrity);
    }
}
