<?php
/*
 ██████  ██████  ███    ██ ████████  █████   ██████ ████████
██      ██    ██ ████   ██    ██    ██   ██ ██         ██
██      ██    ██ ██ ██  ██    ██    ███████ ██         ██
██      ██    ██ ██  ██ ██    ██    ██   ██ ██         ██
 ██████  ██████  ██   ████    ██    ██   ██  ██████    ██


*/

$contact_headline = get_sub_field('contact_headline');
$contact_content = get_sub_field('contact_content');
?>

<div id="contact-<?php echo $iBlock; ?>" class="container-fluid py-5">
    <div class="container bg-negro contact-rounded p-5">
        <div class="row">






            <div class="col-12 col-md-6 pt-5">

                <div class="text-white mb-5">

                    <?php if( $contact_headline ): ?>
                    <div class="text-white mb-5">
                        <h2 class="text-white"><?php echo esc_html($contact_headline); ?></h2>
                    </div>
                    <?php endif; ?>

                    <?php
                    $locations = new WP_Query(array(
                        'post_type'      => 'consulting_location',
                        'posts_per_page' => -1,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                    ));

                    if( $locations->have_posts() ):
                    ?>
                    <p>Eyemedics has a number of locations to make visiting your specialist more convenient.</p>
                    <ul class="ps-3 my-5 location-list">
                        <?php while( $locations->have_posts() ): $locations->the_post(); ?>
                        <?php $location_address = get_field('consulting_location_address'); ?>
                        <li class="mb-2">
                            <strong><?php echo esc_html(get_the_title()); ?></strong><?php if( $location_address ): ?> - <?php echo wp_kses($location_address, array('br' => array())); ?><?php endif; ?>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php
                    wp_reset_postdata();
                    endif;
                    ?>

                    <?php if( $contact_content ): ?>
                    <div>
                        <?php echo $contact_content; ?>
                    </div>
                    <?php endif; ?>

                </div>

            </div>

            <div class="col-12 col-md-6 p-5">
                <h5 class="text-white mb-5">Request an Appointment</h5>
                <?php echo do_shortcode('[contact-form-7 id="21764f5" title="Contact form 1"]'); ?>
            </div>

        </div>
    </div>
</div>