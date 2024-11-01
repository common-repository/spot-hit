<?php

/**
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Cyril Bouxin
 * @copyright 2015-2022 NETSIZE
 * @license GNU General Public License version 2
 */

add_action('wp_ajax_nopriv_SH_ajax_api_request', 'SH_ajax_api_request');
add_action('wp_ajax_SH_ajax_api_request', 'SH_ajax_api_request');

add_action('wp_ajax_nopriv_Set__settings', 'Set__settings');
add_action('wp_ajax_Set__settings', 'Set__settings');

add_action('wp_ajax_nopriv_Set__settings_datas', 'Set__settings_datas');
add_action('wp_ajax_Set__settings_datas', 'Set__settings_datas');

add_action('wp_ajax_nopriv_Get__settings_datas', 'Get__settings_datas');
add_action('wp_ajax_Get__settings_datas', 'Get__settings_datas');

add_action('wp_ajax_nopriv_SH_ajax_get_customers_goup_list', 'SH_ajax_get_customers_goup_list');
add_action('wp_ajax_SH_ajax_get_customers_goup_list', 'SH_ajax_get_customers_goup_list');


add_action('wp_ajax_nopriv_SH_ajax_wordpress_customers_from_group', 'SH_ajax_wordpress_customers_from_group');
add_action('wp_ajax_SH_ajax_wordpress_customers_from_group', 'SH_ajax_wordpress_customers_from_group');

add_action('wp_ajax_nopriv_Update_hook_status', 'Update_hook_status');
add_action('wp_ajax_Update_hook_status', 'Update_hook_status');

add_action('wp_ajax_nopriv_Get__hook_status', 'Get__hook_status');
add_action('wp_ajax_Get__hook_status', 'Get__hook_status');

add_action('wp_ajax_nopriv_Set__hook_status', 'Set__hook_status');
add_action('wp_ajax_Set__hook_status', 'Set__hook_status');

add_action('wp_ajax_nopriv_Get__custom_sender', 'Get__custom_sender');
add_action('wp_ajax_Get__custom_sender', 'Get__custom_sender');

add_action('wp_ajax_nopriv_Set__custom_sender', 'Set__custom_sender');
add_action('wp_ajax_Set__custom_sender', 'Set__custom_sender');

add_action('wp_ajax_nopriv_Set__campaign_list', 'Set__campaign_list');
add_action('wp_ajax_Set__campaign_list', 'Set__campaign_list');

add_action('wp_ajax_nopriv_Set__alert_levels', 'Set__alert_levels');
add_action('wp_ajax_Set__alert_levels', 'Set__alert_levels');

add_action('wp_ajax_nopriv_Get__alert_levels', 'Get__alert_levels');
add_action('wp_ajax_Get__alert_levels', 'Get__alert_levels');

add_action('wp_ajax_nopriv_Get__hook_datas', 'Get__hook_datas');
add_action('wp_ajax_Get__hook_datas', 'Get__hook_datas');

add_action('wp_ajax_nopriv_Variables_list', 'Variables_list');
add_action('wp_ajax_Variables_list', 'Variables_list');

add_action('wp_ajax_nopriv_Characters_checker', 'Characters_checker');
add_action('wp_ajax_Characters_checker', 'Characters_checker');

add_action('wp_ajax_nopriv_Remove_version_notification', 'Remove_version_notification');
add_action('wp_ajax_Remove_version_notification', 'Remove_version_notification');


add_action('wp_ajax_nopriv_Get_All_Contacts_Groups', 'Get_All_Contacts_Groups');
add_action('wp_ajax_Get_All_Contacts_Groups', 'Get_All_Contacts_Groups');

add_action('wp_ajax_nopriv_Save_Widget_Group', 'Save_Widget_Group');
add_action('wp_ajax_Save_Widget_Group', 'Save_Widget_Group');

add_action('wp_ajax_nopriv_Save_Widget_Key', 'Save_Widget_Key');
add_action('wp_ajax_Save_Widget_Key', 'Save_Widget_Key');

add_action('wp_ajax_nopriv_CaptchaCheckout', 'CaptchaCheckout');
add_action('wp_ajax_CaptchaCheckout', 'CaptchaCheckout');

add_action('wp_ajax_nopriv_WidgetSaveContact', 'WidgetSaveContact');
add_action('wp_ajax_WidgetSaveContact', 'WidgetSaveContact');





function SH_ajax_get_customers_goup_list()
{

    global $wp_roles;

    $response_html = '';

    $roles = $wp_roles->get_names();

    foreach ($roles as $role) {
        $args = array(
            'role' => $role
        );
        $users = get_users($args);

        $nb_users = 0;


        if (isset($_POST['type']) && !empty($_POST['type'])) {

            if ($_POST['type'] == 'sms') {
                foreach ($users as $user) {
                    $user_data = get_userdata($user->ID);
                    $user_phone = $user_data->user_phone;
                    if (!empty($user_phone)) {
                        $nb_users = $nb_users + 1;
                    } elseif (empty($user_phone) && is_plugin_active('woocommerce/woocommerce.php')) {

                        $customer = new WC_Customer($user->ID);
                        $customer_phone = $customer->get_billing_phone();

                        if (isset($customer_phone) && !empty($customer_phone)) {
                            $nb_users = $nb_users + 1;
                        }
                    }
                }
                if ($nb_users >= 1) {
                    $response_html .= <<<HTML
                            <div class="col-md-3">
                                <label class="multi_select_label">
                                            <input type="checkbox" class="contact_checkbox" value="{$role}">
                                            <div class="multi_select_label_content">
                                                <span>{$role}</span>
                                                <span class="badge total_group">{$nb_users}</span>
                                            </div>
                                        </label>
                                    </div>
HTML;
                }
            } elseif ($_POST['type'] == 'email') {
                foreach ($users as $user) {
                    $user_data = get_userdata($user->ID);
                    $user_email = $user_data->user_email;
                    if (!empty($user_email)) {
                        $nb_users = $nb_users + 1;
                    } elseif (empty($user_email) && is_plugin_active('woocommerce/woocommerce.php')) {

                        $customer = new WC_Customer($user->ID);
                        $customer_email = $customer->get_email();

                        if (isset($customer_email) && !empty($customer_email)) {
                            $nb_users = $nb_users + 1;
                        }
                    }
                }
                if ($nb_users >= 1) {
                    $response_html .= <<<HTML
                            <div class="col-md-3">
                                <label class="multi_select_label">
                                            <input type="checkbox" class="contact_checkbox" value="{$role}">
                                            <div class="multi_select_label_content">
                                                <span>{$role}</span>
                                                <span class="badge total_group">{$nb_users}</span>
                                            </div>
                                        </label>
                                    </div>
HTML;
                }
            }
        }
    }
    echo ($response_html);
    wp_die();
}

