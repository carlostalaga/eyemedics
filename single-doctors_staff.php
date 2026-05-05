<?php get_header(); ?>
<main id="main-content" role="main">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <?php
            /*
            ===========================================================
                Doctors and Staff: ACF Fields
            ===========================================================
            */
            $doctor_staff_image = get_field('doctor_staff_image');
            $doctor_staff_title = get_field('doctor_staff_title');
            $doctor_staff_specialisations = get_field('doctor_staff_specialisations');
            $doctor_staff_specialist_fields = get_field('doctor_staff_specialist_fields');
            $doctor_staff_conditions = get_field('doctor_staff_conditions');
            $doctor_staff_content = get_field('doctor_staff_content');
            $doctor_staff_consulting_locations = get_field('doctor_staff_consulting_locations');
            $doctor_staff_operating_locations = get_field('doctor_staff_operating_locations');

            /*
            ===========================================================
                Data Shape Normalization
            ===========================================================
            ACF field return formats can vary by field settings and legacy data:
            - Some relationship-like fields may return a single value
            - The same fields may also return arrays
            Normalize here once so rendering logic stays predictable below.
            */
            if (!empty($doctor_staff_conditions) && !is_array($doctor_staff_conditions)) :
                $doctor_staff_conditions = array($doctor_staff_conditions);
            endif;
            if (!empty($doctor_staff_consulting_locations) && !is_array($doctor_staff_consulting_locations)) :
                $doctor_staff_consulting_locations = array($doctor_staff_consulting_locations);
            endif;
            if (!empty($doctor_staff_operating_locations) && !is_array($doctor_staff_operating_locations)) :
                $doctor_staff_operating_locations = array($doctor_staff_operating_locations);
            endif;
            if (!empty($doctor_staff_specialist_fields) && !is_array($doctor_staff_specialist_fields)) :
                $doctor_staff_specialist_fields = array($doctor_staff_specialist_fields);
            endif;

            /*
            Preferred ACF return configurations for this template:
            - doctor_staff_specialist_fields: taxonomy term IDs
            - doctor_staff_conditions: WP_Post objects
            - doctor_staff_consulting_locations: WP_Post objects
            - doctor_staff_operating_locations: WP_Post objects
            We normalize to canonical IDs/objects once, then render from those.
            */
            $doctor_staff_consulting_location_ids = array();
            if (!empty($doctor_staff_consulting_locations)) :
                foreach ($doctor_staff_consulting_locations as $doctor_staff_location) :
                    if ($doctor_staff_location instanceof WP_Post) :
                        $doctor_staff_consulting_location_ids[] = $doctor_staff_location->ID;
                    elseif (is_numeric($doctor_staff_location)) :
                        $doctor_staff_consulting_location_ids[] = (int) $doctor_staff_location;
                    endif;
                endforeach;
                $doctor_staff_consulting_location_ids = array_values(array_unique(array_filter($doctor_staff_consulting_location_ids)));
            endif;

            $doctor_staff_operating_location_ids = array();
            if (!empty($doctor_staff_operating_locations)) :
                foreach ($doctor_staff_operating_locations as $doctor_staff_location) :
                    if ($doctor_staff_location instanceof WP_Post) :
                        $doctor_staff_operating_location_ids[] = $doctor_staff_location->ID;
                    elseif (is_numeric($doctor_staff_location)) :
                        $doctor_staff_operating_location_ids[] = (int) $doctor_staff_location;
                    endif;
                endforeach;
                $doctor_staff_operating_location_ids = array_values(array_unique(array_filter($doctor_staff_operating_location_ids)));
            endif;

            /*
            ===========================================================
                Locations Page Link Routing
            ===========================================================
            Consulting location clicks route into the tabbed Locations page.
            Operating locations remain direct links to their own permalink,
            because they are handled in a different flow.
            */
            $doctor_staff_locations_page_url = '';
            $doctor_staff_locations_page = get_page_by_path('locations');
            if ($doctor_staff_locations_page instanceof WP_Post) :
                $doctor_staff_locations_page_url = get_permalink($doctor_staff_locations_page->ID);
            endif;
            if (empty($doctor_staff_locations_page_url)) :
                $doctor_staff_locations_page_url = home_url('/locations/');
            endif;

            $doctor_staff_condition_ids = array();
            $doctor_staff_conditions_display = '';
            $doctor_staff_condition_links = array();
            if (!empty($doctor_staff_conditions)) :
                $doctor_staff_condition_fallback_values = array();
                foreach ($doctor_staff_conditions as $doctor_staff_condition) :
                    if ($doctor_staff_condition instanceof WP_Post) :
                        $doctor_staff_condition_ids[] = $doctor_staff_condition->ID;
                    elseif (is_numeric($doctor_staff_condition)) :
                        $doctor_staff_condition_ids[] = (int) $doctor_staff_condition;
                    elseif (is_scalar($doctor_staff_condition)) :
                        $doctor_staff_condition_fallback_values[] = (string) $doctor_staff_condition;
                    endif;
                endforeach;

                $doctor_staff_condition_ids = array_values(array_unique(array_filter($doctor_staff_condition_ids)));
                if (!empty($doctor_staff_condition_ids)) :
                    $doctor_staff_condition_titles = array();
                    foreach ($doctor_staff_condition_ids as $doctor_staff_condition_id) :
                        $doctor_staff_condition_title = get_the_title($doctor_staff_condition_id);
                        $doctor_staff_condition_url = get_permalink($doctor_staff_condition_id);
                        if (!empty($doctor_staff_condition_title) && !empty($doctor_staff_condition_url)) :
                            $doctor_staff_condition_links[] = array(
                                'title' => $doctor_staff_condition_title,
                                'url' => $doctor_staff_condition_url,
                            );
                        endif;
                        if (!empty($doctor_staff_condition_title)) :
                            $doctor_staff_condition_titles[] = $doctor_staff_condition_title;
                        endif;
                    endforeach;
                    $doctor_staff_conditions_display = implode(', ', array_filter($doctor_staff_condition_titles));
                elseif (!empty($doctor_staff_condition_fallback_values)) :
                    $doctor_staff_conditions_display = implode(', ', array_filter($doctor_staff_condition_fallback_values));
                endif;
            endif;

            /*
            Image handling:
            - Prefer the custom 576sm thumbnail when available
            - Fallback to full image URL when that size is missing
            - If structure is missing/invalid, keep a safe empty string
            - Templates only render <img> when this normalized URL is present
            */
            $doctor_staff_image_url = '';
            if (is_array($doctor_staff_image)) :
                if (!empty($doctor_staff_image['sizes']['576sm'])) :
                    $doctor_staff_image_url = (string) $doctor_staff_image['sizes']['576sm'];
                elseif (!empty($doctor_staff_image['url'])) :
                    $doctor_staff_image_url = (string) $doctor_staff_image['url'];
                endif;
            endif;

            /*
            Specialisations normalization flow:
            1) Default to empty display string
            2) If array, convert each item to readable text:
               - WP_Term  -> term name
               - WP_Post  -> post title
               - scalar   -> string cast
            3) Join with commas for compact display
            4) If input is already string-like, cast directly
            This guarantees the output passed to wp_kses_post() is always a string.
            */
            $doctor_staff_specialisations_display = '';
            if (!empty($doctor_staff_specialisations)) :
                if (is_array($doctor_staff_specialisations)) :
                    $doctor_staff_specialisations_items = array();
                    foreach ($doctor_staff_specialisations as $doctor_staff_specialisation) :
                        if ($doctor_staff_specialisation instanceof WP_Term) :
                            $doctor_staff_specialisations_items[] = $doctor_staff_specialisation->name;
                        elseif ($doctor_staff_specialisation instanceof WP_Post) :
                            $doctor_staff_specialisations_items[] = get_the_title($doctor_staff_specialisation->ID);
                        elseif (is_scalar($doctor_staff_specialisation)) :
                            $doctor_staff_specialisations_items[] = (string) $doctor_staff_specialisation;
                        endif;
                    endforeach;
                    $doctor_staff_specialisations_display = implode(', ', array_filter($doctor_staff_specialisations_items));
                else :
                    $doctor_staff_specialisations_display = (string) $doctor_staff_specialisations;
                endif;
            endif;

            /*
            Specialist fields normalization flow:
            - Support mixed inputs from ACF/legacy data:
              - WP_Term objects
              - term IDs
              - plain text fallback
            - Resolve IDs/objects once into $doctor_staff_specialist_field_terms
            - Build a comma-separated display string from resolved term names
            - If legacy plain text is provided, keep it as the display fallback
            */
            $doctor_staff_specialist_field_terms = array();
            $doctor_staff_specialist_fields_display = '';
            $doctor_staff_specialist_field_ids = array();
            $doctor_staff_specialist_fields_fallback_values = array();
            if (!empty($doctor_staff_specialist_fields)) :
                foreach ($doctor_staff_specialist_fields as $doctor_staff_specialist_field_item) :
                    // Configured path: taxonomy term ID.
                    if (is_numeric($doctor_staff_specialist_field_item)) :
                        $doctor_staff_specialist_field_ids[] = (int) $doctor_staff_specialist_field_item;
                    // Defensive fallback: tolerate term objects.
                    elseif ($doctor_staff_specialist_field_item instanceof WP_Term) :
                        $doctor_staff_specialist_field_ids[] = (int) $doctor_staff_specialist_field_item->term_id;
                    // Defensive fallback: tolerate legacy plain text values.
                    elseif (is_scalar($doctor_staff_specialist_field_item)) :
                        $doctor_staff_specialist_fields_fallback_values[] = (string) $doctor_staff_specialist_field_item;
                    endif;
                endforeach;

                $doctor_staff_specialist_field_ids = array_values(array_unique(array_filter($doctor_staff_specialist_field_ids)));
                if (!empty($doctor_staff_specialist_field_ids)) :
                    $doctor_staff_specialist_field_terms = get_terms(
                        array(
                            'taxonomy' => 'specialist_fields',
                            'include' => $doctor_staff_specialist_field_ids,
                            'hide_empty' => false,
                            'orderby' => 'include',
                        )
                    );
                    if (is_wp_error($doctor_staff_specialist_field_terms)) :
                        $doctor_staff_specialist_field_terms = array();
                    endif;
                endif;

                if (!empty($doctor_staff_specialist_field_terms)) :
                    // Primary output used in the specialist fields display block.
                    $doctor_staff_specialist_fields_display = implode(', ', wp_list_pluck($doctor_staff_specialist_field_terms, 'name'));
                elseif (!empty($doctor_staff_specialist_fields_fallback_values)) :
                    // Legacy plain text path.
                    $doctor_staff_specialist_fields_display = implode(', ', array_filter($doctor_staff_specialist_fields_fallback_values));
                endif;
            endif;
            ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


        <div class="container-fluid bg-1 doctor-staff-hero">
            <div class="container">
                <?php /* Hook row for overflow behavior so image can extend into purple section. */ ?>
                <div class="row g-5 justify-content-center doctor-staff-hero__row">

                    <?php /* Image column stays in markup order; image itself is taken out of flow on md+ via SCSS. */ ?>
                    <div class="col-12 col-md-6 col-lg-5 p-5 doctor-staff-hero__image-col">
                        <?php if (!empty($doctor_staff_image_url)) : ?>
                        <img src="<?php echo esc_url($doctor_staff_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid doctor-staff-hero__image">
                        <?php endif; ?>
                    </div>

                    <?php /* Text column remains in normal flow, so it defines hero height. */ ?>
                    <div class="col-12 col-md-6 col-lg-5 p-5 doctor-staff-hero__content-col">


                        <div class="doctors-staff-headings-container">
                            <h1 class="text-white">
                                <?php if (!empty($doctor_staff_title)) : ?>
                                <span>
                                    <?php echo esc_html($doctor_staff_title); ?>
                                </span>
                                <?php endif; ?>
                                <br>
                                <span>
                                    <?php the_title(); ?>
                                </span>
                            </h1>

                            <?php if (!empty($doctor_staff_specialisations_display)) : ?>
                            <div class="my-5">
                                <h5 class="text-white"><?php echo wp_kses_post($doctor_staff_specialisations_display); ?></h5>
                            </div>
                            <?php endif; ?>
                        </div>




                    </div>
                </div>
            </div>
        </div>





        <div class="container-fluid bg-white">
            <div class="container">
                <div class="row g-5 pb-5 justify-content-center">

                    <div class="col-12 col-md-6 col-lg-5 px-5 d-none d-md-block">

                    </div>

                    <div class="col-12 col-md-6 col-lg-5 px-5">

                        <div>
                            <div class="mb-3">
                                <div class="text-small">Specialist fields</div>
                                <span class="text-sombra">
                                    <?php if (!empty($doctor_staff_specialist_fields_display)) : ?>
                                    <?php echo esc_html($doctor_staff_specialist_fields_display); ?>
                                    <?php else : ?>
                                    &nbsp;
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <div class="text-small">Conditions</div>
                                <?php if (!empty($doctor_staff_condition_links)) : ?>
                                <?php $doctor_staff_condition_links_total = count($doctor_staff_condition_links); ?>
                                <?php foreach ($doctor_staff_condition_links as $doctor_staff_condition_index => $doctor_staff_condition_link) : ?>
                                <a href="<?php echo esc_url($doctor_staff_condition_link['url']); ?>">
                                    <?php echo esc_html($doctor_staff_condition_link['title']); ?>
                                </a><?php if ($doctor_staff_condition_index < $doctor_staff_condition_links_total - 1) : ?>, <?php endif; ?>
                                <?php endforeach; ?>
                                <?php elseif (!empty($doctor_staff_conditions_display)) : ?>
                                <?php echo esc_html($doctor_staff_conditions_display); ?>
                                <?php else : ?>
                                &nbsp;
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>









        <?php if (!empty($doctor_staff_content)) : ?>
        <div class="container py-5">
            <div class="row my-5 py-5 justify-content-center">
                <div class="col-12 col-lg-10">
                    <div>
                        <?php echo wp_kses_post($doctor_staff_content); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>



        <div class="container-fluid bg-light mb-5">
            <div class="container">
                <div class="row justify-content-center g-5 text-white">

                    <div class="col-12 col-md-5 col-lg-4 bg-negro m-5 p-5 round-all">
                        <?php if (!empty($doctor_staff_consulting_location_ids)) : ?>
                        <div class="mb-4">
                            <h3 class="text-white mb-5">Consulting Locations</h3>
                            <ul class="mb-0">
                                <?php foreach ($doctor_staff_consulting_location_ids as $doctor_staff_location_id) : ?>
                                <?php if ($doctor_staff_location_id) : ?>
                                <?php
                                    /*
                                    Deep-link format used by page-locations.php:
                                    - ?location=<id> selects the matching location tab
                                    - #locations-page scrolls the visitor to the tabs section
                                    */
                                    $doctor_staff_location_tab_url = add_query_arg(
                                        array(
                                            'location' => (int) $doctor_staff_location_id,
                                        ),
                                        $doctor_staff_locations_page_url
                                    ) . '#locations-page';
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($doctor_staff_location_tab_url); ?>" class="text-white">
                                        <?php echo esc_html(get_the_title($doctor_staff_location_id)); ?>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 bg-negro m-5 p-5 round-all">
                        <?php if (!empty($doctor_staff_operating_location_ids)) : ?>
                        <div class="mb-4">
                            <h3 class="text-white mb-5">Operating Locations</h3>
                            <ul class="mb-0">
                                <?php foreach ($doctor_staff_operating_location_ids as $doctor_staff_location_id) : ?>
                                <?php if ($doctor_staff_location_id) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_permalink($doctor_staff_location_id)); ?>" class="text-white">
                                        <?php echo esc_html(get_the_title($doctor_staff_location_id)); ?>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>




        <?php
            /*
            Consulting Locations cards — renders only this doctor's assigned locations.
            Uses the shared component: inc/component-consulting-locations.php
            $doctor_staff_consulting_location_ids is built earlier from the ACF
            relationship field 'doctor_staff_consulting_locations'.
            */
            bystra_render_consulting_locations_cards(
                $doctor_staff_consulting_location_ids
            );
        ?>






    </article>
    <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>