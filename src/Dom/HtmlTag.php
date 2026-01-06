<?php

namespace Wexample\PhpHtml\Dom;

abstract class HtmlTag
{
    protected string $tagName;
    protected array $attributes = [];

    public function setId(string $id): static
    {
        $this->attributes['id'] = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->getAttribute('id');
    }

    public function setAttr(string $name, ?string $value): static
    {
        if ($value === null) {
            unset($this->attributes[$name]);

            return $this;
        }

        $this->attributes[$name] = $value;

        return $this;
    }

    public function getAttr(string $name): ?string
    {
        return $this->getAttribute($name);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name): ?string
    {
        return $this->attributes[$name] ?? null;
    }

    public function render(): string
    {
        $attrs = '';
        foreach ($this->attributes as $k => $v) {
            $attrs .= sprintf(' %s="%s"', $k, htmlspecialchars($v, ENT_QUOTES));
        }

        return sprintf('<%s%s>', $this->tagName, $attrs);
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
