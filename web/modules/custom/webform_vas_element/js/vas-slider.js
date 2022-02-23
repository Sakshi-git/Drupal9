/**
 * @file
 * Range slider behavior.
 */
(function ($, Drupal) {

  'use strict';

  /**
   * Process ranges_slider elements.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.vasSlider = {
    attach: function attach(context, settings) {
      $(context).find('.form-type-webform-vas-element').once('number').each(function () {
        var get_input_id = $(this).find('input').attr('id');
        var desktop_id = get_input_id + '-slider-5';
        var mobile_id = get_input_id + '-slider-6';

        //Get slider position settings
        var elements = 'horizontal'
        var elements = (settings.vas_slider && settings.vas_slider.elements && settings.vas_slider.elements[get_input_id]) ? settings.vas_slider.elements[get_input_id].desktop_vertical : null;

        var webform_config = (settings.vas_slider && settings.vas_slider.elements && settings.vas_slider.elements[get_input_id]) ? settings.vas_slider.elements[get_input_id] : null;
        // Get pain value for submitted results
        var result_value = $( '#' + get_input_id ).val();
        if(result_value) {
          var initial_value = result_value;
        }
        else {
          //On Load get window size
          var initial_value = 1;
          $( '#' + desktop_id + ' .noUi-handle' ).css("display","none");
          $( '#' + mobile_id + ' .noUi-handle' ).css("display","none");
          $( '.noUi-handle' ).css("display","none");
        }


        $(window).resize(function () {
          $('body').css('width', 'unset');

          var element = $('body');

          var width = element.width();
          if(width <= 480) {
            $('.mobile-vas-slider').css({'padding-top':'20px'});
            $("label[for='"+get_input_id+"']").css({'float':'none', 'width': '100%'});
          }
          else {
            $('.mobile-vas-slider').css({'padding-top':'0px'});
            if(elements == 'vertical') {
              $("label[for='"+get_input_id+"']").css({'float':'left', 'width': '40%'});
            }

          }
        });

        //on load
        var element_on_load = $('body');

        var width_on_load = element_on_load.width();
        if(width_on_load <= 600) {
          $('.mobile-vas-slider').css({'padding-top':'20px'});
          $("label[for='"+get_input_id+"']").css({'float':'none', 'width': '100%'});
        }
        else {
          $('.mobile-vas-slider').css({'padding-top':'0px'});
          $("label[for='"+get_input_id+"']").css({'float':'left', 'width': '40%'});
        }


        if(elements == 'vertical') {
          $( '.' + get_input_id + '-horizontal-slider' ).css("display","none");
          $( '.' + get_input_id + '-vertical-slider' ).css({"display": "flex", 'flex-direction': 'row', 'justify-content': 'flex-end'});
          $( '.' + get_input_id + '-vertical-slider .mobile-vas-slider-text' ).css({ 'display': 'flex', 'flex-direction': 'column', 'justify-content': 'space-between', 'text-align': 'right', 'padding-right': '20px'});
          $( '.' + get_input_id + '-vertical-slider .vertical-border' ).css({'margin':'0px','background': '#979797', 'height':'2px','width':'23px' });

          //normal slider
          noUiSlider.cssClasses.target += ' range-slider';


          var pipsSlider = document.getElementById(mobile_id);
          noUiSlider.create(pipsSlider, {
            range: {
              min: ((webform_config !== null && webform_config['minimum']) ? webform_config['minimum'] : 0),
              max: ((webform_config !== null && webform_config['maximum']) ? webform_config['maximum'] : 100),
            },
            cssPrefix: 'noUi-',
            orientation: "vertical",
            direction: 'rtl',
            start: initial_value,
            step: ((webform_config !== null && webform_config['step']) ? webform_config['step'] : 1),
          });

          var slideVal = $( '#' + get_input_id ).val();
          pipsSlider.noUiSlider.set(Math.round(slideVal));
          pipsSlider.noUiSlider.on('change.one', function () {
            $( '#' + mobile_id + ' .noUi-handle' ).css('display','block');
            var getVal = pipsSlider.noUiSlider.get();
            $( '#' + get_input_id ).val(Math.round(getVal));
          });

          if (slideVal == null || slideVal == undefined) {
            $( '#' + mobile_id + ' .noUi-handle' ).css("display","none");
          }
          else {
            $( '#' + desktop_id + ' .noUi-handle' ).css('display','block');
          }
        }
        else {
          //normal slider
          var pipsSlider = document.getElementById(desktop_id);
          $("label[for='"+get_input_id+"']").css('width','100%');

          noUiSlider.create(pipsSlider, {
            range: {
              min: ((webform_config !== null && webform_config['minimum']) ? webform_config['minimum'] : 0),
              max: ((webform_config !== null && webform_config['maximum']) ? webform_config['maximum'] : 100),
            },
            start: initial_value,
            step: ((webform_config !== null && webform_config['step']) ? webform_config['step'] : 1),
          });

          var slideVal = $( '#' + get_input_id ).val();
          pipsSlider.noUiSlider.set(Math.round(slideVal));
          pipsSlider.noUiSlider.on('change.one', function () {
            $( '#' + desktop_id + ' .noUi-handle' ).css('display','block');
            $( '#' + mobile_id + ' .noUi-handle' ).css('display','block');
            var getVal = pipsSlider.noUiSlider.get();
            $( '#' + get_input_id ).val(Math.round(getVal));
            mobilepipsSlider.noUiSlider.set(Math.round(getVal));
          });

          if (slideVal == null || slideVal == undefined || slideVal == "") {
            $( '#' + desktop_id + ' .noUi-handle' ).css("display","none");
            $( '#' + mobile_id + ' .noUi-handle' ).css('display','none');
          }
          else {
            $( '#' + desktop_id + ' .noUi-handle' ).css('display','block');
            $( '#' + mobile_id + ' .noUi-handle' ).css('display','block');
          }


          //Mobile slider
          var mobilepipsSlider = document.getElementById(mobile_id);
          noUiSlider.create(mobilepipsSlider, {
            range: {
              min: ((webform_config !== null && webform_config['minimum']) ? webform_config['minimum'] : 0),
              max: ((webform_config !== null && webform_config['maximum']) ? webform_config['maximum'] : 100),
            },
            orientation: "vertical",
            direction: 'rtl',
            start: initial_value,
            step: ((webform_config !== null && webform_config['step']) ? webform_config['step'] : 1),
          });

          mobilepipsSlider.noUiSlider.set(Math.round(slideVal));
          mobilepipsSlider.noUiSlider.on('change.one', function () {
            $( '#' + desktop_id + ' .noUi-handle' ).css('display','block');
            $( '#' + mobile_id + ' .noUi-handle' ).css('display','block');
            var getValmobile = mobilepipsSlider.noUiSlider.get();
            $( '#' + get_input_id ).val(Math.round(getValmobile));
            pipsSlider.noUiSlider.set(Math.round(getValmobile));
          });
        }

        $( '#' + get_input_id ).css("display","none");
      });
    }
  };

})(jQuery, Drupal);
