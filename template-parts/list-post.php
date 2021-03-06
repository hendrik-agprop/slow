<?php

$posts = new WP_Query( array(
  "post_type" => "post",
  "order"     => "DESC"
) );
?>

<div class="article-list article-list--post">
  <?php
  if ( $posts->have_posts() ) :
    /* Start the Loop */
    $i=0;
    while ( $posts->have_posts() ) :
      $posts->the_post();
      get_template_part( 'template-parts/list-item', 'post' );

      if ( $i == 4 ) :
        ?>
        <div class="container--medium">
          <div class="newsletter-box newsletter-box--large">
            <h2>Newsletter</h2>
            <p>Unser Newsletter informiert Sie regelmäßig über neue Projekte, Neuigkeiten und Veranstaltungen rund um uns und das Atelier.</p>
            <!-- Begin MailChimp Signup Form -->
            <form action="https://slow.us18.list-manage.com/subscribe/post?u=145d96fa68ca354b2c1303c70&amp;id=15e31bda02" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
              <input type="text" name="b_145d96fa68ca354b2c1303c70_15e31bda02" tabindex="-1" value="" style="position: absolute; left: -5000px;" aria-hidden="true">
              <input type="text" value="" name="EMAIL" id="mce-EMAIL" placeholder="E-Mail-Adresse">
              <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
            </form>
            <p><small>Hinweise zu der von der Einwilligung mit umfassenden Erfolgsmessung, zum verwendeten Dienstleister Mailchimp, zu den gespeicherten Daten und Ihren Widerrufsrechten erhalten Sie in unserer <a href="http://www.slow.cc/datenschutz">Datenschutzerklärung</a></small></p>
            <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='BIRTHDAY';ftypes[5]='birthday';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
            <!--End mc_embed_signup-->

            <div class="response" id="mce-error-response" style="display:none"></div>
            <div class="response" id="mce-success-response" style="display:none"></div>
          </div>
        </div>
        <?php
      endif;

      $i++;
    endwhile;
  endif;
  ?>
</div>