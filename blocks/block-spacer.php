<?php
/*
███████ ██████   █████   ██████ ███████ ██████
██      ██   ██ ██   ██ ██      ██      ██   ██
███████ ██████  ███████ ██      █████   ██████
     ██ ██      ██   ██ ██      ██      ██   ██
███████ ██      ██   ██  ██████ ███████ ██   ██


*/

$spacer_background = get_sub_field('spacer_background');
if($spacer_background == 'bg-cielo'):
    $spacer_background_class = 'bg-cielo';
endif;
if($spacer_background == 'bg-hueso'):
    $spacer_background_class = 'bg-hueso';
endif;
if($spacer_background == 'bg-white'):
    $spacer_background_class = 'bg-white';
endif;

$spacer_height = get_sub_field('spacer_height');
$spacer_height_value = $spacer_height ?: '0px';
?>

<?php /* make conditional the py-5 to pt-5 */ ?>
<div id="spacer-<?php echo $iBlock; ?>" class="container-fluid border border-0 border-danger  
<?php echo $spacer_background_class; ?>
" style="height: <?php echo $spacer_height_value; ?>;">
</div>