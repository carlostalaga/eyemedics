<?php
/*
==============================================================================
    Search & Filter Results: Doctors and Staff (Query 1)
==============================================================================
*/

$doctors_results_query = null;

if (isset($query) && $query instanceof WP_Query) :
    $doctors_results_query = $query;
elseif (isset($wp_query) && $wp_query instanceof WP_Query) :
    $doctors_results_query = $wp_query;
else :
    global $wp_query;
    if ($wp_query instanceof WP_Query) :
        $doctors_results_query = $wp_query;
    endif;
endif;
?>

<?php if ($doctors_results_query instanceof WP_Query && $doctors_results_query->have_posts()): ?>
<div class="row row-cols-1 row-cols-lg-2 g-4">
    <?php while ($doctors_results_query->have_posts()): $doctors_results_query->the_post(); ?>
    <?php
        $doctors_result_id = get_the_ID();
        $doctors_result_name = get_the_title($doctors_result_id);
        $doctors_result_profile_url = get_permalink($doctors_result_id);
        $doctors_result_title = get_field('doctor_staff_title', $doctors_result_id);
        $doctors_result_specialisations = get_field('doctor_staff_specialisations', $doctors_result_id);
        $doctors_result_image = get_field('doctor_staff_image', $doctors_result_id);

        $doctors_result_image_url = '';
        if (is_array($doctors_result_image)) :
            if (!empty($doctors_result_image['sizes']['576sm'])) :
                $doctors_result_image_url = (string) $doctors_result_image['sizes']['576sm'];
            elseif (!empty($doctors_result_image['url'])) :
                $doctors_result_image_url = (string) $doctors_result_image['url'];
            endif;
        endif;

        $doctors_result_specialisations_display = '';
        if (!empty($doctors_result_specialisations)) :
            if (is_array($doctors_result_specialisations)) :
                $doctors_result_specialisations_items = array();
                foreach ($doctors_result_specialisations as $doctors_result_specialisation_item) :
                    if ($doctors_result_specialisation_item instanceof WP_Term) :
                        $doctors_result_specialisations_items[] = $doctors_result_specialisation_item->name;
                    elseif ($doctors_result_specialisation_item instanceof WP_Post) :
                        $doctors_result_specialisations_items[] = get_the_title($doctors_result_specialisation_item->ID);
                    elseif (is_scalar($doctors_result_specialisation_item)) :
                        $doctors_result_specialisations_items[] = (string) $doctors_result_specialisation_item;
                    endif;
                endforeach;
                $doctors_result_specialisations_display = implode(', ', array_filter($doctors_result_specialisations_items));
            else :
                $doctors_result_specialisations_display = (string) $doctors_result_specialisations;
            endif;
        endif;

        $doctors_result_content_column_class = !empty($doctors_result_image_url) ? 'col-7' : 'col-12';
    ?>
    <div class="col">
        <div class="bg-white p-4 h-100">
            <div class="row g-3 align-items-center h-100">
                <?php if (!empty($doctors_result_image_url)): ?>
                <div class="col-5">
                    <a href="<?php echo esc_url($doctors_result_profile_url); ?>" aria-label="View profile for <?php echo esc_attr($doctors_result_name); ?>">
                        <img src="<?php echo esc_url($doctors_result_image_url); ?>" alt="<?php echo esc_attr($doctors_result_name); ?>" class="img-fluid w-100">
                    </a>
                </div>
                <?php endif; ?>
                <div class="<?php echo esc_attr($doctors_result_content_column_class); ?>">


                    <h6>
                        <?php if (!empty($doctors_result_title)): ?>
                        <span class="mb-1"><?php echo esc_html($doctors_result_title); ?></span>
                        <?php endif; ?>
                        <br>
                        <span class="mb-1"><?php echo esc_html($doctors_result_name); ?></span>
                    </h6>

                    <?php if (!empty($doctors_result_specialisations_display)): ?>
                    <div class="mb-3 small"><?php echo wp_kses_post($doctors_result_specialisations_display); ?></div>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($doctors_result_profile_url); ?>" class="btn btn-sm btn-verde">LEARN MORE <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
<?php else: ?>
<div>No doctors or staff matched your filters.</div>
<?php endif; ?>