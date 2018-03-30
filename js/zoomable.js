jQuery(document).ready(function($){

  var zoomables = new Array();
  
  $('.zoomable-image').on('click', function(clickEvent){
    console.log('zoom');
    
    $(this).toggleClass('zoom--in');

    var id  = $(this).attr('id');
    if ( !id ) { return; }

    if ($(this).hasClass('zoom--in')) {
      if ($(this).hasClass('zoom--active')) {
        // SHOW ZOOM ELEMENT
        zoomable = zoomables[id];
        zoomable.addClass('zoomable--show');
        zoom(clickEvent);

      } else { 
        // CREATE ZOOM ELEMENT
        var url = $(this).attr('data-zoomable-image');
        if (url) {
          $(this).addClass('zoom--active');

          var zoomable = $('<div>').addClass('zoomable-container');
          zoomable.attr('zoomable-id', id);
          zoomable.css('background-image', 'url(' + url + ')');
          zoomable.on('mousemove', function(event){
            zoom(event);
          });
          zoomable.on('click', function(event){
             // HIDE ZOOM ELEMENT
             $('#'+id).toggleClass('zoom--in');
             zoomable = zoomables[id];
             zoomable.removeClass('zoomable--show');
          });
          
          zoomables[id] = zoomable;
          $('body').append(zoomable);
          zoomable.addClass('zoomable--show');
          zoom(clickEvent);
        }
      }
    }
  });

  function zoom( e ) {
    var zoomer = e.currentTarget;
    e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
    e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
    x = offsetX/zoomer.offsetWidth*100
    y = offsetY/zoomer.offsetHeight*100
    zoomer.style.backgroundPosition = x + '% ' + y + '%';
  }

});