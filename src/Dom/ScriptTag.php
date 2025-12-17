<?php

namespace Wexample\PhpHtml\Dom;

class ScriptTag extends HtmlTag
{
    protected string $tagName = 'script';

    public function getSrc(): ?string
    {
        return $this->getAttr('src');
    }

    public function setSrc(string $src): static
    {
        return $this->setAttr('src', $src);
    }

    public function getAsync(): bool
    {
        return array_key_exists('async', $this->attributes);
    }

    public function setAsync(bool $async = true): static
    {
        if ($async) {
            $this->attributes['async'] = 'async';
        } else {
            unset($this->attributes['async']);
        }
        return $this;
    }

    public function getDefer(): bool
    {
        return array_key_exists('defer', $this->attributes);
    }

    public function setDefer(bool $defer = true): static
    {
        if ($defer) {
            $this->attributes['defer'] = 'defer';
        } else {
            unset($this->attributes['defer']);
        }
        return $this;
    }

    public function getType(): ?string
    {
        return $this->getAttr('type');
    }

    public function setType(string $type): static
    {
        return $this->setAttr('type', $type);
    }

    public function render(): string
    {
        return parent::render() . '</script>';
    }
}
