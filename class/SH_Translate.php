<?php

class SH_Translate
{

    public static function main_script()
    {
        wp_localize_script('spothit_script', 'SH_plugin_translate_main', array(
            'sms_credits_alert_err'  =>  __('You have reached your SMS credit scale !', 'spothit'),
            'email_credits_alert_err'  =>  __('You have reached your EMAILS credit scale !', 'spothit'),

            'previous_step'  =>  __('Previous step', 'spothit'),
            'next_step'  =>  __('Next step', 'spothit'),
            'stop_sms'  =>  __('STOP at 36200', 'spothit'),
            'saved'  =>  __('Saved !', 'spothit'),
            'campaign_name_long'  =>  __('Campaign name is too long (255 characters maximum)', 'spothit'),
            'campaign_sent'  =>  __('The campaign is sent !', 'spothit'),
            'sender_name_long'  =>  __('Your sender name is too long (11 characters maximum)', 'spothit'),
            'sender_name_short'  =>  __('Sender name is too short (3 characters minimum)', 'spothit'),
            'sender_name_empty'  =>  __('Please, complete the sender field !', 'spothit'),
            'recipients_field_empty'  =>  __('Please, complete the contacts field', 'spothit'),
            'select_recipient_method'  =>  __('Please, select a contacts method', 'spothit'),
            'select_recipient_group'  =>  __('Select a contacts group', 'spothit'),
            'invalid_recipient_method'  =>  __('Invalid contacts method', 'spothit'),
            'msg_long'  =>  __('Your message is too long', 'spothit'),
            'msg_empty' => __('Please, complete the message field', 'spothit'),
            'msg_invalid' => __('Invalid message method', 'spothit'),
            'date_empty' => __('Please, select date, hour and minute', 'spothit'),
            'date_method' => __('Please select a date method', 'spothit'),
            'empty_email_address' => __('Please write an email address', 'spothit'),
            'invalid_email_address' => __('Invalid email address', 'spothit'),
            'subject_empty' => __('Please write a subject for you email', 'spothit'),
            'model_select' => __('Please select a model for your email', 'spothit'),
            'content_method' => __('Please, select a content method', 'spothit'),
            'error_23' => __('Unspecified or incorrect message type', 'spothit'),
            'error_24' => __('Message is empty', 'spothit'),
            'error_25' => __('The message contains more than 160 characters (70 in unicode)', 'spothit'),
            'error_26' => __('No valid contact is specified', 'spothit'),
            'error_27' => __('Restricted number', 'spothit'),
            'error_28' => __('Invalid contact', 'spothit'),
            'error_29' => __('Invalid contact number', 'spothit'),
            'error_30' => __('Sender is invalid.', 'spothit'),
            'error_31' => __('The system encountered an error, please contact us.', 'spothit'),
            'error_32' => __('You do not have enough credits to send this message.', 'spothit'),
            'error_33' => __('Sending messages is disabled for the demonstration.', 'spothit'),
            'error_34' => __('Your account has been suspended. Contact us for more information', 'spothit'),
            'error_35' => __('Your set sending limit has been reached. Contact us for more information.', 'spothit'),
            'error_36' => __('Your set sending limit has been reached. Contact us for more information.', 'spothit'),
            'error_37' => __('Your set sending limit has been reached. Contact us for more information.', 'spothit'),
            'error_38' => __('The smslongnbr parameter is not consistent with the size of the message.', 'spothit'),
            'error_39' => __('Sender is not authorized', 'spothit'),
            'error_40' => __('EMAIL | The topic is too short.', 'spothit'),
            'error_41' => __('EMAIL | The reply email is invalid.', 'spothit'),
            'error_42' => __('EMAIL | The sender name is too short.', 'spothit'),
            'error_43' => __('Invalid token. Contact us for more information.', 'spothit'),
            'error_44' => __('Message length not allowed. Contact us for more information.', 'spothit'),
            'error_45' => __('No valid variable date was found in your contact list.', 'spothit'),
            'error_46' => __('The mention "STOP au 36200" is missing.', 'spothit'),
            'error_47' => __('Staggering: empty start date', 'spothit'),
            'error_48' => __('Staggering: empty end date', 'spothit'),
            'error_49' => __('Staggering: start date later than end date', 'spothit'),
            'error_50' => __('Staggering: no slot available', 'spothit'),
            'error_51' => __('Unrecognized API key.', 'spothit'),
            'error_52' => __('You cannot have emojis in your message.', 'spothit'),
            'error_53' => __('You must add a Stop notice to your SMS.', 'spothit'),
            'error_54' => __('This product is not activated.', 'spothit'),
            'error_55' => __('The specified time zone is invalid.', 'spothit'),
            'error_56' => __('The date has already passed after calculating the time zone.', 'spothit'),
            'error_57' => __('You have reached the maximum limit of 50 campaigns in drafts.', 'spothit'),
            'error_58' => __('We have detected a link in the content of your message, please contact our customer service to validate this sending.', 'spothit'),
            'error_59' => __('Your sending limit has been reached.', 'spothit'),
            'error_60' => __('You have exceeded your api request limit.', 'spothit'),
            'error_61' => __('Maintenance is scheduled for this time slot.', 'spothit'),
            'error_62' => __('We have preventively blocked this campaign because it has similar characteristics to a campaign already sent.', 'spothit'),
            'error_63' => __('Your account is suspended.', 'spothit'),
            'error_64' => __('Unauthorized IP.', 'spothit'),
            'empty_sender_name' => __('Empty sender name.', 'spothit'),
            'select_recipients_group' => __('Please select a contacts group', 'spothit'),
        ));
    }




