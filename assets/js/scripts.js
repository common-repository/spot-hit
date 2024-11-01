ShowLoader()
jQuery(document).on('ready', () => {
  HideLoader()
  hide_spothit_notification()


  //? Ajout alert bandeau
  jQuery('#alert_btn_header').on('click', (e) => {
    let alert_msg = []

    let sms_state = jQuery('#alert_btn_header').data('sms-alert')
    let email_state = jQuery('#alert_btn_header').data('email-alert')
    alert_msg.push('<i style="font-size: 50px;" class="fa-solid fa-comment-exclamation text-warning mb-3"></i>')
    if (sms_state == 1) {
      alert_msg.push(SH_plugin_translate_main.sms_credits_alert_err)
    }
    if (email_state == 1) {
      alert_msg.push(SH_plugin_translate_main.email_credits_alert_err)
    }
    show_notification(false, alert_msg, false)
  })
  //? END Ajout alert bandeau

  jQuery('.summary-block').on('click', (e) => {
    let page_number = jQuery(e.currentTarget).data('summary-block')
    jQuery("#spothit_page_navigation").twbsPagination('show', page_number)
  })
})

let submit_btn = jQuery("#spothit_form_submit");

const spothit_form = jQuery("#spothit_form");
let type_request = spothit_form.data("url");


if (type_request == "login") {
  var datas = [];

  submit_btn.on("click", (e) => {
    let input_login = jQuery('input[data-name="key"]');
    e.preventDefault();

    datas.push({
      name: "key",
      value: input_login.val(),
    });
  });
}



function MessageLength(msg) {
  var size1sms = 160;
  var sizexsms = 153;
  var res = 0;
  let sms_count_summary = jQuery('.summary_nb_sms')

  jQuery.post(
    ajaxurl, {
    type: "POST",
    action: "Characters_checker",
    message: msg,
  },
    function (results) {
      results = JSON.parse(results)
      nbr = results[0]
      if (nbr == 0) {
        sms_nb = 0;
      } else if (nbr <= size1sms) {
        sms_nb = 1;
      } else {
        sms_nb = Math.ceil(nbr / sizexsms)
      }


      if (sms_nb <= 1) {

        sms_max = size1sms
        jQuery(".character_count_max").text(sms_max)
        if (sms_nb == 0) {
          res = 0
        } else {
          res = nbr - (sms_nb - 1) * sizexsms
        }

      } else {
        sms_max = sizexsms
        jQuery(".character_count_max").text(sms_max)
        res = nbr - (sms_nb - 1) * sizexsms
      }



      jQuery(".character_count_size").text(res)
      jQuery(".character_count_number").text(sms_nb)


      if (sms_count_summary.length >= 1) {

        if (nbr <= 0) {
          sms_nb = 0
        }
        sms_count_summary.html(sms_nb)
      }
    }
  );
}




function CampaignPagination() {
  var pagination__submit_btn = jQuery("li #spothit_form_submit");
  var pagination__submit_btn = jQuery("#spothit_form_submit");
  var pagination__count_pages = jQuery(
    "#spothit_page_content div[data-page]"
  ).length;
  let braidcramp = jQuery("#spothit_breadcramp div");

  jQuery(braidcramp).on('click', (e) => {
    let click_page_number = jQuery(e.currentTarget).data('page');
    jQuery("#spothit_page_navigation").twbsPagination('show', click_page_number)

  });

  jQuery("#page-content div").hide();
  pagination__submit_btn.parent().hide();
  jQuery("#spothit_page_navigation").twbsPagination({
    totalPages: pagination__count_pages,
    startPage: 1,
    visiblePages: 0,
    paginationClass: null,
    prev: SH_plugin_translate_main.previous_step,
    prevClass: "btn--success previous_page",
    next: SH_plugin_translate_main.next_step,
    nextClass: "btn--success next_page",
    last: "",
    first: "",
    onPageClick: function (event, active_page) {
      let array_pages = jQuery("#spothit_page_content div[data-page]");
      jQuery(array_pages).each(function () {
        let number_of_page = jQuery(this).attr("data-page");
        jQuery(this).hide();
        if (number_of_page == active_page) {
          jQuery(this).show();
          if (active_page == pagination__count_pages) {
            pagination__submit_btn.parent().show();
          } else pagination__submit_btn.parent().hide();
        }
      });



      jQuery(braidcramp).each(function () {
        let nb_page = jQuery(this).attr("data-page");

        if (nb_page == active_page) {
          jQuery(this).addClass("active");
        } else {
          jQuery(this).removeClass("active");
        }
      });
    },
  });
}


