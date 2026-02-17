<?php
/**
 * Block: Content Basic
 * 
 * A flexible content block that supports various layouts with headline, content, and optional image.
 * Supports different column arrangements and image alignments.
 */

// Get field values from ACF
$content_basic_background = get_sub_field('content_basic_background');
$content_basic_columns = get_sub_field('content_basic_columns');
$content_basic_headline = get_sub_field('content_basic_headline');
$content_basic_content = get_sub_field('content_basic_content');
$content_basic_optional_image = get_sub_field('content_basic_optional_image'); // true / false
$content_basic_image = get_sub_field('content_basic_image');

// Initialize image variables with default empty values to prevent undefined variable warnings
// These variables are used later in the code regardless of whether an image is present
$content_basic_image_url_43 = '';
$content_basic_image_url_11 = '';
$content_basic_image_url_slider = '';
$content_basic_image_alt = '';

// Process image data if available
if ($content_basic_image):
    $content_basic_image_url_43 = $content_basic_image['sizes']['576sm'];
    $content_basic_image_url_11 = $content_basic_image['sizes']['576sm'];
    $content_basic_image_url_slider = $content_basic_image['sizes']['1080p'];
    $content_basic_image_alt = $content_basic_image['alt'];
endif;

// Get image alignment setting
$content_basic_image_alignment = get_sub_field('content_basic_image_alignment'); // left, right, content_wide

// Get decorative cloud visibility setting
$show_top_inverted_cloud = get_sub_field('show_top_inverted_cloud');

// Get decorative cloud colour setting
$top_inverted_cloud_colour = get_sub_field('top_inverted_cloud_colour');
// Map color name to hex value
$cloud_fill_color = '#fff'; // default white
if ($top_inverted_cloud_colour == 'cielo') {
    $cloud_fill_color = '#ACCDEC';
} elseif ($top_inverted_cloud_colour == 'hueso') {
    $cloud_fill_color = '#F5F0EB';
} elseif ($top_inverted_cloud_colour == 'white') {
    $cloud_fill_color = '#fff';
}

// Determine background class based on selection
$background_class = '';
    if ($content_basic_background == 'bg-verde') {
        $background_class = 'bg-verde';
    } elseif ($content_basic_background == 'bg-verde-light') {
        $background_class = 'bg-verde-light';
    } elseif ($content_basic_background == 'bg-humo') {
        $background_class = 'bg-humo';
    } elseif ($content_basic_background == 'bg-white') {
        $background_class = 'bg-white';
    }

// Determine if newspaper column style should be applied
$newspaper_class = ($content_basic_columns == '2_col') ? 'newspaper' : '';

// Determine content column classes based on configuration
$content_column_class = 'pt-5 col-12';
if ($content_basic_optional_image) {
    if ($content_basic_columns == '1_col') {
        $content_column_class = 'col-md-6';
    } elseif ($content_basic_columns == '2_col') {
        $content_column_class = 'col-md-8';
    }
}

// Determine image column classes based on configuration
$image_column_class = 'pt-5 bg-transparent';
if ($content_basic_columns == '1_col') {
    $image_column_class .= ' col-md-6';
} elseif ($content_basic_columns == '2_col') {
    $image_column_class .= ' col-md-4';
}

// Determine image ordering based on alignment
$image_order_class = ($content_basic_image_alignment == 'left') ? 'order-0 pe-5' : 'order-1 ps-5';

// Determine which image URL to use based on column setting
$image_url = '';
if ($content_basic_columns == '1_col') {
    $image_url = $content_basic_image_url_43;
} elseif ($content_basic_columns == '2_col') {
    $image_url = $content_basic_image_url_11;
}

// Determine if the image should be expanded
$expand_image = get_sub_field('expand_image');
$flower_container_class = $expand_image ? 'flower-image-container-expanded' : 'flower-image-container';
?>

