<div class="page_title">
    <h2><i class="fa-light fa-clipboard-user fa-lg me-1"></i><?php _e('Sender', 'spothit') ?>
    </h2>
    <div class="content">
        <div class="multi_box">
            <div class="row">
                <div class="col-md-6 offset-md-3">

                    <div class="input_container">
                        <p class="input_icon"><i class="fal fa-user-tag"></i></p>
                        <p class="input_title"><?php _e('Sender', 'spothit') ?></p>
                        <input type="text" id="name_sender" class="form-control form-control-lg mb-3" placeholder="<?php _e('Sender name', 'spothit') ?>" data-name="nom_expediteur" required>
                        <div class="input-group mb-2">
                            <input type="text" id="custom_sender_email" class="form-control form-control-lg mb-3" placeholder="<?php _e('Sender email address', 'spothit') ?>" data-name="expediteur" required>

                            <div class="input-group-text">@sh-mail.fr</div>
                        </div>
                        <div class="form-check p-0">
                            <label class="mb-1 w-100">
                                <input type="checkbox" data-name="sender_name_checkbox" id="sender_name_checkbox"><?php _e('Set this sender name as default', 'spothit') ?>
                            </label>
                            <label class="mb-1 w-100">
                                <input type="checkbox" data-name="sender_email_checkbox" id="sender_email_checkbox"><?php _e('Set this address as default', 'spothit') ?>
                            </label>
                            <br>
                            <p><small class="text-muted mt-3"><?php _e("We are using optimized domain names for optimum reception to mailbox providers (Outlook, Hotmail, Gmail...).", "spothit") ?>
                                    <br>
                                    <?php _e("They are the 3 areas we using :", "spothit") ?>
                                    <br>
                                    <?php _e("@n1xmail.com<br>@m1xmail.com<br>@m2xmail.com<br>", "spothit"); ?>

                                    <!-- <a role="button" class="text-muted mt-3"
                                                        data-trigger="focus" id="email_sender_restriction"
                                                        data-toggle="popover">
                                                        <?php _e('Show more', 'spothit') ?>
                                                    </a> -->
                                </small>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>