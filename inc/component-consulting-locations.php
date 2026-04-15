<?php
/*
 ██████  ██████  ███    ██ ███████ ██    ██ ██      ████████ ██ ███    ██  ██████
██      ██    ██ ████   ██ ██      ██    ██ ██         ██    ██ ████   ██ ██
██      ██    ██ ██ ██  ██ ███████ ██    ██ ██         ██    ██ ██ ██  ██ ██   ███
██      ██    ██ ██  ██ ██      ██ ██    ██ ██         ██    ██ ██  ██ ██ ██    ██
 ██████  ██████  ██   ████ ███████  ██████  ███████    ██    ██ ██   ████  ██████

██       ██████   ██████  █████  ████████ ██  ██████  ███    ██ ███████
██      ██    ██ ██      ██   ██    ██    ██ ██    ██ ████   ██ ██
██      ██    ██ ██      ███████    ██    ██ ██    ██ ██ ██  ██ ███████
██      ██    ██ ██      ██   ██    ██    ██ ██    ██ ██  ██ ██      ██
███████  ██████   ██████ ██   ██    ██    ██  ██████  ██   ████ ███████
*/

/**
 * Shared Consulting Locations Card Component
 *
 * Renders a grid of consulting location cards displaying each location's
 * title, address, phone, fax and image. This is the single source of truth
 * for this card layout — any visual changes here are reflected everywhere.
 *
 * Loaded via: functions.php → require_once '/inc/component-consulting-locations.php'
 *
 * Used by:
 *   - blocks/block-locations.php   → Flexible Content "locations" layout.
 *                                     Queries ALL published consulting_location posts
 *                                     and passes their IDs. The ACF sub-field
 *                                     'locations_background' controls the outer
 *                                     wrapper background class.
 *
 *   - single-doctors_staff.php     → Doctor/Staff single template.
 *                                     Passes only the consulting location IDs
 *                                     assigned to that doctor via the ACF
 *                                     relationship field 'doctor_staff_consulting_locations'.
 *                                     Uses default wrapper classes (no background override).
 *
 * Deep-link contract:
 *   Title and image link to the Locations page (page-locations.php, template "Locations")
 *   using the format: /locations/?location=<post_id>#locations-page
 *   The page-locations.php template reads $_GET['location'] and activates the
 *   matching Bootstrap tab so the user lands on the correct location's detail view.
 *
 * ACF fields consumed per consulting_location post (CPT: consulting_location):
 *   - consulting_location_address  (textarea, new lines → <br>)
 *   - consulting_location_phone    (text)
 *   - consulting_location_fax      (text)
 *   - consulting_location_image    (image array, uses '576sm' size with URL fallback)
 *
 * ACF field group: acf-json/group_69cb4d89b35b5.json
 */

