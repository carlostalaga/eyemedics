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
<div id="block-slider-doctors-<?php echo $iBlock; ?>" class="container-fluid py-5 px-5 px-md-0 d-flex justify-content-center bg-light">
    <div class="container m-0 pb-5" style="z-index: 20;">
        <div class="slider-doctors slick-slider">
            <?php while ($slider_doctors_query->have_posts()): $slider_doctors_query->the_post(); ?>
            <?php
                $slider_doctor_id = get_the_ID();
                $slider_doctor_name = get_the_title();
                $slider_doctor_profile_url = get_permalink($slider_doctor_id);
                $slider_doctor_title = get_field('doctor_staff_title', $slider_doctor_id);
                $slider_doctor_specialisations = get_field('doctor_staff_specialisations', $slider_doctor_id);
                $slider_doctor_image = get_field('doctor_staff_image', $slider_doctor_id);

                $slider_doctor_image_url = '';
                $slider_doctor_image_alt = '';
                if (is_array($slider_doctor_image)):
                    $slider_doctor_image_alt = !empty($slider_doctor_image['alt']) ? $slider_doctor_image['alt'] : $slider_doctor_name;
                    if (!empty($slider_doctor_image['sizes']['576sm'])):
                        $slider_doctor_image_url = (string) $slider_doctor_image['sizes']['576sm'];
                    elseif (!empty($slider_doctor_image['url'])):
                        $slider_doctor_image_url = (string) $slider_doctor_image['url'];
                    endif;
                endif;
            ?>

            <a href="<?php echo esc_url($slider_doctor_profile_url); ?>" class="text-posidonia slider-doctor-card">
                <div class="magnify bg-white p-3">
                    <?php if (!empty($slider_doctor_image_url)): ?>
                    <div class="slider-doctor-image mb-3">
                        <img src="<?php echo esc_url($slider_doctor_image_url); ?>" alt="<?php echo esc_attr($slider_doctor_image_alt); ?>" class="img-fluid w-100">
                    </div>
                    <?php endif; ?>
                    <div class="slider-doctor-info">
                        <?php if (!empty($slider_doctor_title)): ?>
                        <div class="slider-doctor-title mb-1"><?php echo esc_html($slider_doctor_title); ?></div>
                        <?php endif; ?>

                        <h5 class="slider-doctor-name mb-1"><?php echo esc_html($slider_doctor_name); ?></h5>

                        <?php if (!empty($slider_doctor_specialisations)): ?>
                        <div class="slider-doctor-specialisations small mb-3"><?php echo wp_kses_post($slider_doctor_specialisations); ?></div>
                        <?php endif; ?>

                        <span class="btn btn-sm btn-verde">LEARN MORE <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                    </div>
                </div>
            </a>

            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>