function Set__settings()
{
    global $wpdb;
    global $config;

    $key = '';
    $error_state = 1;

    if (isset($_POST['api_key'])) {
        $key = $_POST['api_key'];
    } else {
        $key = $config['api_key'];
    }

    $key = preg_replace('/\s+/', '', $key);

    if (!empty($key)) {
        $body = array(
            'from' => 'wordpress_v2',
            'rest' => '1',
            'key' => $key,
        );


        $url = 'https://www.spot-hit.fr/api/informations';

        $args = array(
            'method' => 'POST',
            'headers' => array(),
            'body' => $body
        );

        $response = wp_remote_post($url, $args);
        $response_json = $response['body'];

        $response_array = json_decode($response_json, true);
        if (!isset($response_array['resultat']) || $response_array['resultat'] === 1) {

            $db_request = $wpdb->get_results(
                "SELECT sh_key, sh_value FROM " . $wpdb->prefix . "spothit_settings"
            );


            global $wpdb;

            $db_settings = $wpdb->prefix . 'spothit_settings';
            $db_hooks_meta = $wpdb->prefix . 'spothit_hooks_meta';




            foreach ($db_request as $value) {
                switch ($value->sh_key) {

                    case 'api_key':
                        if (
                            empty($value->sh_value) || (!empty($value->sh_value) && $value->sh_value != $key)
                        ) {

                            $wpdb->query(
                                "UPDATE  $db_settings
                                        SET sh_value = '$key'
                                        WHERE sh_key = 'api_key'"
                            );
                            $error_state = 0;
                            $error = __("You are logged ! Please wait, you will be redirected", 'spothit');
                        } else {
                            $error_state = 1;
                            $error = __("API key cannot be registred", "spothit");
                        }
                        break;

                    case 'phone_number':

                        if (empty($value->sh_value) && isset($response_array['phone_number']) || (!empty($value->sh_value) && $value->sh_value != $response_array['phone_number'])) {
                            if ($value->sh_value != $response_array['phone_number']) {
                                $wpdb->query(
                                    "UPDATE  $db_settings
                                            SET sh_value = '" . $response_array['phone_number'] . "'
                                            WHERE sh_key = 'phone_number'"
                                );
                            }
                        }
                        break;
                    case 'email_address':
                        if (empty($value->sh_value) && isset($response_array['email_address'])  || (!empty($value->sh_value) && $value->sh_value != $response_array['email_address'])) {
                            if ($value->sh_value != $response_array['email_address']) {
                                $wpdb->query(
                                    "UPDATE  $db_settings
                                        SET sh_value = '" . $response_array['email_address'] . "'
                                        WHERE sh_key = 'email_address'"
                                );
                            };
                        }
                        break;
                    case 'sms_sender':
                        if (empty($value->sh_value) && isset($response_array['first_name'])  || (!empty($value->sh_value) && $value->sh_value != $response_array['first_name'])) {
                            if ($value->sh_value != $response_array['first_name']) {
                                $wpdb->query(
                                    "UPDATE  $db_settings
                                        SET sh_value = '" . $response_array['first_name'] . "'
                                        WHERE sh_key = 'sms_sender'"
                                );
                            }
                        }
                        break;

                    case 'email_sender':
                        if (empty($value->sh_value) && isset($response_array['first_name'])  || (!empty($value->sh_value) && $value->sh_value != $response_array['first_name'])) {
                            if ($value->sh_value != $response_array['phone_number']) {
                                $wpdb->query(
                                    "UPDATE  $db_settings
                                        SET sh_value = '" . $response_array['first_name'] . "'
                                        WHERE sh_key = 'email_sender'"
                                );
                            }
                        }
                        break;
                }
            }
        } else {
            $error_state = 1;
            $error = $response_array['erreurs'];
        }
    } else {
        $error_state = 1;
        $error = __('Please write your key in the field', 'spothit');
    }

    echo json_encode(array(
        'error_message' => $error,
        'error_state' => $error_state
    ));
    wp_die();
}

