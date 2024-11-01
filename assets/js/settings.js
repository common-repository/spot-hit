
jQuery(document).on('ready', () => {

    //****************************************************//
    //**Obtention des données personnalisées de
    //**l'utilisateur
    //****************************************************//
    GetCustomSender('email', 'settings')
    GetCustomSender('sms', 'settings')


    jQuery.post(
        ajaxurl, {
        type: "POST",
        action: "Get__alert_levels",
    },
        function (results) {
            results = JSON.parse(results)

            let alert_state = results.state
            let alert_sms = results.sms
            let alert_email = results.email

            if (alert_state == 1) {
                jQuery('input[data-switch="alerts"]').prop('checked', true)
            }

            for (let i = 0; i < alert_email.length; i++) {
                let element = alert_email[i];
                let tab = jQuery('#email_alerts_scale')
                tab.append('<tr><th scope="row">' + (i + 1) + '</th><td>' + element + '</td></tr>')
            }

            for (let i = 0; i < alert_sms.length; i++) {
                let element = alert_sms[i];
                let tab = jQuery('#sms_alerts_scale')
                tab.append('<tr><th scope="row">' + (i + 1) + '</th><td>' + element + '</td></tr>')
            }

            jQuery('input[name="widget_group"]').on('click', (e) => {
                let container = jQuery('#widget_group_container')
                let element = e.target;
                if (!jQuery(element).is("input")) {
                    element = element.closest('input[name="widget_group"]');
                }
                let choice = parseInt(jQuery(element).val());
                switch (choice) {
                    case 0:
                        container.empty();
                        selectContactsGroup();
                        break;
                    case 1:
                        container.empty();
                        createNewGroup();
                        break;
                }
            })
        }
    );

})








jQuery('.settings-box__link').on('click', (e) => {
    let btn = e.target
    let param = jQuery(btn).attr('data-setting');
    let all_containers = jQuery('.settings_container')
    let title =
    {
        'key': SH_plugin_translate.key_param_title,
        'sms': SH_plugin_translate.sms_param_title,
        'email': SH_plugin_translate.email_param_title,
        'alerts': SH_plugin_translate.alerts_param_title,
        'widget': SH_plugin_translate.widget_param_title
    }
    let icons =
    {
        'key': '<i class="fa-light fa-key  display-3"></i>',
        'sms': '<i class="fa-light fa-message-lines  display-3"></i>',
        'email': '<i class="fa-light fa-envelope  display-3"></i>',
        'alerts': '<i class="fa-light fa-bell-on  display-3"></i>',
        'widget': '<i class="fa-light fa-bell-on  display-3"></i>'
    }
    let description =
    {
        'key': SH_plugin_translate.key_description,
        'sms': SH_plugin_translate.sms_description,
        'email': SH_plugin_translate.email_description,
        'alerts': SH_plugin_translate.alerts_description,
        'widget': SH_plugin_translate.widget_description
    }

    jQuery('#modal_settings_title').text(title[param])
    jQuery('#modal_settings_icon').html(icons[param])
    jQuery('#modal_settings_description').html(description[param])


    for (let i = 0; i < all_containers.length; i++) {
        const element = all_containers[i];
        let setting_attr = jQuery(element).attr('data-setting');

        if (setting_attr != param) {
            jQuery(element).hide()
        } else {
            jQuery(element).show()
        }
    }

})

jQuery('input[data-switch]').on('click', (e) => {
    let target = e.currentTarget;
    let switch_name = jQuery(target).data('switch')
    let switch_checked = jQuery(target).prop('checked');
    let switch_state


    if (switch_checked === true) {
        switch_state = 1
    }
    if (switch_checked === false) {
        switch_state = 0
    }


    if (switch_name == 'alerts') {
        jQuery.post(
            ajaxurl, {
            type: "POST",
            action: "Set__alert_levels",
            url_api: 'login',
            state: switch_state
        }
        );
    }
    else {
        jQuery.post(
            ajaxurl, {
            type: "POST",
            action: "Set__settings_datas",
            type: switch_name,
            state: switch_state
        }
        );
    }
})



