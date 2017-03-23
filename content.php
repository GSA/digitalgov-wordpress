<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
  <div class="row">
    <div class="col-xs-12 col-sm-8">
      <div class="box">
        <h1 class="head"><?php the_title(); ?></h1>
        <div class="byline"><?php dg_byline(); ?> / <?php dg_entry_date(); ?></div>
        <div class="entry-content">
          <?php the_content(); ?>  
        </div>

        <!-- Share Tools -->
        <?php dg_sharetools($id); ?>

      </div><!-- end .box -->
    </div>
  </div>
</article> <!-- #post -->