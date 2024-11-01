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

class SH_WooHooks
{

        public static function activation___hook()
        {
                global $hook_list, $wpdb;
                $hooklist_array = [];

                if (isset($hook_list)) {
                        foreach ($hook_list as $hook) {
                                $hook_action = '';
                                $hook_name = $hook['name'];

                                if (!in_array($hook_name, $hooklist_array)) {
                                        array_push($hooklist_array, $hook_name);
                                                                switch ($hook_name) {

                                                                        case 'new_customer':
                                                                                $hook_action = 'user_register';
                                                                                break;
                                                                        case 'new_order':
                                                                                $hook_action = 'woocommerce_thankyou';
                                                                                break;
                                                                        case 'pending_payment':
                                                                                $hook_action = 'woocommerce_order_status_pending';
                                                                                break;
                                                                        case 'processing':
                                                                                $hook_action = 'woocommerce_order_status_processing';
                                                                                break;
                                                                        case 'onhold':
                                                                                $hook_action = 'woocommerce_order_status_on-hold';
                                                                                break;
                                                                        case 'completed':
                                                                                $hook_action = 'woocommerce_order_status_completed';
                                                                                break;
                                                                        case 'cancelled':
                                                                                $hook_action = 'woocommerce_order_status_cancelled';
                                                                                break;
                                                                        case 'refunded':
                                                                                $hook_action = 'woocommerce_order_status_refunded';
                                                                                break;
                                                                        case 'failed':
                                                                                $hook_action = 'woocommerce_order_status_failed';
                                                                                break;
                                                                }
                                                                if ($hook_action == 'user_register') {

                                                                        add_action(
                                                                                $hook_action,
                                                                                'WooHook__new_user_get_datas',
                                                                                10,
                                                                                1
                                                                        );
                                                                }
                                                                if ($hook_action == 'woocommerce_thankyou') {

                                                                        add_action(
                                                                                $hook_action,
                                                                                'WooHook__new_order_get_datas',
                                                                                10,
                                                                                1
                                                                        );
                                                                }
                                                                elseif ($hook_action !== 'woocommerce_thankyou' && $hook_action !== 'user_register'){
                                                                        add_action(
                                                                                $hook_action,
                                                                                function () use ($hook_name) {
                                                                                        WooHook__other_get_datas($hook_name);
                                                                                },
                                                                                10,
                                                                                1
                                                                        );
                                                                }
                                }
                        }

                }




                function WooHook__new_order_get_datas($order_id) {
                        global $wpdb, $woocommerce;

                        $db_hooks = $wpdb->prefix . 'spothit_hooks';
                        $db_settings = $wpdb->prefix . 'spothit_settings';

                        $db_request = $wpdb->get_results(
                                "SELECT * FROM $db_hooks WHERE hook_name = 'new_order'"
                        );

                        foreach ($db_request as $hook) {
                                $hook_id = $hook->id;
                                $status_email = $hook->status_email;
                                $status_sms = $hook->status_sms;

                                if ($status_sms == 1) {

                                        $wooHooks = new SH_WooHooks();
                                        $datas = $wooHooks->Get__hooks_meta($hook_id, 'sms');

                                        $wooHooks = new SH_WooHooks();
                                        $wooHooks->WooHook__processing($datas, $hook->hook_type, 'sms', $order_id);
                                }
                                if ($status_email == 1) {
                                        $wooHooks = new SH_WooHooks();
                                        $datas = $wooHooks->Get__hooks_meta($hook_id, 'email');
                                        $wooHooks->WooHook__processing($datas, $hook->hook_type, 'email', $order_id);
                                }
                        }
                }



                function WooHook__other_get_datas($hook_name) {
                        global $woocommerce, $post, $wpdb;

                        $order = new WC_Order($post->ID);
                        $order_id = trim(str_replace('#', '', $order->get_order_number()));

                        $db_hooks = $wpdb->prefix . 'spothit_hooks';
                        $db_settings = $wpdb->prefix . 'spothit_settings';

                        $db_request = $wpdb->get_results(
                                "SELECT * FROM $db_hooks WHERE hook_name = '$hook_name'"
                        );

                        foreach ($db_request as $hook) {
                                $hook_id = $hook->id;
                                $status_email = $hook->status_email;
                                $status_sms = $hook->status_sms;

                                if ($status_sms == 1) {

                                        $wooHooks = new SH_WooHooks();
                                        $datas = $wooHooks->Get__hooks_meta($hook_id, 'sms');
                                        $wooHooks->WooHook__processing($datas, $hook->hook_type, 'sms', $order_id);
                                }
                                if ($status_email == 1) {
                                        $wooHooks = new SH_WooHooks();
                                        $datas = $wooHooks->Get__hooks_meta($hook_id, 'email');
                                        $wooHooks->WooHook__processing($datas, $hook->hook_type, 'email', $order_id);
                                }
                        }
                }




                function WooHook__new_user_get_datas($user_id)
                {
                        global $wpdb;

                        $db_hooks = $wpdb->prefix . 'spothit_hooks';
                        $db_settings = $wpdb->prefix . 'spothit_settings';

                        $db_request = $wpdb->get_results(
                                "SELECT * FROM $db_hooks WHERE hook_name = 'new_customer'"
                        );



                        foreach ($db_request as $hook) {
                                $hook_id = $hook->id;
                                $status_email = $hook->status_email;
                                $status_sms = $hook->status_sms;


                                if ($status_sms == 1) {

                                        $wooHooks = new SH_WooHooks();
                                        $datas = $wooHooks->Get__hooks_meta($hook_id, 'sms');

                                        if ($hook->hook_type == '0') {
                                                $get_recipient = $wpdb->get_results(
                                                        "SELECT sh_value FROM $db_settings WHERE sh_key = 'phone_number'"
                                                );
                                                $recipient = $get_recipient[0]->sh_value;
                                        }


                                        elseif ($hook->hook_type == '1') {
                                                $recipient_infos = get_userdata($user_id);
                                                $recipient_infos = $recipient_infos->data;
                                                $recipient = $recipient_infos->phone;

                                                if (empty($recipient)) {
                                                        $customer = new WC_Customer($user_id);
                                                        if (!empty($customer)) {
                                                                $recipient = $customer->get_billing_phone();
                                                        }
                                                }
                                        }


                                        $message = $datas->message;
                                        $wooHooks = new SH_WooHooks;
                                        $message = $wooHooks->WooHook__new_user_variables_assignment($user_id, $message);
                                        $sender_name = $datas->sender_name;

                                        $wooHooks = new SH_WooHooks;

                                        $wooHooks->WooHook__send__sms($sender_name, $recipient, $message);
                                }

                                if ($status_email == 1) {
                                        $wooHooks = new SH_WooHooks();
                                        $datas = $wooHooks->Get__hooks_meta($hook_id, 'email');

                                        if ($hook->hook_type == '0') {
                                                $db_request = $wpdb->get_results(
                                                        "SELECT sh_value FROM $db_settings WHERE sh_key = 'email_address'"
                                                );
                                                $recipient = $db_request[0]->sh_value;
                                        } elseif ($hook->hook_type == '1') {
                                                $recipient_infos = get_userdata($user_id);
                                                $recipient_infos = $recipient_infos->data;
                                                $recipient = $recipient_infos->user_email;
                                                if (empty($recipient)) {
                                                        $customer = new WC_Customer($user_id);
                                                        if (!empty($customer)) {
                                                                $recipient = $customer->get_email();
                                                        }
                                                }
                                        }
                                        $sender_name = $datas->sender_name;
                                        $sender_address = $datas->sender;
                                        $object = $datas->object;
                                        $message = $datas->message;
                                        $wooHooks = new SH_WooHooks;
                                        $message = $wooHooks->WooHook__new_user_variables_assignment($user_id, $message);
                                        $sender_name = $datas->sender_name;
                                        $wooHooks = new SH_WooHooks;

                                        $wooHooks->WooHook__send__email($sender_name, $recipient, $sender_address, $object, $message);
                                }
                        }
                }
        }