<!-- Content Basic Block -->
<div id="content-<?php echo $iBlock; ?>" class="container-fluid  pb-5 px-5 px-md-0 border border-0 border-danger <?php echo $background_class; ?>">

    <?php if ($show_top_inverted_cloud): ?>
    <!-- Decorative cloud SVG -->
    <div class="content-basic__svg-wrapper">
        <svg class="content-basic__svg content-basic__svg--cloud-right" viewBox="0 0 506 120.43" xmlns="http://www.w3.org/2000/svg">
            <path d="M-.0002,1.4298c.08,26.87,21.92,48.59,48.79,48.52,6.62-.02,12.92-1.37,18.66-3.78,2.4,24.69,23.24,43.96,48.54,43.89,11.05-.03,21.2-3.79,29.35-10.01,6.83,22.03,28.14,38.07,53.36,38.01,20.62-.06,38.54-10.9,48.08-26.89,9.22,17.4,27.95,29.32,49.57,29.26,27.84-.08,50.77-19.97,54.71-45.81,8.85,8.98,21.16,14.55,34.77,14.51,25.99-.08,47.1-20.53,48.39-46.18,6.92,3.75,14.84,5.86,23.26,5.84,26.87-.08,48.59-21.92,48.52-48.79L-.0002,1.4298Z" fill="<?php echo $cloud_fill_color; ?>" />
        </svg>
    </div>
    <?php endif; ?>

    <div class="container border border-0 border-secondary">

        <style>
        /* ==========================================================================
           FLOWER CLIP PATH IMAGE STYLES
           
           This creates a flower-shaped mask around images with a subtle rotation effect.
           The flower shape rotates slowly while the image inside remains stationary.
           
           Structure:
           - .flower-image-container: Outer wrapper that sets dimensions
           - .flower-clip-rotator: Middle layer with clip-path that rotates clockwise
           - img: Inner image that counter-rotates to stay visually static
           ========================================================================== */

        /* Hidden SVG containing the flower clip path definition */
        .flower-clip-svg {
            position: absolute;
            width: 0;
            height: 0;
        }

        /* --------------------------------------------------------------------------
           FLOWER ROTATION ANIMATION
           
           Duration: 120s (2 minutes) for one full rotation - very slow and subtle
           To adjust speed: lower = faster, higher = slower
           Example: 60s = 1 min, 180s = 3 min, 240s = 4 min
           -------------------------------------------------------------------------- */
        
        /* Clockwise rotation for the clip-path wrapper */
        @keyframes flower-rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Counter-clockwise rotation for the image (keeps image static while shape rotates) */
        @keyframes flower-counter-rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(-360deg);
            }
        }

        /* --------------------------------------------------------------------------
           STANDARD FLOWER IMAGE CONTAINER
           -------------------------------------------------------------------------- */
        .flower-image-container {
            position: relative;
            width: 100%;
            max-width: 900px;
            aspect-ratio: 1 / 1;
        }

        /* Rotating wrapper - applies flower clip-path and rotates clockwise */
        .flower-image-container .flower-clip-rotator {
            position: absolute;
            width: 100%;
            height: 100%;
            clip-path: url(#flower-clip);
            animation: flower-rotate 120s linear infinite; /* Slow 2-minute rotation */
        }

        /* Image counter-rotates to remain visually stationary */
        .flower-image-container img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: flower-counter-rotate 120s linear infinite; /* Must match rotator duration */
        }

        /* --------------------------------------------------------------------------
           EXPANDED FLOWER IMAGE CONTAINER
           Larger version that can overlap content above (e.g., hero sections)
           -------------------------------------------------------------------------- */
        .flower-image-container-expanded {
            position: relative;
            width: 110%;
            max-width: 900px;
            aspect-ratio: 1 / 1;
            margin-top: -15rem; /* Pulls image up to overlap previous section */
        }

        /* Rotating wrapper for expanded container */
        .flower-image-container-expanded .flower-clip-rotator {
            position: absolute;
            width: 100%;
            height: 100%;
            clip-path: url(#flower-clip);
            animation: flower-rotate 120s linear infinite; /* Slow 2-minute rotation */
        }

        /* Image counter-rotates to remain visually stationary */
        .flower-image-container-expanded img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: flower-counter-rotate 120s linear infinite; /* Must match rotator duration */
        }

        /* Responsive: Reset expanded container on smaller screens */
        @media (max-width: 1200px) {
            .flower-image-container-expanded {
                width: 100%;
                margin-top: 0;
            }
        }

    </style>
        <!-- Hidden SVG with clip path definition -->
        <svg class="flower-clip-svg" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <clipPath id="flower-clip" clipPathUnits="objectBoundingBox">
                    <path transform="scale(0.001582, 0.0016)" d="M631.963,304.856c-.516-21.213-11.867-39.625-28.63-50.103,11.398-16.145,14.721-37.501,6.959-57.256-7.761-19.765-24.735-33.187-44.085-37.311,5.174-19.06.9741-40.263-13.088-56.18-14.062-15.9264-34.616-22.7465-54.214-20.0222-1.671-19.6793-12.888-38.1678-31.561-48.3313-18.673-10.1635-40.324-9.5634-57.803-.3143-8.315-17.9171-25.193-31.462-46.224-34.6435-21.031-3.1814-41.164,4.7817-54.424,19.4316-13.957-14.0022-34.453-20.9747-55.312-16.7836-20.859,4.1911-37.05,18.5362-44.487,36.8343-17.909-8.3918-39.57-7.9536-57.727,3.1052-18.157,11.0589-28.458,30.0618-29.174,49.7982-19.713-1.7717-39.9037,6.0295-53.1828,22.6126-13.2695,16.584-16.4389,37.959-10.3483,56.752-19.131,5.058-35.4268,19.289-42.2143,39.406-6.7875,20.118-2.4343,41.283,9.7278,56.857C9.9465,279.995-.4973,298.931.0183,320.144c.5155,21.213,11.8662,39.625,28.6297,50.103-11.3985,16.145-14.7111,37.501-6.9594,57.257,7.7613,19.764,24.7348,33.186,44.0854,37.31-5.1742,19.06-.9737,40.263,13.0881,56.18,14.0619,15.917,34.6149,22.746,54.2139,20.022,1.671,19.679,12.888,38.168,31.561,48.332,18.673,10.163,40.324,9.563,57.803.314,8.315,17.917,25.193,31.462,46.224,34.643,21.031,3.182,41.164-4.781,54.424-19.431,13.957,14.002,34.453,20.974,55.312,16.783,20.85-4.191,37.05-18.536,44.487-36.834,17.909,8.392,39.569,7.944,57.727-3.105,18.157-11.059,28.458-30.062,29.174-49.798,19.713,1.771,39.904-6.03,53.183-22.613,13.269-16.584,16.439-37.959,10.348-56.752,19.131-5.058,35.427-19.289,42.2241-39.406,6.787-20.118,2.434-41.283-9.728-56.857,16.238-11.277,26.682-30.214,26.167-51.436h-.019Z" />
                </clipPath>
            </defs>
        </svg>



        <?php if ($content_basic_optional_image || $content_basic_content): ?>
        <?php if ($content_basic_image_alignment == 'content_wide'): ?>
        <!-- "content_wide" layout: headline, content, then image -->
        <div class="row g-0 ">

            <!-- Content -->
            <div class="col-12 contentBox bg-transparent  <?php echo $newspaper_class; ?>">
                <?php if ($content_basic_headline): ?>
                <?php if (!$firstContentBlockFound): ?>
                <!-- First headline on page - use H1 for SEO -->
                <h3 class="mb-5"><?php echo esc_html($content_basic_headline); ?></h3>
                <?php $firstContentBlockFound = true; ?>
                <?php else: ?>
                <!-- Subsequent headlines - use H2 for proper heading hierarchy -->
                <h4 class="mb-5"><?php echo esc_html($content_basic_headline); ?></h4>
                <?php endif; ?>
                <?php endif; ?>

                <?php if ($content_basic_content): ?>
                <?php echo $content_basic_content; ?>
                <?php endif; ?>
            </div>

            <!-- Image (if enabled) -->
            <?php if ($content_basic_optional_image): ?>
            <div class="col-12">
                <img src="<?php echo $content_basic_image_url_slider; ?>" class="img-fluid" alt="<?php echo $content_basic_image_alt; ?>">
            </div>
            <?php endif; ?>

        </div>
        <?php else: ?>
        <!-- "left" or "right" layout: image and content side by side -->
        <div class="row g-0 py-0">
            <!-- Image (if enabled) -->
            <?php if ($content_basic_optional_image): ?>

            <div class="flower-image-wrapper <?php echo $image_column_class; ?> <?php echo $image_order_class; ?>">
                <div class="<?php echo $flower_container_class; ?>">
                    <!-- $flower_container_class could be flower-image-container-expanded OR flower-image-container -->
                    <div class="flower-clip-rotator">
                        <img src="<?php echo $image_url; ?>" class="img-fluid" alt="<?php echo $content_basic_image_alt; ?>">
                    </div>
                </div>
            </div>


            <?php endif; ?>

            <!-- Content -->
            <div class="contentBox bg-transparent p-0 d-flex align-items-center <?php echo $content_column_class; ?> <?php echo $newspaper_class; ?>">
                <div>
                    <?php if ($content_basic_headline): ?>
                    <?php if (!$firstContentBlockFound): ?>
                    <!-- First headline on page - use H1 for SEO -->
                    <h3 class="mb-5"><?php echo esc_html($content_basic_headline); ?></h3>
                    <?php $firstContentBlockFound = true; ?>
                    <?php else: ?>
                    <!-- Subsequent headlines - use H2 for proper heading hierarchy -->
                    <h4 class="mb-5"><?php echo esc_html($content_basic_headline); ?></h4>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($content_basic_content): ?>
                    <?php echo $content_basic_content; ?>
                    <?php endif; ?>

                    <!-- Resources Section -->
                    <div class="mt-5">
                        <?php echo display_resources('content_basic_resource_repeater', true, false); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>



    </div>
</div>