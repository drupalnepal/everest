/**
 * @file
 * everest.admin.js
 */

(function ($) {

  Drupal.behaviors.everestSetSummary = {
    attach: function (context, settings) {
      var $context = $(context);

      $context.find('#edit-development').drupalSetSummary(function () {
        var summary = [];

        if ($context.find('input[name="everest_region_debug"]').is(':checked')) {
          summary.push(Drupal.t('Regions visible for debugging'));
        }

        if ($context.find('input[name="everest_rebuild_registry"]').is(':checked')) {
          summary.push(Drupal.t('Rebuild registry'));
        }

        return summary.join(', ');
      });
    }
  };
})(jQuery);
