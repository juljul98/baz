<footer id="containerfooter" class="footerclass" role="contentinfo">
  <div class="container">
  	<div class="row">
  		<?php global $virtue; if(isset($virtue['footer_layout'])) { $footer_layout = $virtue['footer_layout']; } else { $footer_layout = 'fourc'; }
  			if ($footer_layout == "fourc") {
  				if (is_active_sidebar('footer_1') ) { ?> 
					<div class="col-md-3 col-sm-6 footercol1">
					
						<div id="logo" class="logocase">
						  <a class="brand logofont" href="<?php echo home_url(); ?>/">
							<?php if (!empty($virtue['x1_virtue_logo_upload']['url'])) { ?>
							  <div id="thelogo">
								<img src="<?php echo esc_url($virtue['x1_virtue_logo_upload']['url']); ?>" alt="<?php bloginfo('name');?>" class="kad-standard-logo" />
								<?php if(!empty($virtue['x2_virtue_logo_upload']['url'])) {?>
								<img src="<?php echo esc_url($virtue['x2_virtue_logo_upload']['url']);?>" alt="<?php bloginfo('name');?>" class="kad-retina-logo" style="max-height:<?php echo esc_attr($virtue['x1_virtue_logo_upload']['height']);?>px" /> <?php } ?>
							  </div>
							<?php } else { 
								echo apply_filters('kad_site_name', get_bloginfo('name')); 
							  } ?>
						  </a>
						  <?php if (isset($virtue['logo_below_text']) && !empty($virtue['logo_below_text'])) { ?>
							<p class="kad_tagline belowlogo-text"><?php echo $virtue['logo_below_text']; ?></p>
						  <?php }?>
					   </div> <!-- Close #logo -->
					</div> 
            	<?php }; ?>
				<?php if (is_active_sidebar('footer_2') ) { ?> 
					<div class="col-md-3  col-sm-6 footercol2">
					<?php dynamic_sidebar('footer_2'); ?>
					</div> 
		        <?php }; ?>
		        <?php if (is_active_sidebar('footer_3') ) { ?> 
					<div class="col-md-3 col-sm-6 footercol3">
					<?php dynamic_sidebar('footer_3'); ?>
					</div> 
	            <?php }; ?>
				<?php if (is_active_sidebar('footer_4') ) { ?> 
					<div class="col-md-3 col-sm-6 footercol4">
					<?php dynamic_sidebar('footer_4'); ?>
					</div> 
		        <?php }; ?>
		    <?php } else if($footer_layout == "threec") {
		    	if (is_active_sidebar('footer_third_1') ) { ?> 
					<div class="col-md-4 footercol1">
					<?php dynamic_sidebar('footer_third_1'); ?>
					</div> 
            	<?php }; ?>
				<?php if (is_active_sidebar('footer_third_2') ) { ?> 
					<div class="col-md-4 footercol2">
					<?php dynamic_sidebar('footer_third_2'); ?>
					</div> 
		        <?php }; ?>
		        <?php if (is_active_sidebar('footer_third_3') ) { ?> 
					<div class="col-md-4 footercol3">
					<?php dynamic_sidebar('footer_third_3'); ?>
					</div> 
	            <?php }; ?>
			<?php } else {
					if (is_active_sidebar('footer_double_1') ) { ?>
					<div class="col-md-6 footercol1">
					<?php dynamic_sidebar('footer_double_1'); ?> 
					</div> 
		            <?php }; ?>
		        <?php if (is_active_sidebar('footer_double_2') ) { ?>
					<div class="col-md-6 footercol2">
					<?php dynamic_sidebar('footer_double_2'); ?> 
					</div> 
		            <?php }; ?>
		        <?php } ?>
        </div>
        <div class="footercredits clearfix">
    		<p class="copyright"><?php echo date("Y")."&copy;".get_bloginfo("title"); ?></p>
		<div class="footercredit01">
			<?php if (is_active_sidebar('footer_copy_01') ) { ?>
					<div>
					<?php dynamic_sidebar('footer_copy_01'); ?> 
					</div> 
		            <?php }; ?>
		</div>
		
		<div class="footercredit02">
			<?php if (is_active_sidebar('footer_copy_02') ) { ?>
					<div>
					<?php dynamic_sidebar('footer_copy_02'); ?> 
					</div> 
		            <?php }; ?>
		</div>
    	</div>

  </div>

</footer>

<?php wp_footer(); ?>