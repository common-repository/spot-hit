<div class="page_title">
    <h2><i class="fa-light fa-alarm-clock fa-lg me-1"></i><?php _e('Date', 'spothit') ?>
    </h2>
</div>
<div class="content">
    <div class="multi_box mb-3">
        <div class="row">
            <div class="col-md-6">
                <input type="radio" data="date_campaign" class="radio_choice" id="date_now" name="date_choice" value="0" checked>
                <label class="multi_box_label h-100" for="date_now">
                    <div class="input_container">
                        <p class="input_icon"><i class="fal fa-paper-plane"></i></p>
                        <p class="input_title"><?php _e('Immediate', 'spothit') ?></p>
                        <p><?php _e('Email will be sent directly after your campaign validation', 'spothit') ?>
                        </p>
                    </div>
                </label>
            </div>
            <div class="col-md-6">
                <input type="radio" data="date_campaign" class="radio_choice" id="date_scheduled" name="date_choice" value="1">
                <label class="multi_box_label h-100" for="date_scheduled">
                    <div class="input_container">
                        <p class="input_icon"><i class="fal fa-stopwatch"></i></p>
                        <p class="input_title"><?php _e('Custom date', 'spothit') ?></p>
                        <p><?php _e('Select a date and time for sending', 'spothit') ?>
                        </p>
                        <div class="form-group row mb-2">
                            <label class="col-md-12 col-lg-4"><?php _e('Day', 'spothit') ?></label>
                            <div class="col-md-12 col-lg-8">
                                <input class="datepicker" type="text" id="date_day" name="date_jour">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-md-12 col-lg-4 col-form-label"><?php _e('Hour', 'spothit') ?></label>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <select type="text" id="date_hour" name="date_jour" class="form-control"></select>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <select type="text" id="date_minute" name="date_jour" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>