function StopSMS() {

  let btn = jQuery(".stop_btn")
  btn.on("click", () => {
    let message = jQuery('textarea[data-name="message"]')
    let stop_str = SH_plugin_translate_main.stop_sms
    let current_msg = message.val()
    if (btn.is(":checked")) {
      if (current_msg.indexOf(stop_str)) {
        current_msg = current_msg.replace(stop_str, "")
        if (current_msg[current_msg.length - 1] == ' ') {
          message.val(current_msg + stop_str)
        } else (
          message.val(current_msg + " " + stop_str)
        )
      }
    } else {
      message.val(current_msg.replace(stop_str, ""))
    }
    MessageLength(message.val());
  });
}

function SmartphoneHour() {
  let currentDate = new Date()
  currentHour = currentDate.getHours()
  currentMinute = currentDate.getMinutes()
  jQuery('.smartphone__top .hour').text(currentHour + ':' + currentMinute)

}

function DateSelectList() {
  let currentDate = new Date()
  currentHour = currentDate.getHours()
  currentMinute = currentDate.getMinutes()

  let hoursList = []
  let minutesList = []


  for (let i = 9; i < 22; i++) {

    hoursList.push(i)
    let val = i
    if (i < 10) {
      val = '0' + i
    }

    jQuery("<option>", {
      val: val,
      text: val,
    }).appendTo(jQuery("#date_hour"));
  }
  // jQuery('#date_hour option[value="10"]').prop("selected", true);

  i = 00;
  while (i < 60) {
    minutesList.push(i)
    let val = i
    if (i < 10) {
      val = '0' + i
    }
    jQuery("<option>", {
      val: val,
      text: val,
    }).appendTo(jQuery("#date_minute"));
    i = i + 5;
  }
  // jQuery('#date_minute option[value="30"]').prop("selected", true);


  if (currentMinute >= 54) {
    currentMinute = 00
    currentHour++

  } else {

    let arr = minutesList
    let closestTo = currentMinute

    let closest = Math.max.apply(null, arr)

    for (var i = 0; i < arr.length; i++) {
      if (arr[i] >= closestTo && arr[i] < closest) closest = arr[i]
    }

    currentMinute = closest
  }
  jQuery('#date_hour option[value="' + currentHour + '"]').prop("selected", true);
  jQuery('#date_minute option[value="' + currentMinute + '"]').prop("selected", true);

}

function toTimestamp(strDate) {
  var datum = Date.parse(strDate)
  return datum / 1000;
}

async function do_ajax_get_customers(data) {
  let test = await jQuery.post(
    ajaxurl, {
    type: "POST",
    action: "SH_ajax_wordpress_customers_from_group",
    data: data,
  },
    function (results) {
      results = JSON.parse(results)
      return results
    }
  );
  return test;
}



