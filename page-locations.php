<?php 
/**
* Template Name: Locations
*/
get_header(); 
?>
<main id="main-content" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>




        <?php 
        /* Flexible Content */
        include get_theme_file_path('/blocks/flexible-content.php'); 
        ?>

        <?php
        /*
        ██       ██████   ██████  █████  ████████ ██  ██████  ███    ██ ███████
        ██      ██    ██ ██      ██   ██    ██    ██ ██    ██ ████   ██ ██
        ██      ██    ██ ██      ███████    ██    ██ ██    ██ ██ ██  ██ ███████
        ██      ██    ██ ██      ██   ██    ██    ██ ██    ██ ██  ██ ██      ██
        ███████  ██████   ██████ ██   ██    ██    ██  ██████  ██   ████ ███████
        */
        $locations_tabs_background_class = 'bg-white';
        ?>
        <div id="locations-page" class="container tabs-block mt-5 py-5 px-0 <?php echo esc_attr($locations_tabs_background_class); ?>">
            <div class="container tabsBox py-0">
                <?php
                    $locations_posts = get_posts(
                        array(
                            'post_type' => 'consulting_location',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'orderby' => 'title',
                            'order' => 'ASC',
                        )
                    );

                    /*
                    Deep-link input from doctor/staff profile pages:
                    /locations/?location=<consulting_location_id>#locations-page
                    We sanitize to a positive integer before using it.
                    */
                    $locations_requested_location_id = 0;
                    if (isset($_GET['location'])) :
                        $locations_requested_location_raw = wp_unslash($_GET['location']);
                        if (is_scalar($locations_requested_location_raw)) :
                            $locations_requested_location_id = absint((string) $locations_requested_location_raw);
                        endif;
                    endif;
                ?>
                <?php if (!empty($locations_posts)): ?>
                <?php
                    /*
                    Tabs are rendered by index (0..n), while deep links provide a post ID.
                    Convert the requested location post ID into its matching tab index.
                    If no match is found, index 0 stays active as a safe default.
                    */
                    $locations_active_tab_index = 0;
                    if (!empty($locations_requested_location_id)) :
                        foreach ($locations_posts as $locations_index => $locations_post_item) :
                            if ((int) $locations_post_item->ID === $locations_requested_location_id) :
                                $locations_active_tab_index = (int) $locations_index;
                                break;
                            endif;
                        endforeach;
                    endif;

                    $locations_tab_index = 0;
                ?>

                <!-- Nav tabs -->
                <ul class="nav tabs-icon-nav justify-content-center flex-wrap pb-5" id="locationsTab-page" role="tablist">
                    <?php foreach ($locations_posts as $locations_post): ?>
                    <?php // Keep button active state in sync with computed deep-link index. ?>
                    <?php $locations_is_active = ($locations_tab_index === $locations_active_tab_index); ?>
                    <li class="nav-item" role="presentation">
                        <button class="tabs-icon-btn <?php echo $locations_is_active ? 'active' : ''; ?>" id="locations-tab-page-<?php echo esc_attr($locations_tab_index); ?>-tab" data-bs-toggle="tab" data-bs-target="#locations-tab-page-<?php echo esc_attr($locations_tab_index); ?>" type="button" role="tab" aria-controls="locations-tab-page-<?php echo esc_attr($locations_tab_index); ?>" aria-selected="<?php echo $locations_is_active ? 'true' : 'false'; ?>">
                            <span class="tabs-icon-label"><?php echo esc_html(get_the_title($locations_post)); ?></span>
                        </button>
                    </li>
                    <?php $locations_tab_index++; ?>
                    <?php endforeach; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-0" id="locationsTabContent-page">
                    <?php $locations_tab_index = 0; ?>
                    <?php foreach ($locations_posts as $locations_post): ?>
                    <?php
                        // Use the same computed index for pane visibility classes.
                        $locations_is_active = ($locations_tab_index === $locations_active_tab_index);
                        $locations_post_id = $locations_post->ID;
                        $locations_post_title = get_the_title($locations_post_id);
                        $locations_post_content = get_field('consulting_location_content', $locations_post_id);
                        $locations_post_map = get_field('consulting_location_map', $locations_post_id);
                        $locations_post_gallery = get_field('consulting_location_gallery', $locations_post_id);

                        $locations_map_allowed_html = array(
                            'iframe' => array(
                                'src' => array(),
                                'width' => array(),
                                'height' => array(),
                                'style' => array(),
                                'allow' => array(),
                                'allowfullscreen' => array(),
                                'loading' => array(),
                                'referrerpolicy' => array(),
                                'title' => array(),
                                'frameborder' => array(),
                            ),
                        );

                        $locations_doctors_query = new WP_Query(
                            array(
                                'post_type' => 'doctors_staff',
                                'posts_per_page' => -1,
                                'post_status' => 'publish',
                                'orderby' => 'title',
                                'order' => 'ASC',
                                'meta_query' => array(
                                    'relation' => 'OR',
                                    array(
                                        'key' => 'doctor_staff_consulting_locations',
                                        'value' => '"' . $locations_post_id . '"',
                                        'compare' => 'LIKE',
                                    ),
                                    array(
                                        'key' => 'doctor_staff_consulting_locations',
                                        'value' => (string) $locations_post_id,
                                        'compare' => '=',
                                    ),
                                ),
                            )
                        );
                    ?>
                    <div class="tab-pane fade <?php echo $locations_is_active ? 'show active' : ''; ?>" id="locations-tab-page-<?php echo esc_attr($locations_tab_index); ?>" role="tabpanel" aria-labelledby="locations-tab-page-<?php echo esc_attr($locations_tab_index); ?>-tab">
                        <div class="tabs-content-area mt-4 pb-5">


                            <?php 
                            /* -------------------------------------------------------------------------- */
                            /*                                    title                                   */
                            /* -------------------------------------------------------------------------- */
                            if (!empty($locations_post_title)): ?>
                            <h2 class="my-5"><?php echo esc_html($locations_post_title); ?></h2>
                            <?php endif; ?>

                            <?php
                            /* -------------------------------------------------------------------------- */
                            /*                                   content                                  */
                            /* -------------------------------------------------------------------------- */
                            ?>
                            <?php if (!empty($locations_post_content)): ?>
                            <div class="mb-5">
                                <?php echo wp_kses_post($locations_post_content); ?>
                            </div>
                            <?php endif; ?>


                            <?php 
                            /* -------------------------------------------------------------------------- */
                            /*                                   gallery                                  */
                            /* -------------------------------------------------------------------------- */
                            ?>
                            <?php if (!empty($locations_post_gallery) && is_array($locations_post_gallery)): ?>
                            <?php
                                $locations_gallery_id = 'locations-gallery-' . $locations_post_id;
                            ?>
                            <div id="<?php echo esc_attr($locations_gallery_id); ?>" class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 mb-5 pb-5">
                                <?php foreach ($locations_post_gallery as $locations_gallery_image): ?>
                                <?php
                                    $locations_gallery_full = $locations_gallery_image['sizes']['1080p'] ?? $locations_gallery_image['url'];
                                    $locations_gallery_display = $locations_gallery_image['sizes']['medium_large'] ?? $locations_gallery_image['sizes']['720p'] ?? $locations_gallery_image['url'];
                                    $locations_gallery_thumb = $locations_gallery_image['sizes']['thumbnail'] ?? $locations_gallery_image['url'];
                                    $locations_gallery_alt = $locations_gallery_image['alt'] ?? '';
                                    $locations_gallery_caption = $locations_gallery_image['caption'] ?? '';
                                ?>
                                <div class="col">
                                    <a class="d-block ratio ratio-4x3 overflow-hidden" href="<?php echo esc_url($locations_gallery_full); ?>" data-lg-size="1920-1080" data-src="<?php echo esc_url($locations_gallery_full); ?>" data-thumb="<?php echo esc_url($locations_gallery_thumb); ?>" data-sub-html="<?php echo esc_attr($locations_gallery_caption); ?>">
                                        <img src="<?php echo esc_url($locations_gallery_display); ?>" class="w-100 h-100 object-fit-cover lazy" alt="<?php echo esc_attr($locations_gallery_alt); ?>" loading="lazy">
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                lightGallery(document.querySelector("#<?php echo esc_js($locations_gallery_id); ?>"), {
                                    selector: "a",
                                    download: false,
                                    plugins: [lgThumbnail, lgZoom, lgAutoplay],
                                    thumbnail: true,
                                    zoom: true,
                                    autoplay: true,
                                    pause: 3000,
                                    progressBar: true,
                                });
                            });
                            </script>
                            <?php endif; ?>








                            <?php
                            /* -------------------------------------------------------------------------- */
                            /*                                     map                                    */
                            /* -------------------------------------------------------------------------- */
                            ?>
                            <?php if (!empty($locations_post_map)): ?>
                            <div class="my-5 py-5">
                                <?php echo wp_kses($locations_post_map, $locations_map_allowed_html); ?>
                            </div>
                            <?php endif; ?>




                            <?php
                            /* -------------------------------------------------------------------------- */
                            /*                                   doctors                                  */
                            /* -------------------------------------------------------------------------- */
                            ?>

                            <h3 class="my-5 pb-5">Practicing Doctors and Staff at <?php echo esc_html($locations_post_title); ?></h3>

                            <?php if ($locations_doctors_query->have_posts()): ?>
                            <div class="row row-cols-1 row-cols-lg-2 g-4">
                                <?php while ($locations_doctors_query->have_posts()): $locations_doctors_query->the_post(); ?>
                                <?php
                                    $locations_doctor_id = get_the_ID();
                                    /*
                                    Build normalized doctor/staff card data from post ID, then
                                    keep this context's heading style explicit for readability.
                                    */
                                    $locations_doctor_card_data = bystra_get_doctor_staff_card_data(
                                        $locations_doctor_id,
                                        array(
                                            'heading_variant' => 'split',
                                        )
                                    );

                                    bystra_render_doctor_staff_grid_card($locations_doctor_card_data);
                                ?>
                                <?php endwhile; ?>
                            </div>
                            <?php else: ?>
                            <div>No doctors or staff are currently assigned to this location.</div>
                            <?php endif; ?>







                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                    <?php $locations_tab_index++; ?>
                    <?php endforeach; ?>
                </div>

                <?php else: ?>
                <!-- No consulting locations found -->
                <?php endif; ?>
            </div>
        </div>


    </article>


    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>