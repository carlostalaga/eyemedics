<?php get_header(); ?>
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
                    <div class="col-3">
                        <h6>[MENU CONDITIONS HERE]</h6>
                    </div>
                    <div class="col-9">
                        <?php 
                        /* Flexible Content */
                        include get_theme_file_path('/blocks/flexible-content.php'); 
                        ?>
                    </div>
                </div>

            </div>
        </div>



        <h1><?php the_title(); ?></h1>


    </article>


    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>