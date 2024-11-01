<div class="page_title">
    <h2><i class="fa-light fa-clipboard-user fa-lg me-1"></i><?php _e('Sender', 'spothit') ?>
    </h2>
</div>
<div class="content">
    <div class="multi_box">
        <div class="row">
            <div class="col-md-6">
                <input type="radio" data="sender_campaign" class="radio_choice" id="sender_on" name="sender_choice" value="0" checked>
                <label class="multi_box_label h-100" for="sender_on">
                    <div class="input_container">
                        <p class="input_icon"><i class="fal fa-user-tag"></i></p>
                        <p class="input_title"><?php _e('Custom sender', 'spothit') ?>
                        </p>
                        <input type="text" id="custom_sender_sms" class="form-control form-control-lg mb-3" placeholder="<?php _e('Sender name', 'spothit') ?>" maxlength="11">
                        <p><small><?php _e('11 caracters max.', 'spothit') ?></small>
                        </p>
                        <div class="form-check">
                            <label>
                                <input class="text-muted" type="checkbox" data-name="sender_checkbox" id="sender_checkbox">
                                <?php _e('Set this default sender name', 'spothit') ?>
                            </label>
                        </div>
                        <a role="button" class="text-muted" id="sms_sender_restriction">
                            <small><?php _e('Show information', 'spothit') ?></small>
                        </a>
                    </div>
                </label>
            </div>
            <div class="col-md-6">
                <input type="radio" data="sender_campaign" class="radio_choice" id="sender_off" name="sender_choice" value="1">
                <label class="multi_box_label h-100" for="sender_off">
                    <div class="input_container">
                        <p class="input_icon"><i class="fal fa-user-secret"></i></p>
                        <p class="input_title">
                            <?php _e('Without customisation', 'spothit') ?></p>
                        <p><?php _e('SMS will be sent with 5 short numbers (ex. 36200)', 'spothit') ?>
                        </p>
                        <p><?php _e('Your French recipients will be able to reply to this SMS.', 'spothit') ?>
                        </p>
                    </div>
                </label>
            </div>
        </div>
    </div>

</div>