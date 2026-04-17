<?php 
/**
* Template Name: Surgical Services
*/
get_header(); 
?>
<main id="main-content" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


        <?php 
        /* Content Intro */
        include get_theme_file_path('/inc/content-intro.php'); 
        ?>

        <div class="container-fluid">
            <div class="container">

                <div class="row">
                    <div class="col-lg-3 mb-4 mb-lg-0">


                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'surgical-services-menu',
                            'container'      => 'nav',
                            'menu_class'     => 'sidebar-menu',
                        ));
                        ?>


                    </div>
                    <div class="col-lg-9">
                        <?php 
                        /* Flexible Content */
                        include get_theme_file_path('/blocks/flexible-content.php'); 
                        ?>
                    </div>
                </div>

            </div>
        </div>





    </article>


    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>