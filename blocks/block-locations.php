<?php
/*
██       ██████   ██████  █████  ████████ ██  ██████  ███    ██ ███████
██      ██    ██ ██      ██   ██    ██    ██ ██    ██ ████   ██ ██
██      ██    ██ ██      ███████    ██    ██ ██    ██ ██ ██  ██ ███████
██      ██    ██ ██      ██   ██    ██    ██ ██    ██ ██  ██ ██      ██
███████  ██████   ██████ ██   ██    ██    ██  ██████  ██   ████ ███████
*/

/*
Flexible Content layout: "locations"
ACF field group: acf-json/group_6670bd6172100.json (layout_69d5f533bafea)
ACF sub-field:   locations_background (select: bg-hueso | bg-white)

Queries ALL published consulting_location posts (not doctor-specific)
and delegates rendering to the shared component:
  inc/component-consulting-locations.php → bystra_render_consulting_locations_cards()

$iBlock is the flexible content row index set by blocks/flexible-content.php.
*/

$locations_background = get_sub_field('locations_background');
$locations_background_class = 'bg-white';

if ($locations_background === 'bg-hueso'):
    $locations_background_class = 'bg-hueso';
elseif ($locations_background === 'bg-white'):
    $locations_background_class = 'bg-white';
endif;

$locations_post_ids = get_posts(
    array(
        'post_type' => 'consulting_location',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'fields' => 'ids',
    )
);

bystra_render_consulting_locations_cards(
    $locations_post_ids,
    'locations-' . (string) $iBlock,
    'container-fluid mb-5 ' . $locations_background_class
);
