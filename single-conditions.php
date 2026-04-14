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
                    <div class="col-lg-3 mb-4 mb-lg-0">
                        <?php $conditions_current_id = get_the_ID(); ?>
                        <nav class="conditions-sidebar" aria-label="Conditions">
                            <h6 class="conditions-sidebar__heading">Conditions</h6>
                            <?php
                            $conditions_sidebar = new WP_Query(array(
                                'post_type'      => 'conditions',
                                'posts_per_page' => -1,
                                'orderby'        => 'title',
                                'order'          => 'ASC',
                            ));
                            if ($conditions_sidebar->have_posts()):
                            ?>
                            <ul class="conditions-sidebar__list">
                                <?php while ($conditions_sidebar->have_posts()): $conditions_sidebar->the_post(); ?>
                                <li class="conditions-sidebar__item<?php if (get_the_ID() === $conditions_current_id): ?> conditions-sidebar__item--active<?php endif; ?>">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php
                            wp_reset_postdata();
                            endif;
                            ?>
                        </nav>
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



        <h1><?php the_title(); ?></h1>


    </article>


    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>