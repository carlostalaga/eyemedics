<?php
/*

███████ ██      ██ ██████  ███████ ██████
██      ██      ██ ██   ██ ██      ██   ██
███████ ██      ██ ██   ██ █████   ██████
     ██ ██      ██ ██   ██ ██      ██   ██
███████ ███████ ██ ██████  ███████ ██   ██


██████   ██████   ██████ ████████  ██████  ██████  ███████
██   ██ ██    ██ ██         ██    ██    ██ ██   ██ ██
██   ██ ██    ██ ██         ██    ██    ██ ██████  ███████
██   ██ ██    ██ ██         ██    ██    ██ ██   ██      ██
██████   ██████   ██████    ██     ██████  ██   ██ ███████

/* Slider Doctors Block */
?>

<?php
$slider_doctors_query = new WP_Query(
    array(
        'post_type'      => 'doctors_staff',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    )
);
?>

<?php if ($slider_doctors_query->have_posts()): ?>
<div id="block-slider-doctors-<?php echo $iBlock; ?>" class="container-fluid py-5 px-5 px-md-0 d-flex justify-content-center">
    <div class="container-fluid block-slider-doctors-card m-0">
        <div class="slider-doctors slick-slider">
            <?php while ($slider_doctors_query->have_posts()): $slider_doctors_query->the_post(); ?>
            <?php
                $slider_doctor_id = get_the_ID();
                /*
                Build normalized doctor/staff card data from post ID, then
                render with the dedicated slider card renderer.
                */
                $slider_doctor_card_data = bystra_get_doctor_staff_card_data($slider_doctor_id);

                bystra_render_doctor_staff_slider_card($slider_doctor_card_data);
            ?>

            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>