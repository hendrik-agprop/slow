jQuery(document).ready(function($){
  function updateArticleHeaderVideos() {
    $('.article-header--fullscreen .video-wrapper').each(function() {
      var windowHeight = $(window).height();
      var windowWidth = $(window).width();
      var height = windowHeight > windowWidth ? ( windowWidth / 1.77778 ) : ( windowHeight );
      var width = height * 1.77777;
      var scale = windowHeight < windowWidth ? (Math.max(width, windowWidth) / Math.min(width, windowWidth)) : (windowHeight / height);
      $('.article-header--fullscreen .video').css('transform', "scale(" + scale + ")");
    });
  }
  updateArticleHeaderVideos();
  $(window).resize(updateArticleHeaderVideos);

  function updateArticleHeaders() {
    var height = $(window).height();
    $('.article-header--fullscreen').css('height', height+'px');
  }
  updateArticleHeaders();
  $(window).resize(updateArticleHeaders);
});