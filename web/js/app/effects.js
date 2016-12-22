/*
 * Hide Header on scroll down, show it on scroll up
 */
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('nav.navbar').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();

    // Make sure they scroll more than delta
    if (Math.abs(lastScrollTop - st) <= delta) {
        return;
    }

    // Disable this behavior if mobile navbar is expanded
    if ($('#navigation-main').hasClass('in')) {
        return;
    }

    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('nav.navbar').removeClass('nav-visible').addClass('nav-hidden');
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('nav.navbar').removeClass('nav-hidden').addClass('nav-visible');
        }
    }

    lastScrollTop = st;
}

/*
 * Smooth scrolling
 */
$('body').delegate('a[href*=#]:not([href=#])', 'click', (function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {

        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top
            }, 1000);
            return false;
        }
    }
}));

/*
 * Consistent height for posts containers on home page
 */
$(document).ready(function(){
    $('#post-promoted').each(function(){
        var highestBox = 0;
        $('.post.teaser .copy', this).each(function(){
            if($(this).height() > highestBox) {
                highestBox = $(this).height();
            }
        });

        $('.post.teaser .copy',this).height(highestBox);
    });
});
