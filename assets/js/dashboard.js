jQuery(document).on('ready', () => {
  let sms_count = jQuery("[data-sms]").attr("data-sms");
  let email_count = jQuery("[data-email]").attr("data-email");

  if (sms_count == 0 && email_count == 0) {
  } else {
    const labels = ["SMS", "EMAIL"];

    const data = {
      labels: labels,
      datasets: [
        {
          data: [sms_count, email_count],
          backgroundColor: ["#03A6EF", "#48B948"],
        },
      ],
    };

    const config = {
      type: "doughnut",
      data: data,
      options: {
        plugins: {
          legend: {
            display: false,
          },
        },
      },
    };

   new Chart(jQuery("#credits_diagram"), config);
  }
})

jQuery('#last_campaigns_list ul').html(ShowContentLoader())
jQuery.post(
    ajaxurl,
    {
      action: "Set__campaign_list",
      nbr: 5,
    },
    function (response) {
      HideContentLoader()
      jQuery("#last_campaigns_list ul").html(response);
    }
  );