        public static function WooHook__processing($datas, $hook_role, $type, $order_id)
        {

                global $wpdb;
                $db_settings = $wpdb->prefix . 'spothit_settings';

                if (empty($order_id) || $order_id === null) {
                        $order_id = get_the_ID();
                }

                if ($type == 'sms') {
                        if ($hook_role == '0') {
                                $db_request = $wpdb->get_results(
                                        "SELECT sh_value FROM $db_settings WHERE sh_key = 'phone_number'"
                                );
                                $recipient = $db_request[0]->sh_value;
                        } elseif ($hook_role == '1') {
                                $order_datas = wc_get_order($order_id);
                                $recipient_infos = $order_datas->get_data();
                                $recipient_billing = $recipient_infos['billing'];
                                $recipient_shipping = $recipient_infos['shipping'];
                                $recipient_phone = $recipient_billing['phone'];
                                if (!empty($recipient_phone)) {
                                        $recipient = $recipient_phone;
                                } else {
                                        $recipient_phone = $recipient_shipping['phone'];
                                        $recipient = $recipient_phone;
                                }
                        }

                        $message = $datas->message;
                        strip_tags($message);
                        $sender_name = $datas->sender_name;


                        $message = self::WooHook__variables_assignment($order_id, $message);

                        self::WooHook__send__sms($sender_name, $recipient, $message);
                }

                if ($type == 'email') {
                        if ($hook_role == '0') {
                                $db_request = $wpdb->get_results(
                                        "SELECT sh_value FROM $db_settings WHERE sh_key = 'email_address'"
                                );
                                $recipient = $db_request[0]->sh_value;
                        } elseif ($hook_role == '1') {
                                $order_datas = wc_get_order($order_id);
                                $recipient_infos = $order_datas->get_data();
                                $recipient_billing = $recipient_infos['billing'];
                                $recipient_shipping = $recipient_infos['shipping'];
                                $recipient_email = $recipient_billing['email'];
                                if (!empty($recipient_email)) {
                                        $recipient = $recipient_email;
                                } else {
                                        $recipient_email = $recipient_shipping['email'];
                                        $recipient = $recipient_email;
                                }
                        }

                        $sender_name = $datas->sender_name;
                        $sender_address = $datas->sender;
                        $object = $datas->object;
                        $message = $datas->message;

                        $message = self::WooHook__variables_assignment($order_id, $message);


                        self::WooHook__send__email($sender_name, $recipient, $sender_address, $object, $message);
                }
        }




