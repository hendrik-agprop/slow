<?php
$video = get_field( 'header_video' );

if ( $video ) {
  $video_type = $video['header_video_type'];

  if ( $video_type === 'file' ) {

  } elseif ( $video_type === 'embed' ) {
    $video_embed = $video['header_video_embed'];

    $video_embed = str_replace( '" width', '&autoplay=1&loop=1&autopause=0&background=1" width', $video_embed );

    echo '<div class="video video--background">';
    echo '<div class="video-wrapper">';
    echo $video_embed;
    echo '</div>';
    echo '<div class="video-block"></div>';
    echo '</div>';
  }
}
?>
