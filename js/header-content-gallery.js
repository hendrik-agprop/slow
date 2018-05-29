jQuery(document).ready(function($){

  function updateFullScreenGalleries() {
    var height = $(window).height();
    $('.swiper-container--fullscreen').css('height', height+'px');
  }
  updateFullScreenGalleries();
  $(window).resize(updateFullScreenGalleries);

  $('.swiper-container--fullscreen').each(function(){

    var images = $(this).find('.swiper-slide');

    if (images.length > 1) {
      var swiper = new Swiper(this, {
        slidesPerView: 1,
        lazy: false,
        loop: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: true,
        },
      });
    } else {
      var swiper = new Swiper(this, {
        slidesPerView: 1,
        lazy: false,
        loop: false
      });
    }
  });

  $('.swiper-container--inline').each(function() {

    var images = $(this).find('.swiper-slide');

    if (images.length > 1) {
      new Swiper(this, {
        slidesPerView: 3,
        loop: true,
        centeredSlides: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        breakpoints: {
          1280: {
            slidesPerView: 2,
            spaceBetween: 0
          },
          667: {
            slidesPerView: 1,
            spaceBetween: 0
          }
        }
      });
    } else if ( images.length == 1 ) {
      new Swiper(this, {
        slidesPerView: 1,
        loop: false
      });
    }
  });
});
