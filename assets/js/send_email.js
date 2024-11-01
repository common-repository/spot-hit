const spothit_submit = jQuery("#spothit_form_submit");
const input_message = jQuery("#spothit_form textarea[data-name='message']");
const input_object = jQuery('input[data-name="sujet"]');
const input_date_now = jQuery("#date_now");
const input_date_scheduled = jQuery("#date_scheduled");
const select_date = jQuery('select[name="date_jour"]');
const input_date = jQuery('input[name="date_jour"]');
const campaign_name = jQuery('input[data-name="nom"]');
let input_sender = jQuery("#custom_sender_email");
let cancel_confirmation = jQuery('#cancel_campaign_btn')
let send_confirmation = jQuery('#send_campaign_btn')




jQuery(document).on("ready", () => {

  ///////////////////////////////////////////////
  // Vérification de la présenced'un expéditeur
  // personnalisé en base de données.
  ///////////////////////////////////////////////
  Summary_Manual_Count('email')
  CampaignPagination();
  DateSelectList();
  SmartphoneHour();
  GetCustomSender('sending_email_address', 'campaign')
  GetCustomSender('sending_email_name', 'campaign')
    ///////////////////////////////////////////////
    // Data toggle restrictions expéditeur email
    ///////////////////////////////////////////////
    // jQuery('#email_sender_restriction').on('click', () => {
    //     let popup_content = SH_plugin_translate.text1
    //     show_notification(false, popup_content, false)
    //   })

    ! function (a) {
      a.fn.datepicker.dates.fr = {
        days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
        daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
        daysMin: ["d", "l", "ma", "me", "j", "v", "s"],
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
})


///////////////////////////////////////////////
// Initialisation date picker



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
  jQuery('.date_bubble').text('Immediatly');
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

    ////////////////////////////////////////////////////////////
    // Traitement des données suite au clic sur le bouton envoyer
    //////////////////////////////////////////////////////////////
    let check_error = error_processing("email");
    if (check_error.state == 1) {
      show_notification(2, check_error.errors, false)
    }
    // Write_error(check_error.errors, check_error.state)

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Appel de la fonction permettant la vérification de la présence de données dans les champs obligatoires.
    // Dans le cas ou un champ requis n'est pas complété, une notification sera envoyé et l'élément manquant
    // sera mis en surbrillance.
    //
    // La fonction renvoie un "état", si l'état est de 0, le processus de vérification de données continue,
    // sinon, seul les notification seront envoyés
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (check_error.state == 0) {


      if (jQuery('#sender_name_checkbox').is(':checked') === true) {
        SetCustomSender('sending_email_name', jQuery('#name_sender').val() )
      }
      if (jQuery('#sender_email_checkbox').is(':checked') === true) {
        SetCustomSender('sending_email_address', jQuery('#custom_sender_email').val() )
      }

      if (campaign_name.length) {
        ///////////////////////////////////////////////////////
        // Verification de la présence d'un nom de campagne
        ///////////////////////////////////////////////////////
        let campaign_name_content = campaign_name.val();
        datas_send.push({
          name: "nom",
          value: campaign_name_content,
        });
      }


      let sender_email_address = input_sender.val();
      let sender_name = jQuery('input[data-name="nom_expediteur"]').val();
      //////////////////////////////////////////////////////////////////
      // Verification de la présence de l'adresse email de l'expéditeur
      //////////////////////////////////////////////////////////////////
      if (sender_email_address.length) {
        datas_send.push({
          name: "expediteur",
          value: sender_email_address,
        });
      }

      if (sender_name.length) {
        ///////////////////////////////////////////////////////////////////////
        // Verification de la présence d'un nom personnalisé pour l'expéditeur
        ///////////////////////////////////////////////////////////////////////
        datas_send.push({
          name: "nom_expediteur",
          value: sender_name,
        });
      }

      let email_object = jQuery('input[data-name="sujet"]').val();
      if (email_object.length) {
        ///////////////////////////////////////////////////////////////////////
        // Verification de la présence d'un sujet
        ///////////////////////////////////////////////////////////////////////
        datas_send.push({
          name: "sujet",
          value: email_object,
        });
      }


      let recipient_choice = jQuery('input[name="recipient_choice"]:checked').val();
      //////////////////////////////////////////////////////////////////////////
      // Verification du type de destinataire via la valeur de recipient_choice.
      // Puis, insertion dans le tableau de données en fonction de la valeur.
      //
      // La valeur 0 correspond aux groupes wordpress.
      // La valeur 1 correspond aux groupes spothit.
      // La valeur 2 correspond a une suite de numéros séparés par une virgule.
      //////////////////////////////////////////////////////////////////////////

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
        let value = jQuery('textarea[data-param="recipients"]').val();

        datas_send.push({
          name: "destinataires",
          type: "manual",
          value: value,
        });
      }


      let email_message_type = jQuery('input[name="email_message_type"]:checked');
      //////////////////////////////////////////////////////////////////////////
      // Verification du type de message via la valeur de email_message_type.
      // Puis, insertion dans le tableau de données en fonction de la valeur.
      //
      // La valeur 0 correspond à un message rédigé manuellement.
      // La valeur 1 correspond à un template prédéfinit.
      //////////////////////////////////////////////////////////////////////////
      if (email_message_type.val() == 0) {
        let message = tinymce.get("email_custom").getContent();
        if (message.length) {
          datas_send.push({
            name: "message",
            value: message,
          });
        }
      }
      if (email_message_type.val() == 1) {
        let selected_model = jQuery('input[name="model_select"]:checked').val();
        datas_send.push({
          name: "message",
          value: selected_model,
        }, {
          name: "type_message",
          value: "creation",
        });
      }

      let date_choice = jQuery('input[name="date_choice"]:checked').val();
      ////////////////////////////////////////////////////////////////////////////////
      // Si le bloc "Date programmé" est selectionné, alors récupération des valeurs,
      // puis conversion des valeurs des inputs de date en Timestamp.
      ////////////////////////////////////////////////////////////////////////////////
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

      /////////////////////////////////////////////////
      // Appel de la fonction pour envoyer la campagne
      /////////////////////////////////////////////////
      Send_message('envoyer/e-mail', datas_send);
    }
  })


