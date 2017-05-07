/*jslint browser: true*/
/*global console, Framework7, alert, Dom7*/

/**
 * A plugin for Framework7 to show black little toasts
 *
 * @author www.timo-ernst.net
 * @license MIT
 */
Framework7.prototype.plugins.toast = function (app, globalPluginParams) {
  'use strict';
  
  var Toast = function (text, iconhtml, options) {
    var self = this,
        $$ = Dom7,
        $box;

    function hideBox($curbox) {
      if ($curbox) {
        $curbox.removeClass('fadein').transitionEnd(function () {
          $curbox.remove();
        });
      }
    }

    function isString(obj) {
      return toString.call(obj) === '[object String]';
    }
    
    this.show = function (message) {
      var clientLeft,
          $curbox,
          html = [];
      
      // Remove old toasts first if there are still any
      $$('.toast-container').off('click').off('transitionEnd').remove();
      $box = $$('<div class="toast-container show">');
      
      // Add content
      if (isString(iconhtml) && iconhtml.length > 0) {
        html.push(
          '<div class="toast-icon">' + 
            iconhtml + 
          '</div>'
        );
      }

      if (isString(message) && message.length > 0) {
        text = message;
      }

      if (isString(text) && text.length > 0) {
        html.push(
          '<div class="toast-msg">' + 
            text + 
          '</div>'
        );
      }

      $box.html(
        html.join('')
      );

      // Add to DOM
      clientLeft = $box[0].clientLeft;
      $$('body').append($box);

      $box.css('margin-top', $box.outerHeight() / -2 + 'px')
          .css('margin-left', $box.outerWidth() / -2 + 'px');
      
      // Hide box on click
      $box.click(function () {
        hideBox($box);
      });

      // Dirty hack to cause relayout xD
      clientLeft = $box[0].clientLeft;
      
      // Fade in toast
      $box.addClass('fadein');

      // Automatically hide box after few seconds
      $curbox = $box;
      setTimeout(function () {
        hideBox($curbox);
      }, 1500);
    };

    this.hide = function() {
      hideBox($box);
    };
    
    return this;
  };
  
  app.toast = function (text, iconhtml, options) {
    return new Toast(text, iconhtml, options);
  };
};