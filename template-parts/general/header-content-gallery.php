<?php
$gallery = get_field( 'header_gallery' );

if ( $gallery ) {
  $gallery_images = $gallery['header_gallery_images'];

  if ( count( (array)$gallery_images ) > 0 ) {
    echo '<div class="gallery gallery--fullscreen swiper-container swiper-container--fullscreen">';
    echo '<div class="gallery-images swiper-wrapper">';
    
    foreach ($gallery_images as $image_data) {
      $image_data = $image_data['header_gallery_images_image'];
      $image_meta = $image_data['header_gallery_images_image_meta'];
      $image      = $image_data['header_gallery_images_image_image'];

      if ( $image AND count( (array)$image ) > 0 ) {
        $image_url  = wp_get_attachment_image_src( $image['ID'], 'slow-large', false )[0];

        if ( strlen( $image_url ) > 0 ) {
          echo '<div class="gallery-image-item swiper-slide">';
          echo '<div class="gallery-image" style="background-image: url(' . $image_url . ');">';
          echo '</div>';
          echo '</div>';
        }
      }
    }

    echo '</div>';
    echo '</div>';
  }
}
?>
