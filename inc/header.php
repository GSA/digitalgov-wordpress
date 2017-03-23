<header>
  <div class="row">
    <div class="col-xs-12 col-sm-9">
      <div class="box">
        <h1>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img class="logo" src="<?php echo IMG; ?>DigitalGov_Horizontal.png" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
          </a>
        </h1>
        <?php if (is_home()) { ?>
        <h2><?php echo esc_attr( get_bloginfo( 'description' ) ); ?></h2>
        <?php } ?>
        
        <?php include(INC . 'site-nav.php'); ?>
      </div>
    </div>
  </div>
</header>