<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
  <div class="row">
    <div class="col-xs-12 col-sm-8">
      <div class="box">
        <?php echo dg_date($post->id); ?>
        <?php echo dg_title($post->id); ?>
        <h1 class="head"><?php echo dg_title($post->id); ?></h1>
        <div class="byline"><?php dg_byline(); ?> / <?php dg_entry_date(); ?></div>
        -----------
        <?php //print_r(dg_author_slugs($post->id)); ?>
        -----------
        <p><?php //echo dg_summary($post->id); ?></p>
        <p><?php //echo dg_author_slugs($post->id); ?></p>
        <div class="entry-content">
          <?php the_content(); ?>  
        </div>

        <!-- Share Tools -->
        <?php dg_sharetools($id); ?>

      </div><!-- end .box -->
    </div>
  </div>
</article> <!-- #post -->