<div class="col-xs-12 col-sm-4">
  <div class="box">
    <article id="post-<?php the_ID(); ?>" <?php post_class('entry card'); ?>>
      <?php dg_featured_media('w150', get_the_ID()); ?>
      <h3 class="head">
        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
      </h3>

      <div class="entry-content entry-summary">
        <?php dg_excerpt(); ?>
      </div>
  
    </article> <!-- #post -->
  </div>
</div>