$(document).ready(function () {
  //    Tiers switch on/off
  $('.tier_choice_1').on('click', function () {
    $('.tier_choice_1').prop('checked', true);

    $('.tier_choice_2').prop('checked', false);
    $('.tier_choice_3').prop('checked', false);

    $('#ctr_tier1').show();
    $('#ctr_tier2').hide();
    $('#ctr_tier3').hide();
  });

  $('.tier_choice_2').on('click', function () {
    $('.tier_choice_2').prop('checked', true);

    $('.tier_choice_1').prop('checked', false);
    $('.tier_choice_3').prop('checked', false);

    $('#ctr_tier2').show();
    $('#ctr_tier1').hide();
    $('#ctr_tier3').hide();
  });

  $('.tier_choice_3').on('click', function () {
    $('.tier_choice_3').prop('checked', true);

    $('.tier_choice_1').prop('checked', false);
    $('.tier_choice_2').prop('checked', false);

    $('#ctr_tier3').show();
    $('#ctr_tier1').hide();
    $('#ctr_tier2').hide();
  });

  // country select show/hide div
  $('#country').change(function () {
    if ($(this).val() == 'BR') {
      $('#ctr_BRA').show();
      $('#ctr_USA').hide();
    } else if ($(this).val() == 'US') {
      $('#ctr_USA').show();
      $('#ctr_BRA').hide();
    } else {
      $('#ctr_USA').hide();
      $('#ctr_BRA').hide();
    }
  });

  // Click to change the tabs
  $('.option-tabs li').on('click', function () {
    $(this).addClass('active').siblings().removeClass('active');
  });


})