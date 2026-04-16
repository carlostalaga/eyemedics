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
        /*
        Build normalized doctor/staff card data from post ID, then override
        only the context-specific rendering option for this template.
        */
        $doctors_result_card_data = bystra_get_doctor_staff_card_data(
            $doctors_result_id,
            array(
                'heading_variant' => 'inline',
            )
        );

        bystra_render_doctor_staff_grid_card($doctors_result_card_data);
    ?>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
<?php else: ?>
<div>No doctors or staff matched your filters.</div>
<?php endif; ?>