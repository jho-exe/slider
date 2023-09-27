$(document).ready(function(){
    var $carousel = $('#carouselExampleIndicators');
    $carousel.carousel();
    
    $carousel.on('slide.bs.carousel', function (event) {
        var $currentSlide = $(event.relatedTarget);
        var intervalData = $currentSlide.attr('data-interval');
        if(intervalData) {
            $carousel.data('bs.carousel')._config.interval = intervalData;
        }
    });
});
