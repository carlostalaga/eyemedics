<?php
/*
==============================================================================
    Shared Doctor/Staff Card Component
==============================================================================
*/

if (!function_exists('bystra_format_doctor_staff_specialisations')) :
    /**
     * Normalize doctor/staff specialisations to a display string.
     *
     * Handles mixed ACF return formats:
     * - string (already formatted content)
     * - array of WP_Term objects
     * - array of WP_Post objects
     * - array of scalar values
     *
     * @param mixed $doctor_staff_specialisations_raw Raw ACF value.
     *
     * @return string Normalized specialisations string (or empty).
     */
    function bystra_format_doctor_staff_specialisations($doctor_staff_specialisations_raw = '')
    {
        if (empty($doctor_staff_specialisations_raw)) :
            return '';
        endif;

        if (is_array($doctor_staff_specialisations_raw)) :
            $doctor_staff_specialisations_items = array();

            foreach ($doctor_staff_specialisations_raw as $doctor_staff_specialisation_item) :
                if ($doctor_staff_specialisation_item instanceof WP_Term) :
                    $doctor_staff_specialisations_items[] = $doctor_staff_specialisation_item->name;
                elseif ($doctor_staff_specialisation_item instanceof WP_Post) :
                    $doctor_staff_specialisations_items[] = get_the_title($doctor_staff_specialisation_item->ID);
                elseif (is_scalar($doctor_staff_specialisation_item)) :
                    $doctor_staff_specialisations_items[] = (string) $doctor_staff_specialisation_item;
                endif;
            endforeach;

            return implode(', ', array_filter($doctor_staff_specialisations_items));
        endif;

        if (is_scalar($doctor_staff_specialisations_raw)) :
            return (string) $doctor_staff_specialisations_raw;
        endif;

        return '';
    }
endif;

if (!function_exists('bystra_get_doctor_staff_card_data')) :
    /**
     * Build normalized doctor/staff card data from a post ID.
     *
     * This helper centralizes shared ACF field mapping so templates can avoid
     * repeating the same data-loading logic before rendering.
     *
     * @param int   $doctor_staff_post_id Post ID for a doctors_staff post.
     * @param array $doctor_staff_overrides Optional keys to override defaults
     *                                      (for example: heading_variant).
     *
     * @return array Normalized card data for grid/slider card renderers.
     */
    function bystra_get_doctor_staff_card_data($doctor_staff_post_id = 0, $doctor_staff_overrides = array())
    {
        $doctor_staff_id = absint($doctor_staff_post_id);
        if (!$doctor_staff_id) :
            return array();
        endif;

        $doctor_staff_name = get_the_title($doctor_staff_id);
        $doctor_staff_profile_url = get_permalink($doctor_staff_id);
        $doctor_staff_title_raw = get_field('doctor_staff_title', $doctor_staff_id);
        $doctor_staff_specialisations_raw = get_field('doctor_staff_specialisations', $doctor_staff_id);
        $doctor_staff_image_raw = get_field('doctor_staff_image', $doctor_staff_id);

        $doctor_staff_image_url = '';
        $doctor_staff_image_alt = $doctor_staff_name;

        if (is_array($doctor_staff_image_raw)) :
            $doctor_staff_image_alt = !empty($doctor_staff_image_raw['alt']) ? (string) $doctor_staff_image_raw['alt'] : $doctor_staff_image_alt;
            $doctor_staff_image_url = !empty($doctor_staff_image_raw['sizes']['576sm']) ? (string) $doctor_staff_image_raw['sizes']['576sm'] : '';

            if (empty($doctor_staff_image_url) && !empty($doctor_staff_image_raw['url'])) :
                $doctor_staff_image_url = (string) $doctor_staff_image_raw['url'];
            endif;
        endif;

        $doctor_staff_card_data = array(
            'post_id' => $doctor_staff_id,
            'name' => (string) $doctor_staff_name,
            'profile_url' => (string) $doctor_staff_profile_url,
            'title' => is_scalar($doctor_staff_title_raw) ? (string) $doctor_staff_title_raw : '',
            'specialisations_display' => bystra_format_doctor_staff_specialisations($doctor_staff_specialisations_raw),
            'image_url' => $doctor_staff_image_url,
            'image_alt' => $doctor_staff_image_alt,
            'heading_variant' => 'split',
        );

        if (is_array($doctor_staff_overrides)) :
            $doctor_staff_card_data = array_merge($doctor_staff_card_data, $doctor_staff_overrides);
        endif;

        return $doctor_staff_card_data;
    }