//Compteurs pour message et ajout du contenu en parallèle dans les divs smartphone et speech
let email_mess = jQuery("#message_type_results");
jQuery(email_mess).on("click", ".multi_box_label", (e) => {
  let model = e.currentTarget

  let thumbnail_id = jQuery(model).attr('for')
  let thumbnail_src = jQuery('img[data-thumbnail="' + thumbnail_id + '"]').attr('src')
  let thumbnail = jQuery('<img>', {
    src: thumbnail_src
  })
  jQuery('.speech_bubble').empty().append('<img src="' + thumbnail_src + '"></img>')
  jQuery('#msg_preview').html(thumbnail)



  // let message = jQuery(input_message).val();
  // MessageLength(message);
  // console.log(message);
  // message = message.replace(/\n/g, "<br />");
  // jQuery(".smartphone__screen .message p").html(message);

  // jQuery(".speech_bubble").html(message);
});



jQuery(input_sender).on("keyup change paste cut", () => {
  let destinataire = jQuery(input_sender).val()

  if (destinataire.length && OnlySpaces(destinataire) == false) {
    jQuery(".sender_bubble").html(destinataire + "@sh-mail.fr");
    jQuery(".smartphone_sender").html(destinataire + "@sh-mail.fr");
  } else {
    jQuery(".sender_bubble").html(SH_plugin_translate.empty_email_address);
    jQuery(".smartphone_sender").empty();
  }
});



jQuery(input_object).on("keyup change paste cut", () => {
  let object = jQuery(input_object).val();
  jQuery(".smartphone_object").html(object);
  jQuery(".object_bubble").html(object);
});

