<div class="page_title">
    <h2><i class="fa-light fa-user-tag fa-lg me-1"></i><?php _e('Contacts', 'spothit') ?>
    </h2>
</div>
<div class="content">
    <div class="multi_box mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="radio" class="radio_choice" id="recipient_wordpress" name="recipient_choice" value="0">
                <label class="multi_box_label h-100" for="recipient_wordpress">
                    <div class="input_container">
                        <p class="input_icon"><i class="fa-brands fa-wordpress-simple"></i></p>
                        <p class="input_title"><?php _e('Wordpress', 'spothit') ?></p>
                        <p><?php _e('Select contacts', 'spothit') ?>
                            <br><?php _e('in your Wordpress users list', 'spothit') ?>
                        </p>
                    </div>
                </label>
            </div>
            <div class="col-md-4">
                <input type="radio" class="radio_choice" id="recipient_spothit" name="recipient_choice" value="1">
                <label class="multi_box_label h-100" for="recipient_spothit">
                    <div class="input_container">
                        <p class="input_icon"><i class="fa-light fa-message"></i></p>
                        <p class="input_title"><?php _e('Spot-Hit', 'spothit') ?></p>
                        <p><?php _e('Select contacts groups', 'spothit') ?>
                            <br><?php _e('in your Spot-Hit users list', 'spothit') ?>
                        </p>
                    </div>
                </label>
            </div>
            <div class="col-md-4">
                <input type="radio" class="radio_choice" id="recipient_manual" name="recipient_choice" value="2">
                <label class="multi_box_label h-100" for="recipient_manual">
                    <div class="input_container">
                        <p class="input_icon"><i class="fa-light fa-address-book"></i>
                        </p>
                        <p class="input_title"><?php _e('Custom list', 'spothit') ?></p>
                        <p><?php _e('Write your own contacts list', 'spothit') ?></p>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <div class="multi_select recipients_results row mb-3">
        <p class="text-center"><?php _e('Select an option', 'spothit') ?></p>
    </div>
</div>