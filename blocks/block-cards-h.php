<?php 
/*
 ██████  █████  ██████  ██████  ███████     ██   ██
██      ██   ██ ██   ██ ██   ██ ██          ██   ██
██      ███████ ██████  ██   ██ ███████     ███████
██      ██   ██ ██   ██ ██   ██      ██     ██   ██
 ██████ ██   ██ ██   ██ ██████  ███████     ██   ██


*/

$cards_h_background = get_sub_field('cards_h_background');
$cards_h_columns = get_sub_field('cards_h_columns');
?>

<div id="cardsHBlock-<?php echo $iBlock; ?>" class="container-fluid py-5 px-5 px-md-0 <?php 
    if($cards_h_background == 'bg-posidonia'): 
        echo 'bg-posidonia'; 
    elseif($cards_h_background == 'bg-hueso'): 
        echo 'bg-hueso';
    endif; 
?>">

    <div class="container">

        <!-- Cards Repeater -->
        <?php
        if( have_rows('cards_h_repeater') ): $iCards = 0;    
        ?>
        <div class="row <?php if( $cards_h_columns == '1_col' ) : echo 'row-cols-1'; elseif( $cards_h_columns == '2_col' ) :  echo 'row-cols-1 row-cols-lg-2'; endif; ?> g-5 d-flex justify-content-center">
            <!-- new row-cols-2  or if() -->
            <?php
            while ( have_rows('cards_h_repeater') ) : the_row();
            $cards_h_colour = get_sub_field('cards_h_colour');
            if ($cards_h_colour):
                $bg_color = '#7e7e81'; // default color
                $color_value = $cards_h_colour['value']; // Use the hex color directly from the value part of the ACF array
                switch($color_value) {
                    case '#262661':
                        $bg_color = '#262661';
                        break;
                    case '#1a416f':
                        $bg_color = '#1a416f';
                        break;
                    case '#3d5c92':
                        $bg_color = '#3d5c92';
                        break;
                    case '#00664a':
                        $bg_color = '#00664a';
                        break;
                    case '#008f88':
                        $bg_color = '#008f88';
                        break;
                    case '#db2b27':
                        $bg_color = '#db2b27';
                        break;
                }
            endif;

            $cards_h_image = get_sub_field('cards_h_image');
            if($cards_h_image):
                $cards_h_image_url = $cards_h_image['sizes']['576sm'];
            endif;

            $cards_h_headline = get_sub_field('cards_h_headline');
            $cards_h_tagline = get_sub_field('cards_h_tagline');
            $cards_h_content = get_sub_field('cards_h_content');                    
            
            $cards_h_type_of_link = get_sub_field('cards_h_type_of_link');
            
            $cards_h_button_title = get_sub_field('cards_h_button_title');
            $cards_h_extended_content = get_sub_field('cards_h_extended_content');

            $cards_h_link = get_sub_field('cards_h_link');
            if( $cards_h_link ) : 
                $cards_h_link_url = $cards_h_link['url'];
                $cards_h_link_title = $cards_h_link['title'];
                $cards_h_link_target = $cards_h_link['target'] ? $cards_h_link['target'] : '_self';
            endif;

            ?>


            <div class="col-12 <?php if( $cards_h_columns == '1_col' ) : echo 'col-lg-9 col-xl-8'; elseif( $cards_h_columns == '2_col' ) :  echo ' /*  */ '; endif; ?> wow animate__animated animate__fadeInUp">
                <div class="container round-up round-down" class="h-100" <?php if ($cards_h_link) echo 'style="cursor:pointer;"'; ?>>
                    <div class="row g-0">

                        <?php /* ------------------------------ icon ----------------------------- */ ?>
                        <div class="<?php if( $cards_h_columns == '1_col' ) : echo ' col-12 col-sm-4 col-lg-3 '; elseif( $cards_h_columns == '2_col' ) :  echo ' col-12 col-sm-4 col-lg-5 col-xl-4 '; endif; ?> bg-white round-cards-h-icon d-flex align-items-center" style="position: relative;">
                            <div class="p-5 bg-white round-cards-h-icon" style="margin: 0 auto;">
                                <img src="<?php echo $cards_h_image_url; ?>" class="img-fluid card-h-icon">
                            </div>


                            <div class="arrow-icon" data-bgcolor="<?php echo htmlspecialchars($bg_color, ENT_QUOTES, 'UTF-8'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52.416 29.005">
                                    <polygon fill="<?php echo htmlspecialchars($bg_color, ENT_QUOTES, 'UTF-8'); ?>" points="0 29.005 52.416 29.005 26.208 0 0 29.005" />
                                </svg>
                            </div>

                            <style>