    public static function send_email()
    {
        wp_localize_script('email_scripts', 'SH_plugin_translate', array(
            'today'  =>  __('Today', 'spothit'),
            'month'  =>  __('Month', 'spothit'),
            'clear'  =>  __('Delete', 'spothit'),
            'datepicker_lang'  =>  __('en', 'spothit'),
            'empty_email_address'  =>  __('Email address field is empty', 'spothit'),
            'email_placeholder'  =>  __('Insert your message here', 'spothit'),
            'no_recipient_group'  =>  __('No contact group found', 'spothit'),
            'manual_recipient'  =>  __('Insert your contacts list', 'spothit'),
        ));
    }




    public static function send_sms()
    {
        wp_localize_script('sms_scripts', 'SH_plugin_translate', array(
            'today'  =>  __('Today', 'spothit'),
            'month'  =>  __('Month', 'spothit'),
            'clear'  =>  __('Delete', 'spothit'),
            'datepicker_lang'  =>  __('en', 'spothit'),
            'empty_email_address'  =>  __('Email address field is empty', 'spothit'),
            'email_placeholder'  =>  __('Email content', 'spothit'),
            'no_recipient_group'  =>  __('No contact group found', 'spothit'),
            'popup_infos'  =>  __(
                '<p>Sender name must be a minimum of 3 characters to be personalized and must not start with more than 3 consecutive digits before the first letter.</p>
                <p>The display of the sender name depends on the type of phone. For example, on some iPhones, spaces are removed. Moreover, accents and special characters are never show.</p>
                <p><strong>Metropolitan France</strong></p>
                <p>The NRJ Mobile operator does not take into account custom senders, they will be automatically replaced by a short number.
                To avoid any confusion for your contacts, it is preferable to specify the name of your shop also in the body of the message.
                The Free Mobile operator does not take into account sender customizations for SMS Marketing that do not include the mention STOP at 36xxx.
                They will automatically be replaced by a short number.</p><p><strong>International</strong></p><p>Some countries do not accept sender personalization.
                It is strongly advised to contact us in order to know the specificities of each country concerned.</p>',
                'spothit'
            ),
            'send_now'  =>  __('Send now', 'spothit'),
            'stop_sms'  =>  __('STOP at 36200', 'spothit'),
            'manual_recipients_info1'  =>  __('Please separate phone numbers with a "," or a line break.', 'spothit'),
            'manual_recipients_info2'  =>  __('Example : +33600000000,003360-00-00-00 , 6 00 00 00 00.', 'spothit'),
            'manual_recipients_placeholder'  =>  __('Insert your contacts list here', 'spothit'),

        ));
    }


