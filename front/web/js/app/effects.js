$('[data-spy="scroll"]').on('activate.bs.scrollspy', function () {
    var hash = $(this).find("li.active a").attr("href");
console.log($(hash).css('background-color'));
    $('#navigation-main').css('background-color', $(hash).css('background-color'));
});