function GetCustomSender(arg, page) {

  let type

  if (arg == 'sending_email_address' || arg == 'sending_email_name' || arg == 'email') {
    type = 'email'
  }
  if (arg == 'sms_sender_name' || arg == 'sms') {
    type = 'sms'
  }


  jQuery.post(
    ajaxurl, {
    type: "POST",
    action: "Get__custom_sender",
    type: type,
  },
    function (response) {
      response = JSON.parse(response);
      if (page == 'settings') {

        switch (type) {

          case 'email':
            jQuery.each(response, function (index, value) {
              key = value.sh_key
              val = value.sh_value
              if (key == 'sending_email_address') {
                jQuery("#sender_send_email_address").val(val)
              }
              if (key == 'sending_email_name') {
                jQuery("#sender_email_name").val(val)
              }
              if (key == 'email_address') {
                jQuery("#sender_recieve_email_address").val(val)
              }
            })
            break;

          case 'sms':
            jQuery.each(response, function (index, value) {
              key = value.sh_key
              val = value.sh_value
              if (key == 'sms_sender_name') {
                jQuery("#sender_sms_name").val(val)
              }
              if (key == 'phone_number') {
                jQuery("#sender_sms_number").val(val)
              }
            })
            break;

        }
      }

      if (page == 'campaign') {
        switch (arg) {

          case 'sending_email_address':
            jQuery.each(response, function (index, value) {
              key = value.sh_key
              val = value.sh_value

              if (key == 'sending_email_address') {
                jQuery("#custom_sender_email").val(val)
                jQuery(".smartphone_sender").html(val + "@sh-mail.fr");
                jQuery(".sender_bubble").html(val + "@sh-mail.fr");
              }
            })
            break;

          case 'sending_email_name':
            jQuery.each(response, function (index, value) {
              key = value.sh_key
              val = value.sh_value

              if (key == 'sending_email_name') {
                jQuery("#name_sender").val(val)

              }
            })
            break;

          case 'sms_sender_name':
            jQuery.each(response, function (index, value) {
              key = value.sh_key
              val = value.sh_value

              if (key == 'sms_sender_name') {
                jQuery("#custom_sender_sms").val(val)
                jQuery(".sender_bubble").text(val);
                jQuery(".smartphone_sender").text(val);
                jQuery(".smartphone_initials").text(val.slice(0, 2));
              }
            })
            break;
        }
      }



      // if (arg == 'email_name') {
      //   jQuery.each(response, function (index, value) {
      //     key = value.sh_key
      //     val = value.sh_value

      //       if (key == 'email_sender') {
      //         jQuery("#name_sender").val(val)
      //       }
      //   })
      // }

      // if (arg == 'email_address') {

      //   jQuery.each(response, function (index, value) {
      //     key = value.sh_key
      //     val = value.sh_value



      //       if (key == 'email_address') {
      //         jQuery("#custom_sender_email").val(val)
      //       }
      //   })
      // }


      // if (arg == 'settings_sms') {

      //   jQuery.each(response, function (index, value) {
      //     key = value.sh_key
      //     val = value.sh_value

      //       if (key == 'sms_sender') {
      //         jQuery("#custom_sender_sms").val(val)
      //         jQuery('#sender_checkbox').prop('checked', true)
      //       }

      //   })
      // }
      // if (arg == 'settings_email_sender') {

      //   jQuery.each(response, function (index, value) {
      //     key = value.sh_key
      //     val = value.sh_value


      //       if (key == 'email_sender') {
      //         jQuery("#name_sender").val(val)
      //         jQuery('#sender_checkbox').prop('checked', true)
      //       }

      //   })
      // }
    }
  )
}


function SetCustomSender(type, val) {
  jQuery.post(
    ajaxurl, {
    type: "POST",
    action: "Set__custom_sender",
    input_value: val,
    type: type,

  },
    function (response) {
      if (response) {
        // response = JSON.parse(response);
        Write_error(SH_plugin_translate_main.saved, 0)
      }
    }
  );
}




function Write_error(arg, err_type) {

  const error_container = jQuery("#spothit_errors")
  let alert_class = ""
  error_container.empty()

  if (err_type === 0) {
    alert_class = "alert alert-success alert-dismissible fade show"
  }
  if (err_type === 1) {
    alert_class = "alert alert-success alert-dismissible fade show"
  }
  if (err_type === 2) {
    alert_class = "alert alert-success alert-dismissible fade show"
  }


  if (typeof arg === 'array' || typeof arg === 'object') {

    arg.forEach(element => {
      let err = jQuery('<div>', {
        class: alert_class,
      })
      let err_message = jQuery('<span><strong>Erreur: </strong>' + element + '</span>').appendTo(err)
      let err_btn = jQuery('<button>', {
        class: "btn-close",
        type: "button",
        "data-bs-dismiss": "alert"
      }).appendTo(err)
      error_container.append(err)


    });
  }

  if (typeof arg === 'string') {
    let err = jQuery('<div>', {
      class: alert_class,
    })
    let err_message = jQuery('<span><strong>Erreur: </strong>' + arg + '</span>').appendTo(err)
    let err_btn = jQuery('<button>', {
      class: "btn-close",
      type: "button",
      "data-bs-dismiss": "alert"
    }).appendTo(err)
    error_container.append(err);
  }
}



