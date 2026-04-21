<?php if (!have_rows('slider_repeater')):
    return;
endif; ?>

<div id="slider-<?php echo esc_attr($iBlock); ?>" class="swiper slider-nav-hero">
    <div class="swiper-wrapper">
        <?php
        while (have_rows('slider_repeater')): the_row();
            $slider_image = get_sub_field('image');
            $slider_image_url = $slider_image ? ($slider_image['sizes']['6-5r960'] ?? ($slider_image['url'] ?? '')) : '';
            $slider_image_alt = $slider_image ? ($slider_image['alt'] ?? '') : '';

            $slider_video = get_sub_field('video');
            $slider_video_url = $slider_video ? ($slider_video['url'] ?? '') : '';
            $slider_video_type = $slider_video ? ($slider_video['mime_type'] ?? 'video/mp4') : 'video/mp4';

            $slider_headline = get_sub_field('headline');

            $slider_link = get_sub_field('link');
            $slider_link_url = $slider_link ? ($slider_link['url'] ?? '') : '';
            $slider_link_title = $slider_link ? ($slider_link['title'] ?? '') : '';
            $slider_link_target = $slider_link ? ($slider_link['target'] ?? '') : '';
            $slider_link_rel = ($slider_link_target === '_blank') ? 'noopener noreferrer' : '';

            if ($slider_video_url === '' && $slider_image_url === '' && $slider_headline === '' && $slider_link_url === '' && $slider_link_title === ''):
                continue;
            endif;
        ?>
        <div class="swiper-slide">
            <div class="container-fluid p-0 slider-nav-hero-top bg-verde-light">
                <div class="container p-0">
                    <div class="row g-0">
                        <div class="col-6">
                            <div class="slider-nav-hero-media">
                                <img class="slider-nav-hero-arrow slider-nav-hero-arrow-head" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-head.svg'); ?>" alt="" aria-hidden="true" />
                                <?php if (!empty($slider_video_url)): ?>
                                <video class="slider-nav-hero-video" playsinline autoplay muted loop>
                                    <source src="<?php echo esc_url($slider_video_url); ?>" type="<?php echo esc_attr($slider_video_type); ?>">
                                </video>
                                <?php elseif (!empty($slider_image_url)): ?>
                                <img class="slider-nav-hero-image" src="<?php echo esc_url($slider_image_url); ?>" alt="<?php echo esc_attr($slider_image_alt ?: get_the_title()); ?>" fetchpriority="high" />
                                <?php else: ?>
                                <img class="slider-nav-hero-image" src="<?php echo esc_url(get_template_directory_uri() . '/img/failover.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                <?php endif; ?>
                                <img class="slider-nav-hero-arrow slider-nav-hero-arrow-tail" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-tail.svg'); ?>" alt="" aria-hidden="true" />
                            </div>
                        </div>

                        <div class="col-6 d-flex align-items-center slider-nav-hero-content ps-md-5 pe-4 pe-md-5">
                            <img class="slider-nav-hero-content-arrow" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-b.svg'); ?>" alt="" aria-hidden="true" />
                            <div class="slider-nav-hero-content-inner ps-md-5 pe-4 pe-md-5">
                                <?php if (!empty($slider_headline)): ?>
                                <span class="slider-headline text-white"><?php echo esc_html($slider_headline); ?></span>
                                <?php endif; ?>

                                <?php if (!empty($slider_link_url)): ?>
                                <div class="pt-4">
                                    <a class="btn btn-aguamarina" href="<?php echo esc_url($slider_link_url); ?>" <?php if (!empty($slider_link_target)): ?>target="<?php echo esc_attr($slider_link_target); ?>" <?php endif; ?><?php if (!empty($slider_link_rel)): ?> rel="<?php echo esc_attr($slider_link_rel); ?>" <?php endif; ?>>
                                        <?php echo esc_html($slider_link_title ?: __('Learn more', 'eyemedics')); ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div> -->
</div>