jQuery('#spothit_submit_key').on('click', () => {

    let new_api_key = jQuery('input[data-name="api_key"]').val()
    new_api_key = new_api_key.replace(' ', '')


    if (new_api_key.length > 1) {
        if (new_api_key.length < 255) {
            jqxhr = jQuery.post(
                ajaxurl, {
                type: "POST",
                action: "SH_ajax_api_request",
                url_api: 'login',
                data: {
                    'value': new_api_key
                }
            },
                function (results) {
                    results = JSON.parse(results)
                    if (results.state == 1) {
                        show_notification(2, results.msg, false)
                    } else {
                        show_notification(1, results.msg, 2000)
                        setInterval(() => {
                            let url = window.location.href;
                            url = url.replace('spothit_settings', 'spothit')
                            window.location.replace(url);
                        }, 1900);
                    }
                    jqxhr.abort()
                }
            );
        } else {
            show_notification(2, SH_plugin_translate.key_invalid, false)

        }
    } else {
        show_notification(2, SH_plugin_translate.key_insert, false)

    }
})


jQuery('#spothit_submit_sms_settings').on('click', () => {

    let input_sms_number = jQuery('#sender_sms_number').val()
    let input_sms_name = jQuery('#sender_sms_name').val()
    let apply_for_automating = jQuery('#automating_sms_settings').is(':checked')
    let new_sms_number = ''
    let new_sms_name = ''
    let err_state = 0
    let err_mess = []



    var validRegex = /^((\+)33|0)[1-9](\d{2}){4}$/g;
    if (String(input_sms_number).match(validRegex)) {
        new_sms_number = input_sms_number;
    } else {
        err_state = 1
        err_mess.push(SH_plugin_translate.phone_number_invalid)
    }


    if (input_sms_name.length > 2) {

        if (input_sms_name.length <= 11) {
            new_sms_name = input_sms_name
        } else {
            err_state = 1
            err_mess.push(SH_plugin_translate.sender_name_long)
        }
    } else {
        err_state = 1
        err_mess.push(SH_plugin_translate.sender_name_short)

    }

    if (err_state == 0) {
        jqxhr = jQuery.post(
            ajaxurl, {
            type: "POST",
            action: "Set__settings_datas",
            type: 'sms',
            auto_state: apply_for_automating,
            sms_sender: new_sms_name,
            sms_number: new_sms_number
        },
            function (results) {
                err_mess.push(SH_plugin_translate.saved_sms_settings)
                show_notification(1, err_mess, 2000)
                jqxhr.abort()
            }
        );
    } else if (err_state == 1) {
        show_notification(2, err_mess, false)
    }
})



jQuery('#spothit_submit_email_settings').on('click', () => {

    let input_recieve_email_address = jQuery('#sender_recieve_email_address').val()
    let input_send_email_address = jQuery('#sender_send_email_address').val()
    let input_email_name = jQuery('#sender_email_name').val()
    let apply_for_automating = jQuery('#automating_email_settings').is(':checked')

    let new_recieve_email_address = ''
    let new_send_email_address = ''
    let new_email_name = ''

    let err_state = 0
    let err_mess = []




    if (ValidateEmail(input_recieve_email_address)) {
        new_recieve_email_address = input_recieve_email_address;
    } else {
        err_state = 1
        err_mess.push(SH_plugin_translate.recipient_email_invalid)
    }




    if (ValidateEmail(input_send_email_address + '@sh-mail.fr') === true) {
        new_send_email_address = input_send_email_address;
    } else {
        err_state = 1
        err_mess.push(SH_plugin_translate.email_address_invalid)
    }




    if (input_email_name.length > 1) {
        new_email_name = input_email_name
    } else {
        err_state = 1
        err_mess.push(SH_plugin_translate.sender_name_short);
    }

    if (err_state == 0) {
        jqxhr = jQuery.post(
            ajaxurl, {
            type: "POST",
            action: "Set__settings_datas",
            type: 'email',
            auto_state: apply_for_automating,
            email_sender: new_email_name,
            email_send_address: new_send_email_address,
            email_recieve_address: new_recieve_email_address
        },
            function (results) {
                err_mess.push(SH_plugin_translate.saved_email_settings)
                show_notification(1, err_mess, 2000)
                jqxhr.abort()
            }
        );
    } else if (err_state == 1) {
        show_notification(2, err_mess, 2000)
    }
})



