<?php
/* display_resources('resource_entries'); - Files display btn-aguamarina, Links display btn-verde */

function display_resources($repeater_field_name, $alignment = false) {
    ?>
<div class="<?php if ($alignment): echo 'text-start'; else: echo 'text-center'; endif; ?>">

    <style>
@media screen and (max-width: 768px) {
    .fit-content {
        width: -moz-fit-content;
        width: -webkit-fit-content; 
        width: 100%;
    }
}
</style>

    <?php
        if (have_rows($repeater_field_name)): $iDoc = 0; // Set the increment variable
            while (have_rows($repeater_field_name)): the_row();
                $type_of_resource = get_sub_field('type_of_resource');
                
                // Initialize variables
                $url = '';
                $title = '';
                $caption = '';
                $icon = '';
                $link_url = '';
                $link_title = '';
                $link_target = '_self';
                
                $file = get_sub_field('file');
                if ($file):
                    $url = $file['url'];
                    $title = $file['title'];
                    $caption = $file['caption'];
                    $icon = $file['icon'];
                endif;
                $link = get_sub_field('link');
                if ($link):
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                endif;                
    ?>


    <?php if ($type_of_resource == 'file'): ?>
    <a class="btn btn-aguamarina text-start fit-content" href="<?php echo esc_attr($url); ?>" target="_blank" title="<?php echo esc_attr($title); ?>">
        <span style="overflow-wrap: break-word; text-wrap: wrap;">
            <?php if($title): echo esc_html($title); else: ?>Learn&nbsp;more<?php endif; ?>
        </span>
        <i class="fas fa-file" aria-hidden="true"></i>
    </a>
    <?php elseif ($type_of_resource == 'link'): ?>
    <a class="btn btn-verde text-start fit-content" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_attr($link_title); ?>" aria-label="Learn more about <?php echo esc_attr($link_title); ?>">
        <span style="overflow-wrap: break-word; text-wrap: wrap;">
            <?php if($link_title): echo esc_html($link_title); else: ?>Learn&nbsp;more<?php endif; ?>
        </span>
        <i class="fas fa-arrow-right" aria-hidden="true"></i>
    </a>
    <?php endif; ?>
    <?php $iDoc++; endwhile;
        else :
            // No value.
            // Do something...
        endif;
        ?>
</div>

<?php
}
?>