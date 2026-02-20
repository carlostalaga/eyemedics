<?php 
/*
 █████   ██████  ██████  ██████  ██████  ██████  ██  ██████  ███    ██
██   ██ ██      ██      ██    ██ ██   ██ ██   ██ ██ ██    ██ ████   ██
███████ ██      ██      ██    ██ ██████  ██   ██ ██ ██    ██ ██ ██  ██
██   ██ ██      ██      ██    ██ ██   ██ ██   ██ ██ ██    ██ ██  ██ ██
██   ██  ██████  ██████  ██████  ██   ██ ██████  ██  ██████  ██   ████


*/
$accordion_anchor = get_sub_field('accordion_anchor');
$accordion_headline = get_sub_field('accordion_headline');
$accordion_intro = get_sub_field('accordion_intro');
$accordion_background = get_sub_field('accordion_background');
$accordion_background_class = '';
if($accordion_background == 'bg-verde'):
    $accordion_background_class = 'bg-verde';
elseif($accordion_background == 'bg-verde-light'):
    $accordion_background_class = 'bg-verde-light';
elseif($accordion_background == 'bg-humo'):
    $accordion_background_class = 'bg-humo';
elseif($accordion_background == 'bg-white'):
    $accordion_background_class = 'bg-white';
endif;
$accordion_use_light_buttons = in_array($accordion_background, array('bg-verde', 'bg-verde-light'), true);
?>
<div id="<?php echo $accordion_anchor; ?>">
    <div id="accordionBlock-<?php echo $iBlock; ?>" class="container-fluid py-5 <?php echo $accordion_background_class; ?>">
        <div class="container">



            <div class="row  d-flex justify-content-center">


                <div class="col-12 <?php if (!(get_post_type() == 'projects')) { echo 'col-xl-10'; } ?>">

                    <div class="mb-4">
                        <h2><?php echo $accordion_headline; ?></h2>
                        <?php echo $accordion_intro; ?>
                    </div>

                    <!-- Accordion Repeater -->

                    <?php
                // check if the repeater field has rows of data
                if( have_rows('accordion_repeater') ): $iAccordion = 0; // Set the increment variable
                ?>

                    <div class="accordion" id="accordionMain-<?php echo $iBlock; ?>">

                        <?php // loop through the rows of data for the tab header
                    // Initialize $collapse before using it
                    $collapse = 0;
                    while ( have_rows('accordion_repeater') ) : the_row(); $collapse++;
                    $accordion_headline = get_sub_field('accordion_headline');
                    $accordion_body = get_sub_field('accordion_body');
                    $accordion_image = get_sub_field('accordion_image');
                    if($accordion_image):
                        $accordion_image_url = $accordion_image['sizes']['576sm'];
                    endif;
                    $accordion_resource_repeater = get_sub_field('accordion_resource_repeater');
                    ?>

                        <div class="accordion-item mb-5 border-0">

                            <div class="accordion-header <?php echo $accordion_background_class; ?>" id="heading-<?php echo $iBlock; ?>-<?php echo $collapse; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $iBlock; ?>-<?php echo $collapse; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $iBlock; ?>-<?php echo $collapse; ?>">
                                    <div class="accordion-title text-left  py-1 px-4">
                                        <?php echo $accordion_headline; ?>
                                        <i class="plusMinus" aria-hidden="true"></i>
                                    </div>
                                </button>
                            </div>

                            <div id="collapse-<?php echo $iBlock; ?>-<?php echo $collapse;?>" class="accordion-collapse collapse text-tinta py-5 <?php echo $accordion_background_class; ?> p-5 py-3" data-bs-parent="#accordionMain-<?php echo $iBlock; ?>">

                                <div class="row text-start">


                                    <?php if( $accordion_image ): ?>
                                    <div class="col-12 col-md-4 mb-5">
                                        <img src="<?php echo $accordion_image_url; ?>" alt="<?php echo $accordion_image['alt']; ?>" class="img-fluid" />
                                    </div>
                                    <?php endif ?>



                                    <div class="contentBox <?php if( $accordion_image ):  echo'col-12 col-md-8';  else: echo'col-12'; endif; ?> prose">
                                        <?php echo $accordion_body; ?>
                                    </div>


                                    <!-- Resources -->
                                    <?php if($accordion_resource_repeater): ?>
                                    <div class="col-12 mt-5">
                                        <?php display_resources('accordion_resource_repeater', false, false, $accordion_use_light_buttons); ?>
                                    </div>
                                    <?php endif; ?>


                                </div><!-- end accordion body -->

                            </div><!-- end collapse -->

                        </div><!-- end item -->


                        <?php $iAccordion++;  // Increment the increment variable

                    endwhile;//End the loop
                    ?>

                    </div><!-- end accordion -->



                    <?php
                else :
                // no rows found
                endif;
                ?>

                    <!-- //end Accordion Repeater -->
                </div>


            </div>
        </div>
    </div>