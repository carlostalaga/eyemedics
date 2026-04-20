<?php
/**
 * Navigator Hero (template part)
 *
 * Enqueue expectations:
 * - This template part currently outputs minimal inline CSS + vanilla JS for prototyping.
 * - When the prototype is finalized, move the CSS/JS into theme asset files and enqueue them
 *   via `wp_enqueue_style()` / `wp_enqueue_script()` wherever this template part is used.
 */

$navigator_repeater = get_field('navigator_repeater');
if (empty($navigator_repeater) || !is_array($navigator_repeater)):
    return;
endif;

$nav_hero_items = [];
foreach ($navigator_repeater as $row):
    if (!is_array($row)):
        continue;
    endif;

    $nav_hero_image = $row['image'] ?? null;
    $nav_hero_link = $row['link'] ?? [];
    $nav_hero_headline = $row['headline'] ?? '';

    $nav_hero_link_url = is_array($nav_hero_link) ? ($nav_hero_link['url'] ?? '') : '';
    $nav_hero_link_title = is_array($nav_hero_link) ? ($nav_hero_link['title'] ?? '') : '';
    $nav_hero_link_target = is_array($nav_hero_link) ? ($nav_hero_link['target'] ?? '') : '';

    if (empty($nav_hero_image) && $nav_hero_headline === '' && $nav_hero_link_url === '' && $nav_hero_link_title === ''):
        continue;
    endif;

    $nav_hero_items[] = [
        'image' => $nav_hero_image,
        'link' => [
            'url' => $nav_hero_link_url,
            'title' => $nav_hero_link_title,
            'target' => $nav_hero_link_target,
        ],
        'headline' => $nav_hero_headline,
    ];
endforeach;

if (empty($nav_hero_items)):
    return;
endif;

$nav_hero_count = count($nav_hero_items);
$nav_hero_instance_id = function_exists('wp_unique_id') ? wp_unique_id('nav-hero-') : ('nav-hero-' . uniqid());

?>

