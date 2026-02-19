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

// Detect darker green backgrounds so resource buttons can flip to the light palette for contrast.
$use_light_buttons = in_array($content_basic_background, array('bg-verde', 'bg-verde-light'), true);

// Determine if newspaper column style should be applied
$newspaper_class = ($content_basic_columns == '2_col') ? 'newspaper' : '';

// Determine content column classes based on configuration
$content_column_class = '';
if ($content_basic_optional_image) {
    $content_column_class = 'col-md-8';
} else {
    $content_column_class = 'col-12';
}

// Determine image column classes based on configuration
$image_column_class = '';
if ($content_basic_optional_image) {
    $image_column_class = 'col-md-4';
} else {
    $image_column_class = '';
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

// Pre-render shared content sections to avoid duplication
ob_start();
if ($content_basic_headline):
    if (!$firstContentBlockFound): ?>
<!-- First headline on page - use H1 for SEO -->
<h3 class="mb-5"><?php echo esc_html($content_basic_headline); ?></h3>
<?php $firstContentBlockFound = true;
    else: ?>
<!-- Subsequent headlines - use H2 for proper heading hierarchy -->
<h4 class="mb-5"><?php echo esc_html($content_basic_headline); ?></h4>
<?php endif;
endif;
$headline_html = ob_get_clean();

ob_start();
if ($content_basic_content): ?>
<div class="mb-5 <?php echo $newspaper_class; ?>">
    <?php echo $content_basic_content; ?>
</div>
<?php endif;
$content_html = ob_get_clean();

ob_start(); ?>
<div class="mt-5">
    <?php echo display_resources('content_basic_resource_repeater', false, false, $use_light_buttons); ?>
</div>
<?php 
$resources_html = ob_get_clean();

?>

<!-- Content Basic Block -->
<div id="content-<?php echo $iBlock; ?>" class="container-fluid  pb-5 px-5 px-md-0 border border-0 border-danger <?php echo $background_class; ?>">

    <div class="container border border-0 border-secondary">

        <?php if ($content_basic_image_alignment == 'content_wide'): ?>
        <!-- "content_wide" layout: headline, content, resources, then image -->
        <div class="row g-0">
            <div class="col-12 contentBox bg-transparent">
                <?php echo $headline_html; ?>
                <?php echo $content_html; ?>
                <?php echo $resources_html; ?>
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
            <div class="<?php echo $image_column_class; ?> <?php echo $image_order_class; ?>">
                <div class="border">
                    <!-- $flower_container_class could be flower-image-container-expanded OR flower-image-container -->
                    <div class="border">
                        <img src="<?php echo $image_url; ?>" class="img-fluid" alt="<?php echo $content_basic_image_alt; ?>">
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="<?php echo $content_column_class; ?> contentBox bg-primary p-0 d-flex align-items-center">
                <div>
                    <?php echo $headline_html; ?>
                    <?php echo $content_html; ?>
                    <?php echo $resources_html; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>