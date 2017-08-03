<?php global $virtue; ?>
  <div id="topbar" class="topclass">
    <div class="container">
      <div class="row">
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
      echo '<a class="logout-link-topbar" href="'.$logout_link.'">Logout</a><a class="signup-link-topbar" href="'.site_url().'/my-account">'.$user->user_login.'</a>';
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