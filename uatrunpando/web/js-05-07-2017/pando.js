/*!
 * Start Bootstrap - Agency Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top }, 1500, 'easeOutExpo');
        event.preventDefault();
    });
});

// Highlight the top nav as scrolling occurs
$('body').scrollspy({
    target: '.navbar-fixed-top',
	//offset: 105
})

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});


function minHeight() {
   

        var $windowHeight       = $(window).height();
        var $windowWidth        = $(window).width();
        var $navHeight          = $('.navbar').height();

        $('.fill ').css('min-height', $windowHeight - $navHeight );
        $('.fill ').css('padding-top', $navHeight );
        $('.display--table').css('height', $windowHeight - $navHeight);

      }minHeight();
      
      $(window).resize(function () {
        minHeight();
     });
      $(document).ready(function() {
    		$('.alert').delay(3000).fadeOut('slow');
    		$('#alert').delay(3000).fadeOut('slow');
      });