<div class="settings_container" data-setting="alerts">
    <div class="col-md-12 mb-3 mt-5">
        <h3>
            <?php _e('Scales for alerts', 'spothit') ?>
        </h3>
    </div>
    <div class="row d-flex align-items-start modal-alert_scale">
        <div class="col-md-6">
            <div class="col-md-12">
                <h4 class="px-2">
                    <?php _e('SMS alerts', 'spothit') ?>
                </h4>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <tbody id="sms_alerts_scale">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="col-md-12">
                <h4 class="px-2">
                    <?php _e('Email alerts', 'spothit') ?>
                </h4>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <tbody id="email_alerts_scale">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row d-flex align-items-center mt-5 mb-2">
        <div class="col-md-6 d-flex align-items-center">
            <div class="col">
                <?php _e("Enable alerts ?", "spothit") ?>
            </div>
            <div class="col d-flex justify-content-center">
                <label class="switch-label switch-with-text mb-1">
                    <input type="checkbox" class="switch-input" data-switch="alerts">
                    <span class="switch-btn-container">
                        <span class="switch-bg">
                            <span class="switch-bg-text switch-bg-text-active"><?php _e('Yes', 'spothit') ?></span>
                            <span class="switch-btn"></span>
                            <span class="switch-bg-text switch-bg-text-inactive"><?php _e('No', 'spothit') ?></span>
                        </span>
                    </span>
                </label>
            </div>
        </div>
    </div>

</div>