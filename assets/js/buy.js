jQuery.post(
  ajaxurl, {
    action: "SH_ajax_api_request",
    data: 'premium',
    url_api: 'client/tarifs'
  },
  function (response) {
    response = JSON.parse(response)
    getProductPrice(response);
  })
  
  function getProductPrice(datas) {
    let premium = datas.premium;
    let html = datas.html;
    var prices_product_01 = []
    var prices_product_02 = []
    var paliers = []
    
    premium = Object.entries(premium)
    html = Object.entries(html)
    jQuery.each(premium, (key,element)=>{
      paliers.push(parseInt(element[0]))
      prices_product_01.push(element[1]);
    })
    
    if (html.length < 3) {
      html = html[0];
    for (let i = 0; i < 3; i++) {
      prices_product_02.push(html[1])
    }
    } else {
      jQuery.each(html, (key,element)=>{
        paliers.push(element[0])
        prices_product_02.push(element[1]);
      })
    }
    
    
  function spaceNumber(number) {
    let regex = /(-?[0-9]+)([0-9]{3})/;
    number += '';

    while (regex.test(number)) {
      number = number.replace(regex, '$1 $2');
    }

    return number;
  }


  /* FIN VARIABLES A FOURNIR */

  let nb_products = 2;
  var price_product = [];
  var price_product_space = [];
  var cur_palier = 0;
  var cur_nb_product = paliers[cur_palier];
  var increment = 100;

  /* AJOUT DES PRIX ET PALIERS DANS HTML */

jQuery.each(prices_product_01, (index,price) => {
  jQuery('.show-price-premium-'+index+'').each( function () {
    jQuery(this).html(price + ' €')
  })
})

jQuery.each(prices_product_02, (index,price) => {
jQuery('.show-price-html-'+index+'').each( function () {
  jQuery(this).html(price + ' €')
})

})

// jQuery('.show-price-step-0').each(function () {
//   jQuery(this).html(''+ shTranslate.text1 +' <span>100</span> '+ shTranslate.text2 +' <span>'+paliers[0]+'</span> ')
// })

// jQuery('.show-price-step-1').each(function () {
//   jQuery(this).html(''+ shTranslate.text1 +' <span>'+paliers[0]+'</span> '+shTranslate.text2+' <span>'+paliers[1]+'</span> ')
// })

// jQuery('.show-price-step-2').each(function () {
//   jQuery(this).html(''+ shTranslate.text3 +' <span>'+paliers[2]+'</span>')
// })

// jQuery('.show-price-step-0').html(''+ shTranslate.text1 +' <span>100</span> '+ shTranslate.text2 +' <span>'+paliers[0]+'</span> ')
// jQuery('.show-price-step-1').html(''+ shTranslate.text1 +' <span>'+paliers[0]+'</span> '+shTranslate.text2+' <span>'+paliers[1]+'</span> ')
// jQuery('.show-price-step-2').html(''+ shTranslate.text3 +' <span>'+paliers[2]+'</span>')

// jQuery('.show-price-step-0').html(''+ shTranslate.text1 +' <span>100</span> '+ shTranslate.text2 +' <span>'+paliers[0]+'</span> ')
// jQuery('.show-price-step-1').html(''+ shTranslate.text1 +' <span>'+paliers[0]+'</span> '+shTranslate.text2+' <span>'+paliers[1]+'</span> ')
// jQuery('.show-price-step-2').html(''+ shTranslate.text3 +' <span>'+paliers[2]+'</span>')


  /* CLIC SUR LES LIGNES DES PRODUITS */

  jQuery(document).on('click', '.line-product-price', function () {
    cur_palier = jQuery(this).data("palier");
    cur_nb_product = paliers[cur_palier];
    activePalier(true);
  });

  /* SAISIE DU VOLUME */

  jQuery("#volume-product").on("keyup paste", function () {
    checkVolume();
  });

  function checkVolume() {
    cur_nb_product = jQuery('#volume-product').val();
    var write = false;
    if (jQuery.isNumeric(cur_nb_product) === false && cur_nb_product !== '') {
      write = true;
      cur_nb_product = paliers[0];
    }
    if (cur_nb_product < paliers[0]) {
      cur_nb_product = paliers[0];
    } else if (typeof palier_max !== 'undefined' && cur_nb_product > palier_max) {
      write = true;
      cur_nb_product = palier_max;
    } else if (cur_nb_product > 999999999) {
      write = true;
      cur_nb_product = 999999999;
    }
    cur_palier = -1;
    for (var i = 0; i < 10; i++) {
      if (paliers[i] !== "undefined") {
        if ((cur_nb_product >= paliers[i]) && (typeof paliers[i + 1] === "undefined" || cur_nb_product < paliers[i + 1])) {
          cur_palier = i;
        }
      }
    }
    if (cur_palier == 0) {
      increment = 100;
    } else if (cur_palier == 1) {
      increment = 1000;
    } else if (cur_palier > 1) {
      increment = 5000;
    };
    activePalier(write);
  }

  /* Active le palier */

  function activePalier(write) {
    if (cur_palier >= 0) {
      jQuery('.line-product-price').removeClass('active');
      jQuery('.line-product-price[data-palier="' + cur_palier + '"]').addClass('active');
      if (write) {
        jQuery('#volume-product').val(cur_nb_product);
      }
      computePrice();
    }
  }

  /* CALCUL DU/DES PRIX */

  function computePrice() {
    for (i = 1; i <= nb_products; i++) {
      price_product[i] = eval('prices_product_0' + i)[cur_palier] * cur_nb_product;
      if (typeof frais_fixes !== 'undefined' && frais_fixes > 0) {
        price_product[i] += frais_fixes;
      }
      if (Math.round(price_product[i]) !== price_product[i]) {
        price_product[i] = price_product[i].toFixed(2);
      }
      price_product_space[i] = spaceNumber(price_product[i]);
      if (price_product[i] > 0) {
        jQuery('.product-pack').show();
        jQuery('.product-0' + i + '-price').text(price_product_space[i]);
        if (typeof frais_fixes !== 'undefined' && frais_fixes > 0) {
          jQuery('.product-frais-fixes-nb').text(spaceNumber(frais_fixes));
          jQuery('.product-frais-fixes').show();
        }
      } else {
        jQuery('.product-pack').hide();
        jQuery('.product-0' + i + '-price').text('');
        jQuery('.product-frais-fixes').hide();
      }
    }
  }

  /* INCREMENTATION AVEC FLECHES */

  jQuery(document).on('click', '.input-group-volume .btn:first-of-type', function () {
    var newVal = parseInt(jQuery('#volume-product').val(), 10) + increment;
    let purchase_link = 'https://www.spot-hit.fr/espace-client/commandes/ajouter'
    let premium_link = purchase_link + '?html&quantity=' + newVal
    let email_link = purchase_link + '?premium&quantity=' + newVal
    jQuery('#purchase_premium').attr('href', premium_link)
    jQuery('#purchase_html').attr('href', email_link)
    if (typeof palier_max !== 'undefined' && newVal > palier_max) {
      newVal = palier_max;
    }
    jQuery('#volume-product').val(newVal);
    checkVolume();
    return false;
  });

  jQuery(document).on('click', '.input-group-volume .btn:last-of-type', function () {
    var newVal = parseInt(jQuery('#volume-product').val(), 10) - increment;
    let purchase_link = 'https://www.spot-hit.fr/espace-client/commandes/ajouter?'
    let premium_link = purchase_link + 'product=html&quantity=' + newVal
    let email_link = purchase_link + 'product=premium&quantity=' + newVal
    jQuery('#purchase_premium').attr('href', premium_link)
    jQuery('#purchase_html').attr('href', email_link)
    if (newVal < paliers[0]) {
      newVal = paliers[0];
    }
    jQuery('#volume-product').val(newVal);
    checkVolume();
    return false;
  });

  jQuery('#volume-product').on('keyup', function () {
    var newVal = parseInt(jQuery('#volume-product').val(), 10) - increment;
    let purchase_link = 'https://www.spot-hit.fr/espace-client/commandes/ajouter?'
    let premium_link = purchase_link + 'product=html&quantity=' + newVal
    let email_link = purchase_link + 'product=premium&quantity=' + newVal
    jQuery('#purchase_premium').attr('href', premium_link)
    jQuery('#purchase_html').attr('href', email_link)
    if (newVal < paliers[0]) {
      newVal = paliers[0];
    }
    jQuery('#volume-product').val(newVal);
    checkVolume();
    return false;
  });

  activePalier(true);
}