<?php
/*
███████  ██████  ██████  ███    ███
██      ██    ██ ██   ██ ████  ████
█████   ██    ██ ██████  ██ ████ ██
██      ██    ██ ██   ██ ██  ██  ██
██       ██████  ██   ██ ██      ██


*/
$form_background = get_sub_field('form_background');
if($form_background == 'bg-cielo'):
    $form_background_class = 'bg-cielo';
endif;
if($form_background == 'bg-hueso'):
    $form_background_class = 'bg-hueso';
endif;
if($form_background == 'bg-white'):
    $form_background_class = 'bg-white';
endif;

$form_headline = get_sub_field('form_headline');
$form_shortcode = get_sub_field('form_shortcode');
?>

<div id="contact-<?php echo $iBlock; ?>" class="container-fluid py-5 <?php echo esc_attr($form_background); ?>">
    <div class="container bg-white img-contact p-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10 pt-5">


                <?php if( $form_headline ): ?>
                <div class="mb-5">
                    <h6><?php echo esc_html($form_headline); ?></h6>
                </div>
                <?php endif; ?>

                <div>
                    <?php echo do_shortcode($form_shortcode); ?>
                </div>


            </div>
        </div>
    </div>
</div>