function SH_ajax_api_request()
{
    global $wpdb;
    global $config;

    $url = $_POST['url_api'];
    $datas = $_POST['data'];

    if ($config['api_key']) {
        $key = $config['api_key'];
    }

    switch ($url) {

        case 'login':
            $login_state = 0;

            $key = $datas['value'];
            $request = call_ajax($datas, 'credits', $key);
            $request = json_decode($request, true);

            if ($request['resultat'] == true) {
                $db = $wpdb->get_results(
                    "SELECT sh_key FROM " . $wpdb->prefix . "spothit_settings WHERE sh_key = 'api_key'"
                );

                if (isset($db) && !empty($db)) {
                    $wpdb->query(
                        "UPDATE " . $wpdb->prefix . "spothit_settings
                            SET sh_value = '" . $key . "'
                            WHERE sh_key = 'api_key'"
                    );
                    $err_msg = __('API key has been changed !', 'spothit');
                } else {
                    $login_state = 1;
                    $err_msg = __('Unable to save API key !', 'spothit');
                }
            } else {
                $login_state = 1;
                $err_msg = __('Invalide API key !', 'spothit');
            }

            $results['state'] = $login_state;
            $results['msg'] = $err_msg;

            echo json_encode($results);
            break;

        case 'groupe/lister':
            $response_html = '';
            $request = call_ajax('', 'groupe/lister', $key);
            $request = json_decode($request, true);
            foreach ($request as $group) {
                $data_group = [];
                $contacts_list = '';
                $type = $datas;
                $group_name = $group['groupe'];
                $group_id = $group['id'];
                $nb_contacts = 0;

                if ($type == 'sms') {
                    array_push($data_group, array(
                        'name' => 'groupe',
                        'value' => $group_id,
                    ));
                    $request_users = call_ajax($data_group, 'contacts/get', '');
                    $request_users = json_decode($request_users, true);
                    foreach ($request_users as $user) {
                        if (!empty($user['numero'])) {
                            if (!str_contains($contacts_list, $user['numero'])) {
                                $nb_contacts++;
                            }
                        }
                    }
                } elseif ($type == 'email') {
                    array_push($data_group, array(
                        'name' => 'groupe',
                        'value' => $group_id,
                    ));
                    $request_users = call_ajax($data_group, 'contacts/get', $key);
                    $request_users = json_decode($request_users, true);
                    foreach ($request_users as $user) {
                        if (!empty($user['email'])) {
                            if (!str_contains($contacts_list, $user['email'])) {
                                $contacts_list .= $user['email'];
                                $nb_contacts++;
                            }
                        }
                    }
                }

                if ($nb_contacts >= 1) {
                    $response_html .= <<<HTML

                    <div class="col-md-3">
                        <label class="multi_select_label">
                            <input type="checkbox" class="contact_checkbox" value="{$group_id}">
                            <div class="multi_select_label_content">
                                <span>{$group_name}</span>
                                <span class="badge total_group">{$nb_contacts}</span>
                            </div>
                        </label>
                    </div>
    HTML;
                }
            }
            echo ($response_html);

            break;
        case 'client/tarifs':
            $type = $datas;

            $response = call_ajax('', 'client/tarifs', $key);
            echo $response;

            break;

        case 'medias/lister':
            $response_html = '';
            $request = call_ajax($datas, 'medias/lister', $key);
            $request = json_decode($request, true);

            foreach ($request as $value) {
                if ($value['output'] == 1) {
                    $response_html .= <<<HTML
                        <div class="col-md-3 text-center mb-3">
                            <input type="radio" class="radio_choice" id="{$value['id']}" value="{$value['id']}" name="model_select">
                            <label class="multi_box_label h-100" for="{$value['id']}">
                                <div>
                                    <div><img class="thumbnail_model" data-thumbnail="{$value['id']}" src="{$value['thumbnail']}" style="max-height: 200px; width: 160px"></div>
                                    <p><span>{$value['name']}</span></p>
                                </div>
                            </label>
                        </div>

HTML;
                }
            }
            echo ($response_html);
            break;
        case 'envoyer/sms':
            $datas_list = [];

            $campaign_name = '';
            $campaign_sender = '';
            $campaign_date = '';
            $campaign_message = '';
            $campaign_recipients = '';

            foreach ($datas as $data) {
                $data_name = ($data['name']);
                $data_value = ($data['value']);

                if ($data_name == 'nom') {
                    $campaign_name = $data['value'];
                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_name,
                    ));
                }

                if ($data_name == 'message') {
                    $campaign_message = $data['value'];

                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_message,
                    ));

                    if (strlen($campaign_message) > 160) {
                        array_push($datas_list, array(
                            'name' => 'smslong',
                            'value' => '1',
                        ));
                    }
                }
                if ($data_name == 'date') {
                    $campaign_date = $data['value'];

                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_date,
                    ));
                }
                if ($data_name == 'expediteur') {
                    $campaign_sender = $data['value'];

                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_sender,
                    ));
                }

                if ($data_name == 'destinataires') {

                    switch ($data['type']) {

                        case 'wordpress':
                            $groups = $data['group_list'];
                            foreach ($groups as $role) {
                                $args = array(
                                    'role'    => $role,
                                );
                                $users = get_users($args);

                                foreach ($users as $user) {

                                    $id = $user->id;

                                    $customer = new WC_Customer($id);
                                    $customer_phone   = $customer->get_billing_phone();
                                    if ($customer_phone != '' && $customer_phone != null && $customer_phone != ' ') {
                                        $campaign_recipients .= $customer_phone . ',';
                                    }
                                }

                                $campaign_recipients   = str_replace(array(
                                    '\'',
                                    '/',
                                    '"',
                                    '"',
                                    ';',
                                    '<',
                                    '>',
                                    ' '
                                ), '', $campaign_recipients);
                            }
                            array_push($datas_list, array(
                                'name' => $data_name,
                                'value' => $campaign_recipients,
                            ));

                            break;


                        case 'spothit':
                            $groups = $data['group_list'];
                            array_push($datas_list, array(
                                'name' => $data_name,
                                'value' => $groups,
                            ));
                            array_push($datas_list, array(
                                'name' => 'destinataires_type',
                                'value' => 'groupe',
                            ));

                            break;
                        case 'manual':

                            $campaign_recipients = $data['value'];

                            $campaign_recipients   = str_replace(array(
                                '/',
                                '"',
                                '"',
                                ';',
                                '<',
                                '>',
                                ' '
                            ), '', $campaign_recipients);
                            $campaign_recipients   = str_replace(
                                array(
                                    '\'',
                                    "\n"
                                ),
                                ",",
                                $campaign_recipients
                            );

                            array_push($datas_list, array(
                                'name' => $data_name,
                                'value' => $campaign_recipients,
                            ));
                            break;
                    }
                }
            }

            $request = call_ajax($datas_list, $url, $key);
            echo ($request);
            break;

        case 'envoyer/e-mail':
            $datas_list = [];

            $campaign_name = '';
            $campaign_recipients = '';

            foreach ($datas as $data) {
                $data_name = ($data['name']);
                $data_value = ($data['value']);

                if ($data_name == 'nom') {
                    $campaign_name = $data_value;
                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_name,
                    ));
                }

                if ($data_name == 'message') {
                    $campaign_message = $data_value;
                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_message,
                    ));
                }

                if ($data_name == 'type_message') {
                    $messag_type = $data_value;
                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $messag_type,
                    ));
                }

                if ($data_name == 'sujet') {
                    $campaign_object = $data_value;

                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_object,
                    ));
                }
                if ($data_name == 'date') {
                    $campaign_date = $data_value;

                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_date,
                    ));
                }
                if ($data_name == 'expediteur') {
                    $campaign_sender = $data_value;

                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_sender . '@sh-mail.fr',
                    ));
                }
                if ($data_name == 'nom_expediteur') {
                    $campaign_name_sender = $data_value;

                    array_push($datas_list, array(
                        'name' => $data_name,
                        'value' => $campaign_name_sender,
                    ));
                }

                if ($data_name == 'destinataires') {

                    switch ($data['type']) {
                        case 'wordpress':
                            $recipients_list = '';
                            $groups = $data['group_list'];
                            foreach ($groups as $role) {
                                $args = array(
                                    'role'    => $role,
                                );
                                $users = get_users($args);

                                foreach ($users as $user) {
                                    $user_datas = $user->data;

                                    $user_id = $user_datas->ID;
                                    $user_email = $user_datas->user_email;

                                    if (!isset($user_email) || empty($user_email)) {
                                        if (is_plugin_active('woocommerce/woocommerce.php')) {
                                            $customer = new WC_Customer($user_id);
                                            if (isset($customer)) {
                                                $user_email = $customer->get_email();
                                                if (!empty($user_email)) {
                                                    $recipients_list .=  $user_email . ',';
                                                }
                                            }
                                        }
                                    } else {
                                        $recipients_list .=  $user_email . ',';
                                    }
                                }
                            }
                            array_push($datas_list, array(
                                'name' => $data_name,
                                'value' => $recipients_list,
                            ));

                            break;


                        case 'spothit':
                            $groups = $data['group_list'];
                            array_push($datas_list, array(
                                'name' => $data_name,
                                'value' => $groups,
                            ));
                            array_push($datas_list, array(
                                'name' => 'destinataires_type',
                                'value' => 'groupe',
                            ));

                            break;
                        case 'manual':

                            $campaign_recipients = $data_value;

                            $campaign_recipients   = str_replace(array(
                                '/',
                                "'",
                                '"',
                                ';',
                                '<',
                                '>',
                                ' '
                            ), '', $campaign_recipients);
                            $campaign_recipients   = str_replace(
                                array(
                                    '\'',
                                    "\n"
                                ),
                                ",",
                                $campaign_recipients
                            );

                            $campaign_recipients = explode(',', $campaign_recipients);
                            $valid_recipients_list = '';
                            foreach ($campaign_recipients as $recipient) {
                                if (!empty($recipient) && str_contains($recipient, '@') && str_contains($recipient, '.')) {
                                    $valid_recipients_list .= $recipient . ',';
                                }
                            }

                            array_push($datas_list, array(
                                'name' => $data_name,
                                'value' => $valid_recipients_list,
                            ));

                            break;
                    }
                }
            }

            $request = call_ajax($datas_list, $url, $key);
            echo $request;
            break;
    }
    wp_die();
}

