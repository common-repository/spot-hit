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

global $hook_list;

$content_admin = '';
$content_customer = '';

foreach ($hook_list as $value) {
    $state_email = '';
    $state_sms = '';
    $hook_name = $value['name'];
    $hook_id = $value['id'];
    $hook_sms_state = $value['sms'];
    $hook_email_state = $value['email'];
    $hook_type = $value['type'];

    if ($hook_email_state == 1) {
        $state_email = 'checked';
    }
    if ($hook_sms_state == 1) {
        $state_sms = 'checked';
    }

    if ($hook_name == 'new_customer') {
        $hook_title = __('New customer', 'spothit');
        $description = __('A new user has registered', 'spothit');
    }
    if ($hook_name ==  'new_order') {
        $hook_title = __('New order', 'spothit');
        $description = __('A new order has been registered', 'spothit');
    };
    if ($hook_name == 'pending_payment') {
        $hook_title = __('Pending payment', 'spothit');
        $description = __('The order is awaiting payment', 'spothit');
    };
    if ($hook_name ==  'processing') {
        $hook_title = __('Processing', 'spothit');
        $description = __('The order is being processed', 'spothit');
    };
    if ($hook_name ==  'onhold') {
        $hook_title = __('On hold', 'spothit');
        $description = __('The order is on hold', 'spothit');
    };
    if ($hook_name ==  'completed') {
        $hook_title = __('Completed', 'spothit');
        $description = __('The order is completed', 'spothit');
    };
    if ($hook_name ==  'cancelled') {
        $hook_title = __('Cancelled', 'spothit');
        $description = __('The order is cancelled', 'spothit');
    };
    if ($hook_name ==  'refunded') {
        $hook_title = __('Refounded', 'spothit');
        $description = __('The order is refunded', 'spothit');
    };
    if ($hook_name ==  'failed') {
        $hook_title = __('Failed', 'spothit');
        $description = __('The order is failed', 'spothit');
    };

    if ($hook_type == 0) {
        $card = create_hook_card($hook_title, $hook_name, $description, $hook_type, $state_sms, $state_email, 0);
        $content_admin .= $card;
    }
    if ($hook_type == 1) {
        $card = create_hook_card($hook_title, $hook_name, $description, $hook_type, $state_sms, $state_email, 1);
        $content_customer .= $card;
    }
}


function create_hook_card($title, $name, $description, $type, $state_sms, $state_email, $role)
{
    $card = <<<HTML
        <div class="col-md-3">
            <div class="hook_card automatic_campaign_card">
                <div class="row">
                    <h4><i class="fa-light fa-cart-shopping fa-lg me-2"></i>{$title}</h4>
                    <p>{$description}</p>
                </div>
                <div class="row d-flex justify-content-between">
                    <div class="col d-flex">
                        <a href="#" class="hook_edit me-1 mb-1" data-hookname="{$name}" data-hooktitle="{$title}"
                            data-role="{$type}" data-bs-toggle="modal" data-bs-target="#campaignModal">
                            <i class="fa-light fa-pen-to-square"></i>
                        </a>
                    </div>
                    <div class="col d-flex">
HTML;
    if ($name == 'new_customer' && $role == 1) {
        $card .= '';
    } else {
        $card .= <<<HTML
    <label class="switch-label switch-with-text me-1 mb-1">
        <input type="checkbox" class="switch-input hook_switch" data-name="{$name}"
        data_hooktitle="{$title}" data-type="sms" data-role="{$role}" {$state_sms}>
        <span class="switch-btn-container">
            <span class="switch-bg">
                <span class="switch-bg-text switch-bg-text-active">SMS</span>
                <span class="switch-btn"></span>
                <span class="switch-bg-text switch-bg-text-inactive">SMS</span>
            </span>
        </span>
    </label>
HTML;
    }

    $card .= <<<HTML
                        <label class="switch-label switch-with-text mb-1">
                            <input type="checkbox" class="switch-input hook_switch" data-name="{$name}"
                                data_hooktitle="{$title}" data-type="email" data-role="{$role}" {$state_email}>
                            <span class="switch-btn-container">
                                <span class="switch-bg">
                                    <span class="switch-bg-text switch-bg-text-active">EMAIL</span>
                                    <span class="switch-btn"></span>
                                    <span class="switch-bg-text switch-bg-text-inactive">EMAIL</span>
                                </span>
                            </span>
                        </label>

                    </div>
                </div>

            </div>
        </div>
HTML;



    return $card;
}

?>


<div class="container-fluid page_title_container mb-3">
    <div class="row">
        <div class="col spothit_header">
            <h1 class="m-0"><?php _e('Automatic campaigns', 'spothit') ?></h1>
        </div>
    </div>
</div>

<div class="container-fluid page_content_container page_automatic_campaign_content_container" id="spothit_container"
    data-url="automating">
    <div class="row">
        <div class="col">
            <h2 class="mb-3"><?php _e('Campaign management for admin', 'spothit') ?></h2>
        </div>
    </div>
    <div class="row mb-3">
        <?php echo $content_admin ?>
    </div>
    <div class="row">
        <div class="col">
            <h2 class="mb-3"><?php _e('Campaign management for customers', 'spothit') ?></h2>
        </div>
    </div>
    <div class="row mb-3">
        <?php echo $content_customer ?>
    </div>
