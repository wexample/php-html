<?php

namespace Wexample\PhpHtml\Dom;

class LinkTag extends HtmlTag
{
    protected string $tagName = 'link';

    public function __construct()
    {
        $this->setAttr('rel', 'stylesheet');
    }

    public function getHref(): ?string
    {
        return $this->getAttr('href');
    }

    public function setHref(string $href): static
    {
        return $this->setAttr('href', $href);
    }

    public function getRel(): ?string
    {
        return $this->getAttr('rel');
    }

    public function setRel(string $rel): static
    {
        return $this->setAttr('rel', $rel);
    }

    public function getMedia(): ?string
    {
        return $this->getAttr('media');
    }

    public function setMedia(string $media): static
    {
        return $this->setAttr('media', $media);
    }

    public function getCrossOrigin(): ?string
    {
        return $this->getAttr('crossorigin');
    }

    public function setCrossOrigin(string $crossorigin): static
    {
        return $this->setAttr('crossorigin', $crossorigin);
    }

    public function getIntegrity(): ?string
    {
        return $this->getAttr('integrity');
    }

    public function setIntegrity(string $integrity): static
    {
        return $this->setAttr('integrity', $integrity);
    }
}