function error_processing(type) {
  let err_array = [];
  let err_state = 0;


  switch (type) {

    case "sms":

      let SMS_campaign_name = jQuery('input[data-name="nom"]')
      let SMS_sender_radio = jQuery('input[name="sender_choice"]:checked')
      let SMS_recipient_radio = jQuery('input[name="recipient_choice"]:checked')
      let SMS_message = jQuery('textarea[data-name="message"]')
      let SMS_date_radio = jQuery('input[name="date_choice"]:checked')
      let SMS_custom_sender_name = jQuery('#custom_sender_sms')
      let SMS_contacts_checkbox = jQuery('.contact_checkbox:checked')
      let SMS_sender_checkbox = jQuery('sender_checkbox')

      if (SMS_campaign_name.val().length > 255) {
        click
        SMS_campaign_name.addClass('invalid_input')
        err_state = 1
        err_array.push(SH_plugin_translate_main.campaign_name_long)

      }



      if (SMS_sender_radio.val() != null ||
        SMS_sender_radio.val() != 'undefined' ||
        SMS_sender_radio.val() != undefined ||
        SMS_sender_radio.val() != ''
      ) {

        if (SMS_sender_radio.val() == '0') {
          if (SMS_custom_sender_name.val().length < 3) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.sender_name_short)
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.sender_bubble').empty().html(err_element.html(SH_plugin_translate_main.sender_name_short))
          }

          if (SMS_custom_sender_name.val().length > 11) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.sender_name_long)
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.sender_bubble').empty().html(err_element.html(SH_plugin_translate_main.sender_name_long))
          }

          if (OnlySpaces(SMS_custom_sender_name.val()) === true) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.sender_name_empty)
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.sender_bubble').empty().html(err_element.html(SH_plugin_translate_main.sender_name_empty))
          }
        }


        if (SMS_recipient_radio.length) {
          if (SMS_recipient_radio.val() >= 3) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.invalid_recipient_method)
          }

          if (SMS_recipient_radio.val() == '0' || SMS_recipient_radio.val() == '1') {
            if (SMS_contacts_checkbox.length == 0 ||
              SMS_contacts_checkbox.length == '' ||
              SMS_contacts_checkbox.length == undefined ||
              SMS_contacts_checkbox.length == 'undefined') {
              err_state = 1
              err_array.push(SH_plugin_translate_main.select_recipient_group)
              let err_element = jQuery('<small>').attr({
                class: 'error_sh'
              }).css('color', 'red')
              jQuery('.contacts_bubble').empty()
              jQuery('.contacts_bubble').html(err_element.html(SH_plugin_translate_main.select_recipient_group))
            }
          } else {
            let textarea_contacts = jQuery('textarea[data-param="recipients"]').val()
            if (!textarea_contacts.length && textarea_contacts.length < 3) {
              err_state = 1
              err_array.push(SH_plugin_translate_main.recipients_field_empty)
              let err_element = jQuery('<small>').attr({
                class: 'error_sh'
              }).css('color', 'red')
              jQuery('.contacts_bubble').empty().html(err_element.html(SH_plugin_translate_main.recipients_field_empty))
            }
          }
        } else {
          err_state = 1
          err_array.push(SH_plugin_translate_main.select_recipient_method)
          let err_element = jQuery('<small>').attr({
            class: 'error_sh'
          }).css('color', 'red')
          jQuery('.contacts_bubble').empty().html(err_element.html(SH_plugin_translate_main.select_recipient_method))
        }


        if (SMS_message.val().length >= 1) {
          if (SMS_message.val().length >= 1377) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.msg_long)
            SMS_message.addClass('invalid_input')
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.speech_bubble').empty().html(err_element.html(SH_plugin_translate_main.msg_long))

          }

        } else {
          err_state = 1
          err_array.push(SH_plugin_translate_main.msg_empty)
          let err_element = jQuery('<small>').attr({
            class: 'error_sh'
          }).css('color', 'red')
          jQuery('.speech_bubble').empty().html(err_element.html(SH_plugin_translate_main.msg_empty))
          // SMS_message.addClass('invalid_input')
        }

        if (SMS_date_radio.val().length) {

          if (SMS_date_radio.val() == 1) {
            let date = jQuery('#date_day')
            let hour = jQuery('#date_hour')
            let minute = jQuery('#date_minute')

            if (date.val().length && hour.val().length && minute.val().length) {

            } else {
              SMS_date_radio.addClass('invalid_input')
              err_state = 1
              err_array.push(SH_plugin_translate_main.date_empty)
              let err_element = jQuery('<small>').attr({
                class: 'error_sh'
              }).css('color', 'red')
              jQuery('.date_bubble').empty().html(err_element.html(SH_plugin_translate_main.date_empty))
            }
          }

        } else {
          err_state = 1
          err_array.push(SH_plugin_translate_main.date_method)
          let err_element = jQuery('<small>').attr({
            class: 'error_sh'
          }).css('color', 'red')
          jQuery('.date_bubble').empty().html(err_element.html(SH_plugin_translate_main.date_method))
        }
        return {
          state: err_state,
          errors: err_array,
        }
      }

      break;


    case "email":
      jQuery('.error_sh').remove()
      EMAIL_campaign_name = jQuery("input[data-name='nom']")

      EMAIL_sender_name = jQuery("#name_sender")
      EMAIL_sender_email = jQuery("#custom_sender_email")
      EMAIL_object = jQuery('input[data-name="sujet"]')
      EMAIL_recipient_radio = jQuery("input[name='recipient_choice']:checked")
      EMAIL_content_radio = jQuery("input[name='email_message_type']:checked")

      let EMAIL_date_radio = jQuery('input[name="date_choice"]:checked')

      if (EMAIL_campaign_name.val().length > 255) {
        EMAIL_campaign_name.addClass('invalid_input')
        err_state = 1
        err_array.push(SH_plugin_translate_main.campaign_name_long)
      }

      if (EMAIL_sender_name.val() == null ||
        EMAIL_sender_name.val() == 'undefined' ||
        EMAIL_sender_name.val() == undefined ||
        EMAIL_sender_name.val() == ''
      ) {
        err_state = 1
        err_array.push(SH_plugin_translate_main.sender_name_empty)
        let err_element = jQuery('<small>').attr({
          class: 'error_sh'
        }).css('color', 'red')
        jQuery('.sender_bubble').empty().append(err_element.html(SH_plugin_translate_main.sender_name_empty))
      }

      if (EMAIL_sender_email.val() == null ||
        EMAIL_sender_email.val() == 'undefined' ||
        EMAIL_sender_email.val() == undefined ||
        EMAIL_sender_email.val() == ''
      ) {
        err_state = 1
        err_array.push(SH_plugin_translate_main.empty_email_address)
        let err_element = jQuery('<small>').attr({
          class: 'error_sh'
        }).css('color', 'red')
        jQuery('.sender_bubble').empty().append(err_element.html(SH_plugin_translate_main.empty_email_address))
      } else {
        let email_address = EMAIL_sender_email.val();
        email_address = email_address.trim()
        if (ValidateEmail(email_address + '@sh-mail.fr') === false || OnlySpaces(email_address) === true) {
          //! A verifier espace dans email
          err_state = 1
          err_array.push(SH_plugin_translate_main.invalid_email_address)
          let err_element = jQuery('<small>').attr({
            class: 'error_sh'
          }).css('color', 'red')
          jQuery('.sender_bubble').empty().append(err_element.html(SH_plugin_translate_main.invalid_email_address))

        }
      }

      if (EMAIL_object.val() === '' || EMAIL_object.val() == null || EMAIL_object.val() == 'undefined' || EMAIL_object.val() == undefined) {

        err_state = 1
        err_array.push(SH_plugin_translate_main.subject_empty)
        let err_element = jQuery('<small>').attr({
          class: 'error_sh'
        }).css('color', 'red')
        jQuery('.object_bubble').empty().append(err_element.html(SH_plugin_translate_main.subject_empty))
      }


      if (EMAIL_recipient_radio.length) {
        if (EMAIL_recipient_radio.val() >= 3) {
          err_state = 1
          err_array.push(SH_plugin_translate_main.select_recipient_method)
          let err_element = jQuery('<small>').attr({
            class: 'error_sh'
          }).css('color', 'red')
          jQuery('.contact_bubble').empty().append(err_element.html(SH_plugin_translate_main.select_recipient_method))
        }

        if (EMAIL_recipient_radio.val() == 0 || EMAIL_content_radio.val() == 1) {
          if (EMAIL_recipient_radio.length == 0 ||
            EMAIL_recipient_radio.length == '' ||
            EMAIL_recipient_radio.length == undefined ||
            EMAIL_recipient_radio.length == 'undefined') {
            err_state = 1
            err_array.push(SH_plugin_translate_main.select_recipient_method)
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.contact_bubble').empty().html(err_element.html(SH_plugin_translate_main.select_recipient_method))
          }
        }
        if (EMAIL_recipient_radio.val() == '2') {
          let textarea_contacts = jQuery('textarea[data-param="recipients"]').val()
          if (textarea_contacts.length < 3) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.recipients_field_empty)
            // textarea_contacts.addClass('invalid_input')
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.contacts_bubble').empty().html(err_element.html(SH_plugin_translate_main.recipients_field_empty))
          }
        }
      } else {
        err_state = 1
        err_array.push(SH_plugin_translate_main.select_recipient_method)
        let err_element = jQuery('<small>').attr({
          class: 'error_sh'
        }).css('color', 'red')
        jQuery('.contacts_bubble').empty().html(err_element.html(SH_plugin_translate_main.select_recipient_method))
      }



      if (EMAIL_content_radio.length) {
        if (EMAIL_content_radio.val() > 1) {
          err_state = 1
          err_array.push(SH_plugin_translate_main.msg_invalid)
          let err_element = jQuery('<small>').attr({
            class: 'error_sh'
          }).css('color', 'red')
          jQuery('.speech_bubble').empty().html(err_element.html(SH_plugin_translate_main.msg_invalid))
        }

        if (EMAIL_content_radio.val() == '0') {
          let EMAIL_message = tinymce.get("email_custom").getContent()

          if (EMAIL_message.length <= 0) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.msg_empty)
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.speech_bubble').empty().html(err_element.html(SH_plugin_translate_main.msg_empty))
          }
        }

        if (EMAIL_content_radio.val() == '1') {
          let EMAIL_model_select = jQuery('input[name="model_select"]:checked')
          if (EMAIL_model_select.length != 1) {
            err_state = 1
            err_array.push(SH_plugin_translate_main.model_select)
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.speech_bubble').empty().html(err_element.html(SH_plugin_translate_main.model_select))
          }
        }
      } else {
        err_state = 1
        err_array.push(SH_plugin_translate_main.content_method)
        let err_element = jQuery('<small>').attr({
          class: 'error_sh'
        }).css('color', 'red')
        jQuery('.speech_bubble').empty().html(err_element.html(SH_plugin_translate_main.content_method))
      }



      if (EMAIL_date_radio.length) {

        if (EMAIL_date_radio.val() == 1) {
          let date = jQuery('#date_day')
          let hour = jQuery('#date_hour')
          let minute = jQuery('#date_minute')

          if (date.val().length && hour.val().length && minute.val().length) {

          } else {
            EMAIL_date_radio.addClass('invalid_input')
            err_state = 1
            err_array.push(SH_plugin_translate_main.date_empty)
            let err_element = jQuery('<small>').attr({
              class: 'error_sh'
            }).css('color', 'red')
            jQuery('.date_bubble').empty().html(err_element.text(SH_plugin_translate_main.date_empty))
          }
        }

      } else {
        err_state = 1
        err_array.push(SH_plugin_translate_main.date_empty)
        let err_element = jQuery('<small>').attr({
          class: 'error_sh'
        }).css('color', 'red')
        jQuery('.date_bubble').empty().html(err_element.text(SH_plugin_translate_main.date_empty))
      }
      return {
        state: err_state,
        errors: err_array,
      }
  }


}



