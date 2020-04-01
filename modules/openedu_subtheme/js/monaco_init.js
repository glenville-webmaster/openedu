(function ($, Drupal) {
  Drupal.behaviors.monaco = {
    attach: function attach(context, settings) {
      if (!window.require) {
        $.getScript('https://microsoft.github.io/monaco-editor/node_modules/monaco-editor/min/vs/loader.js', function() {
          require.config({
            paths: { 'vs': 'https://microsoft.github.io/monaco-editor/node_modules/monaco-editor/min/vs' },
            baseUrl: 'https://microsoft.github.io/monaco-editor/node_modules/monaco-editor/min/'
          });
          require(['vs/editor/editor.main'], function() {
            var $textarea = $('#custom-css-textarea');
            var editorEl = document.createElement('div');
            editorEl.setAttribute("id", "editor");
            $textarea.parent().append(editorEl);
            var editor = monaco.editor.create(document.getElementById('editor'), {
              value: $textarea.val(),
              language: 'css',
              theme: "vs-dark",
            });
            $('#subtheme-entity-add-form, #subtheme-entity-edit-form').submit(function(event) {
                $textarea.val(editor.getValue());
            });
          });
        });
      }
    }
  };
})(jQuery, Drupal);