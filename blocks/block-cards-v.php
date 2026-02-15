<?php
/*

 ██████  █████  ██████  ██████  ███████         ██    ██
██      ██   ██ ██   ██ ██   ██ ██              ██    ██
██      ███████ ██████  ██   ██ ███████         ██    ██
██      ██   ██ ██   ██ ██   ██      ██          ██  ██
 ██████ ██   ██ ██   ██ ██████  ███████ ███████   ████

*/

$cards_v_background = get_sub_field('cards_v_background');
if($cards_v_background == 'bg-cielo'):
    $cards_v_background_class = 'bg-cielo';
endif;
if($cards_v_background == 'bg-hueso'):
    $cards_v_background_class = 'bg-hueso';
endif;
if($cards_v_background == 'bg-white'):
    $cards_v_background_class = 'bg-white';
endif;
?>

<!-- Card FX styles moved to style.scss -->

<div id="cardsVBlock-<?php echo $iBlock; ?>" class="container-fluid  py-5 px-5 px-md-0  <?php echo $cards_v_background_class; ?>">
    <div class="container">


        <!-- Cards Repeater -->
        <?php
        if( have_rows('cards_v_repeater') ): $iCards = 0;  
        ?>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-5 d-flex justify-content-center cards-v-staggered">

            <?php
            while ( have_rows('cards_v_repeater') ) : the_row();                 
            $cards_v_image = get_sub_field('cards_v_image');
            if($cards_v_image):
            $cards_v_image_url = $cards_v_image['sizes']['25-41r576'];
            $cards_v_image_url_small = $cards_v_image['sizes']['25-41r576'];
            endif;

            $cards_v_headline = get_sub_field('cards_v_headline');
            $cards_v_tagline = get_sub_field('cards_v_tagline');
            $cards_v_content = get_sub_field('cards_v_content');                    
            
            $cards_v_link = get_sub_field('cards_v_link');
            if( $cards_v_link ) : 
                $cards_v_link_url = $cards_v_link['url'];
                $cards_v_link_title = $cards_v_link['title'];
                $cards_v_link_target = $cards_v_link['target'] ? $cards_v_link['target'] : '_self';
            endif;                    
            ?>


            <div class="col wow animate__animated animate__fadeInUp">

                <!-- cards-v-card-wrapper: enables GSAP hover effect on image -->
                <div class="service-card-wrapper">

                    <!-- cards-v-card-body: card container with hover lift effect -->
                    <div class="service-card-body mb-5 mb-md-2" <?php if ($cards_v_link) echo 'style="cursor:pointer;"'; ?>>

                        <?php if( $cards_v_link): ?>
                        <a href="<?php echo esc_url( $cards_v_link_url ); ?>" target="<?php echo esc_attr( $cards_v_link_target ); ?>">
                            <?php endif; ?>

                            <!-- cards-v-image-container: wraps the image for hover animation -->
                            <div class="cards-v-image-container">
                                <img src="<?php echo $cards_v_image_url; ?>" data-default="<?php echo $cards_v_image_url; ?>" data-small="<?php echo $cards_v_image_url_small; ?>" class="img-fluid img-v-cards">
                            </div>

                            <div class="py-4 px-5 bg-posidonia img-v-cards-base fosforos">
                                <div class="text-center">
                                    <?php if($cards_v_headline): ?>
                                    <div>
                                        <h6 class="text-white"><?php echo $cards_v_headline; ?></h6>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($cards_v_tagline): ?>
                                    <div>
                                        <strong class="text-white"><?php echo $cards_v_tagline; ?>jhkjh</strong>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($cards_v_content): ?>
                                    <div class="text-white">
                                        <?php echo $cards_v_content; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if( $cards_v_link): ?>
                        </a>
                        <?php endif; ?>

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



<!-- Script to update image sources based on screen width -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update image sources based on screen width
    function updateImageSources() {
        const images = document.querySelectorAll('img[data-default][data-small]');
        images.forEach(img => {
            if (window.innerWidth <= 767) {
                img.src = img.getAttribute('data-small');
            } else {
                img.src = img.getAttribute('data-default');
            }
        });
    }

    // Initial update
    updateImageSources();

    // Update on window resize
    window.addEventListener('resize', updateImageSources);

    // Cards V hover effect - animates the whole card together
    if (typeof gsap !== 'undefined') {
        const cardsVBlock = document.getElementById('cardsVBlock-<?php echo $iBlock; ?>');
        if (cardsVBlock) {
            const cardWrappers = cardsVBlock.querySelectorAll('.service-card-wrapper');

            cardWrappers.forEach(wrapper => {
                const cardBody = wrapper.querySelector('.service-card-body');
                const image = wrapper.querySelector('.img-v-cards');
                if (!cardBody) return;

                const hoverTl = gsap.timeline({
                    paused: true
                });

                // Animate the whole card: lift and scale
                hoverTl.to(cardBody, {
                    duration: 0.4,
                    y: -8,
                    scale: 1.02,
                    ease: "power2.out"
                });

                // Animate image brightness on hover
                if (image) {
                    hoverTl.to(image, {
                        duration: 0.4,
                        filter: "brightness(1.15)",
                        ease: "power2.out"
                    }, 0); // Start at the same time as the card animation
                }

                wrapper.addEventListener('mouseenter', () => hoverTl.play());
                wrapper.addEventListener('mouseleave', () => hoverTl.reverse());
            });
        }
    }
});
</script>