function call_ajax($datas, $url, $key)
{
    $body = array(
        'from' => 'wordpress_v2',
        'rest' => '1',
    );

    if ($key == '' || $key == null) {
        global $config;
        $key = $config['api_key'];
    }
    $body['key'] = $key;

    $url = 'https://www.spot-hit.fr/api/' . $url;
    if ($datas != '' || $datas != null) {
        foreach ($datas as $data) {
            $body[$data['name']] = $data['value'];
        };
    }

    $args = array(
        'method' => 'POST',
        'headers' => array(),
        'body' => $body
    );

    $response = wp_remote_post($url, $args);
    $reponse_json = $response['body'];

    return ($reponse_json);
    wp_die();
}

function Update_hook_status()
{
    global $wpdb;
    $name = $_POST['hook_name'];
    $type = 'status_' . $_POST['hook_type'];
    $role = $_POST['hook_role'];
    $state = $_POST['switch_action'];


    $table_name = $wpdb->prefix . 'spothit_hooks';

    $wpdb->query(
        "UPDATE `$table_name` SET `$type`='$state' WHERE `hook_name` = '$name' AND `hook_type` = '$role'"
    );

    wp_die();
}

function Get__custom_sender()
{
    global $wpdb;
    $type = $_POST['type'];
    if ($type == 'sms') {
        $db_request = $wpdb->get_results(
            "SELECT * FROM " . $wpdb->prefix . "spothit_settings WHERE sh_key = 'sms_sender_name' OR sh_key = 'phone_number' "
        );
    } elseif ($type == 'email') {
        $db_request = $wpdb->get_results(
            "SELECT * FROM " . $wpdb->prefix . "spothit_settings WHERE sh_key = 'email_address'  OR sh_key = 'sending_email_address' OR sh_key = 'sending_email_name'"
        );
    }
    echo (json_encode($db_request));
    wp_die();
}

function Set__custom_sender()
{
    global $wpdb;
    $key_name = $_POST['type'];
    $new_value = $_POST['input_value'];

    $wpdb->query(
        "UPDATE " . $wpdb->prefix . "spothit_settings
                    SET sh_value = '" . $new_value . "'
                    WHERE sh_key = '" . $key_name . "'"
    );

    wp_die();
}

