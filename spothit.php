<?php
/*
Plugin Name: Spot-Hit - Send SMS and Emails (Compatible with WooCommerce)
Plugin URI:
Description: Send SMS and/or EMAIL to your customers or spothit contacts directly from WordPress. Automatic sends compatible with WooCommerce actions
Version: 2.1.0
Author: Spot-Hit
Author URI: https://www.spot-hit.fr/
Text Domain: spothit
Domain Path: /lang
*/

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


define('SH_URL_PATH', plugin_dir_url(__FILE__));
define('SH_DIR_PATH', plugin_dir_path(__FILE__));
define('SH_VERSION', '2.0');

add_action('init', 'spothit_widget_block_init');
add_action('wp_footer', 'SPOTHIT_enqueue_widget');

global $wpdp;
$db_settings = $wpdb->prefix . 'spothit_settings';
$db_hooks = $wpdb->prefix . 'spothit_hooks';
$db_hooks_meta = $wpdb->prefix . 'spothit_hooks_meta';


global $wp_version;
$php_version = explode('.', phpversion());


if ($wp_version < 6) {
    SPOTHIT_version_notification('wordpress');
}

if ($php_version[0] < 7) {
    SPOTHIT_version_notification('php');
}

require_once(SH_DIR_PATH . 'class/SH_Translate.php');
require_once(SH_DIR_PATH . 'class/SH_Administrator.php');
require_once(SH_DIR_PATH . 'class/SH_Pages.php');
require_once(SH_DIR_PATH . 'functions.php');

add_action('plugins_loaded', 'SPOTHIT_lang');
register_activation_hook(__FILE__, 'SPOTHIT_plugin_initialization');
register_uninstall_hook(__FILE__, 'SPOTHIT_plugin_uninstall');

if (SPOTHIT_database_check() === true) {

    add_action('admin_enqueue_scripts', 'SPOTHIT_enqueue');


    $config = SPOTHIT_create_config();
    if (isset($config['api_key']) && $config['api_key'] != NULL) {
        $credits = SPOTHIT_user_credits();

        if ($credits['resultat'] === true) {
            add_action('admin_menu', array('SH_Administator', 'SH_menu_connected'));

            if (!function_exists('is_plugin_active')) {
                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            }

            if (is_plugin_active('woocommerce/woocommerce.php')) {
                require_once(SH_DIR_PATH . 'class/SH_Woo.php');
                require_once(SH_DIR_PATH . 'class/SH_WooHooks.php');
                new SH_Woo;
                $hook_list = SH_Woo::woo__hook_init();
                new SH_WooHooks;
                SH_WooHooks::activation___hook();
            }


            $get_alert_levels = SPOTHIT__alert_levels();
            if (isset($get_alert_levels) && !empty($get_alert_levels)) {
                $alert_levels = $get_alert_levels;
            }
        } elseif ($credits['resultat'] === false) {
            add_action('admin_menu', array('SH_Administator', 'SH_menu_disconnected'));
            load_plugin_textdomain('spothit', false, basename(dirname(__FILE__)) . '/lang');
        }
    } else {

        add_action('admin_menu', array('SH_Administator', 'SH_menu_disconnected'));
        load_plugin_textdomain('spothit', false, basename(dirname(__FILE__)) . '/lang');
    }
} else {
    add_action('admin_notices', 'SPOTHIT_error_admin_notice');
}




function SPOTHIT_user_credits()
{
    global $config;

    $key = $config['api_key'];
    $url = 'https://www.spot-hit.fr/api/informations';

    $body = array(
        'key' => $key,
        'from' => 'wordpress_v2',
        'rest' => '1',
    );
    $args = array(
        'method' => 'POST',
        'headers' => array(),
        'body' => $body,
        'timeout' => 30,
    );

    $response = wp_remote_post($url, $args);
    $reponse_json = $response['body'];
    $reponse_array = json_decode($reponse_json, true);
    $response_state = ($response['response']['message']);

    if ($response_state == 'OK') {

        $credits['key'] = $key;
        if (isset($reponse_array['premium'])) {
            $credits['premium'] = $reponse_array['premium'];
        } else {
            $credits['premium'] = 0;
        }

        if (isset($reponse_array['email'])) {
            $credits['email'] = $reponse_array['email'];
        } else {
            $credits['email'] = 0;
        }

        if (isset($reponse_array['phone_number'])) {
            $credits['phone_number'] = $reponse_array['phone_number'];
        } else {
            $credits['phone_number'] = '';
        }

        if (isset($reponse_array['email_address'])) {
            $credits['email_address'] = $reponse_array['email_address'];
        } else {
            if (isset($reponse_array['structure_name'])) {
                $credits['email_address'] = $reponse_array['structure_name'] . '@sh-mail.fr';
            } else {
                $credits['email_address'] = 'wordpress@sh-mail.fr';
            }
        }

        if (isset($reponse_array['structure_name'])) {
            $credits['structure_name'] = $reponse_array['structure_name'];
        } else {
            $credits['structure_name'] = 'wordpress';
        }

        $credits['last_name'] = $reponse_array['last_name'];
        if (isset($reponse_array['mobile'])) {
            $credits['mobile'] = $reponse_array['mobile'];
        } else {
            $credits['mobile'] = '';
        }

        $credits['resultat'] = true;
    } else {
        $credits['resultat'] = false;
        $credits['error'] = __('Unable to establish connection with spot-hit!');
    }
    return $credits;
}

