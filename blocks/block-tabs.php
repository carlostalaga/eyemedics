<?php 
/*
████████  █████  ██████  ███████
   ██    ██   ██ ██   ██ ██
   ██    ███████ ██████  ███████
   ██    ██   ██ ██   ██      ██
   ██    ██   ██ ██████  ███████


*/

$tabs_background = get_sub_field('tabs_background'); // Define the background variable for tabs

?>
<div id="tabs-<?php echo $iBlock; ?>" class="container-fluid front-page-tabs py-5 px-5 px-md-0 <?php 
    // Check if the variable is set before using it
    if(isset($tabs_background) && $tabs_background == 'bg-white'): 
        echo 'bg-white'; 
    elseif(isset($tabs_background) && $tabs_background == 'bg-hueso'): 
        echo 'bg-hueso';
    // Optionally add a default class if neither condition is met and the variable might not be set
    // else { echo 'bg-default'; } 
    endif; 
?>">
    <div class="container tabsBox py-5">

        <!-- Nav tabs -->
        <ul class="nav nav-pills gap-3 justify-content-center" id="myTab-<?php echo $iBlock; ?>" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="btn btn-sm btn-verde active" id="tab-uno-tab-<?php echo $iBlock; ?>" data-bs-toggle="tab" data-bs-target="#tab-uno-<?php echo $iBlock; ?>" type="button" role="tab" aria-controls="tab-uno-<?php echo $iBlock; ?>" aria-selected="true">REFER YOUR CHILD <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-sm btn-verde" id="tab-dos-tab-<?php echo $iBlock; ?>" data-bs-toggle="tab" data-bs-target="#tab-dos-<?php echo $iBlock; ?>" type="button" role="tab" aria-controls="tab-dos-<?php echo $iBlock; ?>" aria-selected="false">REFER FOR ADULTS <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
            </li>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content border border-0 p-3" id="myTabContent-<?php echo $iBlock; ?>">

            <div class="tab-pane fade show active" id="tab-uno-<?php echo $iBlock; ?>" role="tabpanel" aria-labelledby="tab-uno-tab-<?php echo $iBlock; ?>">
                <h6 class="mt-5">Refer your Child</h6>
                <div class="w-100">
                    <iframe src="https://sound-bites-therapy-services.splose.com/public-form/c2bc003b-158c-4716-be8b-938faa32d3f7" width="100%" height="3600" style="border: none; max-width: 100%;" title="Sound Bites Therapy Services Form"></iframe>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-dos-<?php echo $iBlock; ?>" role="tabpanel" aria-labelledby="tab-dos-tab-<?php echo $iBlock; ?>">
                <h6 class="mt-5">Refer for Adults</h6>
                <div class="w-100">
                    <iframe src="https://sound-bites-therapy-services.splose.com/public-form/b60c898f-65c7-4eec-8ee3-5f1d84b848d8" width="100%" height="3600" style="border: none; max-width: 100%;" title="Sound Bites Therapy Services Form"></iframe>
                </div>
            </div>


        </div>

    </div>
</div>
</div>