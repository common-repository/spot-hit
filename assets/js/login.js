
jQuery('#spothit_submit_btn').on('click', () => {
    let api_key = jQuery('input[data-name="api_key"]').val()
    let error = ''

    if (api_key == '' || api_key == null || api_key == undefined) {
        error = SH_plugin_translate.write_api
        show_notification(2,error, false)

    }

    if (api_key.length > 0) {
        jqxhr = jQuery.post(
            ajaxurl, {
                type: "POST",
                action: "Set__settings",
                api_key: api_key,

            },
            function (results) {
                results = JSON.parse(results)
                if(results.error_state === 1) {
                    error_message = spothit_errors_list(results.error_message)
                    show_notification(2, error_message, false)

                }
                if(results.error_state === 0) {
                    show_notification(1, SH_plugin_translate.correct_api, 3000)
                    setTimeout(() => {
                        let url = window.location.href
                        window.location.replace(url)
                    }, 2500);
                }
                jqxhr.abort();
            }
            )
        }
})