function selectContactsGroup() {
    let container = jQuery('<div></div>')
        .attr('id', 'widget_group_selection')
        .addClass('multi_select row mb-3');
    jqxhr = jQuery.post(
        ajaxurl, {
        type: "POST",
        action: "Get_All_Contacts_Groups",
    },
        function (results) {
            jqxhr.abort()
            results = JSON.parse(results);

            if (results != null) {
                jQuery(results).each(function (index, el) {
                    let option = `
                    <div class="col-md-3">
                        <label class="multi_select_label">
                            <input type="radio" name="widget_group_selection" class="group_checkbox" data-groupname="${el.groupe}" value="${el.id}">
                            <div class="multi_select_label_content">
                                <span>${el.groupe}</span>
                            </div>
                        </label>
                    </div>`;
                    jQuery(container).append(option)
                });
                jQuery('#widget_group_container').append(container)
            }

        }
    );
}

function createNewGroup() {
    let input = jQuery('<input></input>')
        .attr('placeholder', SH_plugin_translate.group_name)
        .attr('id', 'new_group')

    jQuery('#widget_group_container').html(`
    <div class="mt-4 d-flex flex-row align-items-center">
            <div class="col-md-3 px-4">
            ${SH_plugin_translate.group_name}
            </div>
            <div class="col-md-9">
                <input id="new_group" class="form-control form-control-lg float-right" type="text" placeholder="${SH_plugin_translate.new_group_name}">
            </div>
    </div>
    `)
}



jQuery('#spothit_submit_widget_key').on('click', () => {
    let err_mess = []
    let err_state = 0;

    let site_key = jQuery('#captcha_website_key').val();
    let secret_key = jQuery('#captcha_secret_key').val();


    if (site_key.length < 3 && OnlySpaces(site_key) == true) {
        err_state = 1
        err_mess.push(SH_plugin_translate.key_site_invalid)
    } else {
        site_key.replace(/\s/g, '')
    }
    if (secret_key.length < 3 && OnlySpaces(secret_key) == true) {
        err_state = 1
        err_mess.push(SH_plugin_translate.key_secret_invalid)
    } else {
        secret_key.replace(/\s/g, '')
    }

    if (err_state == 1) {
        show_notification(2, err_mess, false)
    } else {
        jqxhr = jQuery.post(
            ajaxurl, {
            type: "POST",
            action: "Save_Widget_Key",
            data: {
                'site_key': site_key,
                'secret_key': secret_key,
            }
        },
            function (results) {
                jqxhr.abort()
                results = JSON.parse(results);
                if (results.error_state === 0) {
                    show_notification(1, SH_plugin_translate.key_updated, 2000)
                } else {
                    show_notification(2, results.error_message, 2000)
                }
            }
        );
    }
})

jQuery('#spothit_submit_widget_group').on('click', () => {
    let err_mess = []
    let err_state = 0;
    let group_type = parseInt(jQuery('input[name="widget_group"]:checked').val())
    let group_id = null;
    let group_name = null;

    if (group_type == 0) {
        group_id = jQuery('input[name="widget_group_selection"]:checked').val()
        group_name = jQuery('input[name="widget_group_selection"]:checked').data('groupname')
        if (group_id && group_name.length > 1) {
            jqxhr = jQuery.post(
                ajaxurl, {
                type: "POST",
                action: "Save_Widget_Group",
                data: {
                    'group_type': group_type,
                    'group_name': group_name,
                    'group_id': group_id,
                }
            },
                function (results) {
                    jqxhr.abort()
                    results = JSON.parse(results);
                    console.log(results);
                    console.log(results.error_state);
                    if (results.error_state == false) {
                        show_notification(1, SH_plugin_translate.group_updated, 2000)
                        jQuery('#widget_current_group').text(group_name);
                    } else {
                        show_notification(2, SH_plugin_translate.fail_group_update, 2000)
                    }
                }
            );
        } else {
            show_notification(2, SH_plugin_translate.select_group, 2000)
        }

    } else if (group_type == 1) {

        group_name = jQuery('#new_group').val()

        if (group_name.length >= 2) {
            jqxhr = jQuery.post(
                ajaxurl, {
                type: "POST",
                action: "Save_Widget_Group",
                data: {
                    'group_type': group_type,
                    'group_name': group_name,
                }
            },
                function (results) {
                    jqxhr.abort()
                    results = JSON.parse(results);
                    if (results.error_state == false) {
                        show_notification(1, SH_plugin_translate.group_updated, 2000)
                        jQuery('#widget_current_group').text(group_name);
                    } else {
                        show_notification(2, SH_plugin_translate.fail_group_update, 2000)
                    }
                }
            );
        } else {
            show_notification(2,SH_plugin_translate.write_name_group, 2000)
        }
    } else {
        show_notification(2, SH_plugin_translate.select_group, 2000)
    }
})
