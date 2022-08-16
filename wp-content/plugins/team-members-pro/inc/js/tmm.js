/**
 * Team Members Front JS
 */

;(function($){
$(document).ready(function (){

  $('body').on('click', '.tmm_more_info', function(){
    $(this).find(".tmm_comp_text").slideToggle(100);
  });

  /* Equalizes each member on the page. */
  function tmm_equalize(){

    /* Preparing social icon. */
    $('.tmm_textblock').css({'padding-bottom' : '10px'});

    $('.tmm_scblock').each(function(i, val){
      if ($(this).html().length > 0) {
        $(this).closest('.tmm_textblock').css({'padding-bottom' : '65px'});
      }
    });

    /* Equalizer. */
    $('.tmm_container').each(function(){

      if($(this).hasClass('tmm-equalizer')){

        var current_container = $(this);
        var members = [];

        var tabletCount = 0;
        var tabletArray = [];
        var memberOne;
        var memberOneHeight;
        var memberTwo;
        var memberTwoHeight;

        current_container.find('.tmm_member').each(function(){

          tabletCount++;

          var current_member = $(this);
          current_member.css({'min-height':0});
          members.push(current_member.outerHeight());

          if (tabletCount == 1) {
            memberOne = current_member;
            memberOneHeight = memberOne.outerHeight();
          } else if (tabletCount == 2) { 
            tabletCount = 0;
            memberTwo = current_member;
            memberTwoHeight = memberTwo.outerHeight();

            if (memberOneHeight >= memberTwoHeight) {
              tabletArray.push({
                memberOne: memberOne,
                memberTwo: memberTwo,
                height: memberOneHeight
              });
            } else {
              tabletArray.push({
                memberOne: memberOne,
                memberTwo: memberTwo,
                height: memberTwoHeight
              });
            }

          }

        });

        if(parseInt($( window ).width()) > 1026){

          biggestMember = Math.max.apply(Math, members);
          current_container.find('.tmm_member').css('min-height', biggestMember);

        } else if (parseInt($( window ).width()) > 640) {

          $.each( tabletArray, function( index, value ){
            $(value.memberOne).css('min-height', value.height);
            $(value.memberTwo).css('min-height', value.height);
          });

        } else {

          current_container.find('.tmm_member').css('min-height', 'auto');

        }

      }

    });

    

  }

  /* Debounce function for fallback keyup. */
  // http://davidwalsh.name/javascript-debounce-function
  function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
  };

  /* First call. */
  tmm_equalize();

  // Calls after images loaded.
  $(window).on("load", function() { tmm_equalize(); });

  /* Triggers equalizer on resize. */
  $( window ).resize( debounce(function() { tmm_equalize(); }, 100));

});
})(jQuery);