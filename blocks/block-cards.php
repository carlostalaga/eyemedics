<?php
/*
 ██████  █████  ██████  ██████  ███████
██      ██   ██ ██   ██ ██   ██ ██
██      ███████ ██████  ██   ██ ███████
██      ██   ██ ██   ██ ██   ██      ██
 ██████ ██   ██ ██   ██ ██████  ███████

*/

$cards_background = get_sub_field('cards_background');
$cards_columns = get_sub_field('cards_columns');
$cards_image_border = get_sub_field('cards_image_border');
?>

<div id="cardsBlock-<?php echo $iBlock; ?>" class="container-fluid py-5 px-5 px-md-0 <?php 
    if($cards_background == 'bg-hueso'): 
        echo 'bg-hueso'; 
    elseif($cards_background == 'bg-cielo'): 
        echo 'bg-cielo'; 
    elseif($cards_background == 'bg-white'): 
        echo 'bg-white'; 
    endif; 
?>">

    <div class="container py-5 ">


        <!-- Cards Repeater -->
        <?php
        if( have_rows('cards_repeater') ): $iCards = 0;  
        ?>

        <div class="row row-cols-md-2 
        <?php 
        if( $cards_columns == '2_col' ) : 
            echo ''; 
        elseif( $cards_columns == '3_col' ) :  
            echo 'row-cols-lg-3'; 
        elseif( $cards_columns == '4_col' ) :  
        echo 'row-cols-lg-4'; 
        elseif( $cards_columns == '5_col' ) :  
            echo 'row-cols-lg-4 row-cols-lg-5'; 
        elseif( $cards_columns == '6_col' ) :  
            echo 'row-cols-lg-4 row-cols-xl-6'; endif;
        ?> g-5 d-flex justify-content-center">

            <?php
            while ( have_rows('cards_repeater') ) : the_row();                 
            $cards_image = get_sub_field('cards_image');
            if($cards_image):
            $cards_image_url = $cards_image['sizes']['4-3r576'];
            $cards_image_url_43 = $cards_image['sizes']['4-3r576'];
            endif;

            $cards_headline = get_sub_field('cards_headline');
            $cards_tagline = get_sub_field('cards_tagline');
            $cards_content = get_sub_field('cards_content');                    
            
            $cards_link = get_sub_field('cards_link');
            if( $cards_link ) : 
                $cards_link_url = $cards_link['url'];
                $cards_link_title = $cards_link['title'];
                $cards_link_target = $cards_link['target'] ? $cards_link['target'] : '_self';
            endif;                    
            ?>


            <div class="col       wow animate__animated animate__fadeInUp">

                <div>

                    <div class="border border-light shadow-lg cards-shape-top bg-white">


                        <div class="<?php if( $cards_image_border ) : echo 'p-5'; else: echo 'p-0'; endif; ?>">
                            <?php if( $cards_columns == '2_col' ) : ?>
                            <img src="<?php echo $cards_image_url; ?>" class="img-cards img-fluid">
                            <?php elseif( $cards_columns == '3_col' ) : ?>
                            <img src="<?php echo $cards_image_url; ?>" class="img-cards img-fluid">
                            <?php elseif( $cards_columns == '4_col' ) : ?>
                            <img src="<?php echo $cards_image_url; ?>" class="img-cards img-fluid">
                            <?php elseif( $cards_columns == '5_col' ) : ?>
                            <img src="<?php echo $cards_image_url; ?>" class="img-cards img-fluid">
                            <?php elseif( $cards_columns == '6_col' ) : ?>
                            <img src="<?php echo $cards_image_url; ?>" class="img-cards img-fluid">
                            <?php endif; ?>
                        </div>


                        <div class="pb-5 px-5 bg-white text-center cards-shape-bottom">

                            <div class="fosforos pb-5 <?php if( ! $cards_image_border ) : echo 'pt-5'; endif; ?>">
                                <?php if( $cards_headline ):  ?>
                                <div class="mb-5">
                                    <?php if( $cards_columns == '2_col' ) : ?>
                                    <h6 class="text-posidonia highlight"><?php echo $cards_headline; ?></h6>
                                    <?php elseif( $cards_columns == '3_col' ) : ?>
                                    <h6 class="text-posidonia highlight"><?php echo $cards_headline; ?></h6>
                                    <?php elseif( $cards_columns == '4_col' ) : ?>
                                    <h6 class="text-posidonia highlight"><?php echo $cards_headline; ?></h6>
                                    <?php elseif( $cards_columns == '5_col' ) : ?>
                                    <h6 class="text-posidonia highlight"><?php echo $cards_headline; ?></h6>
                                    <?php elseif( $cards_columns == '6_col' ) : ?>
                                    <h6 class="text-posidonia highlight"><?php echo $cards_headline; ?></h6>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php if( $cards_tagline ):  ?>
                                <div class="text-posidonia mb-3">
                                    <?php echo $cards_tagline; ?>
                                </div>
                                <?php endif; ?>

                                <?php if( $cards_content ):  ?>
                                <div class="text-cards-content mb-3">
                                    <?php echo $cards_content; ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <?php if( $cards_link): ?>
                            <div class="text-center">
                                <a href="<?php echo esc_url( $cards_link_url ); ?>" class="btn btn-sm btn-aguamarina" target="<?php echo esc_attr( $cards_link_target ); ?>">LEARN&nbsp;MORE <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>

            </div>



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