let btn_edition = jQuery(".hook_edit")
let hook_switch = jQuery('.hook_switch')
let new_state = Number;
let send_btn = jQuery('#modal_send_btn')

hook_switch.on('click', (e) => {
    let btn = e.currentTarget
    let role = jQuery(btn).attr('data-role')
    let type = jQuery(btn).attr('data-type')
    let hook_name = jQuery(btn).attr('data-name')
    let switch_action

    if (jQuery(btn).is(':checked')) {
        switch_action = 1

    } else {
        switch_action = 0
    }
    jQuery.post(
        ajaxurl, {
            type: "POST",
            action: 'Update_hook_status',
            hook_type: type,
            hook_name: hook_name,
            hook_role: role,
            switch_action: switch_action,
        }
    )
})

jQuery("#campaignModal").find('.switch-input').on('click', function (e) {
    let btn = e.currentTarget



    let role = jQuery('#modal_send_btn').attr('data-hookrole')
    let hook_name = jQuery('#modal_send_btn').attr('data-hookname')
    let type = jQuery(btn).attr('data-switch')

    let selection = jQuery('input[name=edit_hook_choice]:checked').val()

    if (type != selection) {
        switch (type) {
            case 'email':
                jQuery('#email_editor').trigger('click')
                break;
            case 'sms':
                jQuery('#sms_editor').trigger('click')
                break;
        }

    }


    let switch_on_main = jQuery('.hook_switch[data-name="' + hook_name + '"][data-type="' + type + '"][data-role="' + role + '"]')
    if (jQuery(btn).is(':checked')) {
        switch_on_main.prop('checked', true)
        switch_action = 1
    } else {
        switch_on_main.prop('checked', false)
        switch_action = 0
    }
    jQuery.post(
        ajaxurl, {
            type: "POST",
            action: 'Update_hook_status',
            hook_type: type,
            hook_name: hook_name,
            hook_role: role,
            switch_action: switch_action,
        }
    );
})




btn_edition.on("click", (e) => {
    let element = e.currentTarget
    let hook_name = jQuery(element).attr('data-hookname')
    let hook_title = jQuery(element).attr('data-hooktitle')
    let hook_role = jQuery(element).attr('data-role')
    let var_list_type = 2

    let datas = [{
        hook_name: hook_name,
        hook_role: hook_role,
    }]

    jQuery('#modal_hook_title').html(hook_title)
    jQuery(send_btn).attr({
        "data-hookname": hook_name,
        "data-hookrole": hook_role
    })

    if (hook_name == 'new_customer') {
        var_list_type = 1

        if (hook_role == 1) {
            jQuery('label[for="sms_editor"]').hide()
        } else {
            jQuery('label[for="sms_editor"]').css('display', 'block')
        }
    }

    jQuery.post(
        ajaxurl, {
            type: "POST",
            action: 'Variables_list',
            data: var_list_type,
        },
        function (response) {
            let picker_var = jQuery('#select_var')
            picker_var.empty()
            picker_var.selectpicker('destroy')
            picker_var.append(response)
            picker_var.selectpicker()
        }
    );
    jQuery.post(
        ajaxurl, {
            type: "POST",
            action: 'Get__hook_status',
            hook: datas,
        },
        function (response) {
            response = JSON.parse(response);

            if (response.status_email == 1) {
                jQuery('input[type="checkbox"][data-switch="email"]').prop("checked", true)
            } else {
                jQuery('input[type="checkbox"][data-switch="email"]').prop("checked", false)
            }
            if (response.status_sms == 1) {
                jQuery('input[type="checkbox"][data-switch="sms"]').prop("checked", true)
            } else {
                jQuery('input[type="checkbox"][data-switch="sms"]').prop("checked", false)
            }
        }
    )
    ////////////////////////////////////////////////////////////////////////////
    // On appel la fonction sms_radio_click pour obtenir les infos SMS
    // comme valeurs par défaut pour le modal
    ////////////////////////////////////////////////////////////////////////////
    // sms_radio_click()
    if (hook_name == 'new_customer' && hook_role == 1) {
        jQuery('#email_editor').trigger('click')
    } else {
        jQuery('#sms_editor').trigger('click')
    }
})



