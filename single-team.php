<?php get_header(); ?>
<main id="main-content" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>




        <div class="container-fluid bg-hueso" style="padding: 120px 0 120px 0;">


            <div class="container mb-5">
                <div>
                    <a href="<?php echo esc_url(home_url('/team/')); ?>" class="btn btn-sm btn-verde">OUR TEAM <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>


            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-xl-12">
                        <div class="row">
                            <div class="col-12 col-md-4 pe-md-5">
                                <?php $team_image = get_field('team_image'); if ($team_image): ?>
                                <?php // ACF image field using '3-4r576' size. esc_url() sanitises the URL to prevent XSS attacks ?>
                                <img src="<?php echo esc_url($team_image['sizes']['3-4r576']); ?>" alt="<?php the_title(); ?>" class="img-fluid img-rounded-max">
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="mb-4">
                                    <h6><?php the_title(); ?></h6>
                                </div>
                                <div class="text-posidonia mb-4">
                                    <?php the_field('role'); ?>
                                </div>

                                <div class="mb-5">
                                    <!--     <?php 
                                $email = get_field('email');
                                if( $email ):
                                ?>
                                    <a href="mailto:<?php echo esc_attr($email); ?>" class="btn btn-sm btn-verde">
                                        Email Us <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    </a> -->


                                    <a href="contact" class="btn btn-sm btn-verde">
                                        Contact Us <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <p><?php the_field('team_content'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </article>


    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>