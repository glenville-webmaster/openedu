(function ($, Drupal) {
  Drupal.behaviors.sub_color = {
    attach: function attach(context, settings) {
      var val = $('#js-sub-color-json').val() || '{}';
      var sub_color_ref = JSON.parse(val);
      if (Object.keys(sub_color_ref).length !== 0 && sub_color_ref.constructor === Object) {
        settings.color.reference = sub_color_ref;
      }
      $('#subtheme-entity-add-form, #subtheme-entity-edit-form').submit(function(event) {
        //event.preventDefault();
        var inputs_values = {};
        $('.js-color-palette input.form-text').each(function () {
          inputs_values[this.key] = this.value;
        }).promise().done(function() {
          $('#js-sub-color-json').val(JSON.stringify(inputs_values));
        });
      });
      
    }
  };
})(jQuery, Drupal);