endif;

if (!function_exists('bystra_normalize_doctor_staff_card_render_data')) :
    /**
     * Normalize card payload for render helpers.
     *
     * @param array $doctor_staff_card_data Card data payload.
     *
     * @return array<string, string> Normalized render-ready fields.
     */
    function bystra_normalize_doctor_staff_card_render_data($doctor_staff_card_data = array())
    {
        $doctor_staff_card_data = is_array($doctor_staff_card_data) ? $doctor_staff_card_data : array();
        $doctor_staff_name = isset($doctor_staff_card_data['name']) ? (string) $doctor_staff_card_data['name'] : '';

        return array(
            'name' => $doctor_staff_name,
            'profile_url' => isset($doctor_staff_card_data['profile_url']) ? (string) $doctor_staff_card_data['profile_url'] : '',
            'title' => isset($doctor_staff_card_data['title']) ? (string) $doctor_staff_card_data['title'] : '',
            'specialisations_display' => isset($doctor_staff_card_data['specialisations_display']) ? (string) $doctor_staff_card_data['specialisations_display'] : '',
            'image_url' => isset($doctor_staff_card_data['image_url']) ? (string) $doctor_staff_card_data['image_url'] : '',
            'image_alt' => isset($doctor_staff_card_data['image_alt']) ? (string) $doctor_staff_card_data['image_alt'] : $doctor_staff_name,
            'heading_variant' => isset($doctor_staff_card_data['heading_variant']) ? (string) $doctor_staff_card_data['heading_variant'] : 'split',
        );
    }
endif;

if (!function_exists('bystra_render_doctor_staff_grid_card')) :
    /**
     * Render grid-style doctor/staff card markup.
     *
     * Required data:
     * - name
     * - profile_url
     *
     * Optional data:
     * - title
     * - specialisations_display
     * - image_url
     * - image_alt
     * - heading_variant ('split' | 'inline')
     *
     * @param array $doctor_staff_card_data Card data payload.
     *
     * @return void Outputs HTML directly.
     */
    function bystra_render_doctor_staff_grid_card($doctor_staff_card_data = array())
    {
        $doctor_staff_render_data = bystra_normalize_doctor_staff_card_render_data($doctor_staff_card_data);
        $doctor_staff_name = $doctor_staff_render_data['name'];
        $doctor_staff_profile_url = $doctor_staff_render_data['profile_url'];
        $doctor_staff_title = $doctor_staff_render_data['title'];
        $doctor_staff_specialisations_display = $doctor_staff_render_data['specialisations_display'];
        $doctor_staff_image_url = $doctor_staff_render_data['image_url'];
        $doctor_staff_image_alt = $doctor_staff_render_data['image_alt'];
        $doctor_staff_heading_variant = $doctor_staff_render_data['heading_variant'];

        // Preserve existing responsive behavior: content spans full width when there is no image.
        $doctor_staff_content_column_class = !empty($doctor_staff_image_url) ? 'col-7' : 'col-12';
        ?>
<div class="col">
    <div class="bg-white p-4 h-100">
        <div class="row g-5 align-items-center h-100">
            <?php if (!empty($doctor_staff_image_url)): ?>
            <div class="col-5">
                <a href="<?php echo esc_url($doctor_staff_profile_url); ?>" aria-label="View profile for <?php echo esc_attr($doctor_staff_name); ?>">
                    <img src="<?php echo esc_url($doctor_staff_image_url); ?>" alt="<?php echo esc_attr($doctor_staff_image_alt); ?>" class="img-fluid img-rounded w-100">
                </a>
            </div>
            <?php endif; ?>

            <div class="<?php echo esc_attr($doctor_staff_content_column_class); ?>">
                <?php if ($doctor_staff_heading_variant === 'inline'): ?>
                <h6>
                    <?php if (!empty($doctor_staff_title)): ?>
                    <span class="mb-1"><?php echo esc_html($doctor_staff_title); ?></span>
                    <br>
                    <?php endif; ?>
                    <span class="mb-1"><?php echo esc_html($doctor_staff_name); ?></span>
                </h6>
                <?php else: ?>
                <?php if (!empty($doctor_staff_title)): ?>
                <h6 class="mb-1"><?php echo esc_html($doctor_staff_title); ?></h6>
                <?php endif; ?>

                <h6 class="mb-2"><?php echo esc_html($doctor_staff_name); ?></h6>
                <?php endif; ?>

                <?php if (!empty($doctor_staff_specialisations_display)): ?>
                <div class="mb-3 small"><?php echo wp_kses_post($doctor_staff_specialisations_display); ?></div>
                <?php endif; ?>

                <a href="<?php echo esc_url($doctor_staff_profile_url); ?>" class="btn btn-sm btn-verde">LEARN MORE <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>
<?php
    }
