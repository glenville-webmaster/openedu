/**
 * @file
 * Preview for the OpenEdu theme.
 */
(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.color = {
    logoChanged: false,
    callback: function (context, settings, $form) {
      // Change the logo to be the real one.
      if (!this.logoChanged) {
        $('.color-preview-logo').css('background-image', 'url(' + drupalSettings.color.logo + ')');
        this.logoChanged = true;
      }

      var $colorPreview = $form.find('.color-preview');
      var $colorPalette = $form.find('.js-color-palette');

      // Solid background.
      $colorPreview.css('backgroundColor', $colorPalette.find('input[name="palette[bg]"]').val());

      // Header.
      $colorPreview.find('#header').css('background-color', $colorPalette.find('#edit-palette-primary').val());
      $colorPreview.find('#block-webform').css('background', $colorPalette.find('#edit-palette-secondary').val());
      $colorPreview.find('article .dropdown-item').css('color', $colorPalette.find('#edit-palette-text').val());
      $colorPreview.find('article .btn-callout').css('background-color', $colorPalette.find('#edit-palette-buttonlink').val());
      $colorPreview.find('header .apply').css('background', $colorPalette.find('#edit-palette-tertiary').val());
    }
  };
  jQuery('.js-color-palette').after('<a href="https://webaim.org/resources/contrastchecker/" target="_blank">Check selected colors for accessibility</a>');
})(jQuery, Drupal, drupalSettings);
