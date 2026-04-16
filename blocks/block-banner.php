<?php

/*
██████   █████  ███    ██ ███    ██ ███████ ██████
██   ██ ██   ██ ████   ██ ████   ██ ██      ██   ██
██████  ███████ ██ ██  ██ ██ ██  ██ █████   ██████
██   ██ ██   ██ ██  ██ ██ ██  ██ ██ ██      ██   ██
██████  ██   ██ ██   ████ ██   ████ ███████ ██   ██


*/

$banner_content = get_sub_field('banner_content');
$banner_link = get_sub_field('banner_link');
$banner_image = get_sub_field('banner_image');

if($banner_image):
    $banner_image_url = $banner_image['sizes']['4-3r576'];
    $banner_image_alt = $banner_image['alt'];
endif;

if($banner_link):
    $banner_link_url = $banner_link['url'];
    $banner_link_title = $banner_link['title'];
    $banner_link_target = $banner_link['target'];
endif;
?>


<div id="banner-<?php echo $iBlock; ?>" class="container-fluid5">

    <div class="container my-5 py-5">


        <div class="row g-5 banner-rounded my-5 p-5">
            <div class="col-12 col-md-6">
                <div class="mb-5 p-3">
                    <?php echo $banner_content; ?>
                </div>
                <div class="mb-5 p-3">
                    <?php if($banner_link): ?>
                    <a href="<?php echo $banner_link_url; ?>" class="btn btn-verde" target="<?php echo $banner_link_target; ?>"><?php echo $banner_link_title; ?></a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="banner-image">
                    <img src="<?php echo $banner_image_url; ?>" alt="<?php echo $banner_image_alt; ?>" class="img-fluid img-rounded mb-5">
                </div>
            </div>

        </div>
    </div>