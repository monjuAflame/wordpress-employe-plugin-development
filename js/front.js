(function ($) {
  "use strict";

  jQuery(document).ready(function () {
    jQuery("button").click(function (e) {
      let tabledata = jQuery(e.target).attr("data-id");
      jQuery("#info-" + tabledata + " table").slideToggle(300);
    });
  });
})(jQuery);
