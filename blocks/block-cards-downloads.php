<?php
/*
 ██████  █████  ██████  ██████  ███████
██      ██   ██ ██   ██ ██   ██ ██
██      ███████ ██████  ██   ██ ███████
██      ██   ██ ██   ██ ██   ██      ██
 ██████ ██   ██ ██   ██ ██████  ███████


██████   ██████  ██     ██ ███    ██ ██       ██████   █████  ██████  ███████
██   ██ ██    ██ ██     ██ ████   ██ ██      ██    ██ ██   ██ ██   ██ ██
██   ██ ██    ██ ██  █  ██ ██ ██  ██ ██      ██    ██ ███████ ██   ██ ███████
██   ██ ██    ██ ██ ███ ██ ██  ██ ██ ██      ██    ██ ██   ██ ██   ██      ██
██████   ██████   ███ ███  ██   ████ ███████  ██████  ██   ██ ██████  ███████


*/

$cards_downloads_background = get_sub_field('cards_downloads_background');
$cards_downloads_title = get_sub_field('cards_downloads_title');
$cards_downloads_columns = get_sub_field('cards_downloads_columns');
?>



<div id="cardsBlock-<?php echo $iBlock; ?>" class="container-fluid py-5 px-5 px-md-0 <?php 
    if($cards_downloads_background == 'bg-hueso'): 
        echo 'bg-hueso'; 
    elseif($cards_downloads_background == 'bg-white'): 
        echo 'bg-white'; 
    endif; 
?>">
    <div class="container">

        <?php if($cards_downloads_title): ?>
        <h4 class="text-posidonia pb-5 <?php if($cards_downloads_columns == '1_col'): echo 'mx-lg-5 px-lg-5'; endif; ?>"><?php echo $cards_downloads_title ?> </h3>
            <?php endif; ?>


            <!-- Cards Repeater -->
            <?php
        if( have_rows('cards_downloads_repeater') ): $iCards = 0;
        ?>

            <div class="row row-cols-1 <?php if( $cards_downloads_columns == '2_col' ) : echo 'row-cols-lg-2'; elseif( $cards_downloads_columns == '3_col' ) :  echo 'row-cols-lg-2 row-cols-xl-3'; endif;?> g-5    d-flex justify-content-center">

                <?php
            while ( have_rows('cards_downloads_repeater') ) : the_row();                 
            $cards_downloads_headline = get_sub_field('cards_downloads_headline');
            $cards_downloads_tagline = get_sub_field('cards_downloads_tagline');
            $cards_downloads_content = get_sub_field('cards_downloads_content');                    
            ?>


                <div class="col       wow animate__animated animate__fadeInUp">

                    <div id="grid-block-text-reveal" class="h-100">

                        <div>


                            <div class="p-5 fosforos <?php 
                                if($cards_downloads_background == 'bg-hueso'): 
                                    echo 'bg-white'; 
                                elseif($cards_downloads_background == 'bg-white'): 
                                    echo 'bg-hueso'; 
                                endif; 
                            ?>">
                                <?php if( $cards_downloads_headline): ?>
                                <div class="pb-1">
                                    <span class="text-card-downloads-headline highlight"><?php echo $cards_downloads_headline; ?></span>
                                </div>
                                <?php endif; ?>

                                <?php if( $cards_downloads_tagline ):  ?>
                                <div class="fs-3 saga  pb-2">
                                    <span class="text-card-downloads-tagline"><?php echo $cards_downloads_tagline; ?></span>
                                </div>
                                <?php endif; ?>

                                <?php if( $cards_downloads_content ):  ?>
                                <div class="fs-3 saga mb-3">
                                    <?php echo $cards_downloads_content; ?>
                                </div>
                                <?php endif; ?>


                                <div style="margin-bottom: -1rem;">
                                    <?php
                                    echo display_resources('card_downloads_document_resource_repeater', true, true);
                                ?>
                                </div>


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