function Send_message(url, data) {

  jQuery.post(
    ajaxurl, {
    action: "SH_ajax_api_request",
    data: data,
    url_api: url,
  },
    function (response) {

      response = JSON.parse(response);
      if (response.resultat == 1) {
        show_notification(1, SH_plugin_translate_main.campaign_sent, 2000)
        setTimeout(function () {
          let url = window.location.href
          window.location.replace(url);
        }, 2000);
      } else if (response.resultat == 0) {
        let error_message = spothit_errors_list(response.erreurs)
        show_notification(2, error_message, false)
      }
    }
  );
}



function Summary_Manual_Count(type) {
  ////////////////////////////////////////////////
  // Fonction permettant d'incrire le nombre de
  // contacts ajoutés manuellement dans le résumé.
  ////////////////////////////////////////////////
  jQuery('.recipients_results').on('change', 'textarea[data-param="recipients"]', (e) => {
    let message = jQuery(e.currentTarget).val()
    let recipients_count = 0
    message = message.replaceAll("\n", ",")
    message = message.replaceAll(' ', '')
    message = message.split(',')
    jQuery.each(message, function (index, value) {
      if (type == 'email') {
        if (ValidateEmail(value) === true) {
          recipients_count++
        }
      }
      if (type == 'sms') {
        if (value.length >= 10) {
          recipients_count++
        }
      }
    })

    if (recipients_count > 1) {
      jQuery('.contacts_bubble').html(recipients_count + ' contacts')

    } else {
      jQuery('.contacts_bubble').html(recipients_count + ' contact')

    }
    if (type == 'sms') {
      Summary_SMS_Count()
    }
  })
}



