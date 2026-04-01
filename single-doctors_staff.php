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
            - Resolve term objects once into $doctor_staff_specialist_field_terms
              so we can reuse them in multiple template sections
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
                    // Primary output for both summary and detailed section.
                    $doctor_staff_specialist_fields_display = implode(', ', wp_list_pluck($doctor_staff_specialist_field_terms, 'name'));
                elseif (!empty($doctor_staff_specialist_fields_fallback_values)) :
                    // Legacy plain text path.
                    $doctor_staff_specialist_fields_display = implode(', ', array_filter($doctor_staff_specialist_fields_fallback_values));
                endif;
            endif;
            ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="container-fluid bg-verde">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="py-4">
                            <a href="<?php echo esc_url(home_url('/doctors-and-staff/')); ?>">Back to Doctors and Staff</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5">
                        <?php if (!empty($doctor_staff_image_url)) : ?>
                        <img src="<?php echo esc_url($doctor_staff_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
                        <?php endif; ?>
                    </div>

                    <div class="col-12 col-md-6 col-lg-5">

                        <?php if (!empty($doctor_staff_title)) : ?>
                        <div>
                            <h1><?php echo esc_html($doctor_staff_title); ?></h1>
                        </div>
                        <?php endif; ?>

                        <div>
                            <h1><?php the_title(); ?></h1>
                        </div>

                        <?php if (!empty($doctor_staff_specialisations_display)) : ?>
                        <div>
                            <?php echo wp_kses_post($doctor_staff_specialisations_display); ?>
                        </div>
                        <?php endif; ?>

                        <div class="mt-5 bg-white">
                            <?php if (!empty($doctor_staff_specialist_fields_display)) : ?>
                            <div>
                                <div class="text-small">Specialist Fields</div>
                                <?php echo esc_html($doctor_staff_specialist_fields_display); ?>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($doctor_staff_condition_links) || !empty($doctor_staff_conditions_display)) : ?>
                            <div>
                                <div class="text-xs">Conditions</div>
                                <?php if (!empty($doctor_staff_condition_links)) : ?>
                                <?php $doctor_staff_condition_links_total = count($doctor_staff_condition_links); ?>
                                <?php foreach ($doctor_staff_condition_links as $doctor_staff_condition_index => $doctor_staff_condition_link) : ?>
                                <a href="<?php echo esc_url($doctor_staff_condition_link['url']); ?>">
                                    <?php echo esc_html($doctor_staff_condition_link['title']); ?>
                                </a><?php if ($doctor_staff_condition_index < $doctor_staff_condition_links_total - 1) : ?>, <?php endif; ?>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <?php echo esc_html($doctor_staff_conditions_display); ?>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($doctor_staff_content)) : ?>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div>
                        <?php echo wp_kses_post($doctor_staff_content); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>



        <div class="container-fluid bg-light">
            <div class="container">
                <div class="row justify-content-center g-5 text-white">

                    <div class="col-12 col-md-6 col-lg-4 bg-black m-5 p-5 round-all">
                        <?php if (!empty($doctor_staff_consulting_location_ids)) : ?>
                        <div class="mb-4">
                            <h2 class="h5 mb-2">Consulting Locations</h2>
                            <ul class="mb-0">
                                <?php foreach ($doctor_staff_consulting_location_ids as $doctor_staff_location_id) : ?>
                                <?php if ($doctor_staff_location_id) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_permalink($doctor_staff_location_id)); ?>">
                                        <?php echo esc_html(get_the_title($doctor_staff_location_id)); ?>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 bg-black m-5 p-5 round-all">
                        <?php if (!empty($doctor_staff_operating_location_ids)) : ?>
                        <div class="mb-4">
                            <h2 class="h5 mb-2">Operating Locations</h2>
                            <ul class="mb-0">
                                <?php foreach ($doctor_staff_operating_location_ids as $doctor_staff_location_id) : ?>
                                <?php if ($doctor_staff_location_id) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_permalink($doctor_staff_location_id)); ?>">
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











    </article>
    <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>