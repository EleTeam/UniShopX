/*jslint browser: true*/
/*global console*/

var myapp = myapp || {};
myapp.pages = myapp.pages || {};

myapp.pages.IndexPageController = function (myapp, $$) {
  'use strict';
  
  // Init method
  (function () {

    // Use toast plugin
    var options = {},
        toast = myapp.toast('Marked star', '<div>☆</div>', options),
        toastWithOutIcon = myapp.toast('', '', {});

    $$('#btnshow').click(function () {
      toast.show();
    });
    
    $$('#btnhide').click(function () {
      toast.hide();
    });

    $$('#btnShowNoIcon').click(function() {
      toastWithOutIcon.show("A long long message");
    });

    $$('#btnHideNoIcon').click(function() {
      toastWithOutIcon.hide();
    });
  }());
};