</div>

<div class="modal fade" id="campaignModal" tabindex="-1" role="dialog" aria-labelledby="campaignLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="modal_container">
            <div class="modal-header">
                <h5 class="modal-title modal__title" id="modal_hook_title"><?php _e('Hook name', 'spothit') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <label class="nav-link active" for="sms_editor" data-bs-toggle="tab"
                            data-bs-target="#nav-sms-campaign" type="button" role="tab" aria-controls="nav-sms-campaign"
                            aria-selected="true">
                            <input type="radio" name="edit_hook_choice" id="sms_editor" value="sms" checked>
                            <i class="fa-light fa-mobile-button fa-lg me-2"></i><?php _e('SMS campaign', 'spothit') ?>
                            <label class="switch-label switch-with-text ms-2">
                                <input type="checkbox" class="switch-input" data-switch="sms">
                                <span class="switch-btn-container">
                                    <span class="switch-bg">
                                        <span
                                            class="switch-bg-text switch-bg-text-active"><?php _e('Yes', 'spothit') ?></span>
                                        <span class="switch-btn"></span>
                                        <span
                                            class="switch-bg-text switch-bg-text-inactive"><?php _e('No', 'spothit') ?></span>
                                    </span>
                                </span>
                            </label>
                        </label>
                        <label class="nav-link" for="email_editor" data-bs-toggle="tab"
                            data-bs-target="#nav-email-campaign" type="button" role="tab"
                            aria-controls="nav-email-campaign" aria-selected="false">
                            <input type="radio" name="edit_hook_choice" id="email_editor" value="email">
                            <i class="fa-light fa-envelope fa-lg me-2"></i><?php _e('Email campaign', 'spothit') ?>
                            <label class="switch-label switch-with-text ms-2">
                                <input type="checkbox" class="switch-input" data-switch="email">
                                <span class="switch-btn-container">
                                    <span class="switch-bg">
                                        <span
                                            class="switch-bg-text switch-bg-text-active"><?php _e('Yes', 'spothit') ?></span>
                                        <span class="switch-btn"></span>
                                        <span
                                            class="switch-bg-text switch-bg-text-inactive"><?php _e('No', 'spothit') ?></span>
                                    </span>
                                </span>
                            </label>
                        </label>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active pt-5">
                        <div class="row d-flex align-items-center mb-3">
                            <div class="col-md-3"><?php _e('Sender name', 'spothit') ?></div>
                            <div class="col-md-6">
                                <input type="text" id="edit_hook_sender_name"
                                    class="form-control form-control-lg d-inline-block align-middle"
                                    placeholder="Sender name" data-name="sender_name">
                            </div>
                        </div>
                        <div class="additionnal_inputs_email">
                            <div class="row d-flex align-items-center mb-3">
                                <div class="col-md-3"><?php _e('Custom Email address', 'spothit') ?></div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="edit_hook_address"
                                            class="form-control form-control-lg d-inline-block align-middle"
                                            placeholder="<?php _e('Email address', 'spothit') ?>"
                                            data-name="email_address">
                                        <div class="input-group-text">@sh-mail.fr</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center mb-3">
                                <div class="col-md-3"><?php _e('Email subject', 'spothit') ?></div>
                                <div class="col-md-6">
                                    <input type="text" id="edit_hook_object"
                                        class="form-control form-control-lg d-inline-block align-middle"
                                        placeholder="<?php _e('Email subject', 'spothit') ?>" data-name="email_object"">
                                </div>
                            </div>
                        </div>
                        <div class=" row mb-3">
                                    <div class="col-md-12">
                                        <textarea id="edit_hook_message"
                                            placeholder="<?php _e('Write your message in this field', 'spothit') ?>"
                                            data="campaign" class="message_textarea" data-name="message"></textarea>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center mb-3" id="stopsms">
                                    <div class="col-md-3"><?php _e('STOP SMS 36200', 'spothit') ?></div>
                                    <div class="col-md-2">
                                        <label class="switch-label">
                                            <input type="checkbox" class="switch-input stop_btn" data-switch="stop">
                                            <span class="switch-btn-container">
                                                <span class="switch-bg">
                                                    <span class="switch-btn"></span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-7 text-end">
                                        <span class="character_count">
                                            <span class="character_count_size">0</span>/
                                            <span class="character_count_max">160</span>
                                            <span><?php _e('characters', 'spothit') ?> - </span>
                                            <span class="character_count_number">0</span>
                                            <span>SMS</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center mb-3">
                                    <div class="col-md-3"><?php _e('Insert variable', 'spothit') ?></div>
                                    <div class="col-md-4" id="hook_var">
                                        <select class="selectpicker hook_var" id="select_var" data-live-search="true"
                                            data-width="100%" title="{{ <?php _e('Select a variable', 'spothit') ?> }}">
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="hook_var">
                                        <a role="button" class="text-muted" id="variables_infos">
                                            <small><?php _e('Important informations', 'spothit') ?></small></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal"><?php _e('Cancel', 'spothit') ?></button>
                        <button type="button" id="modal_send_btn"
                            class="btn btn-primary"><?php _e('Save', 'spothit') ?></button>
                    </div>
                </div>

            </div>
        </div>

        <div id="spothit_errors"></div>