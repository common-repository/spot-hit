<div class="page_title">
    <h2><i class="fa-light fa-comment fa-lg me-1"></i><?php _e('Message', 'spothit') ?>
    </h2>
</div>
<div class="content">
    <div class="input_container mb-3">
        <p class="input_title"><?php _e('Insert your message', 'spothit') ?></p>
        <textarea placeholder="<?php _e('Writing message', 'spothit') ?>" data="campaign" class="message_textarea" data-name="message"></textarea>
    </div>
    <div class="row">
        <div class="col">
            <label class="switch-label" for="add_stop_sms">
                <input class="switch-input stop_btn" type="checkbox" name="type" value="2" id="add_stop_sms">
                <span class="switch-btn-container">
                    <span class="switch-bg"><span class="switch-btn"></span></span>
                </span>
                <span class="switch-text-container">
                    <span class="switch-text"><?php _e('STOP at 36200', 'spothit') ?></span>
                </span>
            </label>
        </div>
        <div class="col text-end">
            <span class="character_count">
                <span class="character_count_size">0</span>/
                <span class="character_count_max">160</span>
                <span><?php _e('caracters', 'spothit') ?> - </span>
                <span class="character_count_number">0</span>
                <span>SMS</span>
            </span>
        </div>
    </div>
</div>
<div id="carac_doubl" class="mt-5">
    <p><strong><?php _e('Warning : ', 'spothit') ?></strong><?php _e('The caracters |, ^, €, {, }, [, ~, ] count as doubles.', 'spothit') ?></p>
</div>