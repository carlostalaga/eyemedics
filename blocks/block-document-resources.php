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

$document_resources_background_class = '';
if ($document_resources_background == 'bg-verde') {
    $document_resources_background_class = 'bg-verde';
} elseif ($document_resources_background == 'bg-verde-light') {
    $document_resources_background_class = 'bg-verde-light';
} elseif ($document_resources_background == 'bg-humo') {
    $document_resources_background_class = 'bg-humo';
} elseif ($document_resources_background == 'bg-white') {
    $document_resources_background_class = 'bg-white';
} elseif ($document_resources_background == 'bg-hueso') {
    $document_resources_background_class = 'bg-hueso';
}

// Flip resource buttons to the light palette when rendered on dark green backgrounds.
$document_resources_use_light_buttons = in_array($document_resources_background, array('bg-verde', 'bg-verde-light'), true);
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

<div id="documentResources-<?php echo $iBlock; ?>" class="container-fluid py-5 px-5 px-md-0 <?php echo $document_resources_background_class; ?>">
    <div class="container">

        <?php if($document_resources_title): ?>
        <h2 class="pb-5"><?php echo $document_resources_title ?></h2>
        <?php endif; ?>

        <div class="<?php if($document_resources_columns == '1_col'): echo 'newspaper-1'; elseif($document_resources_columns == '2_col'): echo 'newspaper-2'; endif; ?>">


            <?php
                echo display_resources('document_resource_repeater', true, true, $document_resources_use_light_buttons);
            ?>


        </div>
    </div>
</div>