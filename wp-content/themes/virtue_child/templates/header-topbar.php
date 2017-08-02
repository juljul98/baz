<?php global $virtue; ?>
  <div id="topbar" class="topclass">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3 kad-topbar-left">
          <div class="topbarmenu clearfix">
          <?php if (has_nav_menu('topbar_navigation')) :
              wp_nav_menu(array('theme_location' => 'topbar_navigation', 'menu_class' => 'sf-menu'));
            endif;?>
            <?php if(kadence_display_topbar_widget()) {
                    if(is_active_sidebar('topbarright')) {
                      dynamic_sidebar('topbarright');
                    }
                }
            ?>
            <?php if(kadence_display_topbar_icons()) : ?>
            <!-- <div class="topbar_social">
              <ul>
                <?php $top_icons = $virtue['topbar_icon_menu'];
                foreach ($top_icons as $top_icon) {
                  if(!empty($top_icon['target']) && $top_icon['target'] == 1) {
                    $target = '_blank';
                  } else {
                    $target = '_self';
                  }
                  echo '<li><a href="'.esc_url($top_icon['link']).'" target="'.esc_attr($target).'" title="'.esc_attr($top_icon['title']).'" data-toggle="tooltip" data-placement="bottom" data-original-title="'.esc_attr($top_icon['title']).'">';
                  if(!empty($top_icon['url'])) {
                    echo '<img src="'.esc_url($top_icon['url']).'"/>' ;
                  } else {
                    echo '<i class="'.esc_attr($top_icon['icon_o']).'"></i>';
                  }
                  echo '</a></li>';
                } ?>
              </ul>
            </div> -->
          <?php endif; ?>
          </div>
        </div>
        <div class="col-md-9 col-sm-9 kad-topbar-right">
            <?php
            if(isset($virtue['show_cartcount'])) {
              if($virtue['show_cartcount'] == '1') {
                if (class_exists('woocommerce')) {
                    global $woocommerce; ?>
                    <ul class="kad-cart-total">
                      <li>
                        <a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'virtue_child'); ?>">
                          <i class="icon-shopping-cart" style="padding-right:5px;"></i>
                          <?php echo "alert". sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'virtue_child'), $woocommerce->cart->cart_contents_count);?>
                        </a>
                      </li>
                    </ul>
                    
                  <?php }
                }
              }
              ?>
    <?php if(!is_user_logged_in()){
      echo '<a class="signup-link-topbar" href="/midterm5/iteration3/my-account">SIGN UP</a>';
     }else{
      $user = wp_get_current_user();
      $logout_link = wp_logout_url(get_permalink(wc_get_page_id( 'myaccount' )));
      echo '<a class="logout-link-topbar" href="'.$logout_link.'">LOGOUT</a><a class="signup-link-topbar" href="'.site_url().'/my-account">'.$user->user_login.'</a>';
    } ?>
          <div id="topbar-search" class="topbar-widget">
            <?php
                  if(kadence_display_top_search()) {
                    get_search_form();
                  }
            ?>
          </div>
        </div> <!-- close col-md-4-->
      </div> <!-- Close Row -->
    </div> <!-- Close Container -->
  </div>