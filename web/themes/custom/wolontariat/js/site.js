(function ($, Drupal) {

  function setEventsBlockHeight(){
    var blockHeight = $('#block-views-events-block-1').height();
    $('#block-views-events-block').height(blockHeight);
  }

  function hideEmptySliderText(){
    $( '.line-1' ).each(function() {
      if($(this).text() === '' ){
        $(this).closest('.line-group').hide();
      };
    });
  }

  function eventFullblock() {

    if($("#block-views-events-block-1").length == 0) {
      //it doesn't exist
      $("#block-views-events-block").addClass("event-full");
    }

  }

  function addValue() {
    $("#block-search-form .btn").attr("value","Wyszukaj w witrynie");
  }

  /**
   * Campaign main behavior.
   */
  Drupal.behaviors.wolontariatSite = {
    attach: function (context, settings) {
      // setEventsBlockHeight();
      // hideEmptySliderText();
      // eventFullblock();
      // addValue();

      $('.search-block-form .input-group-btn').once('enter').on('mouseenter', function() {
        $('.search-block-form .form-search').show('slide', { direction: "right" });
      });

      $('.search-block-form').once('leave').on('mouseleave', function() {
        $('.search-block-form .form-search').hide("slide", { direction: "right" });
      });
    }
  };

}(jQuery, Drupal));