function show_notification(state, message, timer) {
  let notif_container = jQuery('#spothit_notification')
  let notif_message = notif_container.find('.message')
  let notif_list = notif_container.find('.list')
  let notif_icon = notif_container.find('.state_icon')

  notif_message.empty()
  notif_list.empty()
  notif_icon.empty()
  notif_icon.removeClass('success').removeClass('error')

  if (state == 1) {
    notif_icon.addClass('success')
    notif_icon.append('<i class="fa-solid fa-circle-check"></i>')
  } else if (state == 2) {
    notif_icon.addClass('error')
    notif_icon.append('<i class="fa-solid fa-circle-exclamation"></i>')
  }
  if (typeof message == 'object' || typeof message == 'Array') {
    let list_container = jQuery('<ul>')
    jQuery.each(message, (index, content) => {
      jQuery('<li>').html(content).appendTo(list_container)
    })
    notif_list.append(list_container)
  } else {
    notif_message.html(message)
  }
  notif_container.css('display', 'flex')

  if (timer != '' || timer != false) {

    setInterval(() => {
      jQuery('#spothit_notification').css('display', 'none')
    }, timer);

  }



}

function hide_spothit_notification() {
  let close_btn = jQuery('#spothit_notification_close_btn')
  let notif_container = jQuery('#spothit_notification')

  notif_container.on('click', () => {
    notif_container.css('display', 'none')
  })
  close_btn.on('click', () => {
    notif_container.css('display', 'none')
  })
  notif_container.children().on('click', function (e) {
    e.stopPropagation();
  });
}

