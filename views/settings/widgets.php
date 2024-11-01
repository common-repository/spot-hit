<?php

global $wpdb;
$db_settings = $wpdb->prefix . "spothit_settings";

$site_key = '';
$secret_key = '';
$group = '';




///////////////////////////////////////////////////////////////////////////////////////
//  Récupération des clés pour le Captcha
///////////////////////////////////////////////////////////////////////////////////////
$db_request_site_key = $wpdb->get_results(
    "SELECT sh_value FROM $db_settings WHERE sh_key = 'captcha_site'"
);
$db_request_secret_key = $wpdb->get_results(
    "SELECT sh_value FROM $db_settings WHERE sh_key = 'captcha_secret'"
);
$db_request_site_key = $db_request_site_key[0];
$db_request_secret_key = $db_request_secret_key[0];

if (isset($db_request_site_key) && !empty($db_request_site_key)) {
    $site_key = $db_request_site_key->sh_value;
}

if (isset($db_request_secret_key) && !empty($db_request_secret_key)) {
    $secret_key = $db_request_secret_key->sh_value;
}


///////////////////////////////////////////////////////////////////////////////////////
//  Récupération du nom du groupe pour l'enregistrement des contacts
///////////////////////////////////////////////////////////////////////////////////////
$db_request_group = $wpdb->get_results(
    "SELECT sh_value FROM $db_settings WHERE sh_key = 'widget_group_name'"
);

if (isset($db_request_group) && !empty($db_request_group)) {
    $db_request_group = $db_request_group[0];
    $group = $db_request_group->sh_value;
} else {
    $group = _e('No group selected', 'spothit');
}

?>

<div class="settings_container" data-setting="widget">
    <div class="row d-flex align-items-center">
        <div class="col-md-12">
            <h3>
                <?php _e('Captcha', 'spothit') ?>
            </h3>
        </div>
        <div class="col-md-12 px-3 pb-3 mb-4 text-secondary">
            <?php _e('Configure the captcha of the widget to protect you from spam', 'spothit') ?>
        </div>
        <div class="mb-2 d-flex flex-row align-items-center">
            <div class="col-md-3 px-4">
                <?php _e('Site key', 'spothit') ?>
            </div>
            <div class="col-md-9">
                <input id="captcha_website_key" class="form-control form-control-lg float-right" type="text" placeholder="<?php _e('Captcha site key...', 'spothit') ?>" data-name="site_key" maxlength="255" value="<?php echo $site_key ?>">
            </div>
        </div>
        <div class="mb-2 d-flex flex-row align-items-center">
            <div class="col-md-3 px-4">
                <?php _e('Secret key', 'spothit') ?>
            </div>
            <div class="col-md-9">
                <input id="captcha_secret_key" class="form-control form-control-lg float-right" type="text" placeholder="<?php _e('Captcha secret key...', 'spothit') ?>" data-name="secret_key" maxlength="255" value="<?php echo $secret_key ?>">
            </div>
        </div>
        <small>
            <a class="form-text text-muted d-flex justify-content-end" href="https://www.google.com/recaptcha/admin/" target="_blank">
                <?php _e("Administration panel of your Google captcha keys", "spothit") ?></a>
        </small>

    </div>
    <div class="row mt-2">
        <div class="col-md-12 d-flex justify-content-end">
            <button id="spothit_submit_widget_key" class="btn mt-3"><?php _e('Save captcha settings', 'spothit') ?></button>
        </div>
    </div>


    <div class="row d-flex align-items-center mt-5 mb-2">
        <div class="col-md-12">
            <h3>
                <?php _e('Contact reception group', 'spothit') ?>
            </h3>
        </div>
        <div class=" col-md-12 px-3 pb-3 mb-4 text-secondary">
            <?php _e('Select or create the group in which the contacts will be saved', 'spothit') ?>
        </div>

        <div id="widget_group_choice">
            <div class="row mb-5">
                <span><?php _e('Current group', 'spothit') ?> : <span id="widget_current_group"><?php echo  $group ?></span> </span>
            </div>
            <div class="content">
                <div class="multi_box mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <input id="spothit_widget_select_group" class="radio_choice" type="radio" name="widget_group" value="0">
                            <label class="multi_box_label  d-flex align-tiems-center justify-content-center" for="spothit_widget_select_group">
                                <div class="input_container d-flex justify-content-center flex-column">
                                    <span class="input_icon text-center"><i class="fal fa-people-group fa-2xl"></i></span>
                                    <span class="text-center"><?php _e('Select from groups', 'spothit') ?></span>
                                    </p>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input id="spothit_widget_new_group" class="radio_choice bg-" type="radio" name="widget_group" value="1">
                            <label class="multi_box_label d-flex align-tiems-center justify-content-center" for="spothit_widget_new_group">
                                <div class="input_container d-flex justify-content-center flex-column">
                                    <span class="input_icon text-center"><i class="fal fa-users-medical fa-2xl"></i></span>
                                    <span class="text-center"><?php _e('Create new group', 'spothit') ?></span>
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div id="widget_group_container">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <button id="spothit_submit_widget_group" class="btn mt-3"><?php _e('Save group settings', 'spothit') ?></button>
        </div>
    </div>
</div>