        public static function WooHook__send__sms($sender_name, $recipient, $message)
        {
                global $credits, $wpdb;

                $body = array(
                        'from' => 'wordpress_v2',
                        'rest' => '1',
                        'key' => $credits['key'],
                        'message' => $message,
                        'expediteur' => $sender_name,
                        'destinataires' => $recipient,
                );
                if (strlen($message) > 160) {
                        $body['smslong'] = 1;
                }

                $url = 'https://www.spot-hit.fr/api/envoyer/sms';

                $args = array(
                        'method' => 'POST',
                        'headers' => array(),
                        'body' => $body
                );

                wp_remote_post($url, $args);
        }

        public static function WooHook__send__email($sender_name, $recipient, $sender_email, $object, $message)
        {
                global $credits, $wpdb;



                $body = array(
                        'from' => 'wordpress_v2',
                        'rest' => '1',
                        'key' => $credits['key'],
                        'nom_expediteur' => $sender_name,
                        'expediteur' => $sender_email . '@sh-mail.fr',
                        'sujet' => $object,
                        'message' => $message,
                        'destinataires' => $recipient,
                );

                $url = 'https://www.spot-hit.fr/api/envoyer/e-mail';

                $args = array(
                        'method' => 'POST',
                        'headers' => array(),
                        'body' => $body
                );

                wp_remote_post($url, $args);

        }




        public static function Get__hooks_meta($id, $role)
        {

                global $wpdb;
                $db_hooks_meta = $wpdb->prefix . 'spothit_hooks_meta';

                $datas = $wpdb->get_results(
                        "SELECT * FROM $db_hooks_meta WHERE parent_id = '" . $id . "' AND type = '" . $role . "' "
                );
                if ($datas) {
                        $datas = $datas[0];
                        return $datas;
                }
        }




