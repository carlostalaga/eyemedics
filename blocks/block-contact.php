<?php
/*
 ██████  ██████  ███    ██ ████████  █████   ██████ ████████
██      ██    ██ ████   ██    ██    ██   ██ ██         ██
██      ██    ██ ██ ██  ██    ██    ███████ ██         ██
██      ██    ██ ██  ██ ██    ██    ██   ██ ██         ██
 ██████  ██████  ██   ████    ██    ██   ██  ██████    ██


*/

$contact_background = get_sub_field('contact_background');
$contact_headline = get_sub_field('contact_headline');
$contact_cta_link = get_sub_field('contact_cta_link');
if($contact_background == 'bg-cielo'):
    $contact_background_class = 'bg-cielo';
endif;
if($contact_background == 'bg-hueso'):
    $contact_background_class = 'bg-hueso';
endif;
if($contact_background == 'bg-white'):
    $contact_background_class = 'bg-white';
endif;
?>

<div id="contact-<?php echo $iBlock; ?>" class="container-fluid py-5 <?php echo esc_attr($contact_background); ?>">
    <div class="container bg-white img-contact p-5">
        <div class="row">
            <div class="col-12 col-md-6 pt-5">


                <?php if( $contact_headline ): ?>
                <div class="mb-5">
                    <h6><?php echo esc_html($contact_headline); ?></h6>
                </div>
                <?php endif; ?>

                <div class="mb-5">
                    <?php 
                        $address = get_field('address', 'option');
                        if( $address ):
                            echo $address;
                        endif;
                    ?>
                </div>

                <div class="mb-5">
                    <?php 
                        $phone = get_field('phone', 'option');
                        if( $phone ):
                            echo '<strong>Phone:</strong> <a href="tel:' . $phone . '" class="">' . $phone . '</a>';
                        endif;
                    ?>
                </div>

                <div class="mb-5 d-xl-flex">
                    <div class="me-5 mb-5">
                        <?php 
                        $mail = get_field('mail', 'option');
                        if( $mail ):
                    ?>
                        <a href="mailto:<?php echo esc_attr($mail); ?>" class="btn btn-sm btn-verde">
                            Email Us <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php if( $contact_cta_link ): ?>
                    <div class="mb-5">
                        <a href="<?php echo esc_url($contact_cta_link['url']); ?>" class="btn btn-sm btn-verde" <?php echo $contact_cta_link['target'] ? ' target="' . esc_attr($contact_cta_link['target']) . '"' : ''; ?>>
                            <?php echo esc_html($contact_cta_link['title']); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>


            </div>
            <div class="col-12 col-md-6 p-5">


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
        </div>
    </div>
</div>