jQuery(input_date).on("change", () => {
  let date_day = jQuery("#date_day").val();
  let date_hour = jQuery("#date_hour").val();
  let date_minute = jQuery("#date_minute").val();
  let date_string = date_day + " - " + date_hour + ":" + date_minute;
  jQuery(".date_bubble").html(date_string);
});
jQuery(select_date).on("change", () => {
  let date_day = jQuery("#date_day").val();
  let date_hour = jQuery("#date_hour").val();
  let date_minute = jQuery("#date_minute").val();
  let date_string = date_day + " à " + date_hour + ":" + date_minute;
  jQuery(".date_bubble").html(date_string);
});



//CHOIX DES GROUPES DE DESTINATAIRES//

jQuery("#email_message_models").on("click", () => {
  jQuery('#message_type_results').html(ShowContentLoader())
  jQuery.post(
    ajaxurl, {
      type: "POST",
      action: "SH_ajax_api_request",
      url_api: "medias/lister",
    },
    function (response) {
      if (response) {
        HideContentLoader()
        jQuery("#message_type_results").html(response);
      }
    }
  );
});

jQuery("#email_message_write").on("click", () => {
  jQuery("#message_type_results").html(ShowContentLoader());

  let textarea = jQuery("<textarea/>", {
    class: "email_custom",
    id: "email_custom",
    role: "alert",
    placeholder: SH_plugin_translate.email_placeholder,
  });
  textarea.attr("data-name", "message");
  HideContentLoader()
  jQuery("#message_type_results").html(textarea);
  tinymce.init({
    selector: "#email_custom",
    branding: false,
    setup: function (editor) {
      editor.on("keyup change paste cut", () => {
        let content = editor.getContent().trim();
        jQuery('#msg_preview').html(content)
        jQuery('.speech_bubble').html(content)
      })
    },
  });
});

jQuery("#recipient_spothit").on("click", () => {
  jQuery(".recipients_results").html(ShowContentLoader());
  jqxhr = jQuery.post(
    ajaxurl, {
      action: "SH_ajax_api_request",
      data: "email",
      url_api: "groupe/lister",
    },
    function (response) {
      HideContentLoader()
      if (response.length > 0) {
        jQuery(".recipients_results").html(response);
      } else {
        jQuery(".recipients_results").html('<p>'+SH_plugin_translate.no_recipient_group+'</p>');
      }
    }
  );
  setTimeout(function () {
    jqxhr.abort();
  }, 10000);
});

jQuery("#recipient_wordpress").on("click", () => {
  jQuery(".recipients_results").html(ShowContentLoader());
  jqxhr = jQuery.post(
    ajaxurl, {
      action: "SH_ajax_get_customers_goup_list",
      type: 'email',
    },

    function (response) {

      if (response.length > 0) {
        HideContentLoader()
        jQuery(".recipients_results").html(response);
      } else {
        jQuery(".recipients_results").html('<p>'+SH_plugin_translate.no_recipient_group+'</p>');
      }
    }
  );
  setTimeout(function () {
    jqxhr.abort();
  }, 10000);
});

jQuery("#recipient_manual").on("click", () => {
  jQuery(".recipients_results").html(ShowContentLoader);
  let input = jQuery("<textarea>", {
    "data-param": "recipients",
    placeholder: SH_plugin_translate.manual_recipient,
  });
  HideContentLoader()
  jQuery(".recipients_results").html(input);
});

jQuery(".recipients_results").on("click", ".contact_checkbox", () => {
  let div_total = jQuery(".contacts_bubble");
  let all_groups_select = jQuery(".contact_checkbox:checked");
  if (all_groups_select.length > 0) {
    total = 0;
    for (let i = 0; i < all_groups_select.length; i++) {
      const element = all_groups_select[i];
      let groupe_nb = jQuery(element)
        .closest("div")
        .find(".total_group")
        .text();
      total = total += parseInt(groupe_nb);
    }
    div_total.text(total + " contacts");


  }
});