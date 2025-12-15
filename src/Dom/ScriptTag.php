<?php

namespace Wexample\PhpHtml\Dom;

class ScriptTag extends HtmlTag
{
    protected string $tagName = 'script';

    public function src(string $src): static
    {
        return $this->attr('src', $src);
    }

    public function async(bool $async = true): static
    {
        if ($async) {
            $this->attributes['async'] = 'async';
        } else {
            unset($this->attributes['async']);
        }
        return $this;
    }

    public function defer(bool $defer = true): static
    {
        if ($defer) {
            $this->attributes['defer'] = 'defer';
        } else {
            unset($this->attributes['defer']);
        }
        return $this;
    }

    public function type(string $type): static
    {
        return $this->attr('type', $type);
    }

    public function render(): string
    {
        return parent::render() . '</script>';
    }
}
