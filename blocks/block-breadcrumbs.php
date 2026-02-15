<?php
/*
██████  ██████  ███████  █████  ██████   ██████ ██████  ██    ██ ███    ███ ██████  ███████
██   ██ ██   ██ ██      ██   ██ ██   ██ ██      ██   ██ ██    ██ ████  ████ ██   ██ ██
██████  ██████  █████   ███████ ██   ██ ██      ██████  ██    ██ ██ ████ ██ ██████  ███████
██   ██ ██   ██ ██      ██   ██ ██   ██ ██      ██   ██ ██    ██ ██  ██  ██ ██   ██      ██
██████  ██   ██ ███████ ██   ██ ██████   ██████ ██   ██  ██████  ██      ██ ██████  ███████


*/

$breadcrumbs_background = get_sub_field('breadcrumbs_background');
if($breadcrumbs_background == 'bg-cielo'):
    $breadcrumbs_background_class = 'bg-cielo';
endif;
if($breadcrumbs_background == 'bg-hueso'):
    $breadcrumbs_background_class = 'bg-hueso';
endif;
if($breadcrumbs_background == 'bg-white'):
    $breadcrumbs_background_class = 'bg-white';
endif;
?>


<div id="breadcrumbs-<?php echo $iBlock; ?>" class="container-fluid border border-0 border-danger  
<?php echo $breadcrumbs_background_class; ?>">

    <div class="container">


        <div>
            <?php 
            $current_post_type = get_post_type();
            
            // Services post type - check segment taxonomy
            if ($current_post_type === 'services') :
                if (has_term('children', 'segment')) : ?>
            <a href="<?php echo esc_url(home_url('/children/')); ?>" class="btn btn-sm btn-aguamarina">FOR CHILDREN <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <?php elseif (has_term('adults', 'segment')) : ?>
            <a href="<?php echo esc_url(home_url('/adults/')); ?>" class="btn btn-sm btn-verde">FOR ADULTS <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <?php endif;
            
            // Team post type
            elseif ($current_post_type === 'team') : ?>
            <a href="<?php echo esc_url(home_url('/team/')); ?>" class="btn btn-sm btn-verde">OUR TEAM <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <?php endif; ?>
        </div>



    </div>
</div>