function Set__settings_datas()
{
    global $wpdb;

    if ($_POST['type'] == 'email') {

        $email_sender = $_POST['email_sender'];
        $email_send_address = $_POST['email_send_address'];
        $email_recieve_address = $_POST['email_recieve_address'];
        $automating_state = $_POST['auto_state'];


        if (isset($email_sender) && !empty($email_sender)) {
            $wpdb->query(
                "UPDATE " . $wpdb->prefix . "spothit_settings
                SET sh_value = '" . $email_sender . "'
                WHERE sh_key = 'sending_email_name'"
            );

            if ($automating_state === 'true') {
                $wpdb->query(
                    "UPDATE " . $wpdb->prefix . "spothit_hooks_meta
                SET sender_name = '" . $email_sender . "'
                WHERE type = 'email'"
                );
            }
        }

        if (isset($email_send_address) && !empty($email_send_address)) {

            $meta = $wpdb->prefix . 'spothit_hooks_meta';
            $hooks = $wpdb->prefix . 'spothit_hooks';

            $wpdb->query(
                "UPDATE " . $wpdb->prefix . "spothit_settings
                SET sh_value = '" . $email_send_address . "'
                WHERE sh_key = 'sending_email_address'"
            );

            if ($automating_state === 'true') {
                $wpdb->query("UPDATE $meta hooks_meta JOIN $hooks hooks SET hooks_meta.sender = '" . $email_send_address . "'  WHERE hooks.id = hooks_meta.parent_id AND hooks_meta.type = 'email'");
            }
        }


        if (isset($email_recieve_address) && !empty($email_recieve_address)) {
            $hooks = $wpdb->prefix . 'spothit_hooks';

            $wpdb->query(
                "UPDATE " . $wpdb->prefix . "spothit_settings
                SET sh_value = '" . $email_recieve_address . "'
                WHERE sh_key = 'email_address'"
            );
        }
    }

    if ($_POST['type'] == 'sms') {

        $sms_sender = $_POST['sms_sender'];
        $sms_number = $_POST['sms_number'];
        $automating_state = $_POST['auto_state'];

        if (isset($sms_sender) && !empty($sms_sender)) {
            $wpdb->query(
                "UPDATE " . $wpdb->prefix . "spothit_settings
                SET sh_value = '" . $sms_sender . "'
                WHERE sh_key = 'sms_sender_name'"
            );

            if ($automating_state == 'true') {
                $wpdb->query(
                    "UPDATE " . $wpdb->prefix . "spothit_hooks_meta
                    SET sender_name = '" . $sms_sender . "'
                    WHERE type = 'sms'"
                );
            }
        }
        if (isset($sms_number) && !empty($sms_number)) {
            $wpdb->query(
                "UPDATE " . $wpdb->prefix . "spothit_settings
                SET sh_value = '" . $sms_number . "'
                WHERE sh_key = 'phone_number'"
            );
        }
    }
}

// function dump($data)
// {
//     echo '<pre style=" padding-right: 2em; z-index:9999; border: solid 2px greenyellow;">' . print_r($data, true) . '</pre>';
// }

function Get__hook_status()
{
    global $wpdb;

    $datas = $_POST['hook'][0];

    if ($datas) {
        $hook_name = ($datas['hook_name']);
        $hook_role = ($datas['hook_role']);

        $db = $wpdb->get_results(
            "SELECT id, status_sms, status_email  FROM " . $wpdb->prefix . "spothit_hooks WHERE hook_name = '" . $hook_name . "' AND hook_type = '" . $hook_role . "'"
        );
        $results = $db[0];

        $id = $results->id;
        $status_sms = $results->status_sms;
        $status_email = $results->status_email;

        if (isset($status_sms) && !empty($status_sms)) {
            $datas_sms = $wpdb->get_results(
                "SELECT message, sender  FROM " . $wpdb->prefix . "spothit_hooks_meta WHERE parent_id = '" . $id . "' AND type = 'sms'"
            );
        }

        echo json_encode(
            array(
                'status_sms' => $status_sms,
                'status_email' => $status_email,
            )
        );
    }
    if (isset($_POST['switch_hook'][0])) {
        $switch_hook = $_POST['switch_hook'][0];

        $hook_name = ($switch_hook['hook_name']);
        $hook_role = ($switch_hook['hook_role']);
        $hook_role = ($switch_hook['hook_type']);

        $db = $wpdb->get_results(
            "SELECT id, status_sms, status_email  FROM " . $wpdb->prefix . "spothit_hooks WHERE hook_name = '" . $hook_name . "' AND hook_type = '" . $hook_role . "'"
        );
        $results = $db[0];
    }
    wp_die();
}

function Get__hook_datas()
{
    global $wpdb;
    $datas = [];

    if (isset($_POST['hookname']) && isset($_POST['hookrole']) && isset($_POST['hooktype'])) {
        $hook_name = $_POST['hookname'];
        $hook_role = $_POST['hookrole'];
        $hook_type = $_POST['hooktype'];
        $id = $wpdb->get_results(
            "SELECT id FROM " . $wpdb->prefix . "spothit_hooks WHERE hook_name = '" . $hook_name . "' AND hook_type = '" . $hook_role . "'"
        );
        $id = $id[0]->id;

        if ($hook_type == 'sms') {
            $datas = $wpdb->get_results(
                "SELECT message, sender_name  FROM " . $wpdb->prefix . "spothit_hooks_meta WHERE parent_id = '" . $id . "' AND type = 'sms'"
            );
            if (!empty($datas[0]) && isset($datas[0])) {
                $message = $datas[0]->message;
                $sender_name = $datas[0]->sender_name;
                echo json_encode(
                    array(
                        'sender_name' => $sender_name,
                        'message' => $message
                    )
                );
            }
        } elseif ($hook_type == 'email') {
            $datas = $wpdb->get_results(
                "SELECT message, sender, sender_name, object  FROM " . $wpdb->prefix . "spothit_hooks_meta WHERE parent_id = '" . $id . "' AND type = 'email'"
            );
            if (!empty($datas[0]) && isset($datas[0])) {
                $message = $datas[0]->message;
                $sender_address = $datas[0]->sender;
                $sender_name = $datas[0]->sender_name;
                $email_object = $datas[0]->object;
                echo json_encode(
                    array(
                        'sender_name' => $sender_name,
                        'sender_address' => $sender_address,
                        'object' => $email_object,
                        'message' => $message
                    )
                );
            }
        }
    }
    if (isset($_POST['select']) && $_POST['select'] == 'all') {

        $datas = $wpdb->get_results(
            "SELECT message, sender, object  FROM " . $wpdb->prefix . "spothit_hooks_meta"
        );

        if (!empty($datas) && isset($datas)) {
            echo json_encode($datas);
        }
    }

    // global $wpdb;

    // $db = $wpdb->get_results(
    //     "SELECT message, sender  FROM " . $wpdb->prefix . "spothit_hooks_meta WHERE parent_id = '" . $id . "' AND type = '" . $type . "'"
    // );
    wp_die();
}

