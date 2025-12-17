<?php

namespace Wexample\PhpHtml\Dom;

class LinkTag extends HtmlTag
{
    protected string $tagName = 'link';

    public function __construct()
    {
        $this->setAttr('rel', 'stylesheet');
    }

    public function setHref(string $href): static
    {
        return $this->setAttr('href', $href);
    }

    public function setRel(string $rel): static
    {
        return $this->setAttr('rel', $rel);
    }

    public function setMedia(string $media): static
    {
        return $this->setAttr('media', $media);
    }

    public function setCrossOrigin(string $crossorigin): static
    {
        return $this->setAttr('crossorigin', $crossorigin);
    }

    public function setIntegrity(string $integrity): static
    {
        return $this->setAttr('integrity', $integrity);
    }
}
