(function ($) {
    "use strict";
    $(function () {
//set the container that Masonry will be inside of in a var
        var container = document.querySelector('#post-grid');
//create empty var msnry
        var msnry;
// initialize Masonry after all images have loaded
        imagesLoaded(container, function () {
            msnry = new Masonry(container, {
                itemSelector: '.news-item'
            });
        });
    });
}(jQuery));