function Set__hook_status()
{
    global $wpdb;

    $db_hooks = $wpdb->prefix . 'spothit_hooks';
    $db_hooks_meta = $wpdb->prefix . 'spothit_hooks_meta';


    $datas = $_POST['data'];

    foreach ($datas as $value) {
        if (isset($value['hook_name'])) {
            $hook_name = $value['hook_name'];
        }
        if (isset($value['hook_role'])) {
            $hook_role = $value['hook_role'];
        }
        if (isset($value['hook_type'])) {
            $hook_type = $value['hook_type'];
        }
        if (isset($value['message'])) {
            $message = $value['message'];
        }
        if (isset($value['sender_name'])) {
            $sender_name = $value['sender_name'];
        }
        if (isset($value['email_address'])) {
            $sender_email_address = $value['email_address'];
        }
        if (isset($value['email_object'])) {
            $email_object = $value['email_object'];
        }
    }

    $db_hooks_list = $wpdb->get_results(
        "SELECT id FROM $db_hooks WHERE hook_name = '" . $hook_name . "' AND hook_type = '" . $hook_role . "'"
    );
    $parent_id = $db_hooks_list[0]->id;

    if ($hook_type == 'sms') {
        $wpdb->query(
            "UPDATE  $db_hooks_meta
            SET message = '" . $message . "', sender_name = '" . $sender_name . "'
            WHERE parent_id = '$parent_id' AND type = '$hook_type'"
        );
        echo 'ok sms';
    } elseif ($hook_type == 'email') {
        $wpdb->query(
            "UPDATE  $db_hooks_meta
            SET message = '" . $message . "', sender_name = '" . $sender_name . "', object = '" . $email_object . "', sender = '" . $sender_email_address . "'
            WHERE parent_id = '$parent_id' AND type = '$hook_type'"
        );

        echo 'ok email';
    } else {
        echo 'pas ok !';
    }

    wp_die();
}

function Set__campaign_list()
{
    $to_html = '';

    $sms_list = Get__campaign_list('sms');
    $email_list = Get__campaign_list('email');

    $results = array_merge($sms_list, $email_list);

    usort($results, function ($a, $b) {
        return $b[4] - $a[4];
    });
    if (isset($_POST['nbr'])) {
        $nbr = $_POST['nbr'];
    } else {
        $nbr = count($results);
    }

    for ($i = 0; $i < $nbr; $i++) {
        $element = $results[$i];
        $campaign_id = $element[0];
        $campaign_message = $element[1];
        $campaign_recipient_nbr = $element[3];
        $campaign_status = $element[5];
        $campaign_sender = $element[6];
        $campaign_type = $element[7];
        $campaign_name = $element[9];

        if (!isset($campaign_name) || empty($campaign_name)) {
            $campaign_name = __('Campaign: ', 'spothit') . $campaign_id;
            if (empty($campaign_id)) {
                $campaign_name = __('Campaign not found', 'spothit');
            }
        }
        if ($campaign_recipient_nbr > 1) {
            $campaign_recipient_nbr = $campaign_recipient_nbr  . ' ' . __('contacts', 'spothit');
        } elseif ($campaign_recipient_nbr == 1) {
            $campaign_recipient_nbr = $campaign_recipient_nbr . ' ' . __('contact', 'spothit');
        } elseif ($campaign_recipient_nbr <= 0) {
            $campaign_recipient_nbr = __('No contact', 'spothit');
        }

        switch ($campaign_status) {
            case '0':
                $campaign_status = __('Pending', 'spothit');
                break;

            case '1':
                $campaign_status = __('In progress', 'spothit');
                break;

            case '2':
                $campaign_status = __('Success', 'spothit');
                break;

            case '3':
                $campaign_status = __('Failed', 'spothit');
                break;

            default:
                $campaign_status = __('Error', 'spothit');
                break;
        };

        switch ($campaign_type) {
            case 'premium':
                $campaign_type = '<i class="fa-thin fa-mobile-screen"></i>';
                break;

            case 'html':
                $campaign_type = '<i class="fa-thin fa-envelope"></i>';
                break;
            default:
                $campaign_type = '<i class="fa-solid fa-triangle-exclamation"></i>';
                break;
        };

        if ($campaign_status == __('Error', 'spothit') || $campaign_status == __('Failed', 'spothit')) {
            $state_html_line = '<span class="campaign_list_status bg-danger">' .  $campaign_status . '</span>';
        } else {
            $state_html_line = '<span class="campaign_list_status success-status">' . $campaign_status . '</span>';
        }


        $to_html .= <<<HTML

        <li>
            <span class="campaign_list_type">{$campaign_type}</span>
            <span class="campaign_list_name">{$campaign_name}</span>
            <span class="campaign_list_recipient">{$campaign_recipient_nbr}</span>
            {$state_html_line}
    </li>
HTML;
    }

    echo $to_html;
    wp_die();
}

