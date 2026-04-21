<?php
$slider_repeater = get_sub_field('slider_repeater');
if (empty($slider_repeater) || !is_array($slider_repeater)):
    return;
endif;

/*
|--------------------------------------------------------------------------
| Normalize slider items
|--------------------------------------------------------------------------
*/
$slider_items = [];
foreach ($slider_repeater as $slider_row):
    if (!is_array($slider_row)):
        continue;
    endif;

    $slider_image = $slider_row['image'] ?? null;
    $slider_video = $slider_row['video'] ?? null;
    $slider_headline = $slider_row['headline'] ?? '';
    $slider_link = $slider_row['link'] ?? [];

    $slider_link_url = is_array($slider_link) ? ($slider_link['url'] ?? '') : '';
    $slider_link_title = is_array($slider_link) ? ($slider_link['title'] ?? '') : '';
    $slider_link_target = is_array($slider_link) ? ($slider_link['target'] ?? '') : '';

    $slider_video_url = is_array($slider_video) ? ($slider_video['url'] ?? '') : '';
    $slider_video_type = is_array($slider_video) ? ($slider_video['mime_type'] ?? 'video/mp4') : 'video/mp4';

    $slider_image_url = '';
    $slider_image_alt = '';
    if (is_array($slider_image)):
        $slider_image_url = $slider_image['sizes']['6-5r960'] ?? '';
        if ($slider_image_url === ''):
            $slider_image_url = $slider_image['url'] ?? '';
        endif;

        $slider_image_alt = $slider_image['alt'] ?? '';
    endif;

    if ($slider_video_url === '' && $slider_image_url === '' && $slider_headline === '' && $slider_link_url === '' && $slider_link_title === ''):
        continue;
    endif;

    $slider_items[] = [
        'headline' => $slider_headline,
        'image_url' => $slider_image_url,
        'image_alt' => $slider_image_alt,
        'video_url' => $slider_video_url,
        'video_type' => $slider_video_type,
        'link' => [
            'url' => $slider_link_url,
            'title' => $slider_link_title,
            'target' => $slider_link_target,
        ],
    ];
endforeach;

if (empty($slider_items)):
    return;
endif;
?>

<div id="slider-<?php echo esc_attr($iBlock); ?>" class="swiper slider-nav-hero">
    <div class="swiper-wrapper">
        <?php foreach ($slider_items as $slider_item): ?>
        <?php
            $slider_link_url = $slider_item['link']['url'] ?? '';
            $slider_link_title = $slider_item['link']['title'] ?? '';
            $slider_link_target = $slider_item['link']['target'] ?? '';
            $slider_link_rel = ($slider_link_target === '_blank') ? 'noopener noreferrer' : '';
            ?>
        <div class="swiper-slide">
            <div class="container-fluid p-0 slider-nav-hero-top bg-verde-light">
                <div class="container p-0">
                    <div class="row g-0">
                        <div class="col-12 col-lg-6">
                            <div class="slider-nav-hero-media">
                                <img class="slider-nav-hero-arrow slider-nav-hero-arrow-head" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-head.svg'); ?>" alt="" aria-hidden="true" />
                                <?php if (!empty($slider_item['video_url'])): ?>
                                <video class="slider-nav-hero-video" playsinline autoplay muted loop>
                                    <source src="<?php echo esc_url($slider_item['video_url']); ?>" type="<?php echo esc_attr($slider_item['video_type']); ?>">
                                </video>
                                <?php elseif (!empty($slider_item['image_url'])): ?>
                                <img class="slider-nav-hero-image" src="<?php echo esc_url($slider_item['image_url']); ?>" alt="<?php echo esc_attr($slider_item['image_alt'] ?: get_the_title()); ?>" loading="lazy" />
                                <?php else: ?>
                                <img class="slider-nav-hero-image" src="<?php echo esc_url(get_template_directory_uri() . '/img/failover.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" />
                                <?php endif; ?>
                                <img class="slider-nav-hero-arrow slider-nav-hero-arrow-tail" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-tail.svg'); ?>" alt="" aria-hidden="true" />
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 d-flex align-items-center slider-nav-hero-content ps-md-5 pe-4 pe-md-5">
                            <img class="slider-nav-hero-content-arrow" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-b.svg'); ?>" alt="" aria-hidden="true" />
                            <div class="slider-nav-hero-content-inner ps-md-5 pe-4 pe-md-5">
                                <?php if (!empty($slider_item['headline'])): ?>
                                <span class="nav-hero-headline text-white"><?php echo esc_html($slider_item['headline']); ?></span>
                                <?php endif; ?>

                                <?php if (!empty($slider_link_url)): ?>
                                <div class="pt-4">
                                    <a class="btn btn-aguamarina" href="<?php echo esc_url($slider_link_url); ?>" <?php if (!empty($slider_link_target)): ?>target="<?php echo esc_attr($slider_link_target); ?>" <?php endif; ?><?php if (!empty($slider_link_rel)): ?> rel="<?php echo esc_attr($slider_link_rel); ?>"<?php endif; ?>>
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
        <?php endforeach; ?>
    </div>

    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<?php
static $slider_nav_hero_assets_printed = false;
if (!$slider_nav_hero_assets_printed):
    $slider_nav_hero_assets_printed = true;
    ?>
<style>
        .slider-nav-hero .swiper-slide {
            display: block;
            height: auto;
        }

        .slider-nav-hero-top {
            height: 100%;
        }

        .slider-nav-hero-media {
            position: relative;
            aspect-ratio: 6 / 5;
            overflow: hidden;
        }

        .slider-nav-hero-image,
        .slider-nav-hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .slider-nav-hero-arrow {
            position: absolute;
            top: 0;
            height: 100%;
            width: auto;
            z-index: 1;
            pointer-events: none;
        }

        .slider-nav-hero-arrow-head {
            left: 0;
        }

        .slider-nav-hero-arrow-tail {
            right: 0;
        }

        .slider-nav-hero-content {
            position: relative;
            background: linear-gradient(to right, #A7D16C 0%, #A7D16C 10%, #d3df62 90%, #d3df62 100%);
            min-height: 100%;
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        .slider-nav-hero-content-arrow {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: auto;
            z-index: 0;
            pointer-events: none;
        }

        .slider-nav-hero-content-inner {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 991.98px) {
            .slider-nav-hero-arrow {
                display: none;
            }

            .slider-nav-hero-content-inner {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }
    </style>
<?php endif; ?>