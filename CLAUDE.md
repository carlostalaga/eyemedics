# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Custom WordPress theme for EyeMedics, a medical practice. Built with ACF flexible content, Bootstrap 5, and compiled via CodeKit 3. Text domain: `bystra`.

## Build & Asset Compilation

**There is no npm, webpack, or vite.** SCSS is compiled by **CodeKit 3** (macOS app). Do not run manual SCSS compilation. Edit `.scss` files and CodeKit handles compilation to `style.css`.

- SCSS entry point: `scss/style.scss`
- Color variables: `scss/colours.scss`
- Typography: `scss/fonts.scss` (din-2014 font family via Adobe Typekit)
- Third-party overrides: `scss/vendors.scss`, `scss/swiper.scss`

## Architecture

### Flexible Content Pattern

Every page uses ACF flexible content. The dispatcher is `blocks/flexible-content.php` — it reads the ACF `flexible_content` field and routes each layout to the appropriate block template via a `switch` statement. All block templates live in `blocks/block-*.php`.

When adding a new block:
1. Create `blocks/block-{name}.php`
2. Add a `case '{name}':` entry in `blocks/flexible-content.php`
3. Define the ACF field group in the WordPress admin (synced to `acf-json/`)

### Custom Post Types (registered in `functions.php`)

- `doctors_staff` — taxonomy: `specialist_fields`
- `consulting_locations`
- `operating_locations`
- `conditions` — taxonomy: `segment`

### Reusable Components (`inc/`)

Shared PHP partials included across multiple templates. Not blocks — these are `get_template_part()` includes for recurring UI (e.g., `inc/component-doctor-staff-card.php`, `inc/content-intro.php`).

### ACF JSON

Field group definitions are synced to `acf-json/`. The master flexible content field (all 25+ layouts) is `acf-json/group_6670bd6172100.json`. Edit fields in the WP admin and let ACF sync the JSON.

### JavaScript

`js/main.js` handles: custom navigation behavior, Google Maps initialization, and Swiper carousel setup. Enqueued via `functions.php`. Third-party libraries (Bootstrap, Swiper, GSAP, LightGallery) are loaded via CDN.

## Coding Standards

### PHP Templates

Use `if(): / endif:` syntax — never braces — for template conditionals:

```php
// Correct
if($condition):
    echo esc_html($var);
endif;
```

- 4-space indentation
- Prefix ACF variables with context: `$accordion_headline`, `$hero_image`
- Escape all output: `<?php echo esc_html($var); ?>`
- Use ASCII art block headers for major sections in template files

### SCSS

- Use `@use` for imports (not `@import`)
- 4-space indentation
- Group related styles with ASCII art headers

### General

- Prefer Bootstrap 5 utility classes over custom CSS where possible

## Coding Guidelines

### 1. Think Before Coding

Before implementing: state assumptions explicitly, ask if uncertain. If multiple interpretations exist, present them — don't pick silently. If a simpler approach exists, say so. If something is unclear, name what's confusing and ask.

### 2. Simplicity First

Minimum code that solves the problem. No features beyond what was asked, no abstractions for single-use code, no unrequested flexibility or configurability, no error handling for impossible scenarios.

### 3. Surgical Changes

Touch only what's necessary. Don't improve adjacent code, comments, or formatting. Match existing style. If unrelated dead code is noticed, mention it — don't delete it. Remove only imports/variables/functions that your own changes made unused.

### 4. Goal-Driven Execution

For multi-step tasks, state a brief plan before starting:

```
1. [Step] → verify: [check]
2. [Step] → verify: [check]
3. [Step] → verify: [check]
```
