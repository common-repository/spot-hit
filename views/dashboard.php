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

$path = SH_URL_PATH;

global $link;
global $credits;


$id = get_current_user_id();
$user_info = get_userdata($id);
$user_name = $user_info->user_login;


$link_automatic_campaigns = '';

if (is_plugin_active('woocommerce/woocommerce.php')) {
    $str = __('Automatic campaigns management ', 'spothit');

    $link_automatic_campaigns = '
<a class="btn btn-primary" href="' . $link['automating'] . '">
<i class="fa-light fa-user-robot fa-2xl me-2"></i>' . $str . '
</a>';
}
?>

<div id="spothit__dashboard">

    <div class="container-fluid page_title_container">
        <div class="row">
            <div class="col spothit_header">
                <h1 class="m-0"><?php _e('Dashboard', 'spothit'); ?></h1>
            </div>
        </div>
    </div>

    <div class="container-fluid page_content_container">
        <div class="row mb-5">
            <div class="col-md-12 text-center">

                <h2 class="title mt-2 mb-3">
                    <?php _e('Welcome ', 'spothit');
                    echo $user_name; ?> !
                </h2>

                <div class="col-md-12">
                    <a class="btn btn-primary m-1 " href="<?php echo $link['sms'] ?>">
                        <i class="fa-light fa-mobile-button fa-2xl me-2"></i>
                        <?php _e('New SMS campaign', 'spothit'); ?>
                    </a>

                    <a class="btn btn-primary m-1 m-md-0" href="<?php echo $link['email'] ?>"><i class="fa-light fa-envelope fa-2xl me-2"></i>
                        <?php _e('New EMAIL campaign', 'spothit'); ?>
                    </a>

                    <?php
                    if (is_plugin_active('woocommerce/woocommerce.php')) {
                        $str = __('Automatic campaigns management', 'spothit');
                        echo ('
                <a class="btn btn-primary m-1 m-md-0" href="' . $link['automating'] . '">
                <i class="fa-light fa-user-robot fa-2xl me-2"></i>'
                            . $str .
                            '</a>');
                    } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <?php if ($credits['premium'] == 0 && $credits['email'] == 0) { ?>

                    <div id="empty_credits_datas" class="sh-widget widget-credits">
                        <div class="row sh-widget-title">
                            <div class="col-md-12">
                                <h3 class="mb-0"><?php _e('Your credits', 'spothit'); ?></h3>
                            </div>
                        </div>

                        <div class="row sh-widget-content d-flex align-items-center">
                            <div class="col-md-12 text-center icon-alert-credit">
                                <i class="fa-light fa-message-exclamation"></i>
                                <p>
                                    <?php _e('You have no credits', 'spothit'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="row sh-widget-footer">
                            <div class="col-md-12 text-center">
                                <a class="btn btn-primary btn-sm" href="https://www.spot-hit.fr/espace-client/commandes" target="_blank"><?php _e('Click here to buy', 'spothit'); ?></a>
                            </div>
                        </div>
                    </div>


                <?php } else { ?>

                    <div id="set_credits_datas" class="sh-widget widget-credits">
                        <div class="row sh-widget-title">
                            <div class="col-md-12">
                                <h3 class="mb-0"><?php _e('Your credits', 'spothit'); ?></h3>
                            </div>
                        </div>
                        <div class="row sh-widget-content d-flex align-items-center">
                            <div class="col-md-6 text-center diagram-container">
                                <canvas id="credits_diagram" style="max-height: 220px; max-width: 220px; margin: 0 auto;"></canvas>
                            </div>

                            <div class="col-md-6 col-lg-3 col-product-credits">
                                <p class="product-credits"><span class="product-legend" style="background-color: #03A6EF;"></span><span data-sms="<?php echo $credits['premium']; ?>">
                                        <?php echo $credits['premium']; ?>
                                    </span></p>
                                <p class="product-name"><span>SMS</span></p>
                            </div>
                            <div class="col-md-6 col-lg-3 col-product-credits">
                                <p class="product-credits"><span class="product-legend" style="background-color: #48B948;"></span>
                                    <span data-email="<?php echo $credits['email']; ?>">
                                        <?php echo $credits['email']; ?>
                                    </span>
                                </p>
                                <p class="product-name"><span>EMAIL</span></p>
                            </div>
                        </div>
                        <div class="row sh-widget-footer">
                            <div class="col-md-12 text-end">
                                <a class="btn btn-primary btn-sm" href="https://www.spot-hit.fr/espace-client/commandes?c=270392" target="_blank"><?php _e('Buy more credits', 'spothit'); ?></a>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
            <div class="col-md-6">
                <div class="sh-widget widget-campaigns">
                    <div class="row sh-widget-title">
                        <div class="col-md-12">
                            <h3 class="mb-0"><?php _e('Latest campaigns', 'spothit'); ?></h3>
                        </div>
                    </div>
                    <div class="row sh-widget-content">
                        <div class="col-md-12" id="last_campaigns_list">
                            <ul>
                                <!-- La liste est créée dynamiquement dans la fonction "Set__campaign_list" du fichier "functions.php" -->
                            </ul>
                        </div>

                    </div>
                    <div class="row sh-widget-footer">
                        <div class="col-md-12 text-end">
                            <a id="show_all_camapigns" href="https://www.spot-hit.fr/espace-client/envois-effectues" class="btn btn-primary btn-sm" target="_blank"><?php _e('Show all campaigns', 'spothit'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>