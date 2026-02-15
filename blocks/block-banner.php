<?php
/*
██████   █████  ███    ██ ███    ██ ███████ ██████
██   ██ ██   ██ ████   ██ ████   ██ ██      ██   ██
██████  ███████ ██ ██  ██ ██ ██  ██ █████   ██████
██   ██ ██   ██ ██  ██ ██ ██  ██ ██ ██      ██   ██
██████  ██   ██ ██   ████ ██   ████ ███████ ██   ██


*/

$banner_background = get_sub_field('banner_background');
if($banner_background == 'bg-cielo'):
    $banner_background_class = 'bg-cielo';
endif;
if($banner_background == 'bg-hueso'):
    $banner_background_class = 'bg-hueso';
endif;
if($banner_background == 'bg-white'):
    $banner_background_class = 'bg-white';
endif;

$banner_style = get_sub_field('banner_style');
if($banner_style == 'aguamarina'):
    $banner_style_tone = 'bg-aguamarina';
    $banner_style_shape = '#8CC63E'; // colours.$verde
    $banner_style_line1 = 'text-purpura';
    $banner_style_line2 = 'text-verde ps-5';
endif;
if($banner_style == 'purpura'):
    $banner_style_tone = 'bg-purpura';
    $banner_style_shape = '#ACCDEC'; // colours.$cielo
    $banner_style_line1 = 'text-cielo';
    $banner_style_line2 = 'text-blanco ps-5';
endif;
if($banner_style == 'verde'):
    $banner_style_tone = 'bg-verde';
    $banner_style_shape = '#B7DFC9'; // colours.$aguamarina
    $banner_style_line1 = 'text-blanco';
    $banner_style_line2 = 'text-blanco ps-5';    
endif;
if($banner_style == 'cielo'):
    $banner_style_tone = 'bg-cielo';
    $banner_style_shape = '#0D2C6B'; // colours.$posidonia
    $banner_style_line1 = 'text-purpura';
    $banner_style_line2 = 'text-blanco ps-5';    
endif;

$banner_line_1 = get_sub_field('banner_line_1');
$banner_line_2 = get_sub_field('banner_line_2');
?>

<div id="banner-<?php echo $iBlock; ?>" class="container-fluid py-5 <?php echo esc_attr($banner_background); ?>">
    <div class="container img-banners p-5 <?php echo esc_attr($banner_style_tone); ?>">

        <?php if ($banner_line_1): ?>
        <h2 class="<?php echo esc_attr($banner_style_line1); ?>"><?php echo esc_html($banner_line_1); ?></h2>
        <?php endif; ?>

        <?php if ($banner_line_2): ?>
        <h2 class="<?php echo esc_attr($banner_style_line2); ?>" style="margin-top: -1rem;"><?php echo esc_html($banner_line_2); ?></h2>
        <?php endif; ?>

        <svg class="banner-demo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 198.105 156.043">
            <path d="M165.5999,26.639c-14.1496-10.3557-34.4271-10.5007-49.7944.9667-12.5604,9.3784-18.597,24.1131-17.1711,38.1982-13.5186-6.4556-30.3539-5.249-43.5287,4.583-16.9592,12.6598-21.951,35.1918-12.6558,52.7537-9.473-1.472-19.5101.7048-27.7995,6.892-8.6759,6.4763-13.6761,16.0269-14.6503,26.0104h198.105V0c-6.7009.5375-13.3359,2.9082-19.1212,7.2274-6.7361,5.0245-11.2288,11.9157-13.3839,19.4116Z" fill="<?php echo esc_attr($banner_style_shape); ?>" />
        </svg>

    </div>
</div>

<style>
    #banner-<?php echo $iBlock; ?> .container {
        position: relative;
        overflow: hidden;
    }
    #banner-<?php echo $iBlock; ?> h2 {
        position: relative;
        z-index: 2;
    }
    #banner-<?php echo $iBlock; ?> .banner-demo {
        position: absolute;
        bottom: -2rem;
        right: -2rem;
        width: 220px;
        height: auto;
        z-index: 1;
    }
</style>