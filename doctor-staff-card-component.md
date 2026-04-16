# Doctor/Staff Card Component

## Purpose

This document explains the shared Doctor/Staff card implementation used across the theme to avoid duplicated markup while preserving context-specific behavior.

The card design is now maintained in one place, while each template still controls:

- how doctors/staff are queried
- which data values are passed into the card
- empty-state messaging and surrounding layout

## Files Involved

- `inc/component-doctor-staff-card.php`
  - Defines reusable functions:
    - `bystra_format_doctor_staff_specialisations()`
    - `bystra_get_doctor_staff_card_data()`
    - `bystra_render_doctor_staff_grid_card()`
    - `bystra_render_doctor_staff_slider_card()`
- `functions.php`
  - Loads the component file with:
    - `require_once get_template_directory() . '/inc/component-doctor-staff-card.php';`
- `search-filter/1.php`
  - Uses the shared formatter and shared card renderer for Search & Filter results.
- `page-locations.php`
  - Uses the shared formatter and shared card renderer for location-specific doctor cards.
- `blocks/block-slider-doctors.php`
  - Uses the shared formatter and shared card renderer with the slider layout variant.

## Architecture

The component split is intentionally simple:

1. **Data retrieval stays in template context**
   - Each template queries posts and reads ACF fields based on its own needs.
2. **Data normalization and mapping are centralized**
   - `bystra_get_doctor_staff_card_data()` maps shared post + ACF fields into one card-data array.
   - `bystra_format_doctor_staff_specialisations()` normalizes mixed specialisations return types.
3. **Markup rendering is centralized**
   - `bystra_render_doctor_staff_grid_card()` renders Bootstrap grid cards.
   - `bystra_render_doctor_staff_slider_card()` renders slick slider cards.

This keeps one source of truth for the card UI but avoids creating heavy abstractions around query logic.

## Function Reference

### `bystra_format_doctor_staff_specialisations($doctor_staff_specialisations_raw)`

### Why it exists

`doctor_staff_specialisations` can come back from ACF in different formats depending on field settings and context (string, term relationship, post relationship, scalar arrays).  
This helper ensures a predictable display string.

### Input handling

- Empty value -> returns `''`
- Array of `WP_Term` -> joins term names with `, `
- Array of `WP_Post` -> joins post titles with `, `
- Array of scalars -> joins values with `, `
- Scalar value -> casts to string
- Other types -> returns `''`

### Output

- Returns a string intended for output with `wp_kses_post()`

### `bystra_get_doctor_staff_card_data($doctor_staff_post_id, array $doctor_staff_overrides = array())`

### Why it exists

The same doctor/staff field mapping was repeated in multiple templates.  
This helper removes that duplication by returning a normalized card payload from one post ID.

### Base data it builds

- `post_id`
- `name`
- `profile_url`
- `title`
- `specialisations_display`
- `image_url`
- `image_alt`
- `heading_variant` (default `split`)

### Image handling

Supports multiple ACF/image return formats:

- image array (preferred in this project)
- attachment ID
- direct URL string

### Overrides

Pass overrides to set context-specific output without re-building the base payload in templates.  
Examples:

- `array('heading_variant' => 'inline')`

### `bystra_render_doctor_staff_grid_card(array $doctor_staff_card_data)`

### Required keys

- `name`
- `profile_url`

### Optional keys

- `title`
- `specialisations_display`
- `image_url`
- `image_alt` (defaults to `name`)
- `heading_variant` (`split` or `inline`)

### Shared UI behavior

- Keeps the original card wrapper layout and classes:
  - `bg-white p-4 h-100`
  - `row g-5 align-items-center h-100`
- Preserves responsive width behavior:
  - with image: image `col-5`, content `col-7`
  - without image: content `col-12`
- Preserves button style:
  - `btn btn-sm btn-verde`

### Heading variants

- `split` (default):
  - title and name render as separate `<h6>` lines
- `inline`:
  - title and name render in a single `<h6>` with line break after title (if title exists)

This allows each context to preserve its original visual rhythm without duplicating full card markup.

### `bystra_render_doctor_staff_slider_card(array $doctor_staff_card_data)`

### Required keys

- `name`
- `profile_url`

### Optional keys

- `title`
- `specialisations_display`
- `image_url`
- `image_alt` (defaults to `name`)

### Slider behavior

- Preserves the original slider markup/classes:
  - outer anchor: `text-posidonia slider-doctor-card`
  - card wrapper: `magnify bg-white p-3`
  - image wrapper: `slider-doctor-image mb-3`
  - content wrappers: `slider-doctor-info`, `slider-doctor-title`, `slider-doctor-name`, `slider-doctor-specialisations`
- Keeps the CTA as a non-link button-styled `<span>` because the full card is already the link target.

## Current Usage

### Search & Filter results (`search-filter/1.php`)

- Builds card data via `bystra_get_doctor_staff_card_data($id, array('heading_variant' => 'inline'))`
- Renders with `bystra_render_doctor_staff_grid_card()`

### Locations tab cards (`page-locations.php`)

- Builds card data via `bystra_get_doctor_staff_card_data($id, array('heading_variant' => 'split'))`
- Renders with `bystra_render_doctor_staff_grid_card()`

### Slider doctors block (`blocks/block-slider-doctors.php`)

- Builds card data via `bystra_get_doctor_staff_card_data($id)`
- Renders with `bystra_render_doctor_staff_slider_card()`

## Escaping and Security

The renderer keeps output escaping aligned with WordPress best practices:

- URL values -> `esc_url()`
- Attributes (`aria-label`, `alt`, class interpolation) -> `esc_attr()`
- Text values (`name`, `title`) -> `esc_html()`
- Specialisations rich text/string -> `wp_kses_post()`

## How To Use In Another Template

1. Query doctor/staff posts in that template.
2. Build normalized card data from the post ID.
3. Optionally override `heading_variant` for grid contexts.
4. Render with the appropriate explicit function:

```php
$doctor_card_data = bystra_get_doctor_staff_card_data(
    $doctor_post_id,
    array(
        'heading_variant' => 'split',
    )
);

bystra_render_doctor_staff_grid_card($doctor_card_data);
```

```php
$doctor_card_data = bystra_get_doctor_staff_card_data($doctor_post_id);
bystra_render_doctor_staff_slider_card($doctor_card_data);
```

## Testing Checklist

When adjusting this component, verify all contexts:

- Doctors & Staff page (Search & Filter results)
- Locations page tabs (doctor cards per location)
- Slider Doctors block (slick slider cards)

For each page, confirm:

- card renders with image and without image
- title present/absent behavior
- specialisations render when present and hide when empty
- card links and button links point to profile URL
- card classes/layout remain unchanged

## Extension Guidance

If you need additional visual differences in future contexts:

- Prefer adding small optional keys to the renderer data array.
- Avoid adding query logic inside the component file.
- Keep context-specific empty-state messages in the calling template.

This preserves a clean separation between data source and presentation.

## Slider Troubleshooting

If slider cards break or look incorrect, validate this contract first:

- The outer wrapper remains `slider-doctors slick-slider` in `blocks/block-slider-doctors.php`.
- Each rendered item keeps `slider-doctor-card` as the card anchor class.
- The child class names are unchanged (`slider-doctor-image`, `slider-doctor-info`, `slider-doctor-title`, `slider-doctor-name`, `slider-doctor-specialisations`).
- Slick initialization still targets the same container selector.
