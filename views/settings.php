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

$key = $credits['key'];
global $alert_levels;

$key_length =  strlen($key);
$key_visible = str_split($key, 5);

$key_hidden = $key_visible[0] . '****';

?>

<div class="container-fluid page_title_container">
    <div class="row">
        <div class="col spothit_header">
            <h1 class="m-0"><?php _e('Settings', 'spothit'); ?></h1>
        </div>
    </div>
</div>


<div class="container page_content_container">
    <div class="row">
        <div class="col-md-10 offset-md-1 mt-5">

            <div class="row d-flex justify-content-center widget-settings-block wrap">
                <div class="d-flex flex-column multi-block"">
                    <div class=" text-center thumbnail">
                    <i class="fa-light fa-key alerts_icon"></i>
                </div>
                <div class="text-center sh-widget-title">
                    <h3><?php _e('API key setting', 'spothit') ?></h3>
                </div>
                <a href="#" class="settings-box__link " data-setting="key" data-bs-toggle="modal" data-bs-target="#settingsModal"></a>
            </div>

            <div class="d-flex flex-column multi-block">
                <div class="text-center thumbnail">
                    <i class="fa-light fa-message-lines alerts_icon"></i>
                </div>
                <div class="text-center sh-widget-title">
                    <h3><?php _e('SMS setting', 'spothit') ?></h3>
                </div>
                <a href="#" class="settings-box__link" data-setting="sms" data-bs-toggle="modal" data-bs-target="#settingsModal"></a>
            </div>

            <div class="d-flex flex-column multi-block">
                <div class="text-center thumbnail">
                    <i class="fa-light fa-envelope alerts_icon"></i>
                </div>
                <div class="text-center sh-widget-title">
                    <h3><?php _e('EMAIL setting', 'spothit') ?></h3>
                </div>
                <a href="#" class="settings-box__link" data-setting="email" data-bs-toggle="modal" data-bs-target="#settingsModal"></a>
            </div>

            <div class="d-flex flex-column multi-block">
                <div class="text-center thumbnail">
                    <i class="fa-light fa-bell-on alerts_icon"></i>
                </div>
                <div class="text-center sh-widget-title">
                    <h3><?php _e('Alerts setting', 'spothit') ?></h3>
                </div>
                <a href="#" class="settings-box__link" data-setting="alerts" data-bs-toggle="modal" data-bs-target="#settingsModal"></a>
            </div>

            <div class="d-flex flex-column multi-block">
                <div class="text-center thumbnail">
                    <i class="fa-light fa-bell-on alerts_icon"></i>
                </div>
                <div class="text-center sh-widget-title">
                    <h3><?php _e('Widget setting', 'spothit') ?></h3>
                </div>
                <a href="#" class="settings-box__link" data-setting="widget" data-bs-toggle="modal" data-bs-target="#settingsModal"></a>
            </div>

        </div>
    </div>
</div>
</div>


<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="modal_container">

            <div class="modal-header">
                <h4 class="modal-title modal__title" id="modal_settings_title">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active pt-1">

                        <div class="row modal__info mb-3">
                            <div class="col-md-2" id="modal_settings_icon">
                                <i class="fa-light fa-envelope  display-3"></i>
                            </div>
                            <div class="col-md-10" id="modal_settings_description">
                                <?php _e('You can set your default sender name, default address for sent and recieve Emails, including for automatic campaigns.', 'spothit') ?>

                            </div>
                        </div>



                        <?php
                        require_once(SH_DIR_PATH . 'views/settings/api.php');
                        require_once(SH_DIR_PATH . 'views/settings/sms.php');
                        require_once(SH_DIR_PATH . 'views/settings/email.php');
                        require_once(SH_DIR_PATH . 'views/settings/alerts.php');
                        require_once(SH_DIR_PATH . 'views/settings/widgets.php');
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>