send_btn.on('click', (e) => {
    let btn = e.currentTarget
    let hook_type = jQuery('input[name="edit_hook_choice"]:checked').val()
    let role_hook = jQuery(btn).attr("data-hookrole")
    let name_hook = jQuery(btn).attr("data-hookname")

    let error_state = 0
    let error_list = []

    let data_array = [{
            hook_type: hook_type
        },
        {
            hook_role: role_hook
        },
        {
            hook_name: name_hook
        }
    ]

    if (hook_type == 'email') {
        let message = tinymce.activeEditor.getContent()
        let object = jQuery('#edit_hook_object').val()
        let sender_address = jQuery('#edit_hook_address').val()
        let sender_name = jQuery('#edit_hook_sender_name').val()

        //////////////////////////////////
        // Verification du message
        //////////////////////////////////

        if (message.length > 1) {
            data_array.push({
                message: message
            })
        } else {
            error_state = 1
            // error_list.push('Write a message')
            error_list.push(SH_plugin_translate.msg_empty)
        }
        //////////////////////////////////
        // Verification de l'objet du email
        //////////////////////////////////
        if (object.length >= 1) {
            data_array.push({
                email_object: object
            })
        } else {
            error_state = 1
            // error_list.push('Write a email subject')
            error_list.push(SH_plugin_translate.subject_empty)
        }
        //////////////////////////////////
        // Verification de l'adresse email
        // de l'expéditeur
        //////////////////////////////////
        if (sender_address.length > 1) {
            if (ValidateEmail(sender_address + '@sh-mail.fr') === true || OnlySpaces(sender_address) === false) {
                data_array.push({
                    email_address: sender_address
                })
            } else {
                error_state = 1
                // error_list.push('Email address is invalid')
                error_list.push(SH_plugin_translate.email_invalid)
            }
        } else {
            error_state = 1
            error_list.push(SH_plugin_translate.email_invalid)

        }
        //////////////////////////////////
        // Verification de l'expéditeur
        //////////////////////////////////

        if (sender_name.length > 3) {
            data_array.push({
                sender_name: sender_name
            })
        } else {
            error_state = 1
            error_list.push(SH_plugin_translate.sender_name_short)
        }
    }




    if (hook_type == 'sms') {
        let sender_name = jQuery('#edit_hook_sender_name').val()
        let message = jQuery("#edit_hook_message").val()

        //////////////////////////////////
        // Verification du message
        //////////////////////////////////
        if (message.length > 1) {
            data_array.push({
                message: message
            })
        } else {
            error_state = 1
            error_list.push(SH_plugin_translate.msg_short)
        }

        //////////////////////////////////
        // Verification de l'expéditeur
        //////////////////////////////////
        if (sender_name.length > 0) {
            if (sender_name.length <= 11) {
                data_array.push({
                    sender_name: sender_name
                })
            } else {
                error_state = 1
                error_list.push(SH_plugin_translate.sender_name_long)
            }
        }
    }

    if (error_state == 0) {
        jQuery.post(
            ajaxurl, {
                type: "POST",
                action: 'Set__hook_status',
                data: data_array,
            },
            function (response) {
                show_notification(1, SH_plugin_translate.saved, 2500)
            }
        );

    } else if (error_state == 1) {
        show_notification(2, error_list, false)
    }

})


let sms_radio_btn = jQuery('#sms_editor')
let email_radio_btn = jQuery('#email_editor')

sms_radio_btn.on('click', () => {
    sms_radio_click()
})
email_radio_btn.on('click', () => {
    email_radio_click()
})

function add_custom_var_into_message() {
    jQuery('.hook_var').on('change', function () {
        let hook_type = jQuery('input[name="edit_hook_choice"]:checked').val()
        let value = jQuery(this).val()
        value = '{{' + value + '}}';
        if (hook_type == 'email') {
            tinymce.activeEditor.execCommand('mceInsertContent', false, value);
        }
        if (hook_type == 'sms') {
            let textarea = jQuery('#edit_hook_message');
            let cursor_position = textarea[0].selectionStart;
            var textarea_content = textarea.val();
            textarea.val(textarea_content.substring(0, cursor_position) + value + textarea_content.substring(cursor_position) );
        }
    });
}

