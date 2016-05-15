$('.main_menu>ul').addClass('top_level').treemenu({delay: 300}).openActive();

$(document).ready(function () {
    var scrollContent = $('.scroll_content');
    resizeContent(scrollContent);
    $(window).resize(function () {
        resizeContent(scrollContent);
    })
});
function resizeContent(scrollContent) {
    scrollContent.height($(window).height() - scrollContent.offset().top);
}