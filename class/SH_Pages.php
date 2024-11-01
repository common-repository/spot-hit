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

class SH_Pages
{



    public static function SH_call_login_page()
    {

        echo ('<div id="app_spothit">');
        require_once(SH_DIR_PATH . 'views/login.php');
        echo ('</div>');
        require_once(SH_DIR_PATH . 'components/notification.php');
        wp_enqueue_script('login_scripts', SH_URL_PATH . 'assets/js/login.js', 'jquery');
        new SH_Translate;
        SH_Translate::login();

    }



    public static function SH_call_sms_page()
    {
        echo ('<div id="app_spothit">');
        require_once(SH_DIR_PATH . 'components/header.php');
        require_once(SH_DIR_PATH . 'components/confirmation.php');
        require_once(SH_DIR_PATH . 'views/sms_campaign.php');
        require_once(SH_DIR_PATH . 'components/loader.php');
        echo ('</div>');
        require_once(SH_DIR_PATH . 'components/notification.php');
        wp_enqueue_script('sms_scripts', SH_URL_PATH . 'assets/js/send_sms.js', 'jquery');
        // require_once(SH_DIR_PATH . 'class/SH_Translate.php');
        new SH_Translate;
        SH_Translate::send_sms();
    }


    public static function SH_call_dashboard()
    {
        echo ('<div id="app_spothit">');
        require_once(SH_DIR_PATH . 'components/header.php');
        require_once(SH_DIR_PATH . 'views/dashboard.php');
        require_once(SH_DIR_PATH . 'components/loader.php');
        echo ('</div>');
        require_once(SH_DIR_PATH . 'components/notification.php');
        wp_enqueue_script('dashboard_scripts', SH_URL_PATH . 'assets/js/dashboard.js', 'jquery');
    }


    public static function SH_call_email_page()
    {
        echo ('<div id="app_spothit">');
        require_once(SH_DIR_PATH . 'components/header.php');
        require_once(SH_DIR_PATH . 'components/confirmation.php');
        require_once(SH_DIR_PATH . 'views/email_campaign.php');
        require_once(SH_DIR_PATH . 'components/loader.php');
        echo ('</div>');
        require_once(SH_DIR_PATH . 'components/notification.php');
        wp_enqueue_script('email_scripts', SH_URL_PATH . 'assets/js/send_email.js', 'jquery');
        // require_once(SH_DIR_PATH . 'class/SH_Translate.php');
        new SH_Translate;
        SH_Translate::send_email();
    }


    public static function SH_call_settings_page()
    {
        echo ('<div id="app_spothit">');
        require_once(SH_DIR_PATH . 'components/header.php');
        require_once(SH_DIR_PATH . 'views/settings.php');
        require_once(SH_DIR_PATH . 'components/loader.php');
        echo ('</div>');
        require_once(SH_DIR_PATH . 'components/notification.php');
        wp_enqueue_script('settings_scripts', SH_URL_PATH . 'assets/js/settings.js', 'jquery');
        // require_once(SH_DIR_PATH . 'class/SH_Translate.php');
        new SH_Translate;
        SH_Translate::settings();
    }


    public static function SH_call_automating()
    {
        echo ('<div id="app_spothit">');
        require_once(SH_DIR_PATH . 'components/header.php');
        require_once(SH_DIR_PATH . 'views/automating.php');
        require_once(SH_DIR_PATH . 'components/loader.php');
        echo ('</div>');
        require_once(SH_DIR_PATH . 'components/notification.php');
        wp_enqueue_script('automating_scripts', SH_URL_PATH . 'assets/js/automating.js', 'jquery');
        // require_once(SH_DIR_PATH . 'class/SH_Translate.php');
        new SH_Translate;
        SH_Translate::automating();
    }


    public static function SH_call_buy_page()
    {
        echo ('<div id="app_spothit">');
        require_once(SH_DIR_PATH . 'components/header.php');
        require_once(SH_DIR_PATH . 'views/buy.php');
        require_once(SH_DIR_PATH . 'components/loader.php');
        echo ('</div>');
        require_once(SH_DIR_PATH . 'components/notification.php');
        wp_enqueue_script('buy_scripts', SH_URL_PATH . 'assets/js/buy.js', 'jquery');
    }
}