function spothit_errors_list(error) {

  let errors_list = {
    1: SH_plugin_translate_main.error_23,
    2: SH_plugin_translate_main.error_24,
    3: SH_plugin_translate_main.error_25,
    4: SH_plugin_translate_main.error_26,
    5: SH_plugin_translate_main.error_27,
    6: SH_plugin_translate_main.error_28,
    7: SH_plugin_translate_main.error_29,
    8: SH_plugin_translate_main.error_30,
    9: SH_plugin_translate_main.error_31,
    10: SH_plugin_translate_main.error_32,
    11: SH_plugin_translate_main.error_33,
    12: SH_plugin_translate_main.error_34,
    13: SH_plugin_translate_main.error_35,
    14: SH_plugin_translate_main.error_36,
    15: SH_plugin_translate_main.error_37,
    16: SH_plugin_translate_main.error_38,
    17: SH_plugin_translate_main.error_39,
    18: SH_plugin_translate_main.error_40,
    19: SH_plugin_translate_main.error_41,
    20: SH_plugin_translate_main.error_42,
    21: SH_plugin_translate_main.error_43,
    22: SH_plugin_translate_main.error_44,
    23: SH_plugin_translate_main.error_45,
    24: SH_plugin_translate_main.error_46,
    25: SH_plugin_translate_main.error_47,
    26: SH_plugin_translate_main.error_48,
    27: SH_plugin_translate_main.error_49,
    28: SH_plugin_translate_main.error_50,
    30: SH_plugin_translate_main.error_51,
    36: SH_plugin_translate_main.error_52,
    38: SH_plugin_translate_main.error_53,
    45: SH_plugin_translate_main.error_54,
    50: SH_plugin_translate_main.error_55,
    51: SH_plugin_translate_main.error_56,
    52: SH_plugin_translate_main.error_57,
    61: SH_plugin_translate_main.error_58,
    62: SH_plugin_translate_main.error_59,
    63: SH_plugin_translate_main.error_60,
    65: SH_plugin_translate_main.error_61,
    66: SH_plugin_translate_main.error_62,
    99: SH_plugin_translate_main.error_63,
    100: SH_plugin_translate_main.error_64,
  }

  if (typeof error == 'string') {
    error = parseInt(error)
    response = getKeyByValue(errors_list, error);
    return response

  } else if (typeof error == 'number') {
    response = getKeyByValue(errors_list, error);
    return response

  } else if (typeof error == 'object') {
    let err_list = []
    jQuery.each(error, function (key, value) {
      let errors = getKeyByValue(errors_list, value)
      err_list.push(errors)
    })

  } else if (typeof error == 'array') {
    let err_list = []
    jQuery.each(error, function (key, value) {
      let errors = getKeyByValue(errors_list, value)
      err_list.push(errors)
    })
  }

  function getKeyByValue(list, error) {
    let response = ''
    jQuery.each(list, function (key, msg) {
      key = parseInt(key)
      if (key == error) {
        response = msg
      }
    })
    return response
  }
}