</style>

                        </div>

                        <?php /* ------------------------------ content ----------------------------- */ ?>
                        <div class="<?php if( $cards_h_columns == '1_col' ) : echo ' col-12 col-sm-8 col-lg-9 '; elseif( $cards_h_columns == '2_col' ) :  echo ' col-12 col-sm-8  col-lg-7 col-xl-8 '; endif; ?> p-5 round-cards-h-content fosforos" style="background-color: <?php echo $bg_color ?>;">
                            <div class="text-center text-start">
                                <?php if($cards_h_headline): ?>
                                <div class="text-white highlight text-uppercase">
                                    <h3><?php echo $cards_h_headline; ?></h3>
                                </div>
                                <?php endif; ?>
                                <?php if($cards_h_tagline): ?>
                                <div class="text-white highlight">
                                    <h6><?php echo $cards_h_tagline; ?></h6>
                                </div>
                                <?php endif; ?>
                                <?php if($cards_h_content): ?>
                                <div class="text-white highlight mb-3">
                                    <?php echo $cards_h_content; ?>
                                </div>
                                <?php endif; ?>

                                <?php if($cards_h_type_of_link == 'modal'): ?>
                                <div>
                                    <button id="popup-<?php echo $iCards; ?>-<?php echo $iBlock; ?>" type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#cardsH-Modal-<?php echo $iCards; ?>-<?php echo $iBlock; ?>"><?php if($cards_h_button_title): echo $cards_h_button_title; else: echo 'Learn More'; endif; ?></button>
                                </div>
                                <?php endif; ?>

                                <?php if($cards_h_type_of_link == 'standard' && $cards_h_link): ?>
                                <div>
                                    <a class="btn btn-outline-light" href="<?php echo $cards_h_link_url ?>" target="<?php echo $cards_h_link_target ?>" title="<?php echo $cards_h_link_title ?>"><?php echo $cards_h_link_title ?></a>
                                </div>
                                <?php endif; ?>



                                <!-- CARD Accordion Repeater -->
                                <?php
                                // check if the repeater field has rows of data
                                if( have_rows('card_accordion') ): $iCardAccordion = 0; // Set the increment variable
                                ?>

                                <div class="accordion pt-5" id="cardAccordion-<?php echo $iBlock; ?>-<?php echo $iCards; ?>">

                                    <?php
                                    // Initialize $cardCollapse before using it
                                    $cardCollapse = 0;
                                    while ( have_rows('card_accordion') ) : the_row(); $cardCollapse++;
                                    $card_accordion_headline = get_sub_field('card_accordion_headline');
                                    $card_accordion_body = get_sub_field('card_accordion_body');
                                    ?>

                                    <div class="accordion-item mb-3 border-0">
                                        <div class="accordion-header" id="heading-<?php echo $iBlock; ?>-<?php echo $iCards; ?>-<?php echo $cardCollapse; ?>">
                                            <button class="accordion-button" style="background-color: <?php echo $bg_color ?>; border: 1px solid #fff !important;" type="button" data-bs-toggle="collapse" data-bs-target="#cardcollapse-<?php echo $iBlock; ?>-<?php echo $iCards; ?>-<?php echo $cardCollapse; ?>" aria-expanded="true" aria-controls="cardcollapse-<?php echo $iBlock; ?>-<?php echo $iCards; ?>-<?php echo $cardCollapse; ?>">
                                                <div class="accordion-title epic fs-2 text-left text-white text-uppercase py-1 px-4">
                                                    <?php echo $card_accordion_headline; ?>
                                                    <i class="plusMinus plusMinusCard" aria-hidden="true"></i>
                                                </div>
                                            </button>
                                        </div>

                                        <div id="cardcollapse-<?php echo $iBlock; ?>-<?php echo $iCards; ?>-<?php echo $cardCollapse; ?>" class="accordion-collapse collapse" style="background-color: <?php echo $bg_color ?>; border: 0px solid #fff !important;" data-bs-parent="#cardAccordion-<?php echo $iBlock; ?>-<?php echo $iCards; ?>">
                                            <div class="row pt-5 text-start">
                                                <div class="col-12 prose px-5 text-white">
                                                    <?php echo $card_accordion_body; ?>
                                                </div>
                                            </div><!-- end accordion body -->
                                        </div><!-- end collapse -->
                                    </div><!-- end item -->

                                    <?php
                                    $iCardAccordion++; // Increment the increment variable
                                    endwhile; //End the loop
                                    ?>

                                </div><!-- end accordion -->


                                <?php
                                else :
                                // no rows found
                                endif;
                                ?>
                                <!-- //end CARD Accordion Repeater -->



                            </div>

                        </div>

                    </div>
                </div>
            </div>




            <?php /* ----------------------------- modal structure ---------------------------- */ ?>
            <div class="modal fade" id="cardsH-Modal-<?php echo $iCards; ?>-<?php echo $iBlock; ?>" tabindex="-1" aria-labelledby="cardsH-ModalLabel-<?php echo $iCards; ?>-<?php echo $iBlock; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-5">
                            <?php echo $cards_h_extended_content; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //end Modal Structure -->

            <?php $iCards++; 
            endwhile; 
            ?>
        </div>
        <?php
        else :
        echo 'Carpe diem';
        endif;
        ?>
        <!-- //end Cards Repeater -->
    </div>
</div>