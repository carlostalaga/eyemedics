<?php if (have_rows('slider_repeater')): ?>
<!-- In Swiper.js version 11.x, the container class has changed from swiper-container to swiper -->
<div id="slider-<?php echo $iBlock; ?>" class="swiper">
    <div class="swiper-wrapper">
        <?php while (have_rows('slider_repeater')): the_row();
                $video = get_sub_field('video');
                $image = get_sub_field('image');
                if ($image):
                    $image_url_mobile = $image['sizes']['16-9r720'];
                    $image_url_tablet = $image['sizes']['720p'];
                    $image_url = $image['sizes']['1080p'];
                endif; // This is important to close the if statement
                $alignment = get_sub_field('alignment');
                $headline = get_sub_field('headline');
                $tagline = get_sub_field('tagline');
                $content = get_sub_field('content');
                $link = get_sub_field('link');
            ?>

        <div class="swiper-slide">
            <div class="swiper-slide-cover">

                <?php if ($video): ?>

                <video playsinline autoplay muted loop>
                    <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <?php elseif ($image): ?>

                <picture>
                    <!-- Mobile image for screens <= 576px -->
                    <source media="(max-width: 576px)" srcset="<?php echo esc_url($image_url_mobile); ?>">

                    <!-- Tablet image for screens between 576px and 1200px -->
                    <source media="(min-width: 577px) and (max-width: 1199px)" srcset="<?php echo esc_url($image_url_tablet); ?>">

                    <!-- Desktop image for screens > 1200px -->
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="img-fluid">
                </picture>

                <?php else: ?>

                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/failover.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="card-img-top">

                <?php endif; ?>
            </div>

            <?php if ($headline || $tagline): ?>
            <div class="container-fluid pb-5" style="position: absolute;">
                <div class="container pt-3">
                    <div>
                        <div class="position-relative text-start pt-4 pb-2 px-5" style="position: relative;">
                            <?php if ($headline): ?>
                            <div class="text-header alignment-<?php echo $iBlock; ?> text-white">
                                <?php echo esc_html($headline); ?>
                            </div>
                            <?php endif; ?>
                            <?php if ($tagline): ?>
                            <div class="text-slider-tagline alignment-<?php echo $iBlock; ?> text-white mb-3 d-none d-md-block">
                                <?php echo esc_html($tagline); ?>
                            </div>
                            <?php endif; ?>
                            <?php if ($content): ?>
                            <div class="text-slider-content alignment-<?php echo $iBlock; ?> text-white mb-3 d-none d-xl-block">
                                <?php echo esc_html($content); ?>
                            </div>
                            <?php endif; ?>

                            <div class="alignment-<?php echo $iBlock; ?> pt-3">
                                <?php if ($link && is_array($link)): ?>
                                <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target']); ?>" class="btn btn-aguamarina" title="<?php echo esc_attr($link['title']); ?>" aria-label="Learn more about <?php echo esc_attr($link['title']); ?>">Learn More</a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php endwhile; ?>
    </div>

    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>

    <!-- Add Navigation -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

</div>

<script>

</script>

<style>
/* Content alignment */
.alignment-<?php echo $iBlock; ?> {
    text-align: <?php if($alignment == 'center'): echo 'center'; else: echo 'left'; endif; ?>;
}
</style>

<?php else: ?>
<!-- No slides found -->
<?php endif; ?>