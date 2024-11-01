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

class SH_Woo
{

  // public static function woo__admin_menu()
  // {
  //   add_submenu_page(
  //     'spothit',
  //     'Automatic Campaigns',
  //     __('Automatic Campaigns', 'spothit'),
  //     'manage_options',
  //     'spothit_automatisation',
  //     array('Pages', 'call_automating')
  //   );
  // }


  public static function woo__hook_init()
  {

    global $wpdb;

    $db = $wpdb->get_results(
      "SELECT * FROM " . $wpdb->prefix . "spothit_hooks"
    );



    $hook_list = [];

    foreach ($db as $value) {
      if ($value->hook_type == 0) {

        $hook_list['adm_' . $value->hook_name] = array(
          'id' => $value->id,
          'name' => $value->hook_name,
          'type' => $value->hook_type,
          'sms' => $value->status_sms,
          'email' => $value->status_email,
        );
      }

      if ($value->hook_type == 1) {

        $hook_list['cust_' . $value->hook_name] = array(
          'id' => $value->id,
          'name' => $value->hook_name,
          'type' => $value->hook_type,
          'sms' => $value->status_sms,
          'email' => $value->status_email,
        );
      }
    }


    if (!isset($hook_list['adm_new_customer'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'new_customer',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }

    if (!isset($hook_list['adm_new_order'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'new_order',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['adm_pending_payment'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'pending_payment',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['adm_processing'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'processing',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['adm_onhold'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'onhold',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['adm_completed'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'completed',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['adm_cancelled'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'cancelled',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['adm_refunded'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'refunded',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['adm_failed'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'failed',
          'hook_type' => 0,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }





    if (!isset($hook_list['cust_new_customer'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'new_customer',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }

    if (!isset($hook_list['cust_new_order'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'new_order',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['cust_pending_payment'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'pending_payment',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['cust_processing'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'processing',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['cust_onhold'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'onhold',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['cust_completed'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'completed',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['cust_cancelled'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'cancelled',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['cust_refunded'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'refunded',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }
    if (!isset($hook_list['cust_failed'])) {
      $wpdb->insert(
        $wpdb->prefix . 'spothit_hooks',
        array(
          'hook_name' => 'failed',
          'hook_type' => 1,
          'status_sms' => 2,
          'status_email' => 2,
        )
      );
    }

    return $hook_list;
  }
}