<?php
/*
████████ ███████ ███████ ████████ ██ ███    ███  ██████  ███    ██ ██  █████  ██      ███████
   ██    ██      ██         ██    ██ ████  ████ ██    ██ ████   ██ ██ ██   ██ ██      ██
   ██    █████   ███████    ██    ██ ██ ████ ██ ██    ██ ██ ██  ██ ██ ███████ ██      ███████
   ██    ██           ██    ██    ██ ██  ██  ██ ██    ██ ██  ██ ██ ██ ██   ██ ██           ██
   ██    ███████ ███████    ██    ██ ██      ██  ██████  ██   ████ ██ ██   ██ ███████ ███████
*/

// Get the background and segment values from ACF fields
$testimonials_background = get_sub_field('testimonials_background');
$testimonials_segment = get_sub_field('testimonials_segment'); // Term ID for filtering by 'segment' taxonomy

// If a segment is selected, get the term object and store the term name for output
if ($testimonials_segment) {
    $segment_term = get_term($testimonials_segment, 'segment');
    if ($segment_term && !is_wp_error($segment_term)) {
        $segment_name = esc_html($segment_term->name);
    }
}

// Prepare WP_Query arguments for retrieving 'testimonials' posts
$testimonials_args = [
    'post_type'      => 'testimonials', // Custom post type
    'posts_per_page' => 256,             // Limit the number of posts
    'orderby'        => 'rand',         // Random order for posts
];

// Add taxonomy filter if a segment is selected
if ($testimonials_segment) {
    $testimonials_args['tax_query'] = [
        [
            'taxonomy' => 'segment',        // Custom taxonomy name
            'field'    => 'term_id',        // Filter by term ID
            'terms'    => $testimonials_segment, // The selected segment ID
        ],
    ];
}

// Execute WP_Query with the arguments
$testimonials_query = new WP_Query($testimonials_args);

// Begin HTML output
?>
<div id="testimonialsBlock-<?php echo $iBlock; ?>" class="container-fluid py-5 <?php 
    if ($testimonials_background == 'bg-hueso'): 
        echo 'bg-white'; 
    elseif ($testimonials_background == 'bg-white'): 
        echo 'bg-white'; 
    endif; 
?>">
    <div class="container">
        <div class="row">
            <div class="col-12 py-5">
                <h2 class="text-posidonia">What our customers say about us:</h2>
            </div>
            <div class="col-12">
                <?php
                // Check if the query returned any posts
                if ($testimonials_query->have_posts()) :
                    // Loop through the posts
                    $testimonial_count = 0;
                    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                        $testimonial_count++;
                        
                        // Retrieve custom fields
                        $testimonial = get_field('testimonial');
                        $author = get_field('author');
                        $about_author = get_field('about_author');
                        $author_image = get_field('image');
                        $testimonial_gallery = get_field('testimonial_gallery');
                        $sales_consultant = get_field('sales_consultants');
                        
                        // Alternate quote icon colors
                        $quote_color = ($testimonial_count % 2 === 1) ? 'text-aguamarina' : 'text-posidonia';
                ?>
                <div class="testimonial-container bg-hueso p-5 mb-4">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left fa-3x <?php echo $quote_color; ?> mb-3"></i>
                    </div>
                    <div class="testimonial-content">
                        <div class="row">
                            <div class="col-12">
                                <?php if ($testimonial) : ?>
                                <div class="col-12 mb-4">
                                    <p class="lead"><?php echo wp_kses_post($testimonial); ?></p>
                                </div>
                                <?php endif; ?>

                                <?php if ($author_image || $author || $about_author) : ?>
                                <div class="col-md-auto mb-3">
                                    <?php if ($author_image) : ?>
                                    <img src="<?php echo esc_url($author_image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($author_image['alt']); ?>" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md mb-3">
                                    <?php if ($author) : ?>
                                    <h5 class="mb-1"><?php echo esc_html($author); ?></h5>
                                    <?php endif; ?>
                                    <?php if ($about_author) : ?>
                                    <p class="text-muted mb-0"><?php echo esc_html($about_author); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php if ($testimonial_gallery && is_array($testimonial_gallery) && count($testimonial_gallery) > 0) : ?>
                                <div class="col-12 mt-5">
                                    <div class="testimonial-gallery" id="testimonial-gallery-<?php echo get_the_ID(); ?>">
                                        <?php foreach ($testimonial_gallery as $image) : ?>
                                        <div class="d-inline-block me-2 mb-2" data-src="<?php echo esc_url($image['sizes']['1080p'] ?? $image['url']); ?>">
                                            <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;">
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ($sales_consultant) : ?>
                                <div class="col-12 mt-5 pt-5 border-top">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-12">
                                            <div class="text-prose-semibold text-sombra mb-3">
                                                <?php echo (is_array($sales_consultant) && count($sales_consultant) > 1) ? 'Your Sales Consultants' : 'Your Sales Consultant'; ?>
                                            </div>
                                        </div>

                                        <?php 
                                        // Convert to array if not already
                                        $consultants = is_array($sales_consultant) ? $sales_consultant : array($sales_consultant);
                                        
                                        foreach ($consultants as $consultant) :
                                            // Get consultant ID depending on return format
                                            $consultant_id = is_object($consultant) ? $consultant->ID : $consultant;
                                            $consultant_photo = get_field('photo', $consultant_id);
                                        ?>
                                        <div class="col-lg-6 mb-3">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="flex-shrink-0">
                                                    <?php if ($consultant_photo) : 
                                                        $photo_url = isset($consultant_photo['sizes']['thumbnail']) ? $consultant_photo['sizes']['thumbnail'] : $consultant_photo['url'];
                                                    ?>
                                                    <a href="<?php echo esc_url(get_permalink($consultant_id)); ?>">
                                                        <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr(get_the_title($consultant_id)); ?>" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-1">
                                                        <a href="<?php echo esc_url(get_permalink($consultant_id)); ?>" class="text-decoration-none">
                                                            <?php echo esc_html(get_the_title($consultant_id)); ?>
                                                        </a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    // End of the loop
                    endwhile;
                else:
                    // Display message if no posts are found
                    _e('Sorry, no testimonials matched your criteria.', 'textdomain');
                endif;

                // Reset post data
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    .testimonial-gallery img:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    .testimonial-container {
        position: relative;
        padding-top: 80px;
        margin-top: 9rem;
        margin-bottom: 60px;
        text-align: center;
    }

    .testimonial-container .quote-icon {
        position: absolute;
        top: -70px;
        left: 50%;
        transform: translateX(-50%);
        background-color: transparent;
        border-radius: 50%;
        padding: 15px;
        font-size: 3.5rem;
    }

    .testimonial-container .lead {
        font-size: 1.25rem;
        padding: 1rem 0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize lightGallery for each testimonial gallery
    document.querySelectorAll('[id^="testimonial-gallery-"]').forEach(function(container) {
        if (container.children.length > 0) {
            lightGallery(container, {
                thumbnail: true,
                speed: 500,
                preload: 4,
                showCloseIcon: true,
                download: false,
                mode: 'lg-fade',
                plugins: [lgZoom, lgThumbnail, lgAutoplay],
                mobileSettings: {
                    controls: false,
                    showCloseIcon: true,
                    download: false
                }
            });
        }
    });
});
</script>