        public static function WooHook__variables_assignment($id_order, $message)
        {

                $order = wc_get_order($id_order);
                $order_datas = $order->get_data();

                $order_billing = $order_datas['billing'];
                $order_shipping = $order_datas['shipping'];
                $order_items = $order->get_items();
                $user_datas = get_userdata($order_datas['customer_id']);
                $user_datas = $user_datas->data;

                $items_names_list = '';
                $items_id_list = '';
                $items_total_nb = 0;
                $items_total_price = 0;
                $items_name_quantity = '';

                foreach ($order->get_items() as $key => $value) {
                        $product_id      = $value->get_product_id();
                        $product_name    = $value->get_name();
                        $quantity        = $value->get_quantity();
                        $total           = $value->get_total();

                        $items_names_list .= $product_name . ', ';
                        $items_id_list .= $product_id . ', ';
                        $items_total_nb = $items_total_nb + $quantity;
                        $items_total_price = $items_total_price + $total;
                        $items_name_quantity .= $product_name . ' x ' . $quantity . ', ';
                }

                $order_items['items_total_selected_products'] = count($order->get_items());
                $order_items['items_total_quantity'] = $items_total_nb;
                $items_names_list = rtrim($items_names_list, ", ");
                $order_items['items_names_list'] = $items_names_list;
                $items_id_list = rtrim($items_id_list, ", ");
                $order_items['items_id_list'] = $items_id_list;
                $items_name_quantity = rtrim($items_name_quantity, ", ");
                $order_items['items_name_quantity'] = $items_name_quantity;

                foreach ($user_datas as $key => $value) {
                        if (
                                !empty($value)
                                && str_contains($key, 'user_')
                                && !str_contains($key, 'user_activation_key')
                                && !str_contains($key, 'user_pass')
                        ) {
                                $array_user[$key] = $value;
                        } elseif (
                                !empty($value)
                                && !str_contains($key, 'user_')
                                && !str_contains($key, 'user_activation_key')
                                && !str_contains($key, 'user_pass')
                        ) {
                                $array_user['user_' . $key] = $value;
                        }
                }
                foreach ($order_billing as $key => $value) {
                        if (str_contains($key, 'billing_')) {
                                $array_billing[$key] = $value;
                        } elseif (!str_contains($key, 'billing_')) {
                                $array_billing['billing_' . $key] = $value;
                        }
                }
                foreach ($order_shipping as $key => $value) {
                        if (str_contains($key, 'shipping_')) {
                                $array_shipping[$key] = $value;
                        } elseif (!str_contains($key, 'shipping_')) {
                                $array_shipping['shipping_' . $key] = $value;
                        }
                }
                foreach ($order_datas as $key => $value) {
                        if (str_contains($key, 'data_')) {
                                $array_other[$key] = $value;
                        } elseif (!str_contains($key, 'data_') && !str_contains($key, 'billing') && !str_contains($key, 'shipping')) {
                                $array_other['data_' . $key] = $value;
                        }
                }



                $variables_array = array(
                        'user' => $array_user,
                        'billing' => $array_billing,
                        'shipping' => $array_shipping,
                        'other' => $array_other,
                        'items' => $order_items
                );


                foreach ($variables_array['user'] as $key => $value) {
                        $var_name = '{{' . $key . '}}';
                        if (str_contains($message, $var_name)) {
                                $message = str_replace($var_name, $value, $message);
                        }
                }
                foreach ($variables_array['billing'] as $key => $value) {
                        $var_name = '{{' . $key . '}}';
                        if (str_contains($message, $var_name)) {
                                $message = str_replace($var_name, $value, $message);
                        }
                }
                foreach ($variables_array['shipping'] as $key => $value) {
                        $var_name = '{{' . $key . '}}';
                        if (str_contains($message, $var_name)) {
                                $message = str_replace($var_name, $value, $message);
                        }
                }
                foreach ($variables_array['other'] as $key => $value) {
                        $var_name = '{{' . $key . '}}';
                        if (str_contains($message, $var_name)) {
                                $message = str_replace($var_name, $value, $message);
                        }
                }
                foreach ($variables_array['items'] as $key => $value) {
                        $var_name = '{{' . $key . '}}';
                        if (str_contains($message, $var_name)) {
                                $message = str_replace($var_name, $value, $message);
                        }
                }
                return $message;
        }




        public static function WooHook__new_user_variables_assignment($id_user, $message)
        {


                // $user_datas = get_user_meta($id_user);

                $user_datas = get_userdata($id_user);
                $user_datas = $user_datas->data;


                $array_user = [];
                foreach ($user_datas as $key => $value) {

                        if (
                                !empty($value)
                                && str_contains($key, 'user_')
                                && !str_contains($key, 'user_activation_key')
                                && !str_contains($key, 'user_pass')
                        ) {
                                $array_user[$key] = $value;
                        } elseif (
                                !empty($value)
                                && !str_contains($key, 'user_')
                                && !str_contains($key, 'user_activation_key')
                                && !str_contains($key, 'user_pass')
                        ) {
                                $array_user['user_' . $key] = $value;
                        }
                }

                $variables_array = array(
                        'user' => $array_user,
                );

                foreach ($variables_array['user'] as $key => $value) {
                        $var_name = '{{' . $key . '}}';
                        if (str_contains($message, $var_name)) {
                                $message = str_replace($var_name, $value, $message);
                        }
                }
                return $message;
        }
}




// {{user_ID}}/{{user_nicename}}/{{user_email}}/{{user_display_name}}/{{data_id}}/{{data_customer_id}}/{{data_status}}/{{data_discount_total}}/{{data_shipping_total}}/{{data_total}}/{{data_payment_method_title}}/{{data_currency}}/{{billing_first_name}}/{{billing_last_name}}/{{billing_address_1}}/{{billing_city}}/{{billing_postcode}}/{{billing_country}}/{{billing_email}}/{{billing_phone}}/{{shipping_first_name}}/{{shipping_last_name}}/{{shipping_address_1}}/{{shipping_address_2}}/{{shipping_city}}/{{shipping_postcode}}/{{shipping_country}}/{{items_total_selected_products}}/{{items_total_quantity}}/{{items_name_quantity}}/{{items_id_list}}/{{items_names_list}}