function Set__alert_levels()
{
    global $credits;
    $state = $_POST['state'];


    $body = array(
        'from' => 'wordpress_v2',
        'rest' => '1',
        'key' =>  $credits['key'],
        'alerts' => $state
    );

    $url = 'https://www.spot-hit.fr/api/client/alerts/set';

    $args = array(
        'method' => 'POST',
        'headers' => array(),
        'body' => $body
    );

    $response = wp_remote_post($url, $args);
    wp_die();
}

function Get__alert_levels()
{
    global $alert_levels;

    $alerts_arr = [
        'state' => $alert_levels['alerts'],
        'sms' => $alert_levels['sms'],
        'email' => $alert_levels['email'],
    ];

    echo json_encode($alerts_arr);
    wp_die();
}

function Get__campaign_list($product_type)
{
    global $credits;


    $current_time = time();
    $last_year_time = strtotime('-1 year', $current_time);
    $url = 'campaign/list';
    $key = $credits['key'];
    $datas_request = [];
    $datas_list = [];

    array_push($datas_request, array(
        'name' => 'date_start',
        'value' => $last_year_time,
    ));

    array_push($datas_request, array(
        'name' => 'date_end',
        'value' => $current_time
    ));

    array_push($datas_request, array(
        'name' => 'product',
        'value' => $product_type,
    ));


    $list = call_ajax($datas_request, 'campaign/list', $key);
    $list = json_decode($list);
    return $list;

    wp_die();
}

function Characters_checker()
{
    $msg = $_POST['message'];
    $url = 'https://www.spot-hit.fr/api/nombre_caracteres';
    $body = array(
        'from' => '_v2',
        'rest' => '1',
        'message' => $msg
    );
    $args = array(
        'method' => 'POST',
        'headers' => array(),
        'body' => $body,
    );

    $response = wp_remote_post($url, $args);
    $reponse_json = $response['body'];
    // echo (json_encode($reponse_json));

    echo $reponse_json;

    wp_die();
}

function Variables_list()
{

    $type = $_POST['data'];
    $to_HTML = '';


    $var__new_user = [
        'user_ID' => __('User ID', 'spothit'),
        'user_nicename' =>  __('User nickname', 'spothit'),
        'user_email' =>  __('User email', 'spothit'),
        'user_display_name' =>  __('Username', 'spothit'),
    ];

    $var__order_infos = [
        'data_id' =>  __('Order ID', 'spothit'),
        'data_customer_id' =>  __('User ID', 'spothit'),
        'data_status' =>  __('Order status', 'spothit'),
        'data_discount_total' =>  __('Total - Discounts', 'spothit'),
        'data_shipping_total' =>  __('Total - Shipping', 'spothit'),
        'data_total' =>  __('Total - Order', 'spothit'),
        'data_payment_method_title' =>  __('Payment method', 'spothit'),
        'data_currency' =>  __('Currency', 'spothit'),

        'billing_first_name' =>  __('Billing name', 'spothit'),
        'billing_last_name' =>  __('Billing first name', 'spothit'),
        'billing_address_1' =>  __('Billing address 1', 'spothit'),
        'billing_address_1' =>  __('Billing address 2', 'spothit'),
        'billing_city' =>  __('Billing city', 'spothit'),
        'billing_postcode' =>  __('Billing postcode', 'spothit'),
        'billing_country' =>  __('Billing country', 'spothit'),
        'billing_email' =>  __('Billing email', 'spothit'),
        'billing_phone' =>  __('Billing telephone number', 'spothit'),

        'shipping_first_name' =>  __('Recipient name', 'spothit'),
        'shipping_last_name' =>  __('Recipient first Name', 'spothit'),
        'shipping_address_1' =>  __('Recipient address 1', 'spothit'),
        'shipping_address_2' =>  __('Recipient address 2', 'spothit'),
        'shipping_city' =>  __('Recipient city', 'spothit'),
        'shipping_postcode' =>  __('Recipient postcode', 'spothit'),
        'shipping_country' =>  __('Recipient country', 'spothit'),

        'items_total_selected_products' =>  __('Total of selected products', 'spothit'),
        'items_total_quantity' =>  __('Total of products purchased', 'spothit'),
        'items_name_quantity' =>  __('List of product names with quantity (example : First product x 2, Second product x 1, Third product x 1)', 'spothit'),
        'items_id_list' =>  __('List of product ID (example : 22, 107, 35)', 'spothit'),
        'items_names_list' =>  __('List of product names (example : First product, Second product, Third product)', 'spothit')
    ];

    switch ($type) {
        case '1':
            foreach ($var__new_user as $name => $description) {
                $to_HTML .= '<option value="' . $name . '" data-subtext="' . $description . '">' . $name . '</option>';
            }
            echo $to_HTML;
            break;

        case '2':
            foreach ($var__new_user as $name => $description) {
                $to_HTML .= '<option value="' . $name . '" data-subtext="' . $description . '">' . $name . '</option>';
            }
            foreach ($var__order_infos as $name => $description) {
                $to_HTML .= '<option value="' . $name . '" data-subtext="' . $description . '">' . $name . '</option>';
            }
            echo $to_HTML;
            break;
    }
}




function Remove_version_notification()
{
    global $wpdb;
    global $db_settings;
    $type = $_POST['data'] . '_error';
    $wpdb->query(
        "UPDATE `$db_settings` SET `sh_value`='0' WHERE `sh_key` = '$type'"
    );
    return json_encode('Notification désactivée');
    wp_die();
}

