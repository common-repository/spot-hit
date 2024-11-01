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

$content = <<<HTML
  <div id="spothit_notification">
      <div class="content">
          <div class="state_icon success">
          </div>
          <div class="message">
        </div>
          <div class="list">
        </div>
        <span id="spothit_notification_close_btn"><i class="fa-solid fa-xmark-large"></i></span>
      </div>
  </div>
HTML;

echo $content;