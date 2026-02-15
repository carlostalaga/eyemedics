<?php
/*
██   ██ ███████ ██████   ██████
██   ██ ██      ██   ██ ██    ██
███████ █████   ██████  ██    ██
██   ██ ██      ██   ██ ██    ██
██   ██ ███████ ██   ██  ██████


███████ ██      ██ ██████  ███████ ██████
██      ██      ██ ██   ██ ██      ██   ██
███████ ██      ██ ██   ██ █████   ██████
     ██ ██      ██ ██   ██ ██      ██   ██
███████ ███████ ██ ██████  ███████ ██   ██

Hero slider with SVG decorations and video/image background support
Based on scale_vectors reference implementation
*/

// Get hero settings
$hero_height = get_sub_field('hero_height') ?: '80vh';


// Default settings (not configurable via ACF)
$show_navigation = false;
$show_pagination = true;
$autoplay = true;
$autoplay_delay = 5000;
$show_svg_purple = true;
$show_svg_orange = true;
$show_svg_cloud = true;
?>

<?php if (have_rows('hero_repeater')): ?>
<section class="hero-section" id="hero-<?php echo $iBlock; ?>">
    <!-- Swiper Container -->
    <div class="swiper swiper-hero" id="heroSlider-<?php echo $iBlock; ?>" style="--hero-height: <?php echo esc_attr($hero_height); ?>;">
        <div class="swiper-wrapper">
            <?php while (have_rows('hero_repeater')): the_row();
                $video = get_sub_field('video');
                $image = get_sub_field('image');
                $headline = get_sub_field('headline');
                $tagline = get_sub_field('tagline');
                $content = get_sub_field('content');
                $link = get_sub_field('link');
                $text_alignment = get_sub_field('text_alignment') ?: 'left';
                
                $bottom_cloud_colour = get_sub_field('bottom_cloud_colour') ?: '#F5F0EB';
                if($bottom_cloud_colour == 'cielo') {
                    $bottom_cloud_colour_class = '#ACCDEC';
                } 
                elseif($bottom_cloud_colour == 'hueso') {
                    $bottom_cloud_colour_class = '#F5F0EB';
                } 
                elseif($bottom_cloud_colour == 'white') {
                    $bottom_cloud_colour_class = '#FFFFFF';
                } else {
                    $bottom_cloud_colour_class = '#F5F0EB';
                }
                
                // Image sizes
                if ($image):
                    $image_url_mobile = $image['sizes']['16-9r720'] ?? $image['sizes']['medium_large'] ?? $image['url'];
                    $image_url_tablet = $image['sizes']['720p'] ?? $image['sizes']['large'] ?? $image['url'];
                    $image_url = $image['sizes']['1080p'] ?? $image['sizes']['full'] ?? $image['url'];
                endif;
            ?>

            <div class="swiper-slide">
                <!-- Background -->
                <div class="hero__background">
                    <?php if ($video): ?>
                    <video playsinline autoplay muted loop>
                        <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <?php elseif ($image): ?>
                    <picture>
                        <source media="(max-width: 576px)" srcset="<?php echo esc_url($image_url_mobile); ?>">
                        <source media="(min-width: 577px) and (max-width: 1199px)" srcset="<?php echo esc_url($image_url_tablet); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" loading="eager">
                    </picture>
                    <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/failover.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <?php endif; ?>
                </div>

                <!-- Content Overlay -->
                <?php if ($headline || $tagline || $content): ?>
                <div class="hero__content">
                    <div class="hero__text-container hero__text-container--<?php echo esc_attr($text_alignment); ?>">
                        <!-- SVG Purple Starburst (behind text) -->
                        <?php if ($show_svg_purple): ?>
                        <svg class="hero__svg hero__svg--purple" viewBox="0 0 286 282" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M118.029 17.6699C125.921 -5.89001 159.245 -5.89 167.137 17.6699C172.424 33.4544 191.016 40.2216 205.213 31.5285C226.402 18.5531 251.93 39.9734 242.831 63.0939C236.735 78.5839 246.628 95.7192 263.091 98.185C287.663 101.866 293.45 134.683 271.618 146.546C256.992 154.494 253.556 173.979 264.582 186.45C281.04 205.064 264.378 233.924 240.028 228.978C223.715 225.665 208.558 238.383 208.988 255.024C209.631 279.862 178.316 291.259 162.843 271.819C152.476 258.795 132.69 258.795 122.323 271.819C106.85 291.259 75.5353 279.862 76.1776 255.024C76.608 238.383 61.4509 225.665 45.1377 228.978C20.7884 233.924 4.12641 205.064 20.5842 186.45C31.6103 173.979 28.1745 154.494 13.548 146.546C-8.28369 134.683 -2.49704 101.866 22.0753 98.185C38.538 95.7192 48.4311 78.5839 42.3352 63.0939C33.2364 39.9734 58.7641 18.5531 79.9534 31.5285C94.1495 40.2216 112.742 33.4544 118.029 17.6699Z" fill="#80298F" />
                        </svg>
                        <?php endif; ?>

                        <?php if ($headline): ?>
                        <p class="<?php echo is_front_page() ? 'text-slider-headline-frontpage' : 'text-slider-headline'; ?>"><?php echo wp_kses_post($headline); ?></p>
                        <?php endif; ?>

                        <?php if ($tagline): ?>
                        <p class="hero__tagline"><?php echo esc_html($tagline); ?></p>
                        <?php endif; ?>

                        <?php if ($content): ?>
                        <div class="hero__description d-none d-md-block"><?php echo wp_kses_post($content); ?></div>
                        <?php endif; ?>

                        <?php if ($link && is_array($link)): ?>
                        <div class="hero__cta">
                            <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>" class="btn btn-primary btn-lg" title="<?php echo esc_attr($link['title']); ?>">
                                <?php echo esc_html($link['title'] ?: 'Learn More'); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php if ($show_pagination): ?>
        <div class="swiper-pagination"></div>
        <?php endif; ?>

        <!-- Navigation Arrows -->
        <?php if ($show_navigation): ?>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <?php endif; ?>
    </div>

    <!-- SVG 2: Orange scalloped shape - right side (global decoration) -->
    <?php if ($show_svg_orange): ?>
    <svg class="hero__svg hero__svg--orange" viewBox="0 0 187.53 787.91" xmlns="http://www.w3.org/2000/svg">
        <path d="M185.3,0c-41.84.12-75.66,34.14-75.55,75.98.03,10.31,2.14,20.11,5.89,29.06-38.45,3.74-68.46,36.18-68.34,75.59.04,17.21,5.9,33.01,15.59,45.7-34.3,10.64-59.29,43.81-59.18,83.08.1,32.1,16.97,60.02,41.87,74.86C18.47,398.63-.09,427.79,0,461.46c.13,43.34,31.09,79.05,71.32,85.2-13.98,13.78-22.65,32.95-22.59,54.14.12,40.47,31.97,73.34,71.91,75.35-5.83,10.77-9.13,23.11-9.09,36.22.12,41.84,34.13,75.66,75.97,75.55L185.3,0Z" fill="#dc651d" />
    </svg>
    <?php endif; ?>

    <!-- SVG 3: Cloud shape - bottom (global decoration) -->
    <?php if ($show_svg_cloud): ?>
    <svg class="hero__svg hero__svg--cloud" viewBox="0 0 506 120.43" xmlns="http://www.w3.org/2000/svg">
        <path d="M506,119c-.08-26.87-21.92-48.59-48.79-48.52-6.62.02-12.92,1.37-18.66,3.78-2.4-24.69-23.24-43.96-48.54-43.89-11.05.03-21.2,3.79-29.35,10.01-6.83-22.03-28.14-38.07-53.36-38.01-20.62.06-38.54,10.9-48.08,26.89C250,11.86,231.27-.06,209.65,0c-27.84.08-50.77,19.97-54.71,45.81-8.85-8.98-21.16-14.55-34.77-14.51-25.99.08-47.1,20.53-48.39,46.18-6.92-3.75-14.84-5.86-23.26-5.84C21.65,71.72-.07,93.56,0,120.43l506-1.43Z" fill="<?php echo esc_attr($bottom_cloud_colour_class); ?>" />
    </svg>
    <?php endif; ?>
</section>
<?php else: ?>
<!-- Hero: No slides configured -->
<?php endif; ?>