if (!function_exists('bystra_render_consulting_locations_cards')) :
    /**
     * Render a responsive grid of consulting location cards.
     *
     * Accepts mixed input (WP_Post objects or numeric IDs) and normalizes
     * them to a deduplicated integer array before rendering. Outputs nothing
     * if the resulting ID list is empty.
     *
     * @param array  $consulting_location_items  Location identifiers — accepts
     *                                           WP_Post objects, post ID integers,
     *                                           or numeric strings. Mixed input is safe.
     * @param string $section_id                 Optional HTML id attribute for the
     *                                           outermost <div>. Omit or pass '' to
     *                                           skip the id. Used by block-locations.php
     *                                           to set 'locations-<$iBlock>'.
     * @param string $section_classes            CSS classes for the outermost <div>.
     *                                           Defaults to 'container-fluid mb-5'.
     *                                           block-locations.php appends the ACF
     *                                           background class here.
     *
     * @return void Outputs HTML directly.
     */
    function bystra_render_consulting_locations_cards($consulting_location_items = array(), $section_id = '', $section_classes = 'container-fluid mb-5')
    {
        /*
        ===========================================================
            Input Normalization
        ===========================================================
        ACF relationship fields may return WP_Post objects or plain IDs
        depending on the field's "Return Format" setting. The block query
        with 'fields' => 'ids' returns integers. We handle all cases
        and deduplicate to avoid rendering the same card twice.
        */
        $consulting_location_ids = array();
        if (!empty($consulting_location_items) && is_array($consulting_location_items)) :
            foreach ($consulting_location_items as $consulting_location_item) :
                if ($consulting_location_item instanceof WP_Post) :
                    $consulting_location_ids[] = (int) $consulting_location_item->ID;
                elseif (is_numeric($consulting_location_item)) :
                    $consulting_location_ids[] = (int) $consulting_location_item;
                endif;
            endforeach;
        endif;
        $consulting_location_ids = array_values(array_unique(array_filter($consulting_location_ids)));

        if (empty($consulting_location_ids)) :
            return;
        endif;

        /*
        ===========================================================
            Locations Page URL Resolution
        ===========================================================
        Each card's title and image link to the tabbed Locations page
        (page-locations.php) with a deep-link query param. The target
        page uses the "Locations" page template and must exist at the
        /locations/ slug. Falls back to home_url('/locations/') if the
        page cannot be found by path.

        Deep-link format: /locations/?location=<id>#locations-page
        Consumed by: page-locations.php → $_GET['location']
        */
        $consulting_location_page_url = '';
        $consulting_location_page = get_page_by_path('locations');
        if ($consulting_location_page instanceof WP_Post) :
            $consulting_location_page_url = get_permalink($consulting_location_page->ID);
        endif;
        if (empty($consulting_location_page_url)) :
            $consulting_location_page_url = home_url('/locations/');
        endif;
        ?>
<div<?php if (!empty($section_id)) : ?> id="<?php echo esc_attr($section_id); ?>" <?php endif; ?> class="<?php echo esc_attr($section_classes); ?>">
    <div class="container py-5">
        <div class="row justify-content-center g-5">

            <div class="col-12">
                <h2><i class="fas fa-caret-right ms-2" aria-hidden="true"></i> Locations</h2>
            </div>

            <!-- Loop: one card per consulting location -->
            <?php foreach ($consulting_location_ids as $consulting_location_id) : ?>
            <?php
                // Load ACF fields for this location (group_69cb4d89b35b5)
                $consulting_location_title = get_the_title($consulting_location_id);
                $consulting_location_address = get_field('consulting_location_address', $consulting_location_id);
                $consulting_location_phone = get_field('consulting_location_phone', $consulting_location_id);
                $consulting_location_fax = get_field('consulting_location_fax', $consulting_location_id);
                $consulting_location_image = get_field('consulting_location_image', $consulting_location_id);

                // Image: prefer the 576sm crop, fall back to full URL
                $consulting_location_image_url = '';
                if (is_array($consulting_location_image)) :
                    if (!empty($consulting_location_image['sizes']['576sm'])) :
                        $consulting_location_image_url = (string) $consulting_location_image['sizes']['576sm'];
                    elseif (!empty($consulting_location_image['url'])) :
                        $consulting_location_image_url = (string) $consulting_location_image['url'];
                    endif;
                endif;

                /*
                Build the deep-link URL for this location's tab on the Locations page.
                Format: /locations/?location=<post_id>#locations-page

                page-locations.php reads $_GET['location'], matches it against
                the consulting_location post IDs rendered as Bootstrap tabs,
                and sets the matching tab to 'show active' on page load.
                The #locations-page fragment scrolls the browser to the
                <div id="locations-page"> container that wraps the tabs.
                */
                $consulting_location_tab_url = add_query_arg(
                    array('location' => (int) $consulting_location_id),
                    $consulting_location_page_url
                ) . '#locations-page';
            ?>
            <!-- Card: single location -->
            <div class="col-12 col-md-6 col-xl-4">
                <div class="h-100 pt-4">
                    <div class="row g-3 align-items-start">
                        <div class="col-12 col-sm-7 fosforos">
                            <?php if (!empty($consulting_location_title)) : ?>
                            <h6 class="mb-3">
                                <!-- Title links to this location's tab on the Locations page -->
                                <a href="<?php echo esc_url($consulting_location_tab_url); ?>">
                                    <?php echo esc_html($consulting_location_title); ?>
                                </a>
                            </h6>
                            <?php endif; ?>
                            <?php if (!empty($consulting_location_address)) : ?>
                            <div class="mb-3"><?php echo wp_kses_post($consulting_location_address); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($consulting_location_phone)) : ?>
                            <div class="mb-2 underline-link">
                                <span class="text-verde fw-bold me-2">T</span><a href="tel:<?php echo esc_html($consulting_location_phone); ?>"><?php echo esc_html($consulting_location_phone); ?></a>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($consulting_location_fax)) : ?>
                            <div><span class="text-verde fw-bold me-2">F</span><?php echo esc_html($consulting_location_fax); ?></div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($consulting_location_image_url)) : ?>
                        <div class="col-12 col-sm-5">
                            <!-- Image links to the same tab deep-link as the title -->
                            <a href="<?php echo esc_url($consulting_location_tab_url); ?>" aria-label="<?php echo esc_attr($consulting_location_title); ?>">
                                <img src="<?php echo esc_url($consulting_location_image_url); ?>" alt="<?php echo esc_attr('Location image for ' . $consulting_location_title); ?>" class="img-fluid w-100">
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- End: location cards loop -->

        </div>
    </div>
    </div>
    <?php
    }
endif;