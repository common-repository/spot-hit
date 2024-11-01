<div class="settings_container" data-setting="sms">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-12">
                                    <h3>
                                        <?php _e('Sender name', 'spothit') ?>
                                    </h3>
                                </div>
                                <div class="col-md-12 px-3 pb-3 mb-4 text-secondary">
                                    <?php _e('Change sender name for all sent SMS', 'spothit') ?>
                                </div>
                                <div class="col-md-3 px-4">
                                    <?php _e('Sender name', 'spothit') ?>
                                </div>
                                <div class="col-md-9">
                                    <input id="sender_sms_name" class="input-1 form-control form-control-lg float-right" type="text" placeholder="<?php _e('Your sender name...', 'spothit') ?>" data-name="#" maxlength="11">
                                </div>
                                <small class="text-muted d-block text-end"><?php _e('11 characters max.', 'spothit') ?></small>
                            </div>

                            <div class="row d-flex align-items-center mt-5">
                                <div class=" col-md-12">
                                    <h3>
                                        <?php _e('Telephone number', 'spothit') ?>
                                    </h3>
                                </div>
                                <div class="col-md-12 px-3 pb-3 mb-4 text-secondary">
                                    <?php _e('Change the phone number on which you will receive messages', 'spothit') ?>
                                </div>
                                <div class=" col-md-3 px-4 ">
                                    <?php _e('Your telephone number', 'spothit') ?>
                                </div>
                                <div class="col-md-9">
                                    <input id="sender_sms_number" class="input-1 form-control form-control-lg" type="text" placeholder="<?php _e('Your telephone number', 'spothit') ?>" maxlength="15">
                                </div>
                            </div>

                            <div class="row d-flex align-items-center mt-5 mb-2 px-3">
                                <div class="col-md-8 d-flex justify-content-between align-items-center">
                                    <span>
                                        <?php _e("Apply to all automatic campaigns", "spothit") ?>
                                    </span>
                                    <label class="switch-label">
                                        <input type="checkbox" class="switch-input" id="automating_sms_settings">
                                        <span class="switch-btn-container">
                                            <span class="switch-bg">
                                                <span class="switch-btn"></span>
                                            </span>
                                        </span>
                                    </label>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end mt-5">
                                    <button id="spothit_submit_sms_settings" class="btn mt-3"><?php _e('Save', 'spothit') ?></button>
                                </div>
                            </div>
                        </div>