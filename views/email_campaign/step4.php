<div class="page_title">
    <h2><i class="fa-light fa-user-tag fa-lg me-1"></i><?php _e('Email content', 'spothit') ?>
    </h2>
</div>
<div class="content">
    <div class="multi_box mb-3">
        <div class="row mb-3">
            <div class="col-md-4 offset-md-2">
                <input type="radio" class="radio_choice" id="email_message_write" name="email_message_type" value="0">
                <label class="multi_box_label h-100" for="email_message_write">
                    <div class="input_container">
                        <p class="input_icon"><i class="fa-light fa-file-pen"></i></p>
                        <p class="input_title"><?php _e('Write an Email', 'spothit') ?>
                        </p>
                    </div>
                </label>
            </div>
            <div class="col-md-4">
                <input type="radio" class="radio_choice" id="email_message_models" name="email_message_type" value="1">
                <label class="multi_box_label h-100" for="email_message_models">
                    <div class="input_container">
                        <p class="input_icon"><i class="fa-light fa-envelope-open-text"></i></p>
                        <p class="input_title"><?php _e('Use a model', 'spothit') ?></p>
                    </div>
                </label>
            </div>
        </div>
        <div id="message_type_results" class="row multi_box ">

        </div>
    </div>
</div>