add_custom_var_into_message()

jQuery('#edit_hook_message').on('keyup change', () => {
    message = jQuery('#edit_hook_message').val()
    MessageLength(message);
})

// modal_send_btn.click(() => {
//     let hook_type = jQuery('input[name="edit_hook_choice"]:checked').val()
//     let datas_array = []
//     let message = jQuery('#modal__message').val()
//     let message = jQuery('#modal__message').val()
//     let message = jQuery('#modal__message').val()

//     if (hook_type == 'sms') {
//         data_array.push(
//             message => message,
//             hook_role => role,
//             hook_name => hook_name,
//         );
//     }
//     if (hook_type == 'email') {

//     }

//     request('SH_ajax_update_hook_meta', data_array)

// })




//     inputs_switch.click(function(e) {
//         let input = jQuery(this);
//         let hook_name = (jQuery(input).data('name'));
//         let hook_type = (jQuery(input).data('type'));
//         let hook_role = (jQuery(input).data('role'));
//         let data_array = [];
//         data_array.push(
//             name => hook_name,
//             type => hook_type,
//             role => hook_role,
//         );

//         if (jQuery(input).is(':checked')) {
//             new_state = 1;
//             data_array.push(
//                 value => new_state,
//             );

//             request('SH_ajax_update_hook_status', data_array);



//         } else {
//             new_state = 0;
//             data_array.push(
//                 value => new_state,
//             );

//             request('SH_ajax_update_hook_status', data_array);
//         }
//     });

jQuery(document).on('ready', () => {
    StopSMS()

    jQuery('#variables_infos').on('click', () => {
        let popup_content = SH_plugin_translate.popup_infos
        show_notification(false, popup_content, false)
    })
})




function sms_radio_click() {
    let hook_name = jQuery('#modal_send_btn').attr('data-hookname')
    let hook_role = jQuery('#modal_send_btn').attr('data-hookrole')
    let sender_name_input = jQuery('#edit_hook_sender_name')

    sender_name_input.attr('maxlength', '11')
    jQuery('.additionnal_inputs_email').hide().children().hide()
    jQuery('#stopsms').show().children().show()
    jQuery('#edit_hook_sender_name').attr('maxlength', '11')
    tinymce.remove('#edit_hook_message')

    jQuery.post(
        ajaxurl, {
            type: "POST",
            action: 'Get__hook_datas',
            hookname: hook_name,
            hookrole: hook_role,
            hooktype: 'sms',
        },
        function (response) {
            response = JSON.parse(response);
            jQuery('#edit_hook_sender_name').val(response.sender_name)
            jQuery('#edit_hook_message').val(response.message)
            MessageLength(response.message);
        }
    );
}

function email_radio_click() {
    let hook_name = jQuery('#modal_send_btn').attr('data-hookname')
    let hook_role = jQuery('#modal_send_btn').attr('data-hookrole')
    let sender_name_input = jQuery('#edit_hook_sender_name')

    sender_name_input.attr('maxlength', '200')
    jQuery('.additionnal_inputs_email').show()
    jQuery('#stopsms').hide()
    jQuery('#stopsms').children().hide()
    jQuery('#edit_hook_message').val('')
    jQuery.post(
        ajaxurl, {
            type: "POST",
            action: 'Get__hook_datas',
            hookname: hook_name,
            hookrole: hook_role,
            hooktype: 'email',
        },
        function (response) {
            response = JSON.parse(response);
            tinymce.init({
                selector: "#edit_hook_message",
                branding: false,
                setup: function (editor) {
                    editor.on('init', function (e) {
                        editor.setContent(response.message);
                    });
                }
            })
            jQuery('#edit_hook_address').val(response.sender_address)
            jQuery('#edit_hook_sender_name').val(response.sender_name)
            jQuery('#edit_hook_message').val(response.message)
            jQuery('#edit_hook_object').val(response.object)
        }
    );
}