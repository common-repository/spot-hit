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
?>



<div class="container-fluid page_title_container">
    <div class="row">
        <div class="col spothit_header">
            <h1 class="m-0"><?php _e('Manual EMAIL campaign', 'spothit') ?></h1>
        </div>
    </div>
</div>

<div class="container-fluid page_content_container page_email_content_container">
    <div class="row">
        <div class="col">

            <div class="spothit_main">

                <div id="spothit_breadcramp">
                    <div data-page="1">
                        <span>1</span>
                        <span><?php _e('Campaign', 'spothit') ?></span>
                    </div>

                    <div data-page="2">
                        <span>2</span>
                        <span><?php _e('Sender', 'spothit') ?></span>
                    </div>

                    <div data-page="3">
                        <span>3</span>
                        <span><?php _e('Contacts', 'spothit') ?></span>
                    </div>

                    <div data-page="4">
                        <span>4</span>
                        <span><?php _e('Email content', 'spothit') ?></span>
                    </div>

                    <div data-page="5">
                        <span>5</span>
                        <span><?php _e('Date', 'spothit') ?></span>
                    </div>

                    <div data-page="6">
                        <span>6</span>
                        <span><?php _e('Confirmation', 'spothit') ?></span>
                    </div>
                </div>

                <div class="spothit_content">
                    <div id="spothit_form" data-action="SH_ajax_api_request" data-url="envoyer/email">

                        <div id="spothit_page_content">
                            <div id="error_notification" style="position: absolute;right:3em;bottom:1em;z-index: 3;">
                            </div>
                            <div data-page="1">
                                <?php require_once(SH_DIR_PATH . 'views/email_campaign/step1.php') ?>
                            </div>
                            <div data-page="2">
                                <?php require_once(SH_DIR_PATH . 'views/email_campaign/step2.php') ?>
                            </div>
                            <div data-page="3">
                                <?php require_once(SH_DIR_PATH . 'views/email_campaign/step3.php') ?>
                            </div>
                            <div data-page="4">
                                <?php require_once(SH_DIR_PATH . 'views/email_campaign/step4.php') ?>
                            </div>
                            <div data-page="5">
                                <?php require_once(SH_DIR_PATH . 'views/email_campaign/step5.php') ?>
                            </div>
                            <div data-page="6">
                                <?php require_once(SH_DIR_PATH . 'views/email_campaign/step6.php') ?>
                            </div>
                        </div>

                        <div id="spothit_page_navigation">
                            <div><button id="spothit_form_submit"><?php _e('Send', 'spothit') ?></button></div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="spothit_preview">
                <div class="smartphone email-preview">
                    <div class="smartphone__top">
                        <span class="speaker"></span>
                        <span class="camera"></span>
                        <span class="hour">16:42</span>
                        <span class="network">
                            <i class="fa-regular fa-signal me-1"></i>
                            <i class="fa-regular fa-battery-half fa-lg"></i>
                        </span>
                    </div>

                    <div class="smartphone__screen">
                        <div class="title">
                            <div class="row mb-2">
                                <div class="col-3 text-end"><?php _e('From', 'spothit') ?> :</div>
                                <div class="col-9"><span class="smartphone_sender"></span></div>
                            </div>
                            <div class="row m-0">
                                <div class="col-3 text-end"><?php _e('Subject', 'spothit') ?> :</div>
                                <div class="col-9"><span class="smartphone_object"></span></div>
                            </div>
                        </div>
                        <div id="msg_preview" class="email-content">
                            <p></p>
                        </div>
                    </div>
                    <div class="smartphone__bottom"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="spothit_errors"></div>