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

global $credits;
global $alert_levels;

$sms_level = 0;
$email_level = 0;
$sms_state = 0;
$email_state = 0;


$alert_state = $alert_levels['alerts'];
if (isset($alert_levels['sms'][0]) && !empty($alert_levels['sms'][0])) {
    $sms_level = $alert_levels['sms'][0];
}
if (isset($alert_levels['email'][0]) && !empty($alert_levels['email'][0])) {
    $email_level = $alert_levels['email'][0];
}

?>


<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php?page=spothit"><img src="<?php echo SH_URL_PATH ?>/assets/img/logo.png"
                alt="logo spothit"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><?php _e('Manual campaigns', 'spothit'); ?></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="admin.php?page=spothit_sms_campaign">SMS</a></li>
                        <li><a class="dropdown-item" href="admin.php?page=spothit_email_campaign">Email</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="link"
                        href="admin.php?page=spothit_automatisation"><?php _e('Automatic campaigns', 'spothit'); ?></a>
                </li>
            </ul>
            <span class="navbar-text">
                <span>
                    <?php echo $credits['premium']; ?> SMS
                    |
                    <?php echo $credits['email']; ?> EMAIL
                </span>
            </span>
            <span class="navbar-text navbar-actions">


                <!-- if ($alert_state == 1) {
                    if ($credits['email'] < $email_level || $credits['premium'] < $sms_level) {
                        if (isset($credits['email']) && $credits['email'] < $email_level) {
                            $email_state = 1;
                        }

                        if (isset($credits['premium']) && $credits['premium'] < $sms_level) {
                            $sms_state = 1;
                        }

                        echo <<<HTML
<a href="#" id="alert_btn_header" data-sms-alert="{$sms_state}" data-email-alert="{$email_state}"><i class="fa-regular fa-message-exclamation text-warning"></i></a>
HTML;
                    }
                } -->
                <a href="admin.php?page=spothit_settings"><i class="fa-light fa-gear"></i></a>
                <a href="admin.php?page=spothit_buy"><i class="fa-light fa-cart-arrow-down"></i></a>
            </span>
        </div>
    </div>
</nav>
<?php

if ($alert_state == 1) {

    $alert_band = '<div id="spothit_credits_alert" class="alert alert-warning w-100 mb-0 text-center p-0">';
    if ($credits['premium'] == 0 && $credits['email'] == 0) {
        $alert_band.='<p class="m-3">'.__('Warning, your credit balance has expired. Automatic campaigns will not be sent.', 'spothit').'</p>';
    }
    elseif ($credits['email'] < $email_level && $credits['premium'] < $sms_level) {
        $alert_band.='<p class="m-3">'.__('Warning, SMS credits and EMAIL credits are low. In case you have no more credit, the automatic campaigns will not be sent.', 'spothit').'</p>';
    }
    elseif ($credits['email'] > $email_level && $credits['premium'] < $sms_level) {
        $alert_band.='<p class="m-3">'.__('Warning, you don\'t have credits for sending SMS. Automatic campaigns will not be sent.', 'spothit').'</p>';

    } elseif ($credits['premium'] > $sms_level && $credits['email'] < $email_level) {
        $alert_band.='<p class="m-3">'.__('Warning, you don\'t have credits for sending Emails. Automatic campaigns will not be sent.', 'spothit').'</p>';

    }
    $alert_band.='</div>';

    echo $alert_band;

} ?>