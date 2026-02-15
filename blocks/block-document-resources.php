<?php 

/*
██████   ██████   ██████ ██    ██ ███    ███ ███████ ███    ██ ████████
██   ██ ██    ██ ██      ██    ██ ████  ████ ██      ████   ██    ██
██   ██ ██    ██ ██      ██    ██ ██ ████ ██ █████   ██ ██  ██    ██
██   ██ ██    ██ ██      ██    ██ ██  ██  ██ ██      ██  ██ ██    ██
██████   ██████   ██████  ██████  ██      ██ ███████ ██   ████    ██


██████  ███████ ███████  ██████  ██    ██ ██████   ██████ ███████ ███████
██   ██ ██      ██      ██    ██ ██    ██ ██   ██ ██      ██      ██
██████  █████   ███████ ██    ██ ██    ██ ██████  ██      █████   ███████
██   ██ ██           ██ ██    ██ ██    ██ ██   ██ ██      ██           ██
██   ██ ███████ ███████  ██████   ██████  ██   ██  ██████ ███████ ███████


*/

$document_resources_background = get_sub_field('document_resources_background');
$document_resources = get_sub_field('document_resources');
$document_resources_title = get_sub_field('document_resources_title');
$document_resources_columns = get_sub_field('document_resources_columns');
?>


<style>
.newspaper-1 {
    column-count: 1;
    column-gap: 40px;
}
.newspaper-2 {
    column-count: 2;
    column-gap: 40px;
}

@media screen and (max-width: 992px) {
    .newspaper-2 {
        column-count: 1;
    }
}

/* List separator styles moved to style.scss */
</style>

<div id="documentResources-<?php echo $iBlock; ?>" class="container-fluid py-5 px-5 px-md-0 <?php 
    if($document_resources_background == 'bg-white'): 
        echo 'bg-white'; 
    elseif($document_resources_background == 'bg-hueso'): 
        echo 'bg-hueso';
    endif; 
?>">
    <div class="container">

        <?php if($document_resources_title): ?>
        <h3 class="text-posidonia pb-5 <?php if($document_resources_columns == '1_col'): echo 'mx-lg-5 px-lg-5'; endif; ?>"><?php echo $document_resources_title ?></h3>
        <?php endif; ?>

        <div class="<?php if($document_resources_columns == '1_col'): echo 'newspaper-1 mx-lg-5 px-lg-5'; elseif($document_resources_columns == '2_col'): echo 'newspaper-2'; endif; ?>">


            <?php
                echo display_resources('document_resource_repeater', false, true);
            ?>


        </div>
    </div>
</div>