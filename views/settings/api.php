<div class="settings_container" data-setting="key">
    <div class="row d-flex align-items-center">
        <div class="col-md-12 mt-3 ">
            <h3>
                <?php _e('API key', 'spothit') ?>
            </h3>
        </div>
        <div class="col-md-12 mb-3">
            <span><?php _e('Current API key is', 'spothit'); ?> :<strong>
                    <?php echo (' ' . $key_hidden) ?></p>
                </strong></span>
        </div>
        <div class="row d-flex align-items-center mb-3">
            <div class="col-md-4">
                <?php _e('Update API key', 'spothit') ?>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input class="input-1 form-control form-control-lg" type="text" placeholder="<?php _e('Write your new API key', 'spothit') ?>" data-name="api_key" maxlength="255">
                </div>
            </div>
            <small><a class="form-text text-muted d-flex justify-content-end" href="https://www.spot-hit.fr/espace-client/parametres/api">
                    <?php _e("You don't know your key ?", "spothit") ?></a></small>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-5">
            <button id="spothit_submit_key" class="btn"><?php _e('Save', 'spothit') ?></button>
        </div>
    </div>
</div>