let submit_button_element = document.getElementById("spothit_widget_submit");

let captchaState = false;

if (submit_button_element) {
  submit_button_element.addEventListener("click", (e) => {
    e.preventDefault();
    SpothitWidgetSubmit();
  });
}

let SpothitWidgetSubmit = () => {
  let errorStatus = false;
  let errorMessage = String;
  let form = document.getElementById("spothit_widget_form");
  let listOfInputs = form.querySelectorAll("input");
  let fieldsList = {};
  let errorMessageElement;

  listOfInputs.forEach((element) => {
    errorMessageElement = jQuery(element).parent().find(".error_msg")[0];
    jQuery(errorMessageElement).removeClass("valid-feedback");
    jQuery(errorMessageElement)
      .removeClass("invalid-feedback")
      .css("display", "block");
    errorMessageElement.textContent = "";

    testReg = false;
    switch (element.name) {
      case "firstname":
        fieldsList[element.name] = element.value;
        firstName = element.value;
        testReg = /^[a-zéèçà]{2,50}(-| )?([a-zéèçà]{2,50})?$/gim.test(
          element.value
        );
        if (testReg === false) {
          errorStatus = true;
          errorMessage = SH_plugin_translate.firstname_error;
          jQuery(errorMessageElement).addClass("invalid-feedback");
          errorMessageElement.textContent = errorMessage;
        }

        break;
      case "lastname":
        fieldsList[element.name] = element.value;
        testReg = /^[a-zéèçà]{2,50}(-| )?([a-zéèçà]{2,50})?$/gim.test(
          element.value
        );
        if (testReg === false) {
          errorStatus = true;
          errorMessage = SH_plugin_translate.lastname_error;
          jQuery(errorMessageElement).addClass("invalid-feedback");
          errorMessageElement.textContent = errorMessage;
        }
        break;
      case "phone":
        fieldsList["mobile"] = element.value;
        testReg =
          /^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/gm.test(
            element.value
          );
        if (testReg === false) {
          errorStatus = true;
          errorMessage = SH_plugin_translate.phone_error;
          jQuery(errorMessageElement).addClass("invalid-feedback");
          errorMessageElement.textContent = errorMessage;
        }
        break;
      case "email":
        fieldsList[element.name] = element.value;
        testReg =
          /^([a-z0-9]+(?:[._-][a-z0-9]+)*)@([a-z0-9]+(?:[.-][a-z0-9]+)*\.[a-z]{2,})$/gm.test(
            element.value
          );
        if (testReg === false) {
          errorStatus = true;
          errorMessage = SH_plugin_translate.email_error;
          jQuery(errorMessageElement).addClass("invalid-feedback");
          errorMessageElement.textContent = errorMessage;
        }
        break;
    }
  });

  if (captchaState === true) {
    jQuery("#captcha_error_message")
      .addClass("invalid-feedback")
      .css("display", "none")
      .text("");
    if (errorStatus === false) {
      console.log(fieldsList);
      SaveContact(fieldsList);
    }
  } else {
    jQuery("#captcha_error_message")
      .addClass("invalid-feedback")
      .css("display", "block")
      .text(SH_plugin_translate.captcha_confirm);
  }
};

async function CaptchaCheckout(e) {
  jQuery.post(
    spothit_widget.ajax_url,
    {
      action: "CaptchaCheckout",
      data: {
        token: e,
      },
    },
    function (response) {
      response = JSON.parse(response);

      if (response.error_state == 0) {
        captchaState = true;
      } else {
        captchaState = false;
      }
    }
  );
}

function SaveContact(usersData) {
  jQuery.post(
    spothit_widget.ajax_url,
    {
      action: "WidgetSaveContact",
      data: usersData,
    },
    function (response) {
      response = JSON.parse(response);

      if (response.error_state == 0) {
        jQuery("#spothit_widget_submit")
          .addClass("bg-success text-white disabled")
          .text(SH_plugin_translate.send_success);
      } else {
        jQuery("#spothit_widget_submit")
          .addClass("bg-danger text-white")
          .text(SH_plugin_translate.send_error);
      }
    }
  );
}
