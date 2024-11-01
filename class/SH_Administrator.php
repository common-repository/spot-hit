<?php

class SH_Administator
{

  public static function SH_create_database()
  {
    global $wpdb;

    $settings_dbname= $wpdb->prefix . "spothit_settings";
    $hooks_dbname = $wpdb->prefix . "spothit_hooks";
    $meta_dbname = $wpdb->prefix . "spothit_hooks_meta";


      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $settings_dbname (
        sh_key varchar(55) DEFAULT NULL,
        sh_value text DEFAULT NULL
      ) $charset_collate;";



      $sql .= "CREATE TABLE $hooks_dbname (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        hook_name varchar(55) DEFAULT '' NOT NULL,
        hook_type tinyint(1) DEFAULT 0 NOT NULL,
        status_sms tinyint(1) DEFAULT 0 NOT NULL,
        status_email tinyint(1) DEFAULT 0 NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";



      $sql .= "CREATE TABLE $meta_dbname (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        message LONGTEXT NOT NULL,
        sender text  NULL,
        sender_name varchar(55) DEFAULT '' NOT NULL,
        object LONGTEXT  NULL,
        type varchar(10) DEFAULT '' NOT NULL,
        parent_id int DEFAULT 0 NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );
  }




  public static function SH_drop_database()
  {
    global $wpdb;

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      $wpdb->query("DROP TABLE  " . $wpdb->prefix . "spothit_settings");
      $wpdb->query("DROP TABLE  " . $wpdb->prefix . "spothit_hooks");
      $wpdb->query("DROP TABLE " . $wpdb->prefix . "spothit_hooks_meta");
  }





  public static function SH_insert_first_datas()
  {
    global $wpdb;

    $db_settings = $wpdb->prefix . 'spothit_settings';
    $db_hooks = $wpdb->prefix . 'spothit_hooks';
    $db_hooks_meta = $wpdb->prefix . 'spothit_hooks_meta';

    $current_database = $wpdb->get_results("SELECT * FROM $db_settings");

if (isset($current_database) && empty($current_database)) {
    $site_title = get_bloginfo('name');
        $site_title = preg_replace("/[^A-Za-z0-9]/", "", $site_title);
        $site_title = strtolower($site_title);

        if (strlen($site_title) > 11) {
          $minified_site_title = substr($site_title, 0, 10);
        } else {
          $minified_site_title = $site_title;
        }

        $admin_email = $site_title . '@domain.com';
        $admin_sending_email = $site_title;
        $admin_email_sender_name = $site_title;

        $admin_phone = '';
        $admin_sms_sender_name = $minified_site_title;
        $admin_email_sender_name = $site_title;

        if (current_user_can('administrator')) {
          $admin_id = get_current_user_id();
          $admin_user_datas = get_userdata($admin_id);
          $admin_datas = $admin_user_datas->data;

          if (isset($admin_datas->user_email) && !empty($admin_datas->user_email)) {
            $admin_email = $admin_datas->user_email;
          }
          if (isset($admin_datas->phone_number) && !empty($admin_datas->phone_number)) {
            $admin_phone = $admin_datas->phone_number;
          }
        }

        $wpdb->query("INSERT INTO $db_settings
                (sh_key, sh_value)
                VALUES
                ('api_key', null),
                ('phone_number', '$admin_phone'),
                ('sms_sender_name', '$admin_sms_sender_name'),
                ('email_address', '$admin_email'),
                ('sending_email_address', '$admin_sending_email'),
                ('sending_email_name', '$admin_email_sender_name'),
                ('widget_group_id', null),
                ('widget_group_name', null),
                ('captcha_site', null),
                ('captcha_secret', null),
                ('php_error', 1),
                ('wordpress_error', 1)
                ");

        $wpdb->query("INSERT INTO $db_hooks
                (id, hook_name, hook_type )
                VALUES
              (1, 'new_customer', 0),
              (2, 'new_customer',1),
              (3, 'new_order', 0),
              (4, 'new_order',1),
              (5, 'pending_payment', 0),
              (6, 'pending_payment',1),
              (7, 'processing', 0),
              (8, 'processing',1),
              (9, 'onhold', 0),
              (10, 'onhold',1),
              (11, 'completed', 0),
              (12, 'completed',1),
              (13, 'cancelled', 0),
              (14, 'cancelled',1),
              (15, 'refunded', 0),
              (16, 'refunded',1),
              (17, 'failed', 0),
              (18,'failed', 1)
              ");

        $default_admin_text__new_customer = __("User {{user_nicename}} is just registered !", "spothit");
        $default_admin_text__new_customer = addslashes($default_admin_text__new_customer);
        $default_admin_text__new_order = __("{{user_nicename}} registered a new order (id: {{data_id}})", "spothit");
        $default_admin_text__new_order = addslashes($default_admin_text__new_order);
        $default_admin_text__pending_payment = __("Order number {{data_id}} for an amount of {{data_total}} is pending payment", "spothit");
        $default_admin_text__pending_payment = addslashes($default_admin_text__pending_payment);
        $default_admin_text__processing = __("Order number {{data_id}} for an amount of {{data_total}} is being processed", "spothit");
        $default_admin_text__processing = addslashes($default_admin_text__processing);
        $default_admin_text__onhold = __("Order number {{data_id}} for an amount of {{data_total}} is on hold !", "spothit");
        $default_admin_text__onhold = addslashes($default_admin_text__onhold);
        $default_admin_text__completed = __("Order number {{data_id}} for an amount of {{data_total}} is completed !", "spothit");
        $default_admin_text__completed = addslashes($default_admin_text__completed);
        $default_admin_text__cancelled = __("Order number {{data_id}} for an amount of {{data_total}} is cancelled !", "spothit");
        $default_admin_text__cancelled = addslashes($default_admin_text__cancelled);
        $default_admin_text__refunded = __("Order number {{data_id}} for an amount of {{data_total}} is refunded !", "spothit");
        $default_admin_text__refunded = addslashes($default_admin_text__refunded);
        $default_admin_text__failed = __("Order number {{data_id}} for an amount of {{data_total}} is failed !", "spothit");
        $default_admin_text__failed = addslashes($default_admin_text__failed);
        $default_customer_text__new_customer = __("Hello {{user_nicename}} ! Thank you for your registration !", "spothit");
        $default_customer_text__new_customer = addslashes($default_customer_text__new_customer);
        $default_customer_text__new_order = __("Hello {{user_nicename}},  your order n°{{data_id}} is registered. Thank you for your purchase !", "spothit");
        $default_customer_text__new_order = addslashes($default_customer_text__new_order);
        $default_customer_text__pending_payment = __("Hello {{user_nicename}}, your order n°{{data_id}} for an amount of {{data_total}} is pending payment !", "spothit");
        $default_customer_text__pending_payment = addslashes($default_customer_text__pending_payment);
        $default_customer_text__processing = __("Hello {{user_nicename}}, your order n°{{data_id}} for an amount of {{data_total}} is being processed !", "spothit");
        $default_customer_text__processing = addslashes($default_customer_text__processing);
        $default_customer_text__onhold = __("Hello {{user_nicename}}, your order n°{{data_id}} for an amount of {{data_total}} is on hold !", "spothit");
        $default_customer_text__onhold = addslashes($default_customer_text__onhold);
        $default_customer_text__completed = __("Hello {{user_nicename}}, your order n°{{data_id}} for an amount of {{data_total}} is completed !", "spothit");
        $default_customer_text__completed = addslashes($default_customer_text__completed);
        $default_customer_text__cancelled = __("Hello {{user_nicename}}, your order n°{{data_id}} for an amount of {{data_total}} is cancelled !", "spothit");
        $default_customer_text__cancelled = addslashes($default_customer_text__cancelled);
        $default_customer_text__refunded = __("Hello {{user_nicename}}, your order n°{{data_id}} for an amount of {{data_total}} is refunded !", "spothit");
        $default_customer_text__refunded = addslashes($default_customer_text__refunded);
        $default_customer_text__failed = __("Hello {{user_nicename}}, your order n°{{data_id}} for an amount of {{data_total}} is failed !", "spothit");
        $default_customer_text__failed = addslashes($default_customer_text__failed);
        $default_subject__new_customer = __("New registration", "spothit");
        $default_subject__new_customer = addslashes($default_subject__new_customer);
        $default_subject__new_order = __("New order", "spothit");
        $default_subject__new_order = addslashes($default_subject__new_order);
        $default_subject__pending_payment = __("Order is pending payment", "spothit");
        $default_subject__pending_payment = addslashes($default_subject__pending_payment);
        $default_subject__processing = __("Order is being processed", "spothit");
        $default_subject__processing = addslashes($default_subject__processing);
        $default_subject__onhold = __("Order is on hold", "spothit");
        $default_subject__onhold = addslashes($default_subject__onhold);
        $default_subject__completed = __("Order is completed", "spothit");
        $default_subject__completed = addslashes($default_subject__completed);
        $default_subject__cancelled = __("Order is cancelled !", "spothit");
        $default_subject__cancelled = addslashes($default_subject__cancelled);
        $default_subject__refunded = __("Order is refunded !", "spothit");
        $default_subject__refunded = addslashes($default_subject__refunded);
        $default_subject__failed = __("Order is failed", "spothit");
        $default_subject__failed = addslashes($default_subject__failed);


        $wpdb->query("INSERT INTO $db_hooks_meta
        (message, sender_name, sender, object, type, parent_id)
        VALUES
        ('$default_admin_text__new_customer' , '$admin_sms_sender_name ' , null ,null, 'sms', 1 ),
        ('$default_admin_text__new_customer' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__new_customer', 'email', 1 ),
        ('$default_customer_text__new_customer' , '$admin_sms_sender_name ' , null ,null, 'sms', 2 ),
        ('$default_customer_text__new_customer' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__new_customer', 'email', 2),
        ('$default_admin_text__new_order' , '$admin_sms_sender_name ' , null ,null, 'sms', 3 ),
        ('$default_admin_text__new_order' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__new_order', 'email', 3),
        ('$default_customer_text__new_order' , '$admin_sms_sender_name ' , null ,null, 'sms', 4 ),
        ('$default_customer_text__new_order' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__new_order', 'email', 4 ),
        ('$default_admin_text__pending_payment' , '$admin_sms_sender_name ' , null ,null, 'sms', 5 ),
        ('$default_admin_text__pending_payment' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__pending_payment', 'email', 5 ),
        ('$default_customer_text__pending_payment' , '$admin_sms_sender_name ' , null ,null, 'sms', 6 ),
        ('$default_customer_text__pending_payment' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__pending_payment', 'email', 6 ),
        ('$default_admin_text__processing' , '$admin_sms_sender_name ' , null ,null, 'sms', 7 ),
        ('$default_admin_text__processing' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__processing', 'email', 7 ),
        ('$default_customer_text__processing' , '$admin_sms_sender_name' , null ,null, 'sms', 8 ),
        ('$default_customer_text__processing' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__processing', 'email', 8 ),
        ('$default_admin_text__onhold' , '$admin_sms_sender_name ' , null ,null, 'sms', 9 ),
        ('$default_admin_text__onhold' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__onhold', 'email', 9 ),
        ('$default_customer_text__onhold' , '$admin_sms_sender_name ' , null ,null, 'sms', 10 ),
        ('$default_customer_text__onhold' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__onhold', 'email', 10 ),
        ('$default_admin_text__completed' , '$admin_sms_sender_name ' , null ,null, 'sms', 11 ),
        ('$default_admin_text__completed' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__completed', 'email', 11 ),
        ('$default_customer_text__completed' , '$admin_sms_sender_name ' , null ,null, 'sms', 12 ),
        ('$default_customer_text__completed' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__completed', 'email', 12 ),
        ('$default_admin_text__cancelled' , '$admin_sms_sender_name ' , null ,null, 'sms', 13 ),
        ('$default_admin_text__cancelled' , '$admin_email_sender_name'  , '$admin_sending_email' ,'$default_subject__cancelled', 'email', 13 ),
        ('$default_customer_text__cancelled' , '$admin_sms_sender_name' , null ,null, 'sms', 14 ),
        ('$default_customer_text__cancelled' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__cancelled', 'email', 14 ),
        ('$default_admin_text__refunded' , '$admin_sms_sender_name ' , null ,null, 'sms', 15 ),
        ('$default_admin_text__refunded' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__refunded', 'email', 15 ),
        ('$default_customer_text__refunded' , '$admin_sms_sender_name' , null ,null, 'sms', 16 ),
        ('$default_customer_text__refunded' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__refunded', 'email', 16 ),
        ('$default_customer_text__failed' , '$admin_sms_sender_name' , null ,null, 'sms', 17 ),
        ('$default_customer_text__failed' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__failed', 'email', 17 ),
        ('$default_admin_text__failed' , '$admin_sms_sender_name ' , null ,null, 'sms', 18 ),
        ('$default_admin_text__failed' , '$admin_email_sender_name' , '$admin_sending_email' ,'$default_subject__failed', 'email', 18 )
        ");
      }

}



  public static function SH_menu_disconnected()
  {
    $icon_base64 = 'PHN2ZyBpZD0iQ2FscXVlXzEiIGRhdGEtbmFtZT0iQ2FscXVlIDEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDE1MC4yNCAxMTUuMzkiIGhlaWdodD0iMjBweCIgd2lkdGg9IjIwcHgiPjx0aXRsZT5TUE9ULUhJVDwvdGl0bGU+PHBhdGggZD0iTTEzMC4yNCwwSDIwQTIwLjA2LDIwLjA2LDAsMCwwLDAsMjBWODIuMDVzMCwuMSwwLC4xNUgwdjMzLjE5TDEwLjcsOTkuNzNhMTkuODcsMTkuODcsMCwwLDAsOS4zLDIuMzJIMTMwLjI0YTIwLjA2LDIwLjA2LDAsMCwwLDIwLTIwVjIwQTIwLjA2LDIwLjA2LDAsMCwwLDEzMC4yNCwwWk01Ni42OSw4Mi4yaC0xMVY1Ni41MkE4LjY4LDguNjgsMCwwLDAsMzcsNDcuODVIMzFWODIuMkgyMFYxOS44NEgzMXYxN2g2QTE5LjY5LDE5LjY5LDAsMCwxLDU2LjY5LDU2LjUyWm0yOC4xOCwwaC0xMVYzNi44NWgxMVptLTUuNS01MS4zNmE1LjUsNS41LDAsMSwxLDUuNS01LjVBNS41LDUuNSwwLDAsMSw3OS4zNywzMC44NFpNMTMwLjIyLDgyLjJoLTguNWExOS42OSwxOS42OSwwLDAsMS0xOS42Ny0xOS42N1YxOS44NGgxMVYzOS42OGgxMS41djExaC0xMS41VjYyLjUzYTguNjgsOC42OCwwLDAsMCw4LjY3LDguNjdoOC41WiIgc3R5bGU9ImZpbGw6cmdiYSgyNDAsMjQ2LDI1MiwuNikiLz48L3N2Zz4NCg==';
    $icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

    add_menu_page(
      'Spot-Hit',
      'Spot-Hit',
      'manage_options',
      'spothit',
      array('SH_Pages', 'SH_call_login_page'),
      $icon_data_uri
    );
  }

  public static function SH_menu_connected()
  {
    $icon_base64 = 'PHN2ZyBpZD0iQ2FscXVlXzEiIGRhdGEtbmFtZT0iQ2FscXVlIDEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDE1MC4yNCAxMTUuMzkiIGhlaWdodD0iMjBweCIgd2lkdGg9IjIwcHgiPjx0aXRsZT5TUE9ULUhJVDwvdGl0bGU+PHBhdGggZD0iTTEzMC4yNCwwSDIwQTIwLjA2LDIwLjA2LDAsMCwwLDAsMjBWODIuMDVzMCwuMSwwLC4xNUgwdjMzLjE5TDEwLjcsOTkuNzNhMTkuODcsMTkuODcsMCwwLDAsOS4zLDIuMzJIMTMwLjI0YTIwLjA2LDIwLjA2LDAsMCwwLDIwLTIwVjIwQTIwLjA2LDIwLjA2LDAsMCwwLDEzMC4yNCwwWk01Ni42OSw4Mi4yaC0xMVY1Ni41MkE4LjY4LDguNjgsMCwwLDAsMzcsNDcuODVIMzFWODIuMkgyMFYxOS44NEgzMXYxN2g2QTE5LjY5LDE5LjY5LDAsMCwxLDU2LjY5LDU2LjUyWm0yOC4xOCwwaC0xMVYzNi44NWgxMVptLTUuNS01MS4zNmE1LjUsNS41LDAsMSwxLDUuNS01LjVBNS41LDUuNSwwLDAsMSw3OS4zNywzMC44NFpNMTMwLjIyLDgyLjJoLTguNWExOS42OSwxOS42OSwwLDAsMS0xOS42Ny0xOS42N1YxOS44NGgxMVYzOS42OGgxMS41djExaC0xMS41VjYyLjUzYTguNjgsOC42OCwwLDAsMCw4LjY3LDguNjdoOC41WiIgc3R5bGU9ImZpbGw6cmdiYSgyNDAsMjQ2LDI1MiwuNikiLz48L3N2Zz4NCg==';
    $icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

    add_menu_page(
      'Spot-Hit',
      'Spot-Hit',
      'manage_options',
      'spothit',
      array('SH_Pages', 'SH_call_dashboard'),
      $icon_data_uri
    );
    add_submenu_page(
      'spothit',
      'Dashboard',
      __('Dashboard', 'spothit'),
      'manage_options',
      'spothit',
      array('SH_Pages', 'SH_call_dashboard')
    );
    add_submenu_page(
      'spothit',
      'SMS Campaigns',
      __('SMS Campaigns', 'spothit'),
      'manage_options',
      'spothit_sms_campaign',
      array('SH_Pages', 'SH_call_sms_page')
    );
    add_submenu_page(
      'spothit',
      'EMAIL Campaigns',
      __('EMAIL Campaigns', 'spothit'),
      'manage_options',
      'spothit_email_campaign',
      array('SH_Pages', 'SH_call_email_page')
    );

    if (is_plugin_active('woocommerce/woocommerce.php')) {
      add_submenu_page(
        'spothit',
        'Automatic Campaigns',
        __('Automatic Campaigns', 'spothit'),
        'manage_options',
        'spothit_automatisation',
        array('SH_Pages', 'SH_call_automating')
      );
    }

    add_submenu_page(
      'spothit',
      'Settings',
      __('Settings', 'spothit'),
      'manage_options',
      'spothit_settings',
      array('SH_Pages', 'SH_call_settings_page')
    );
    add_submenu_page(
      'spothit',
      'Buy credits',
      __('Buy credits', 'spothit'),
      'manage_options',
      'spothit_buy',
      array('SH_Pages', 'SH_call_buy_page')
    );
  }
}