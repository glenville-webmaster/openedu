(function ($, Drupal) {
  Drupal.behaviors.sub_theme_entity = {
    attach: function attach(context, settings) {
      var $logo_fid = $('#subtheme-logo-fid');
      var $parent_logo = $logo_fid.closest('.js-form-wrapper');
      $(document).bind("ajaxSuccess", function(event, xhr, settings) {
        if (settings.type == "POST" && settings.url.indexOf('logo') !== -1) {
          var fid = $('[data-drupal-selector="edit-logo-0-logo-logo-upload-fids"]').val();
          $logo_fid.val(fid);
          var $parent = $('#subtheme-logo-fid').closest('.js-form-wrapper');
          // update preview
          $('.color-preview .img-fluid').attr('src', $parent_logo.find('.js-form-managed-file .file a').attr('href'));
        }
      });
      $('.color-preview .img-fluid').attr('src', $parent_logo.find('.js-form-managed-file .file a').attr('href'));
      $('.js-color-preview-wrapper a').click(function(event) {
        event.preventDefault();
      });
    }
  };
})(jQuery, Drupal);