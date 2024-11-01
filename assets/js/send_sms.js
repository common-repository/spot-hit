const spothit_submit = jQuery("#spothit_form_submit");
let input_message = jQuery("#spothit_form textarea[data-name='message']");
let input_sender_on = jQuery("#sender_on");
let input_sender_off = jQuery("#sender_off");
let input_sender = jQuery("#custom_sender_sms");
let input_date_now = jQuery("#date_now");
let input_date_scheduled = jQuery("#date_scheduled");
let select_date = jQuery('select[name="date_jour"]');
let input_date = jQuery('input[name="date_jour"]');
let campaign_name = jQuery('input[data-name="nom"]');
let cancel_confirmation = jQuery('#cancel_campaign_btn')
let send_confirmation = jQuery('#send_campaign_btn')
let msg_length
let msg_long_state = false



jQuery(document).on('ready', () => {

  ///////////////////////////////////////////////
  // Vérification de la présenced'un expéditeur
  // personnalisé en base de données.
  ///////////////////////////////////////////////
  CampaignPagination()
  StopSMS()
  DateSelectList()
  SmartphoneHour();
  Summary_Manual_Count('sms')


    ! function (a) {
      a.fn.datepicker.dates.fr = {
        days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
        daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
        daysMin: ["du", "lu", "ma", "me", "je", "ve", "sa"],
        months: ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
        monthsShort: ["janv.", "févr.", "mars", "avril", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."],
        today: SH_plugin_translate.today,
        monthsTitle: SH_plugin_translate.month,
        clear: SH_plugin_translate.clear,
        weekStart: 1,
        format: "dd/mm/yyyy"
      }
    }(jQuery);



  jQuery('.datepicker').datepicker({
    format: "dd/mm/yyyy",
    autoclose: true,
    language: SH_plugin_translate.datepicker_lang,
  });
  ///////////////////////////////////////////////
  // Data toggle restrictions expéditeur sms
  ///////////////////////////////////////////////
  jQuery('#sms_sender_restriction').on('click', () => {
    let popup_content = SH_plugin_translate.popup_infos
    show_notification(false, popup_content, false)
  })
    GetCustomSender('sms_sender_name', 'campaign')


    jQuery('.character_count_number').on("DOMSubtreeModified", () => {
      let message_size = jQuery('.character_count_number').text()
      if (message_size >= 2) {
        if (msg_long_state === false) {
          let mess = ['<strong>Activation du SMS long</strong>', 'Votre SMS fait plus de 160 caractères.', 'Dans le cas ou le SMS contient plus de 160 caractères, le SMS long est activé et la limite maximale est de 9 SMS de 153 caractères.']
          show_notification(false, mess , false)
          msg_long_state = true
        }
      }
    })
    jQuery("#carac_doubl").fadeOut('slow');
})


input_sender.on("click keyup change DOMSubtreeModified", () => {
  ////////////////////////////////////////////////////////////////////////////////
  // Un changement ou un clic sur l'input dans le bloc "Expéditeur personnalisé"
  // ajoutera l'attribut "checked" à celui-ci et ajoutera le contenu de l'input
  //
  // dans le smartphone et le récapitulatif.
  // Si la valeur est vide, un contenu par défaut est ajouté et le bouton
  // d'enregistrement est décoché.
  ////////////////////////////////////////////////////////////////////////////////
  jQuery('#sender_checkbox').prop("checked", false);
  input_sender_off.removeProp("checked");
  input_sender_on.prop("checked", true);
  jQuery('#sender_checkbox').prop('disabled', false)
  if (input_sender.val().length > 0) {
    jQuery(".sender_bubble").text(jQuery(input_sender).val());
    jQuery(".smartphone_sender").text(jQuery(input_sender).val());
    jQuery(".smartphone_initials").text(jQuery(input_sender).val().slice(0, 2));

  } else {
    jQuery(".sender_bubble").text('36200');
    jQuery(".smartphone_sender").text('36200');
    jQuery(".smartphone_initials").html('<i class="fa-solid fa-user"></i>');
    jQuery('#sender_checkbox').prop('checked', false)

  }


});

input_sender_on.on("click", () => {
  jQuery('#sender_checkbox').prop('disabled', false)
  if (input_sender.val().length > 0) {
    jQuery(".sender_bubble").text(jQuery(input_sender).val());
    jQuery(".smartphone_sender").text(jQuery(input_sender).val());
    jQuery(".smartphone_initials").text(jQuery(input_sender).val().slice(0, 2));
  } else {
    jQuery(".sender_bubble").text('36200');
    jQuery(".smartphone_sender").text('36200');
    jQuery(".smartphone_initials").html('<i class="fa-solid fa-user"></i>');
    jQuery('#sender_checkbox').prop('checked', false)
  }
})

input_sender_off.on("click", () => {
  /////////////////////////////////////////////////////////////////////
  // Un clic sur le bloc "Sans personnalisation" attribura des valeurs
  // par défaut dans le smartphone et le récapitulatif et désactivera
  // le bouton d'enregistrement
  /////////////////////////////////////////////////////////////////////
  jQuery(".sender_bubble").text('36200');
  jQuery(".smartphone_sender").text('36200');
  jQuery(".smartphone_initials").html('<i class="fa-solid fa-user"></i>');
  jQuery('#sender_checkbox').prop({
    'checked': false,
    'disabled': true
  })
});

input_date.on("click", () => {
  /////////////////////////////////////////////////////////////
  // Au clic sur l'un des input concernant la date,
  // l'attribut "Checked" est ajouté au bloc "Envoi programmé"
  /////////////////////////////////////////////////////////////
  input_date_now.removeProp("checked");
  input_date_scheduled.prop("checked", true);
  let date = jQuery('#date_day').val()
  let hour = jQuery('#date_hour').val()
  let minute = jQuery('#date_minute').val()

  jQuery('.date_bubble').html(date + ' - ' + hour + ':' + minute);

});
select_date.on("click", () => {
  /////////////////////////////////////////////////////////////
  // Au clic sur l'un des input concernant la date,
  // l'attribut "Checked" est ajouté au bloc "Envoi programmé"
  // et ce même attribut est retiré sur le bloc "Envoi immédiat".
  ///////////////////////////////////////////////////////////////
  input_date_now.removeProp("checked");
  input_date_scheduled.prop("checked", true);
  let date = jQuery('#date_day').val()
  let hour = jQuery('#date_hour').val()
  let minute = jQuery('#date_minute').val()

  jQuery('.date_bubble').html(date + ' - ' + hour + ':' + minute);
});
input_date_scheduled.on('click', () => {
  let date = jQuery('#date_day').val()
  let hour = jQuery('#date_hour').val()
  let minute = jQuery('#date_minute').val()

  jQuery('.date_bubble').html(date + ' - ' + hour + ':' + minute);
})

input_date_now.on('click', () => {
  //////////////////////////////////////////////////////////////////////////////
  // Au clic sur le bloc "Envoi immédiat", changement de contenu dans le résumé
  //////////////////////////////////////////////////////////////////////////////
  jQuery('.date_bubble').text(SH_plugin_translate.send_now);
})

/////////////////////////////////////////////////////////////////
// Attribution de la date du jour à l'input de selection de date
/////////////////////////////////////////////////////////////////
let today = new Date();
let currentDay = today.getDate()
let currentMonth = today.getMonth()
currentMonth++
let currentYear = today.getFullYear()
if (currentMonth < 10) {
  currentMonth = '0' + currentMonth;
}

today = currentDay + '/' + currentMonth + '/' + currentYear

input_date.val(today);


spothit_submit.on("click", (e) => {
  e.preventDefault();

  ConfirmationPopUp(true)
});
  cancel_confirmation.on('click', () => {
    ConfirmationPopUp(false)
  })
  send_confirmation.on('click', () => {
    ConfirmationPopUp(false)
    let datas_send = [];


    let check_error = error_processing("sms");
    if (check_error.state == 1) {
      show_notification(2, check_error.errors, false)
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Appel de la fonction permettant la vérification de la présence de données dans les champs obligatoires.
    // Dans le cas ou un champ requis n'est pas complété, une notification sera envoyé et l'élément manquant
    // sera mis en surbrillance.
    //
    // La fonction renvoie un "état", si l'état est de 0, le processus de vérification de données continue,
    // sinon, seul les notification seront envoyés
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (check_error.state == 0) {

      //////////////////////////////////////////////////////////////////////////////////
      // Les champs obligatoires ont bien un contenu, début du traitement des données.
      // Si le contenu est correct, celui-ci est ajouté au tableau datas-send.
      //////////////////////////////////////////////////////////////////////////////////

      if (campaign_name) {
        ////////////////////////////////////////////////////
        // Vérification de la présence d'un nom de campagne
        ////////////////////////////////////////////////////
        let campaign_name_content = campaign_name.val();
        datas_send.push({
          name: "nom",
          value: campaign_name_content,
        });
      }
      if (jQuery('#sender_checkbox').is(':checked')) {
        SetCustomSender('sms_sender_name', input_sender.val(), )
      }
      /////////////////////////////////////////////////////////////////////////////////
      // S'il s'agit d'un expéditeur personnalisé, récupération du contenu de l'input
      /////////////////////////////////////////////////////////////////////////////////
      let sender_choice = jQuery('input[name="sender_choice"]:checked');
      if (sender_choice.val() == 0) {
        input_sender_val = input_sender.val()
        if (input_sender_val.length && input_sender_val.length >= 3 && input_sender_val.length <= 11) {
          datas_send.push({
            name: "expediteur",
            value: input_sender_val,
          });
        }
      }


      let recipient_choice = jQuery('input[name="recipient_choice"]:checked').val();
      ////////////////////////////////////////
      // Vérification du type de destinataire
      ////////////////////////////////////////
      if (recipient_choice == 0) {
        var group_list = [];
        jQuery(".contact_checkbox:checked").each(function () {
          let value = jQuery(this).val();
          group_list.push(value);
        });
        datas_send.push({
          name: "destinataires",
          type: "wordpress",
          value: "0",
          group_list: group_list,
        });
      }
      if (recipient_choice == 1) {
        var group_list = [];
        jQuery(".contact_checkbox:checked").each(function () {
          let value = jQuery(this).val();
          group_list.push(value);
        });
        datas_send.push({
          name: "destinataires",
          type: "spothit",
          value: "0",
          group_list: group_list,
        });
      }
      if (recipient_choice == 2) {
        let value = jQuery('textarea[data-param="recipients"').val();
        datas_send.push({
          name: "destinataires",
          type: "manual",
          value: value,
        });
      }

      // Ajout des données des inputs Date et conversion en datestamp, en fonction du choix
      let date_choice = jQuery('input[name="date_choice"]:checked').val();
      ////////////////////////////////////////////////////////////
      // Dans le cas ou la date est personnalisée, transformation
      // de la date des inputs en Timestamp
      ////////////////////////////////////////////////////////////
      if (date_choice == 1) {
        let date_day = jQuery("#date_day").val();
        date_day = date_day.split("/")
        date_day = date_day[2] + '-' + date_day[1] + '-' + date_day[0]
        let date_hour = jQuery("#date_hour").val();
        let date_minute = jQuery("#date_minute").val();
        let date = date_day + " " + date_hour + ":" + date_minute;
        datestamp = toTimestamp(date);

        datas_send.push({
          name: "date",
          value: datestamp,
        });
      }

      ////////////////////////////////////////
      // Recupération des données du message
      ////////////////////////////////////////

      let message = jQuery('textarea[data-name="message"]');
      if (message) {
        let message_content = message.val();
        datas_send.push({
          name: "message",
          value: message_content,
        });
      }

      /////////////////////////////////////////////////
      // Appel de la fonction pour envoyer la campagne
      /////////////////////////////////////////////////
      Send_message('envoyer/sms', datas_send);

    }
  })





jQuery(input_message).on("keyup change DOMSubtreeModified", () => {
  //////////////////////////////////////////////////////////////
  // Au changement, déclanchement d'un compteur pour le message
  // et ajout du contenu dans le smartphone et le résumé
  /////////////////////////////////////////////////////////////
  let message = jQuery(input_message).val()

  SpecialCharactersAlert(message)

  let StopSMS = jQuery('#add_stop_sms').is(':checked')
  if (!message.includes(SH_plugin_translate.stop_sms) && StopSMS === true) {
    jQuery('#add_stop_sms').prop('checked', false)
  }
  if (message.includes(SH_plugin_translate.stop_sms) && StopSMS === false) {
    jQuery('#add_stop_sms').prop('checked', true)

  }
  clearTimeout(msg_length)
  msg_length = setTimeout(() => {
    MessageLength(message);
  }, 300);

  Summary_SMS_Count();

  message = message.replace(/(?:\r\n|\r|\n)/g, '<br>');
  jQuery(".smartphone__screen .message p").html(message)
  jQuery(".speech_bubble").html(message);
  Summary_SMS_Count()
});




jQuery(input_sender).on("keyup", () => {

  let destinataire = jQuery(input_sender).val();
  if (jQuery('input[name="sender_choice"]:checked').val() == 0) {
    jQuery(".sender_bubble").text(destinataire);
  }
  Summary_SMS_Count()
});




jQuery(input_date).on("change", () => {
  let date_day = jQuery("#date_day").val();
  let date_hour = jQuery("#date_hour").val();
  let date_minute = jQuery("#date_minute").val();
  let date_string = date_day + " à " + date_hour + ":" + date_minute;
  jQuery(".date_bubble").text(date_string);
});




jQuery(select_date).on("change", () => {
  let date_day = jQuery("#date_day").val();
  let date_hour = jQuery("#date_hour").val();
  let date_minute = jQuery("#date_minute").val();
  let date_string = date_day + " à " + date_hour + ":" + date_minute;
  jQuery(".date_bubble").text(date_string);
});




jQuery("#recipient_spothit").on("click", () => {
  jQuery(".recipients_results").html(ShowContentLoader())
  jqxhr = jQuery.post(
    ajaxurl, {
      action: "SH_ajax_api_request",
      data: "sms",
      url_api: "groupe/lister",
    },
    function (response) {
      HideContentLoader()
      if (response.length > 0) {
        jQuery(".recipients_results").html(response);
        Summary_SMS_Count()
      } else {
        jQuery(".recipients_results").html('<p>'+ SH_plugin_translate.no_recipient_group +' </p>')
        Summary_SMS_Count()
      }
      jqxhr.abort();
    }
  );
});




jQuery("#recipient_wordpress").on("click", () => {
  jQuery(".recipients_results").html(ShowContentLoader())
  jqxhr = jQuery.post(
    ajaxurl, {
      action: "SH_ajax_get_customers_goup_list",
      type: 'sms',
    },

    function (response) {
      HideContentLoader()
      if (response.length > 0) {
        jQuery(".recipients_results").html(response)
        Summary_SMS_Count()
      } else {
        jQuery(".recipients_results").html('<p>'+ SH_plugin_translate.no_recipient_group +' </p>')
        Summary_SMS_Count()
      }
    }
  );
  setTimeout(function () {
    jqxhr.abort();
  }, 6000);
});




jQuery("#recipient_manual").on("click", () => {
  let infos = jQuery("<p>", {
    text: SH_plugin_translate.manual_recipients_info1
  })
  let infos2 = jQuery("<p>", {
    text: SH_plugin_translate.manual_recipients_info2
  })
  let input = jQuery("<textarea>", {
    "data-param": "recipients",
    placeholder: SH_plugin_translate.manual_recipients_placeholder,
  });
  jQuery(".recipients_results").empty().append(infos).append(infos2).append(input);
});




jQuery(".recipients_results ").on('click', '.contact_checkbox', (e) => {
  let div_total = jQuery('.contacts_bubble')
  let all_groups_select = jQuery('.contact_checkbox:checked')
  let total = 0
  if (all_groups_select.length > 0) {
    for (let i = 0; i < all_groups_select.length; i++) {
      const element = all_groups_select[i];
      let groupe_nb = jQuery(element).closest('div').find('.total_group').text()
      total = total += parseInt(groupe_nb)
    }
  }
  div_total.text(total + ' contacts')
  Summary_SMS_Count()
})




function Summary_SMS_Count() {


  let summary_total_sms = jQuery('.summary_total_sms')
  let summary_nb_contacts = jQuery('.summary_nb_contacts')
  let summary_nb_sms = jQuery('.summary_nb_sms')
  let nombre_de_contact_element = jQuery('.contacts_bubble').text()

  nombre_de_contact_element = nombre_de_contact_element.split(' ')
  nombre_de_contact_element = Number(nombre_de_contact_element[0])

  if (isNaN(nombre_de_contact_element) === true) {
    nombre_de_contact_element = 0
  }

  summary_nb_contacts.text(nombre_de_contact_element)

  if (Number(summary_nb_sms.text()) > 0 || nombre_de_contact_element > 0) {
    let results = Number(summary_nb_sms.text()) * nombre_de_contact_element;
    summary_total_sms.text(results)
  } else {
    summary_total_sms.text('0')
  }

}




function SpecialCharactersAlert(message) {
  console.log('ok')
  if (message.match(/\|/g) || message.match(/\^/g) || message.match(/\ê/g) || message.match(/\î/g) || message.match(/\ô/g) || message.match(/\\/g) || message.match(/\[/g) || message.match(/\]/g) || message.match(/\€/g) || message.match(/\~/g)) {
    jQuery("#carac_doubl").fadeIn('slow');
  } else {
    jQuery("#carac_doubl").fadeOut('slow');
  }
}