<div class="container-fluid p-0 nav-hero" data-nav-hero="<?php echo esc_attr($nav_hero_instance_id); ?>">

    <div class="container-fluid nav-hero-top  bg-verde-light">
        <?php foreach ($nav_hero_items as $index => $item): ?>
        <?php
            $is_active = ($index === 0);
            $tab_id = $nav_hero_instance_id . '-tab-' . $index;
            $panel_id = $nav_hero_instance_id . '-panel-' . $index;
            ?>

        <div class="container bg-info p-0 nav-hero-slide<?php echo $is_active ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr($index); ?>" id="<?php echo esc_attr($panel_id); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($tab_id); ?>" tabindex="0" <?php if (!$is_active): ?>hidden<?php endif; ?>>
            <div class="row g-0">

                <div class="col-6">
                    <div class="nav-hero-media">
                        <img class="nav-hero-arrow nav-hero-arrow-head" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-head.svg'); ?>" alt="" aria-hidden="true" />
                        <?php $image = $item['image']; ?>
                        <?php if (!empty($image['sizes']['6-5r960'])): ?>
                        <img class="img-fluid nav-hero-image" src="<?php echo esc_url($image['sizes']['6-5r960']); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" loading="lazy" />
                        <?php endif; ?>
                        <img class="nav-hero-arrow nav-hero-arrow-tail" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-tail.svg'); ?>" alt="" aria-hidden="true" />
                    </div>
                </div>

                <div class="col-6 d-flex align-items-center nav-hero-content ps-md-5 pe-4 pe-md-5">
                    <img class="nav-hero-content-arrow" src="<?php echo esc_url(get_template_directory_uri() . '/img/arrow-b.svg'); ?>" alt="" aria-hidden="true" />
                    <?php if (!empty($item['headline'])): ?>
                    <div class="ps-md-5 pe-4 pe-md-5">
                        <span class="nav-hero-headline text-white"><?php echo esc_html($item['headline']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <?php endforeach; ?>
    </div>



    <?php if ($nav_hero_count > 1): ?>
    <div class="container-fluid nav-hero-bottom">
        <div class="container">
            <div class="row nav-hero-tabs" role="tablist" aria-label="<?php echo esc_attr__('Navigator hero', 'eyemedics'); ?>">
                <?php foreach ($nav_hero_items as $index => $item): ?>
                <?php
                    $is_active = ($index === 0);
                    $tab_id = $nav_hero_instance_id . '-tab-' . $index;
                    $panel_id = $nav_hero_instance_id . '-panel-' . $index;

                    $link_url = $item['link']['url'] ?? '';
                    $link_title = $item['link']['title'] ?? '';
                    $link_target = $item['link']['target'] ?? '';
                    $link_rel = ($link_target === '_blank') ? 'noopener noreferrer' : '';
                    ?>

                <div class="col-12 col-sm-6 col-md">
                    <a class="btn btn-hero w-100 nav-hero-tab<?php echo $is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url($link_url ?: '#'); ?>" <?php if (!empty($link_target)): ?>target="<?php echo esc_attr($link_target); ?>" <?php endif; ?> <?php if (!empty($link_rel)): ?>rel="<?php echo esc_attr($link_rel); ?>" <?php endif; ?> role="tab" id="<?php echo esc_attr($tab_id); ?>" aria-controls="<?php echo esc_attr($panel_id); ?>" aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>" tabindex="<?php echo $is_active ? '0' : '-1'; ?>" data-target="<?php echo esc_attr($index); ?>">
                        <?php echo esc_html($link_title ?: __('Learn more', 'eyemedics')); ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
static $nav_hero_assets_printed = false;
if (!$nav_hero_assets_printed):
    $nav_hero_assets_printed = true;
    ?>
<style>
        .nav-hero-slide {
            display: none;
        }

        .nav-hero-slide.is-active {
            display: block;
        }

        .nav-hero-media {
            position: relative;
        }

        .nav-hero-arrow {
            position: absolute;
            top: 0;
            height: 100%;
            width: auto;
            pointer-events: none;
            z-index: 1;
        }

        .nav-hero-arrow-head { left: 0; }
        .nav-hero-arrow-tail { right: 0; }

        .nav-hero-content {
            position: relative;
            background: linear-gradient(to right, #A7D16C 0%, #A7D16C 10%, #d3df62 90%, #d3df62 100%);
        }

        .nav-hero-content-arrow {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: auto;
            z-index: 0;
            pointer-events: none;
        }

        .nav-hero-content .nav-hero-headline {
            position: relative;
            z-index: 1;
        }

        /* Overhang: pull tabs up so they overlap the hero's bottom edge.
           position: relative + z-index lifts them above .nav-hero-content
           (which creates its own stacking context via position: relative). */
        .nav-hero-bottom {
            position: relative;
            z-index: 2;
            margin-top: -60px;
            margin-bottom: -45px;
        }

        .nav-hero-tab.is-active,
        .nav-hero-tab.is-active:hover {
            border-color: #D5E04D;
            background-color: #D5E04D;
            color: #0A0203;
        }
    </style>

<script>
(function() {
    "use strict";

    function isModifiedClick(event) {
        return Boolean(event.metaKey || event.ctrlKey || event.shiftKey || event.altKey);
    }

    function setActive(root, nextIndex, nextTab) {
        var slides = root.querySelectorAll(".nav-hero-slide[data-slide]");
        var tabs = root.querySelectorAll(".nav-hero-tab[data-target]");

        slides.forEach(function(slide) {
            slide.classList.remove("is-active");
            slide.setAttribute("hidden", "");
        });

        tabs.forEach(function(tab) {
            tab.classList.remove("is-active");
            tab.setAttribute("aria-selected", "false");
            tab.setAttribute("tabindex", "-1");
        });

        var nextSlide = root.querySelector('.nav-hero-slide[data-slide="' + String(nextIndex) + '"]');
        if (nextSlide) {
            nextSlide.classList.add("is-active");
            nextSlide.removeAttribute("hidden");
        }

        if (nextTab) {
            nextTab.classList.add("is-active");
            nextTab.setAttribute("aria-selected", "true");
            nextTab.setAttribute("tabindex", "0");
        }
    }

    function initNavHero(root) {
        var tablist = root.querySelector('[role="tablist"]');
        if (!tablist) {
            return;
        }

        tablist.addEventListener("click", function(event) {
            var tab = event.target.closest('.nav-hero-tab[data-target]');
            if (!tab || !root.contains(tab)) {
                return;
            }

            // Prototype decision: left-click swaps in place instead of navigating.
            // Modified clicks (cmd/ctrl/shift/alt) still behave like normal links.
            if (event.button === 0 && !isModifiedClick(event)) {
                event.preventDefault();
            } else {
                return;
            }

            var nextIndex = tab.getAttribute("data-target");
            setActive(root, nextIndex, tab);
        });

        tablist.addEventListener("keydown", function(event) {
            var tab = event.target.closest('.nav-hero-tab[data-target]');
            if (!tab || !root.contains(tab)) {
                return;
            }

            if (event.key === " " || event.key === "Spacebar") {
                event.preventDefault();
                tab.click();
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".nav-hero").forEach(function(root) {
            initNavHero(root);
        });
    });
})();
</script>
<?php endif; ?>