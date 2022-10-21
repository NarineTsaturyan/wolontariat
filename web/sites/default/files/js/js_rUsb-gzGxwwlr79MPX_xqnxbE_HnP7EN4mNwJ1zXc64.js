/*!
 * jQuery Once v2.2.3 - http://github.com/robloach/jquery-once
 * @license MIT, GPL-2.0
 *   http://opensource.org/licenses/MIT
 *   http://opensource.org/licenses/GPL-2.0
 */
(function(e){"use strict";if(typeof exports==="object"&&typeof exports.nodeName!=="string"){e(require("jquery"))}else if(typeof define==="function"&&define.amd){define(["jquery"],e)}else{e(jQuery)}})(function(t){"use strict";var r=function(e){e=e||"once";if(typeof e!=="string"){throw new TypeError("The jQuery Once id parameter must be a string")}return e};t.fn.once=function(e){var n="jquery-once-"+r(e);return this.filter(function(){return t(this).data(n)!==true}).data(n,true)};t.fn.removeOnce=function(e){return this.findOnce(e).removeData("jquery-once-"+r(e))};t.fn.findOnce=function(e){var n="jquery-once-"+r(e);return this.filter(function(){return t(this).data(n)===true})}});

/**
 * @file
 * bef_select_all_none.js
 *
 * Adds select all/none toggle functionality to an exposed filter.
 */

(function ($) {
  Drupal.behaviors.betterExposedFiltersSelectAllNone = {
    attach: function (context) {
      /*
       * Add Select all/none links to specified checkboxes
       */
      var selected = $('.form-checkboxes.bef-select-all-none:not(.bef-processed)');
      if (selected.length) {
        var selAll = Drupal.t('Select All');
        var selNone = Drupal.t('Select None');

        // Set up a prototype link and event handlers.
        var link = $('<a class="bef-toggle" href="#">' + selAll + '</a>')
        link.click(function (event) {
          // Don't actually follow the link...
          event.preventDefault();
          event.stopPropagation();

          if (selAll == $(this).text()) {
            // Select all the checkboxes.
            $(this)
              .html(selNone)
              .siblings('.bef-select-all-none, .bef-tree')
              .find('input:checkbox').each(function () {
                $(this).prop('checked', true);
                // @TODO:
                // _bef_highlight(this, context);
              })
              .end()

              // attr() doesn't trigger a change event, so we do it ourselves. But just on
              // one checkbox otherwise we have many spinning cursors.
              .find('input[type=checkbox]:first').change();
          }
          else {
            // Unselect all the checkboxes.
            $(this)
              .html(selAll)
              .siblings('.bef-select-all-none, .bef-tree')
              .find('input:checkbox').each(function () {
                $(this).prop('checked', false);
                // @TODO:
                // _bef_highlight(this, context);
              })
              .end()

              // attr() doesn't trigger a change event, so we do it ourselves. But just on
              // one checkbox otherwise we have many spinning cursors.
              .find('input[type=checkbox]:first').change();
          }
        });

        // Add link to the page for each set of checkboxes.
        selected
          .addClass('bef-processed')
          .each(function (index) {
            // Clone the link prototype and insert into the DOM.
            var newLink = link.clone(true);

            newLink.insertBefore($(this));

            // If all checkboxes are already checked by default then switch to Select None.
            if ($('input:checkbox:checked', this).length == $('input:checkbox', this).length) {
              newLink.text(selNone);
            }
          });
      }

      // @TODO:
      // Add highlight class to checked checkboxes for better theming
      // $('.bef-tree input[type="checkbox"], .bef-checkboxes input[type="checkbox"]')
      // Highlight newly selected checkboxes
      //  .change(function () {
      //    _bef_highlight(this, context);
      //  })
      //  .filter(':checked').closest('.form-item', context).addClass('highlight')
      // ;
      // @TODO: Put this somewhere else...
      // Check for and initialize datepickers
      // if (Drupal.settings.better_exposed_filters.datepicker) {
      //  // Note: JavaScript does not treat "" as null
      //  if (Drupal.settings.better_exposed_filters.datepicker_options.dateformat) {
      //    $('.bef-datepicker').datepicker({
      //      dateFormat: Drupal.settings.better_exposed_filters.datepicker_options.dateformat
      //    });
      //  }
      //  else {
      //    $('.bef-datepicker').datepicker();
      //  }
      // }
    }                   // attach: function() {
  };                    // Drupal.behaviors.better_exposed_filters = {.

  Drupal.behaviors.betterExposedFiltersAllNoneNested = {
    attach:function (context, settings) {
      $('.bef-select-all-none-nested li').has('ul').once('bef-all-none-nested').each(function () {
        var $this = $(this);
        // Check/uncheck child terms along with their parent.
        $this.find('input:checkbox:first').change(function () {
          $(this).closest('li').find('ul li input:checkbox').prop('checked', this.checked);
        });

        // When a child term is checked or unchecked, set the parent term's
        // status as needed.
        $this.find('ul input:checkbox').change(function () {
          // Determine the number of unchecked sibling checkboxes.
          var $this = $(this);
          var uncheckedSiblings = $this.closest('li').siblings('li').find('> div > input:checkbox:not(:checked)').length;

          // If this term or any siblings are unchecked, uncheck the parent and
          // all ancestors.
          if (uncheckedSiblings || !this.checked) {
            $this.parents('ul').siblings('div').find('input:checkbox').prop('checked', false);
          }

          // If this and all sibling terms are checked, check the parent. Then
          // trigger the parent's change event to see if that change affects the
          // grandparent's checked state.
          if (this.checked && !uncheckedSiblings) {
            $(this).closest('ul').closest('li').find('input:checkbox:first').prop('checked', true).change();
          }
        });
      });
    }
  }

})(jQuery);
;