    public static function settings()
    {
        wp_localize_script('settings_scripts', 'SH_plugin_translate', array(

            'key_param_title'  =>  __('Key parameters', 'spothit'),
            'sms_param_title'  =>  __('SMS parameters', 'spothit'),
            'email_param_title'  =>  __('Emails parameters', 'spothit'),
            'alerts_param_title'  =>  __('Alerts parameters', 'spothit'),
            'key_invalid'  =>  __('Invalid API key', 'spothit'),
            'key_insert'  =>  __('Please insert your new API key', 'spothit'),
            'phone_number_invalid'  =>  __('Invalid phone number', 'spothit'),
            'sender_name_long'  =>  __('Sender name is too long', 'spothit'),
            'sender_name_short'  =>  __('Sender name is too short', 'spothit'),
            'email_address_invalid'  =>  __('Incorrect Email address', 'spothit'),
            'sender_name_invalid'  =>  __('Incorrect sender name', 'spothit'),
            'saved_email_settings'  =>  __('Email parameters are saved !', 'spothit'),
            'saved_sms_settings'  =>  __('SMS parameters are saved !', 'spothit'),
            'recipient_email_invalid'  =>  __('Invalid contact email address', 'spothit'),
            'key_description'  =>  __('Changing your key does not change previous datas in any way recorded. If you wantto edit your informations, please refer to the SMS & Email settings.', 'spothit'),
            'sms_description'  =>  __('You can change your sender name directly for all of your SMS campaigns (including automatic campaigns) by editing the fields below.', 'spothit'),
            'email_description'  =>  __('Into the Email settings you can set your sender name and your email address for all email campaigns, including for automatic campaigns.', 'spothit'),
            'alerts_description'  =>  __('An alert will be sent to you according to the scale you have defined. You can enable or disable these alerts.', 'spothit'),
            'key_site_invalid'  =>  __('Invalid site key', 'spothit'),
            'key_secret_invalid'  =>  __('Invalid secret key', 'spothit'),
            'key_updated'  =>  __('Key is updated', 'spothit'),
            'group_updated'  =>  __('Group is updated', 'spothit'),
            'fail_group_update'  =>  __('Group cannot be updated', 'spothit'),
            'select_group'  =>  __('Select group', 'spothit'),
            'write_name_group'  =>  __('Write group name...', 'spothit'),
        ));
    }




    public static function automating()
    {
        wp_localize_script('automating_scripts', 'SH_plugin_translate', array(

            'msg_empty'  =>  __('Empty message field', 'spothit'),
            'subject_empty'  =>  __('Empty email subject', 'spothit'),
            'email_invalid'  =>  __('Invalid Email address', 'spothit'),
            'sender_name_short'  =>  __('Sender name is too short (min. 3 characters)', 'spothit'),
            'msg_short'  =>  __('Your message is too short', 'spothit'),
            'sender_name_long'  =>  __('Sender name is too long (max. 11 characters)', 'spothit'),
            'saved'  =>  __('Saved !', 'spothit'),
            'popup_infos'  =>  __('<p><strong>Important :</strong></p><p>Variables that we propose to you may not be functional. Indeed, depending on the configuration of your store, some variables may return an empty result. You are strongly advised to carry out tests before use.</p>', 'spothit'),
        ));
    }



    public static function login()
    {
        wp_localize_script('login_scripts', 'SH_plugin_translate', array(

            'correct_api'  =>  __('Correct API key, you will be redirected...', 'spothit'),
            'write_api'  =>  __('Please insert your API key', 'spothit')
        ));
    }

    public static function widget()
    {
        wp_localize_script('spothit_widget_scripts', 'SH_plugin_translate', array(

            'firstname_error'  =>  __('Firstname is not valid', 'spothit'),
            'lastname_error'  =>  __('Lastname is not valid', 'spothit'),
            'phone_error'  =>  __('Phone number is not valid', 'spothit'),
            'email_error'  =>  __('Email address is not valid', 'spothit'),
            'captcha_confirm'  =>  __('Please confirm captcha', 'spothit'),
            'send_success'  =>  __('Saved !', 'spothit'),
            'send_error'  =>  __('Error', 'spothit'),

        ));
    }
}
