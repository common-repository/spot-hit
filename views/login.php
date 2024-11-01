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

?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php?page=spothit"><img src="<?php echo ($path . "/assets/img/logo.png") ?>"
                alt="logo spothit"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div id="spothit__login">

    <div class="spothit_content">

        <div>
            <div class="page_title mb-4 col-lg-12">
                <h2><?php _e('Login', 'spothit') ?></h2>
            </div>

            <div class="mb-5" id="spothit_form" data-action="SH_ajax_api_request" data-url="login">

                <input type="password" class="form-control" data-name="api_key"
                    placeholder="<?php _e('Insert your API key', 'spothit'); ?>">

                <a target="_blank"
                    href="https://www.spot-hit.fr/espace-client/parametres/api"><?php _e("You don't know your key ?", "spothit"); ?></a>

                <button id="spothit_submit_btn" class="btn btn-primary">
                    <?php _e('Submit', 'spothit'); ?>
                </button>


            </div>

            <div class="col-lg-12">
                <p><?php _e('You are not registered yet ?', 'spothit'); ?></p>
                <a target="_blank"
                    href="https://www.spot-hit.fr/inscription?from=wordpress"><?php _e('Join us !', 'spothit') ?></a>
            </div>
        </div>



    </div>
</div>

<div id="spothit_errors">
</div>