/**
 * Hide Header on on scroll down
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

    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
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