function Save_Widget_Group()
{
    global $credits;
    global $wpdb;
    $database = $wpdb->prefix . "spothit_settings";

    $data = $_POST['data'];
    $group_type = $data['group_type'];

    if ($group_type == 0) {
        $group_id = $data['group_id'];
        $group_name = $data['group_name'];
        $wpdb->query(
            "UPDATE  $database SET sh_value = '$group_id' WHERE sh_key = 'widget_group_id'"
        );
        $wpdb->query(
            "UPDATE  $database SET sh_value = '$group_name' WHERE sh_key = 'widget_group_name'"
        );
        echo json_encode(array(
            'error_message' => 'ok',
            'error_state' => 0
        ));
    } else if ($group_type == 1) {
        $group_name = $data['group_name'];

        if (!empty($group_name)) {
            $body = array(
                'from' => 'wordpress_v2',
                'rest' => '1',
                'key' =>  $credits['key'],
                'nom' =>  $group_name
            );
            $request = wp_remote_post(
                'https://www.spot-hit.fr/api/groupe/creer',
                [
                    'method' => 'POST',
                    'body' => $body
                ]
            );
            $response = json_decode($request['body']);
            if (!empty($response->id)) {
                $group_id = $response->id;
                $wpdb->query(
                    "UPDATE  $database SET sh_value = '$group_id' WHERE sh_key = 'widget_group_id'"
                );
                $wpdb->query(
                    "UPDATE  $database SET sh_value = '$group_name' WHERE sh_key = 'widget_group_name'"
                );

                echo json_encode(array(
                    'error_message' => 'ok',
                    'error_state' => 0
                ));
            } else {
                echo json_encode(array(
                    'error_message' => 'Erreur lors de l\'enregistrement du groupe',
                    'error_state' => 1
                ));
            }
        } else {
            echo json_encode(array(
                'error_message' => 'Invalid group name',
                'error_state' => 1
            ));
        }
    }
    wp_die();
}

function Get_All_Contacts_Groups()
{
    global $credits;
    $body = array(
        'from' => 'wordpress_v2',
        'rest' => '1',
        'key' =>  $credits['key'],
    );

    $url = 'https://www.spot-hit.fr/api/groupe/lister';
    $args = array(
        'method' => 'POST',
        'headers' => array(),
        'body' => $body
    );
    $response = wp_remote_post($url, $args);
    $response = json_decode($response['body']);
    if (empty($response)) {
        echo json_encode(null);
    } else {
        echo json_encode($response);
    }
    wp_die();
}

function Save_Widget_Key()
{
    $errors = [];
    $error_state = 0;
    $data = $_POST['data'];

    $site_key = $data['site_key'];
    $secret_key = $data['secret_key'];


    if (empty($site_key) && empty($secret_key)) {
        $error_state = 1;
        array_push($errors, 'txt : Invalid wabsite key');
    } else {

        global $wpdb;
        $db = $wpdb->prefix . "spothit_settings";

        $wpdb->query(
            "UPDATE  $db SET sh_value = '$site_key' WHERE sh_key = 'captcha_site'"
        );
        $wpdb->query(
            "UPDATE  $db SET sh_value = '$secret_key' WHERE sh_key = 'captcha_secret'"
        );
    }

    echo json_encode(array(
        'error_message' => $errors,
        'error_state' => $error_state
    ));
    wp_die();
}

function WidgetSaveContact()
{
    global $wpdb;
    global $credits;

    $database_name = $wpdb->prefix . "spothit_settings";
    $database_request_group = $wpdb->get_results(
        "SELECT sh_value FROM $database_name WHERE sh_key = 'widget_group_id'"
    );

    $group_id = $database_request_group[0]->sh_value;

    $data = [];
    $data[0] = [];
    if (isset($_POST['data']['lastname'])) {
        $data[0]['nom'] = $_POST['data']['lastname'];
    }
    if (isset($_POST['data']['firstname'])) {
        $data[0]['prenom'] = $_POST['data']['firstname'];
    }
    if (isset($_POST['data']['email'])) {
        $data[0]['email'] = $_POST['data']['email'];
    }
    if (isset($_POST['data']['mobile'])) {
        $data[0]['mobile'] = $_POST['data']['mobile'];
    }

    $body = array(
        'from' => 'wordpress_v2',
        'rest' => '1',
        'key' =>  $credits['key'],
        'contacts' => $data,
        'groupe_id' => $group_id,
    );

    $url = "https://www.spot-hit.fr/api/contacts/import";
    $args = array(
        'method' => 'POST',
        'body' => $body
    );
    $response = wp_remote_post($url, $args);
    $response = json_decode($response['body']);

    if ($response->resultat = true) {
        echo json_encode(array(
            'error_message' => 'Vous êtes désormais enregistré !',
            'error_state' => 0
        ));
    } else {
        echo json_encode(array(
            'error_message' => 'Erreur : Nous n\'avons pas pu vous enregistrer !',
            'error_state' => 1
        ));
    }

    wp_die();
}

function CaptchaCheckout()
{
    global $wpdb;

    $token = $_POST['data']['token'];
    $database_name = $wpdb->prefix . "spothit_settings";
    $database_request_key = $wpdb->get_results(
        "SELECT sh_value FROM $database_name WHERE sh_key = 'captcha_secret'"
    );
    if (isset($database_request_key[0]->sh_value) && !empty($database_request_key[0]->sh_value)) {

        $secret_key = $database_request_key[0]->sh_value;

        $body = array(
            'secret' =>  $secret_key,
            'response' =>  $token
        );

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $args = array(
            'method' => 'POST',
            'body' => $body
        );
        $response = wp_remote_post($url, $args);
        $response = json_decode($response['body']);
        if ($response->success === true) {
            echo json_encode(array(
                'error_message' => 'Captcha verification OK',
                'error_state' => 0
            ));
        } else {
            echo json_encode(array(
                'error_message' => $response['error-codes'],
                'error_state' => 1
            ));
        }
    } else {
        echo json_encode(array(
            'error_message' => 'text = Bad secret key',
            'error_state' => 1
        ));
    }
    wp_die();
}

function rebuildCharacters($str)
{
    $str = str_replace('!/%%?', '<', $str);
    $str = str_replace('!//%%?', '>', $str);
    $str = str_replace('!|%%?', '"', $str);
    $str = str_replace("!||%%?", "'", $str);
    $str = str_replace("!_|%%?", "`", $str);
    $str = str_replace("!__%%?", " ", $str);
    return $str;
}
