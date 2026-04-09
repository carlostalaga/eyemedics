<div class="container py-5 px-5 px-md-0">
    <span class="guia">sf::: sf-1-doctors-staff.php</span>
    <div class="row row-cols-3 g-5">
        <?php 
        /* -------------------------------------------------------------------------- */
        /*                             ADD SEARCH
        /* -------------------------------------------------------------------------- */
        ?>
        <!-- /* ---------------------------- Connected Fields ---------------------------- */ -->
        <div class="col-12 col-md-6 col-lg-4"><?php echo do_shortcode('[searchandfilter field="2"]'); ?></div>
        <div class="col-12 col-md-6 col-lg-4"><?php echo do_shortcode('[searchandfilter field="3"]'); ?></div>
        <div class="col-12 col-md-6 col-lg-4 d-flex align-items-end"><?php echo do_shortcode('[searchandfilter field="4"]'); ?></div>
        <?php //echo do_shortcode('[searchandfilter field="Submit HD"]'); ?>
        <!-- /* ---------------------------------- Query --------------------------------- */ -->
    </div>
</div>