endif;

if (!function_exists('bystra_render_doctor_staff_slider_card')) :
    /**
     * Render slider-style doctor/staff card markup.
     *
     * Required data:
     * - name
     * - profile_url
     *
     * Optional data:
     * - title
     * - specialisations_display
     * - image_url
     * - image_alt
     *
     * @param array $doctor_staff_card_data Card data payload.
     *
     * @return void Outputs HTML directly.
     */
    function bystra_render_doctor_staff_slider_card($doctor_staff_card_data = array())
    {
        $doctor_staff_render_data = bystra_normalize_doctor_staff_card_render_data($doctor_staff_card_data);
        $doctor_staff_name = $doctor_staff_render_data['name'];
        $doctor_staff_profile_url = $doctor_staff_render_data['profile_url'];
        $doctor_staff_title = $doctor_staff_render_data['title'];
        $doctor_staff_specialisations_display = $doctor_staff_render_data['specialisations_display'];
        $doctor_staff_image_url = $doctor_staff_render_data['image_url'];
        $doctor_staff_image_alt = $doctor_staff_render_data['image_alt'];
        ?>
<a href="<?php echo esc_url($doctor_staff_profile_url); ?>" class="doctor-staff-card-link">
    <div class="row g-5">
        <?php if (!empty($doctor_staff_image_url)): ?>
        <div class="col-12 col-lg-5 mb-3">
            <img src="<?php echo esc_url($doctor_staff_image_url); ?>" alt="<?php echo esc_attr($doctor_staff_image_alt); ?>" class="img-fluid img-rounded w-100">
        </div>
        <?php endif; ?>
        <div class="col-12 col-lg-7 d-flex align-items-center">
            <div>
                <?php if (!empty($doctor_staff_title)): ?>
                <div class="d-flex align-items-center">
                    <h6><?php echo esc_html($doctor_staff_title); ?></h6>
                </div>
                <?php endif; ?>

                <div class="d-flex align-items-center">
                    <h6 class="mb-1"><?php echo esc_html($doctor_staff_name); ?></h6>
                </div>

                <?php if (!empty($doctor_staff_specialisations_display)): ?>
                <div class="slider-doctor-specialisations small mb-3"><?php echo wp_kses_post($doctor_staff_specialisations_display); ?></div>
                <?php endif; ?>

                <span class="btn btn-sm btn-verde">LEARN MORE</span>
            </div>
        </div>
    </div>
</a>
<?php
    }
endif;