function ValidateEmail(email) {
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (email.match(mailformat)) {
    return true;
  } else {
    return false;
  }
}

function OnlySpaces(str) {
  return str.trim().length === 0;
}


function HideLoader() {

  jQuery('#spothit_loader').addClass('hidden');
  setTimeout(() => {
    jQuery('#spothit_loader').hide()
  }, 500);
}

function ShowLoader() {

  jQuery('#spothit_loader').removeClass('hidden');
  jQuery('#spothit_loader').show()
}

function ShowContentLoader() {
  let div = jQuery("<div>", {
    "class": "spothit_content_loader"
  })
  let content = jQuery("<div>", {
    "class": "content"
  })
  let loader = jQuery("<div>", {
    "class": "loader"
  });
  content.append(loader)
  div.append(content)
  return div
}


function HideContentLoader() {
  jQuery(".spothit_content_loader").remove()
}


function ConfirmationPopUp(arg) {
  if (arg === true) {
    jQuery('#campaign_confirmation').css('display', 'flex')
  } else if (arg === false) {
    jQuery('#campaign_confirmation').css('display', 'none')
  }
}

function StopDisplayVersion(e) {
  console.log(e.dataset.type);

  jQuery.post(
    ajaxurl, {
    action: "Remove_version_notification",
    data: e.dataset.type,
  },
    function (response) {

      response = JSON.parse(response);
      console.log(response);
    }
  )
}
