<!-- new design footer -->

<footer class="container-fluid img-round-footer bg-posidonia p-0">


    <div class="container py-5">

        <div class="row mx-4 d-flex justify-content-center">

            <div class="col-12 col-md-6 mb-5 mb-md-0">
                <a id="navbar-brand" href="<?php echo get_option('siteurl'); ?>" aria-label="Go to homepage">
                    <img src="<?php echo get_template_directory_uri() ?>/img/logo-soundbites-dark.png" class="img-fluid my-3" alt="<?php echo get_bloginfo('name'); ?> logo">
                </a>
            </div>



            <div class="col-12 col-md-6 text-white text-start text-md-end  d-flex justify-content-start justify-content-md-end align-items-end">

                <?php 
                    $cta_button = get_field('cta_button', 'option');
                    if( $cta_button ):
                        $cta_url = $cta_button['url'];
                        $cta_title = $cta_button['title'] ?: 'EMAIL US';
                        $cta_target = $cta_button['target'] ? $cta_button['target'] : '_self';
                ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-sm btn-verde me-5" <?php echo $cta_target !== '_self' ? ' target="' . esc_attr($cta_target) . '" rel="noopener noreferrer"' : ''; ?>>
                    <?php echo esc_html($cta_title); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
                <?php endif; ?>

                <?php /* Social Icons */ ?>
                <div id="social-icons-lightmode">
                    <?php if( get_field('mail', 'option') ): ?>
                    <a href="<?php echo esc_url( 'mailto:' . antispambot( get_field('mail', 'option' ) ) . '?subject=' . rawurlencode( 'Message from ' . get_bloginfo('name') ) ); ?>">
                        <i class="fas fa-envelope ms-2 fs-1 text-white" aria-hidden="true"></i>
                    </a>&nbsp;
                    <?php endif; ?>

                    <?php if( get_field('facebook', 'option') ): ?>
                    <a target="_blank" href="<?php the_field('facebook', 'option'); ?>"><i class="fab fa-facebook-f ms-2 fs-1 text-white" aria-hidden="true"></i></a>&nbsp;
                    <?php endif; ?>

                    <?php if( get_field('twitter', 'option') ): ?>
                    <a target="_blank" href="<?php the_field('twitter', 'option'); ?>"><i class="fab fa-twitter  ms-2 fs-1 text-white" aria-hidden="true"></i></a>&nbsp;
                    <?php endif; ?>

                    <?php if( get_field('tiktok', 'option') ): ?>
                    <a target="_blank" href="<?php the_field('tiktok', 'option'); ?>"><i class="fab fa-tiktok  ms-2 fs-1 text-white" aria-hidden="true"></i></a>&nbsp;
                    <?php endif; ?>

                    <?php if( get_field('instagram', 'option') ): ?>
                    <a target="_blank" href="<?php the_field('instagram', 'option'); ?>"><i class="fab fa-instagram ms-2 fs-1 text-white" aria-hidden="true"></i></a>&nbsp;
                    <?php endif; ?>

                    <?php if( get_field('linkedin', 'option') ): ?>
                    <a target="_blank" href="<?php the_field('linkedin', 'option'); ?>"><i class="fab fa-linkedin-in  ms-2 fs-1 text-white" aria-hidden="true"></i></a>&nbsp;
                    <?php endif; ?>


                </div>
            </div>

        </div>


        <div class="row border-bottom border-top border-white border-1 my-4 mx-4 mx-md-0 pt-5 pb-5">

            <div class="col-12 col-md-6 col-lg-3 mb-5 pt-5 text-white">
                <div class="titles-footer mb-4">
                    Quick Links
                </div>
                <nav aria-label="Footer primary navigation" id="footer-menu" class="col">
                    <?php /* Footer Menu */
                        wp_nav_menu( array(
                            'menu' => 'footer-menu',
                            'theme_location' => 'footer-menu',
                            'fallback_cb'    => false
                        ) );
                    ?>
                </nav>
            </div>

            <div class="col-12 col-md-6 col-lg-3 mb-5 pt-5 text-white">
                <div class="titles-footer mb-4">
                    Contact
                </div>
                <div class="mb-4">
                    <?php 
                        $phone = get_field('phone', 'option');
                        if( $phone ):
                            echo 'Phone: <a href="tel:' . $phone . '" class="text-white">' . $phone . '</a>';
                        endif;
                    ?>
                </div>
                <div class="mb-5">
                    <?php 
                        $mail = get_field('mail', 'option');
                        if( $mail ):
                    ?>
                    <a href="mailto:<?php echo esc_attr($mail); ?>" class="btn btn-sm btn-verde">
                        Email Us <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="titles-footer mb-4">
                    Find Us
                </div>
                <div class="mb-5">
                    <?php 
                        $address = get_field('address', 'option');
                        if( $address ):
                            echo $address;
                        endif;
                    ?>
                </div>
            </div>

            <div class="col-12 col-md-9 col-lg-4 mb-5 pt-5 text-white">
                <div class="mapBlock">
                    <?php $google_map_iframe = get_field('google_map_iframe', 'options'); // Only needed for the conditional check, NOT to display the map. Check functions.php and main.js for the map display.
                    if ($google_map_iframe) :
                    ?>
                    <div id="map-placeholder" class=" text-white">
                        <p>Loading map...</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-md-3 col-lg-2 mb-5 text-white ps-md-5      d-flex d-md-block">
                <div class="mb-4 ps-md-5 pe-5 pe-md-0">
                    <img src="<?php echo get_template_directory_uri() ?>/img/logo-ndis.png" class="img-fluid mb-3 img-rounded logos-footer">
                </div>
                <div class="mb-4 ps-md-5 pe-5 pe-md-0">
                    <img src="<?php echo get_template_directory_uri() ?>/img/logo-cpsp.png" class="img-fluid mb-3 img-rounded logos-footer">
                </div>
            </div>

        </div>


        <!-- <div class="row border-bottom border-white border-1 my-4 mx-4 mx-md-0 pt-3 pb-5 text-small">
            <div class="col-12 text-white">
                <?php 
                    $terms_conditions = get_field('terms_conditions', 'option');
                    if( $terms_conditions ):
                        echo $terms_conditions;
                    endif;
                ?>
            </div>
        </div> -->


        <div class="row row-cols-1 row-cols-md-2 pb-5 text-small">

            <div class="col text-center text-lg-start text-white pb-5">
                &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. All rights reserved.
            </div>

            <div class="col text-center text-lg-end pb-5">
                <a href="https://envyus.com.au" target="_blank" rel="noopener noreferrer" class="text-white">Site by EnvyUs Design</a>
            </div>
        </div>

    </div>




</footer>
<?php wp_footer(); ?>
</body>

</html>