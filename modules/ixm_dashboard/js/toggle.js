(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.ixmDashboardToggle = {
    attach: function attach(context, settings) {
      var $toggle = $('#ixm-dashboard-toggle', context);
      var $dashboard = $('#ixm-dashboard', context);

      if ($toggle.length && $dashboard.length) {

        $toggle.click(function () {
          var currentStatus = !$.cookie('IXMDashboardShow') || $.cookie('IXMDashboardShow') * 1 === 1;
          if (currentStatus) {
            $dashboard.removeClass('enabled');
            $('body').removeClass('ixm-dashboard');
            $.cookie('IXMDashboardShow', 0, {path: '/'});
          }
          else {
            $dashboard.addClass('enabled');
            $('body').addClass('ixm-dashboard');
            $.cookie('IXMDashboardShow', 1, {path: '/'});
          }
        });

        // Initial value.
        var currentStatus = !$.cookie('IXMDashboardShow') || $.cookie('IXMDashboardShow') * 1 === 1;
        if (currentStatus) {
          $('body').addClass('ixm-dashboard');
          $dashboard.addClass('enabled');
        }
      }
    }
  };

})(jQuery, Drupal, drupalSettings);
