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

<div id="spothit_loader">
    <div class="content">
        <div class="logo mb-1">
            <img src="<?php echo SH_URL_PATH; ?>/assets/img/logo-spot-hit.svg" alt="logo spothit">
        </div>
        <span class="slogan mb-5">
            <?php _e('Online sending platform', 'spothit'); ?>
            <br>
            <strong>
                <?php _e('100% multicanal', 'spothit'); ?>
            </strong>
        </span>
        <span class="state">
            <?php _e('Loading...', 'spothit'); ?>
        </span>
        <div class="loader">
        </div>
    </div>
</div>