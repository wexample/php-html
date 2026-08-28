# php_html

Version: 0.1.7

php-html gives PHP ≥ 8.2 developers typed object representations of common HTML tags: `LinkTag` and `ScriptTag` each extend the abstract `HtmlTag`, which manages a keyed attribute map and exposes a `render()` / `__toString()` method that emits the opening tag as a string. The companion `DomHelper` provides procedural alternatives — `buildTag()` and `buildTagAttributes()` assemble HTML from a plain array of attributes, while `buildStringIdentifier()` converts arbitrary text to a stable kebab-case identifier kept in sync with its JavaScript counterpart. The library targets Wexample-suite projects and any PHP codebase that needs to construct or manipulate HTML markup without concatenating raw strings by hand.

## Table of Contents

- [Architecture](#architecture)
- [Integration in the Suite](#integration-in-the-suite)
- [Dependencies](#dependencies)
- [Versioning & Compatibility Policy](#versioning--compatibility-policy)
- [License](#license)
- [About us](#about-us)
- [Migration Notes](#migration-notes)

## Architecture

The library is split into two namespaces under `src/`: `Dom` holds typed object representations of individual HTML elements; `Helper` holds procedural utilities that work from plain arrays.

### Dom — object-oriented tag model

src/Dom/HtmlTag.php is the abstract base every tag class extends. It owns a `$tagName` string and an associative `$attributes` array. All attribute access goes through `setAttr` / `getAttr` / `getAttribute`, where passing `null` to `setAttr` removes the key rather than storing it. `render()` iterates the array and emits the opening tag:

```php
sprintf('<%s%s>', $this->tagName, $attrs)
// → e.g. <link rel="stylesheet" href="/app.css">
```

`__toString()` delegates to `render()`, so any tag object can be interpolated directly into a string.

src/Dom/LinkTag.php sets `$tagName = 'link'` and pre-populates `rel="stylesheet"` in its constructor. It exposes typed getters and setters for `href`, `rel`, `media`, `crossorigin`, and `integrity`, each of which calls through to `setAttr` / `getAttr` on the base class.

src/Dom/ScriptTag.php sets `$tagName = 'script'` and adds typed accessors for `src`, `type`, `async`, and `defer`. Because `async` and `defer` are boolean attributes, `setAsync(true)` stores `'async' => 'async'` in the array while `setAsync(false)` removes the key; `getAsync()` tests presence with `array_key_exists`. `ScriptTag` also overrides `render()` to close the element:

```php
public function render(): string
{
    return parent::render() . '</script>';
}
```

#### Call path through a Dom tag

1. Instantiate `LinkTag` or `ScriptTag`.
2. Call typed setters — each writes to `$this->attributes` via `setAttr`.
3. Call `render()` (or cast to string) — iterates `$this->attributes`, escapes values with `htmlspecialchars(..., ENT_QUOTES)`, and returns the HTML string.

### Helper — procedural tag assembly

src/Helper/DomHelper.php is a static utility class for callers that work with plain arrays rather than objects.

`buildTagAttributes(array $attributes): string` joins a key-value array into a space-separated string of `key="value"` pairs, silently skipping any entry whose value is `null`.

`buildTag(string $tagName, array $attributes, string $body, ?bool $allowSingleTag): string` calls `buildTagAttributes` internally, then wraps the result in an opening tag. When `$allowSingleTag` is `null` the method consults the `TAG_ALLOWS_AUTO_CLOSING` constant (which currently marks `div` and `span` as non-self-closing); an explicit `true` produces a self-closing `/>` only when `$body` is empty.

`buildStringIdentifier(string $string): string` converts arbitrary text to a stable kebab-case identifier. The pipeline is:

1. Replace every character outside `[a-zA-Z0-9-]` with `-`.
2. Convert to kebab-case via `TextHelper::toKebab` (from `wexample/php-helpers`).
3. Collapse consecutive dashes and trim leading/trailing dashes.

The result is kept in sync with the JavaScript counterpart in `@wexample/js-helpers stringBuildIdentifier()`.

#### Call path through DomHelper

1. Call `DomHelper::buildTag($name, $attrs, $body)`.
2. Internally calls `buildTagAttributes($attrs)` to produce the attribute string.
3. Returns the complete HTML string, including body and closing tag when applicable.

## Integration in the Suite

This package is part of the Wexample Suite — a collection of high-quality, modular tools designed to work seamlessly together across multiple languages and environments.

### Related Packages

The suite includes packages for configuration management, file handling, prompts, and more. Each package can be used independently or as part of the integrated suite.

Visit the [Wexample Suite documentation](https://docs.wexample.com) for the complete package ecosystem.

## Dependencies

- php: >=8.2
- wexample/php-helpers: >=3.0.0

## Versioning & Compatibility Policy

Wexample packages follow **Semantic Versioning** (SemVer):

- **MAJOR**: Breaking changes
- **MINOR**: New features, backward compatible
- **PATCH**: Bug fixes, backward compatible

We maintain backward compatibility within major versions and provide clear migration guides for breaking changes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

Free to use in both personal and commercial projects.

## About us

[Wexample](https://wexample.com) stands as a cornerstone of the digital ecosystem — a collective of seasoned engineers, researchers, and creators driven by a relentless pursuit of technological excellence. More than a media platform, it has grown into a vibrant community where innovation meets craftsmanship, and where every line of code reflects a commitment to clarity, durability, and shared intelligence.

This packages suite embodies this spirit. Trusted by professionals and enthusiasts alike, it delivers a consistent, high-quality foundation for modern development — open, elegant, and battle-tested. Its reputation is built on years of collaboration, refinement, and rigorous attention to detail, making it a natural choice for those who demand both robustness and beauty in their tools.

Wexample cultivates a culture of mastery. Each package, each contribution carries the mark of a community that values precision, ethics, and innovation — a community proud to shape the future of digital craftsmanship.

## Migration Notes

When upgrading between major versions, refer to the migration guides in the documentation.

Breaking changes are clearly documented with upgrade paths and examples.
