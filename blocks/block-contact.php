<?php
/*
 ██████  ██████  ███    ██ ████████  █████   ██████ ████████
██      ██    ██ ████   ██    ██    ██   ██ ██         ██
██      ██    ██ ██ ██  ██    ██    ███████ ██         ██
██      ██    ██ ██  ██ ██    ██    ██   ██ ██         ██
 ██████  ██████  ██   ████    ██    ██   ██  ██████    ██


*/

$contact_headline = get_sub_field('contact_headline');
$contact_content = get_sub_field('contact_content');
?>

<div id="contact-<?php echo $iBlock; ?>" class="container-fluid py-5">
    <div class="container bg-negro contact-rounded p-5">
        <div class="row">

            <?php endwhile; ?>
            </ul>
            <?php
                    wp_reset_postdata();
                    endif;
                    ?>

            <?php if( $contact_content ): ?>
            <div>
                <?php echo $contact_content; ?>
            </div>
            <?php endif; ?>

        </div>

    </div>

    <div class="col-12 col-md-6 p-5">
        <h5 class="text-white mb-5">Request an Appointment</h5>
        <?php echo do_shortcode('[contact-form-7 id="21764f5" title="Contact form 1"]'); ?>
    </div>

</div>
</div>
</div>