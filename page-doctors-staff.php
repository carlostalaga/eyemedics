<?php 
/**
* Template Name: Doctors & Staff
*/
get_header(); 
?>
<main id="main-content" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>




        <?php 
        /* Flexible Content */
        include get_theme_file_path('/blocks/flexible-content.php'); 
        ?>


        <div class="container-fluid bg-white py-5 px-0">
            <?php
            // Include the Search & Filter form with the House and Land Packages fields
            include get_theme_file_path('/search-filter/sf-1-doctors-staff.php');
            ?>
        </div>

        <div class="container-fluid">
            <div class="container py-5">
                <?php 
            // Include the Search & Filter form with the House and Land Packages query
            echo do_shortcode('[searchandfilter query="1" action="show-results"]'); 
            ?>
            </div>
        </div>




    </article>


    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>