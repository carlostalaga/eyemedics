<?php
/*
 ██████  █████  ██████  ██████  ███████     ██    ██     ██  ██████  ██████  ███    ██
██      ██   ██ ██   ██ ██   ██ ██          ██    ██     ██ ██      ██    ██ ████   ██
██      ███████ ██████  ██   ██ ███████     ██    ██     ██ ██      ██    ██ ██ ██  ██
██      ██   ██ ██   ██ ██   ██      ██      ██  ██      ██ ██      ██    ██ ██  ██ ██
 ██████ ██   ██ ██   ██ ██████  ███████       ████       ██  ██████  ██████  ██   ████


*/

$cards_v_icon_background = get_sub_field('cards_v_icon_background');
?>



<div id="cardsVIconBlock-<?php echo $iBlock; ?>" class="container-fluid  py-5 px-5 px-md-0  <?php 
    if($cards_v_icon_background == 'bg-hueso'): 
        echo 'bg-hueso'; 
    elseif($cards_v_icon_background == 'bg-white'): 
        echo 'bg-white'; 
    endif; 
?>">
    <div class="container">


        <!-- Cards Repeater -->
        <?php
        if( have_rows('cards_v_icon_repeater') ): $iCards = 0;  
        ?>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-5  px-5 px-lg-0    d-flex justify-content-center">

            <?php
            while ( have_rows('cards_v_icon_repeater') ) : the_row();                 
            $cards_v_icon_icon = get_sub_field('cards_v_icon_icon');
            if($cards_v_icon_icon):
                $cards_v_icon_icon_url = $cards_v_icon_icon['sizes']['576sm'];
                $cards_v_icon_icon_alt = $cards_v_icon_icon['alt'];
            endif;

            $cards_v_icon_headline = get_sub_field('cards_v_icon_headline');
            $cards_v_icon_tagline = get_sub_field('cards_v_icon_tagline');
            $cards_v_icon_content = get_sub_field('cards_v_icon_content');                    
            
            $cards_v_icon_link = get_sub_field('cards_v_icon_link');
            if( $cards_v_icon_link ) : 
                $cards_v_icon_link_url = $cards_v_icon_link['url'];
                $cards_v_icon_link_title = $cards_v_icon_link['title'];
                $cards_v_icon_link_target = $cards_v_icon_link['target'] ? $cards_v_icon_link['target'] : '_self';
            endif;                    
            ?>


            <div class="col card-fx-container           wow animate__animated animate__fadeInUp">

                <div class="card-fx mb-5 mb-md-2 bg-posidonia" id="grid-block-text-reveal" class="h-100" <?php if ($cards_v_icon_link) echo 'style="cursor:pointer;"'; ?>>
                    <?php if( $cards_v_icon_link): ?>
                    <a href="<?php echo esc_url( $cards_v_icon_link_url ); ?>" target="<?php echo esc_attr( $cards_v_icon_link_target ); ?>">
                        <?php endif; ?>

                        <div class="px-0 px-md-5">
                            <div class="bg-posidonia  p-5  text-center">
                                <img src="<?php echo $cards_v_icon_icon_url; ?>" class="card-icon">
                            </div>
                        </div>

                        <div class="pb-5 px-5 bg-posidonia fosforos">

                            <div class="text-center">
                                <?php if($cards_v_icon_headline): ?>
                                <div>
                                    <h5 class="text-white highlight"><?php echo $cards_v_icon_headline; ?></h5>
                                </div>
                                <?php endif; ?>
                                <?php if($cards_v_icon_tagline): ?>
                                <div class="text-white highlight">
                                    <?php echo $cards_v_icon_tagline; ?>
                                </div>
                                <?php endif; ?>
                                <?php if($cards_v_icon_content): ?>
                                <div class="text-cards-content text-white highlight">
                                    <?php echo $cards_v_icon_content; ?>
                                </div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <?php if( $cards_v_icon_link): ?>
                    </a>
                    <?php endif; ?>
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