function SPOTHIT_enqueue()
{
    wp_enqueue_style('spothit_bootstrap_style', SH_URL_PATH . 'node_modules/bootstrap/dist/css/bootstrap.min.css');
    wp_enqueue_style('spothit_bootstrap_select_style', SH_URL_PATH . 'node_modules/bootstrap-select/dist/css/bootstrap-select.min.css');
    wp_enqueue_style('spothit_style', SH_URL_PATH . 'assets/css/style.css');
    wp_enqueue_style('bootstrap_datepicker', SH_URL_PATH . 'assets/css/bootstrap-datepicker.min.css');
    wp_enqueue_script('spothit_script', SH_URL_PATH . 'assets/js/scripts.js', 'jquery');

    new SH_Translate;
    SH_Translate::main_script();

    wp_enqueue_script('spothit_pagination', SH_URL_PATH . 'assets/js/twbsPagination.min.js', 'jquery');
    wp_enqueue_script('spothit_bootstrap_bundle', SH_URL_PATH . 'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('spothit_bootstrap_select', SH_URL_PATH . 'node_modules/bootstrap-select/dist/js/bootstrap-select.js');
    wp_enqueue_script('spothit_tiny', SH_URL_PATH . 'node_modules/tinymce/tinymce.min.js');
    wp_enqueue_script('spothit_fa', 'https://kit.fontawesome.com/5d31008a61.js');
    wp_enqueue_script('spothit_chart', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js');
    wp_enqueue_script('spothit_chart', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js');
    wp_enqueue_script('bootstrap_datepicker_scripts', SH_URL_PATH . 'assets/js/bootstrap-datepicker.min.js');
}

function SPOTHIT_enqueue_widget()
{
    wp_enqueue_script('spothit_widget_scripts', SH_URL_PATH . 'assets/js/widget.js', array('jquery'), false, true);
    wp_localize_script(
        'spothit_widget_scripts',
        'spothit_widget',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
        )
    );
    new SH_Translate;
    SH_Translate::widget();


    wp_enqueue_script('google_captcha', 'https://www.google.com/recaptcha/api.js');
    wp_enqueue_script('spothit_bootstrap_bundle', SH_URL_PATH . 'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('spothit_bootstrap_select', SH_URL_PATH . 'node_modules/bootstrap-select/dist/js/bootstrap-select.js');
    wp_enqueue_style('spothit_bootstrap_style', SH_URL_PATH . 'node_modules/bootstrap/dist/css/bootstrap.min.css');
    wp_enqueue_style('spothit_bootstrap_select_style', SH_URL_PATH . 'node_modules/bootstrap-select/dist/css/bootstrap-select.min.css');
}

function SPOTHIT_plugin_initialization()
{
    new SH_Administator;
    SH_Administator::SH_create_database();
    SH_Administator::SH_insert_first_datas();
}

function SPOTHIT_plugin_uninstall()
{
    new SH_Administator;
    SH_Administator::SH_drop_database();
}




function SPOTHIT_database_check()
{

    global $wpdb;
    $database_state = true;


    $table_names = [
        $wpdb->base_prefix . 'spothit_settings',
        $wpdb->base_prefix . 'spothit_hooks',
        $wpdb->base_prefix . 'spothit_hooks_meta'
    ];


    foreach ($table_names as $table_name) {
        $query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));
        if (!$wpdb->get_var($query) == $table_name) {
            $database_state = false;
        }
        return $database_state;
    }
}

function SPOTHIT_create_config()
{
    global $wpdb;

    $database = $wpdb->get_results(
        "SELECT * FROM " . $wpdb->prefix . "spothit_settings"
    );

    $array_config = array();
    foreach ($database as $data) {
        $key = $data->sh_key;
        $value = $data->sh_value;

        if (empty($value)) {
            $array_config[$key] = null;
        } else {
            $array_config[$key] = $value;
        }
    }
    return $array_config;
}
function SPOTHIT_error_admin_notice()
{
?>
    <div>
        <p>
            <?php _e('Fatal error: Spot-Hit plugin database could not be generated !', 'spothit'); ?>
        </p>
    </div>
    <?php
}

function SPOTHIT__alert_levels()
{
    global $credits;

    $body = array(
        'from' => 'wordpress_v2',
        'rest' => '1',
        'key' => $credits['key'],
    );

    $url = 'https://www.spot-hit.fr/api/client/alerts/get';

    $args = array(
        'method' => 'POST',
        'headers' => array(),
        'body' => $body
    );

    $response = wp_remote_post($url, $args);

    $response_json = $response['body'];
    $response_array = json_decode($response_json, true);

    $alert_landing['alerts'] = $response_array['alerts'];
    $alert_landing['email'] = $response_array['email'];
    $alert_landing['sms'] = $response_array['sms'];

    return $alert_landing;
}


function SPOTHIT_lang()
{
    load_plugin_textdomain('spothit', false, basename(dirname(__FILE__)) . '/lang');
}

///////////////////////////////////////////////////////////////
// Affiche une erreur si la version de PHP ou Wordpress
// n'est pas la bonne
///////////////////////////////////////////////////////////////
function SPOTHIT_version_notification(string $type)
{

    global $wpdb;
    global $db_settings;

    $sh_key_search = $type . '_error';

    $database_request = $wpdb->get_results("SELECT sh_key, sh_value FROM $db_settings WHERE sh_key = '$sh_key_search'");

    if ($database_request[0]->sh_value == 1) {
        if ($type == 'php') {
            add_action('admin_notices', function () {
    ?>
                <div class="notice notice-warning is-dismissible">
                    <bold>Spot-Hit</bold>
                    <p>
                        <?php
                        _e('Please note that your PHP version is lower than version 7. The plugin may not work correctly.', 'spothit');
                        ?></p>
                    <a href="#" class="spothit_notice_version font-weight-light" data-type="php" onclick="StopDisplayVersion(this)">Do not display anymore</a>
                </div>
            <?php
            });
        } elseif ($type == 'wordpress') {
            add_action('admin_notices', function () {
            ?>
                <div class="notice notice-warning is-dismissible">
                    <bold>Spot-Hit</bold>
                    <p>
                        <?php
                        _e('Please note that your Wordpress version is lower than version 6. The plugin may not work correctly.', 'spothit');
                        ?>
                    </p>
                    <a href="#" class="spothit_notice_version font-weight-light" data-type="wordpress" onclick="StopDisplayVersion(this)">Do not display anymore</a>
                </div>
<?php
            });
        }
    }
}


add_shortcode('spothit_short', function ($atts) {
    global $wpdb;

    $database_name = $wpdb->prefix . "spothit_settings";
    $database_request_key = $wpdb->get_results(
        "SELECT sh_value FROM $database_name WHERE sh_key = 'captcha_site'"
    );

    if ($database_request_key[0]->sh_value !== null) {
        $website_key = $database_request_key[0];
        $website_key = $website_key->sh_value;

        $title = '';
        $description = '';
        $submit = '';
        $style = 'light';
        $fields_elements = '';

        foreach ($atts as $key => $value) {
            $value = rebuildCharacters($value);
            switch ($key) {
                case 'title':
                    $title =
                        <<<HTML
                            <div class="row">
                                <div class="section-title col-md-12 mb-2">
                                    <h2>$value</h2>
                                </div>
                            </div>
        HTML;
                    break;
                case 'description':
                    $description = <<<HTML
                        <div class="col-md-12" id="spot_description_block">$value</div>
                        HTML;
                    break;
                case 'submit':
                    $submit = $value;
                    break;
                case 'style':
                    $style = $value;
                    break;

                default:
                    var_dump($key);
                    $fields_elements .=
                        <<<HTML
                        <div class="form-group mt-3">
                            <label class="control-label" for="spot_mobile">$value</label>
                            <input class="form-control" type="text" name="$key">
                            <div class="help-block error_msg"></div>
                        </div>
        HTML;
                    break;
            }
        }



        //     // CONDITION DU TITRE DU FORMULAIRE

        $form = <<<HTML
                <section id="spothit_widget" class="col-md-8 col-sm-12 offset-md-2 p-3 section-$style">
                  <div class="container">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                            $title
                            $description
                        </div>
                          <div class="col-md-12">
                              <form id="spothit_widget_form" name="contact-form" >
                                  $fields_elements
                                  <div class="form-group mt-5 d-flex justify-content-center">
                                    <div class="g-recaptcha" data-sitekey="$website_key" data-callback="CaptchaCheckout" data-theme="$style"></div>
                                        <div id="captcha_error_message w-100"></div>
                                  </div>

                                  <div class="form-submit mt-5 d-flex justify-content-end">
                                      <button class="btn btn-common w-100" id="spothit_widget_submit">$submit</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                </section>
                HTML;
    } else {

        $form = <<<HTML
            <section id="spothit_widget" class="col-md-8 col-sm-12 offset-md-2 p-3">
                <h2>Spot-Hit error :</h2>
                <p>Please save your captcha keys to activate the form.</p>
            </section>
            HTML;
    }
    return $form;
});

function spothit_widget_block_init()
{
    register_block_type(__DIR__ . '/widget/build');
}
