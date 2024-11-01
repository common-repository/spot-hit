<div class="settings_container" data-setting="email">
    <div class="row d-flex align-items-center">
        <div class="col-md-12">
            <h3>
                <?php _e('Sender name', 'spothit') ?>
            </h3>
        </div>
        <div class="col-md-12 px-3 pb-3 mb-4 text-secondary">
            <?php _e('Change default sender name for all sent Emails', 'spothit') ?>
        </div>
        <div class="col-md-3 px-4">
            <?php _e('Sender name', 'spothit') ?>
        </div>
        <div class="col-md-9">
            <input id="sender_email_name" class="input-1 form-control form-control-lg float-right" type="text" placeholder="<?php _e('Your sender name...', 'spothit') ?>" data-name="sender_email" maxlength="255">
        </div>
    </div>

    <div class="row d-flex align-items-center mt-5">
        <div class="col-md-12">
            <h3>
                <?php _e('Receiving email address', 'spothit') ?>
            </h3>
        </div>
        <div class="col-md-12 px-3 pb-3 mb-4 text-secondary">
            <?php _e('Change the Email address on which you will receive messages', 'spothit') ?>
        </div>
        <div class="col-md-3 px-4">
            <?php _e('Email address', 'spothit') ?>
        </div>
        <div class="col-md-9">
            <input id="sender_recieve_email_address" class="input-1 form-control form-control-lg" type="text" placeholder="<?php _e('Your Email address to receive emails...', 'spothit') ?>" data-name="sender_recieve_email" maxlength="255">
        </div>
    </div>


    <div class="row d-flex align-items-center mt-5 mb-2">
        <div class="col-md-12"">
                                    <h3>
                                        <?php _e('Sending Email address', 'spothit') ?>
                                    </h3>
                                </div>
                                <div class=" col-md-12 px-3 pb-3 mb-4 text-secondary">
            <?php _e('Change the Email address on which you will sent Emails', 'spothit') ?>
        </div>
        <div class="col-md-3 px-4">
            <?php _e('Email address', 'spothit') ?>
        </div>
        <div class="col-md-9">
            <div class="input-group">
                <input id="sender_send_email_address" class="input-1 form-control form-control-lg" type="text" placeholder="<?php _e('Your Email address to send emails...', 'spothit') ?>" data-name="sender_send_email" maxlength="255">
                <div class="input-group-text">
                    @sh-mail.fr
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex align-items-center mt-5 mb-2 px-3">
        <div class="col-md-8 d-flex justify-content-between align-items-center">
            <span>
                <?php _e("Apply to all automatic campaigns", "spothit") ?>
            </span>
            <label class="switch-label">
                <input type="checkbox" class="switch-input" id="automating_email_settings">
                <span class="switch-btn-container">
                    <span class="switch-bg">
                        <span class="switch-btn"></span>
                    </span>
                </span>
            </label>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <button id="spothit_submit_email_settings" class="btn mt-3"><?php _e('Save', 'spothit') ?></button>
        </div>
    </div>
</div>