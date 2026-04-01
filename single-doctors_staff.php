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

            // Fallbacks for legacy field names during migration.
            if (!$doctor_staff_image) :
                $doctor_staff_image = get_field('team_image');
            endif;
            if (!$doctor_staff_title) :
                $doctor_staff_title = get_field('role');
            endif;
            if (!$doctor_staff_content) :
                $doctor_staff_content = get_field('team_content');
            endif;

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
            ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="container-fluid bg-verde">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="py-4">
                            <a href="<?php echo esc_url(home_url('/doctors-and-staff/')); ?>">Back to Doctors and Staff</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <img src="<?php echo esc_url($doctor_staff_image['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
                    </div>

                    <div class="col-12 col-md-6">
                        <div>
                            <?php echo esc_html($doctor_staff_title); ?>
                        </div>
                        <div>
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div>
                            <?php echo wp_kses_post($doctor_staff_specialisations); ?>
                        </div>
                        <div>
                            <?php echo wp_kses_post($doctor_staff_specialist_fields); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-5">


            <h1 class="mb-4"><?php the_title(); ?></h1>

            <?php if (!empty($doctor_staff_image)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-3">Image</h2>
                <img src="<?php echo esc_url($doctor_staff_image['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
            </section>
            <?php endif; ?>

            <?php if (!empty($doctor_staff_title)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-2">Title</h2>
                <p class="mb-0"><?php echo esc_html($doctor_staff_title); ?></p>
            </section>
            <?php endif; ?>

            <?php if (!empty($doctor_staff_specialisations)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-2">Specialisations</h2>
                <p class="mb-0"><?php echo wp_kses_post($doctor_staff_specialisations); ?></p>
            </section>
            <?php endif; ?>

            <?php if (!empty($doctor_staff_specialist_fields)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-2">Specialist Fields</h2>
                <ul class="mb-0">
                    <?php foreach ($doctor_staff_specialist_fields as $doctor_staff_term_id) : ?>
                    <?php
                                    $doctor_staff_term = get_term((int) $doctor_staff_term_id, 'specialist_fields');
                                    if (!is_wp_error($doctor_staff_term) && $doctor_staff_term) :
                                    ?>
                    <li><?php echo esc_html($doctor_staff_term->name); ?></li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endif; ?>

            <?php if (!empty($doctor_staff_conditions)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-2">Conditions</h2>
                <ul class="mb-0">
                    <?php foreach ($doctor_staff_conditions as $doctor_staff_condition) : ?>
                    <?php
                                    $doctor_staff_condition_id = $doctor_staff_condition instanceof WP_Post ? $doctor_staff_condition->ID : (int) $doctor_staff_condition;
                                    if ($doctor_staff_condition_id) :
                                    ?>
                    <li>
                        <a href="<?php echo esc_url(get_permalink($doctor_staff_condition_id)); ?>">
                            <?php echo esc_html(get_the_title($doctor_staff_condition_id)); ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endif; ?>

            <?php if (!empty($doctor_staff_content)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-2">Content</h2>
                <div><?php echo wp_kses_post($doctor_staff_content); ?></div>
            </section>
            <?php endif; ?>

            <?php if (!empty($doctor_staff_consulting_locations)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-2">Consulting Locations</h2>
                <ul class="mb-0">
                    <?php foreach ($doctor_staff_consulting_locations as $doctor_staff_location) : ?>
                    <?php
                                    $doctor_staff_location_id = $doctor_staff_location instanceof WP_Post ? $doctor_staff_location->ID : (int) $doctor_staff_location;
                                    if ($doctor_staff_location_id) :
                                    ?>
                    <li>
                        <a href="<?php echo esc_url(get_permalink($doctor_staff_location_id)); ?>">
                            <?php echo esc_html(get_the_title($doctor_staff_location_id)); ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endif; ?>

            <?php if (!empty($doctor_staff_operating_locations)) : ?>
            <section class="mb-4">
                <h2 class="h5 mb-2">Operating Locations</h2>
                <ul class="mb-0">
                    <?php foreach ($doctor_staff_operating_locations as $doctor_staff_location) : ?>
                    <?php
                                    $doctor_staff_location_id = $doctor_staff_location instanceof WP_Post ? $doctor_staff_location->ID : (int) $doctor_staff_location;
                                    if ($doctor_staff_location_id) :
                                    ?>
                    <li>
                        <a href="<?php echo esc_url(get_permalink($doctor_staff_location_id)); ?>">
                            <?php echo esc_html(get_the_title($doctor_staff_location_id)); ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endif; ?>
        </div>
    </article>
    <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>