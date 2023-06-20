// Spinner
var spinner = function () {
    setTimeout(function () {
        if ($('#spinner').length > 0) {
            $('#spinner').removeClass('show');
        }
    }, 1);
};
spinner();

// Sticky Navbar
$(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.sticky-top').addClass('shadow-sm').css('top', '0px');
    } else {
        $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
    }
});

// Back To TOP
$(window).scroll(function () {
    scrollFunction();
});

function scrollFunction() {
    var scrollButton = $('.scroll-top');

    if ($(window).scrollTop() > 200) {
        scrollButton.css('display', 'block');
    } else {
        scrollButton.css('display', 'none');
    }
}