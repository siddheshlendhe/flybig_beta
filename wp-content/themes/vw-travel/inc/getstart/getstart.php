<?php
//about theme info
add_action( 'admin_menu', 'vw_travel_gettingstarted' );
function vw_travel_gettingstarted() {    	
	add_theme_page( esc_html__('About VW Travel', 'vw-travel'), esc_html__('About VW Travel', 'vw-travel'), 'edit_theme_options', 'vw_travel_guide', 'vw_travel_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function vw_travel_admin_theme_style() {
   wp_enqueue_style('vw-travel-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstart/getstart.css');
   wp_enqueue_script('vw-travel-tabs', esc_url(get_template_directory_uri()) . '/inc/getstart/js/tab.js');
   wp_enqueue_style( 'font-awesome-css', esc_url(get_template_directory_uri()).'/assets/css/fontawesome-all.css' );
}
add_action('admin_enqueue_scripts', 'vw_travel_admin_theme_style');

//guidline for about theme
function vw_travel_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'vw-travel' );
?>

<div class="wrapper-info">
    <div class="col-left">
    	<h2><?php esc_html_e( 'Welcome to VW Travel Theme', 'vw-travel' ); ?> <span class="version">Version: <?php echo esc_html($theme['Version']);?></span></h2>
    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','vw-travel'); ?></p>
    </div>
    <div class="col-right">
    	<div class="logo">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/final-logo.png" alt="" />
		</div>
		<div class="update-now">
			<h4><?php esc_html_e('Buy VW Travel at 20% Discount','vw-travel'); ?></h4>
			<h4><?php esc_html_e('Use Coupon','vw-travel'); ?> ( <span><?php esc_html_e('vwpro20','vw-travel'); ?></span> ) </h4> 
			<div class="info-link">
				<a href="<?php echo esc_url( VW_TRAVEL_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'Upgrade to Pro', 'vw-travel' ); ?></a>
			</div>
		</div>
    </div>

    <div class="tab-sec">
		<div class="tab">
			<button class="tablinks" onclick="vw_travel_open_tab(event, 'gutenberg_editor')"><?php esc_html_e( 'Setup With Gutunberg Block', 'vw-travel' ); ?></button>	
			<button class="tablinks" onclick="vw_travel_open_tab(event, 'block_pattern')"><?php esc_html_e( 'Setup With Block Pattern', 'vw-travel' ); ?></button>
		  	<button class="tablinks" onclick="vw_travel_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'vw-travel' ); ?></button>	  
		  	<button class="tablinks" onclick="vw_travel_open_tab(event, 'theme_pro')"><?php esc_html_e( 'Get Premium', 'vw-travel' ); ?></button>
		  	<button class="tablinks" onclick="vw_travel_open_tab(event, 'free_pro')"><?php esc_html_e( 'Support', 'vw-travel' ); ?></button>
		</div>

		<!-- Tab content -->
		<?php
			$vw_travel_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$vw_travel_plugin_custom_css ='display: block';
			}
		?>
		<div id="gutenberg_editor" class="tabcontent open">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
			$plugin_ins = VW_Travel_Plugin_Activation_Settings::get_instance();
			$vw_travel_actions = $plugin_ins->recommended_actions;
			?>
				<div class="vw-travel-recommended-plugins">
				    <div class="vw-travel-action-list">
				        <?php if ($vw_travel_actions): foreach ($vw_travel_actions as $key => $vw_travel_actionValue): ?>
				                <div class="vw-travel-action" id="<?php echo esc_attr($vw_travel_actionValue['id']);?>">
			                        <div class="action-inner plugin-activation-redirect">
			                            <h3 class="action-title"><?php echo esc_html($vw_travel_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($vw_travel_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($vw_travel_actionValue['link']); ?>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php }else{ ?>
				<h3><?php esc_html_e( 'Gutunberg Blocks', 'vw-travel' ); ?></h3>
				<hr class="h3hr">
				<div class="vw-travel-pattern-page">
			    	<a href="<?php echo esc_url( admin_url( 'admin.php?page=ibtana-visual-editor-templates' ) ); ?>" class="vw-pattern-page-btn ibtana-dashboard-page-btn button-primary button"><?php esc_html_e('Ibtana Settings','vw-travel'); ?></a>
			    </div>

			    <div class="link-customizer-with-guternberg-ibtana">
					<h3><?php esc_html_e( 'Link to customizer', 'vw-travel' ); ?></h3>
					<hr class="h3hr">
					<div class="first-row">
						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','vw-travel'); ?></a>
							</div>
							<div class="row-box2">
								<span class="dashicons dashicons-networking"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_social_icon_settings') ); ?>" target="_blank"><?php esc_html_e('Social Icons','vw-travel'); ?></a>
							</div>
						</div>
						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','vw-travel'); ?></a>
							</div>
							
							<div class="row-box2">
								<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','vw-travel'); ?></a>
							</div>
						</div>

						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','vw-travel'); ?></a>
							</div>
							 <div class="row-box2">
								<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_woocommerce_section') ); ?>" target="_blank"><?php esc_html_e('WooCommerce Layout','vw-travel'); ?></a>
							</div> 
						</div>
						
						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','vw-travel'); ?></a>
							</div>
							 <div class="row-box2">
								<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','vw-travel'); ?></a>
							</div> 
						</div>
					</div>
				</div>
			<?php } ?>
		</div>

		<div id="block_pattern" class="tabcontent">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
			$plugin_ins = VW_Travel_Plugin_Activation_Settings::get_instance();
			$vw_travel_actions = $plugin_ins->recommended_actions;
			?>
				<div class="vw-travel-recommended-plugins">
				    <div class="vw-travel-action-list">
				        <?php if ($vw_travel_actions): foreach ($vw_travel_actions as $key => $vw_travel_actionValue): ?>
				                <div class="vw-travel-action" id="<?php echo esc_attr($vw_travel_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($vw_travel_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($vw_travel_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($vw_travel_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" href="javascript:void(0);" get-start-tab-id="gutenberg-editor-tab"><?php esc_html_e('Skip','vw-travel'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="gutenberg-editor-tab" style="<?php echo esc_attr($vw_travel_plugin_custom_css); ?>">
				<div class="block-pattern-img">
				  	<h3><?php esc_html_e( 'Block Patterns', 'vw-travel' ); ?></h3>
					<hr class="h3hr">
					<p><?php esc_html_e('Follow the below instructions to setup Home page with Block Patterns.','vw-travel'); ?></p>
	              	<p><b><?php esc_html_e('Click on Below Add new page button >> Click on "+" Icon >> Click Pattern Tab >> Click on homepage sections >> Publish.','vw-travel'); ?></span></b></p>
	              	<div class="vw-travel-pattern-page">
				    	<a href="javascript:void(0)" class="vw-pattern-page-btn button-primary button"><?php esc_html_e('Add New Page','vw-travel'); ?></a>
				    </div>
	              	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/block-pattern.png" alt="" />	
	            </div>

	            <div class="block-pattern-link-customizer">
	              	<div class="link-customizer-with-block-pattern">
						<h3><?php esc_html_e( 'Link to customizer', 'vw-travel' ); ?></h3>
						<hr class="h3hr">
						<div class="first-row">
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','vw-travel'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-networking"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_social_icon_settings') ); ?>" target="_blank"><?php esc_html_e('Social Icons','vw-travel'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','vw-travel'); ?></a>
								</div>
								
								<div class="row-box2">
									<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','vw-travel'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','vw-travel'); ?></a>
								</div>
								 <div class="row-box2">
									<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_woocommerce_section') ); ?>" target="_blank"><?php esc_html_e('WooCommerce Layout','vw-travel'); ?></a>
								</div> 
							</div>
							
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','vw-travel'); ?></a>
								</div>
								 <div class="row-box2">
									<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','vw-travel'); ?></a>
								</div> 
							</div>
						</div>
					</div>	
				</div>				
	        </div>
		</div>

		<div id="lite_theme" class="tabcontent">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
				$plugin_ins = VW_Travel_Plugin_Activation_Settings::get_instance();
				$vw_travel_actions = $plugin_ins->recommended_actions;
				?>
				<div class="vw-travel-recommended-plugins">
				    <div class="vw-travel-action-list">
				        <?php if ($vw_travel_actions): foreach ($vw_travel_actions as $key => $vw_travel_actionValue): ?>
				                <div class="vw-travel-action" id="<?php echo esc_attr($vw_travel_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($vw_travel_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($vw_travel_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($vw_travel_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" get-start-tab-id="lite-theme-tab" href="javascript:void(0);"><?php esc_html_e('Skip','vw-travel'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="lite-theme-tab" style="<?php echo esc_attr($vw_travel_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Lite Theme Information', 'vw-travel' ); ?></h3>
				<hr class="h3hr">
			  	<p><?php esc_html_e('VW travel is a good name when it comes to the themes related to the travel business or any kind of international agency related to travel. It is also good and highly applicable for the tour planners as well as the tourist guides and a nice option for the travel and adventure blogs as well as the travel magazines. VW Travel is a fine theme for the hotels as well as airline agencies and the credit goes to its multiple features of relevance and these include retina ready, user friendliness, CTA, Bootstrap, customization options and above all this  theme has the optimised codes a well as the faster page load time. It has customization options and because of its core multipurpose nature, it is credible not only for the travel related business but also for any type of businesses related to the tourist industry. It is a translation ready theme and this feature is very special for the travel industry because the very word travel means moving across the globe and interacting with the different languages, cultures and civilizations. VW travel is good for tourist agencies, tour operators, travel guides, photographic agencies, travel diaries, vacation, airlines, hotels, lifestyle, technology, traveling or journey blog, fashion, and a lot more. ','vw-travel'); ?></p>
			  	<div class="col-left-inner">
			  		<h4><?php esc_html_e( 'Theme Documentation', 'vw-travel' ); ?></h4>
					<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'vw-travel' ); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( VW_TRAVEL_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'vw-travel' ); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Theme Customizer', 'vw-travel'); ?></h4>
					<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'vw-travel'); ?></p>
					<div class="info-link">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'vw-travel'); ?></a>
					</div>
					<hr>				
					<h4><?php esc_html_e('Having Trouble, Need Support?', 'vw-travel'); ?></h4>
					<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'vw-travel'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( VW_TRAVEL_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'vw-travel'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Reviews & Testimonials', 'vw-travel'); ?></h4>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'vw-travel'); ?>  </p>
					<div class="info-link">
						<a href="<?php echo esc_url( VW_TRAVEL_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'vw-travel'); ?></a>
					</div>
			  		<div class="link-customizer">
						<h3><?php esc_html_e( 'Link to customizer', 'vw-travel' ); ?></h3>
						<hr class="h3hr">
						<div class="first-row">
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','vw-travel'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-slides"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_slidersettings') ); ?>" target="_blank"><?php esc_html_e('Slider Section','vw-travel'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-welcome-write-blog"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_topbar') ); ?>" target="_blank"><?php esc_html_e('Topbar Settings','vw-travel'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','vw-travel'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','vw-travel'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-admin-customizer"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=vw_travel_typography') ); ?>" target="_blank"><?php esc_html_e('Typography','vw-travel'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','vw-travel'); ?></a>
								</div>
								 <div class="row-box2">
									<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_woocommerce_section') ); ?>" target="_blank"><?php esc_html_e('WooCommerce Layout','vw-travel'); ?></a>
								</div>
							</div>
							
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_travel_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','vw-travel'); ?></a>
								</div>
								 <div class="row-box2">
									<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','vw-travel'); ?></a>
								</div> 
							</div>
						</div>
					</div>
			  	</div>
				<div class="col-right-inner">
					<h3 class="page-template"><?php esc_html_e('How to set up Home Page Template','vw-travel'); ?></h3>
				  	<hr class="h3hr">
					<p><?php esc_html_e('Follow these instructions to setup Home page.','vw-travel'); ?></p>
	                <ul>
	                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','vw-travel'); ?></span><?php esc_html_e(' Go to ','vw-travel'); ?>
					  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','vw-travel'); ?></b></p>

	                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','vw-travel'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
	                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','vw-travel'); ?></span><?php esc_html_e(' Go to ','vw-travel'); ?>
					  	<b><?php esc_html_e(' Settings >> Reading ','vw-travel'); ?></b></p>
					  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','vw-travel'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
	                  	<p><?php esc_html_e(' Once you are done with this, then follow the','vw-travel'); ?> <a class="doc-links" href="https://www.vwthemesdemo.com/docs/free-vw-travel/" target="_blank"><?php esc_html_e('Documentation','vw-travel'); ?></a></p>
	                </ul>
			  	</div>
			</div>
		</div>	

		<div id="theme_pro" class="tabcontent">
		  	<h3><?php esc_html_e( 'Premium Theme Information', 'vw-travel' ); ?></h3>
			<hr class="h3hr">
		    <div class="col-left-pro">
		    	<p><?php esc_html_e('WordPress travel theme is a special one for the travel related business and you get this at the affordable rate in the online international market. It is a premium order theme for the travel companies and the travel agencies or for any kind of start-up related to the travel with the focus on expansion in the different parts of globe. WordPress travel theme has some mind blowing features and these include CTA, retina ready, translation ready, Bootstrap framework, customization options and above all, it is minimal as well as responsive plus multipurpose with the clean code as well as shorter page load time. All these features make it good for tourist agencies, tour operators, travel guides, photographic agencies, travel diaries, vacation, airlines, hotels, lifestyle, technology, traveling or journey blog, fashion and a lot more. This is not only an interactive theme but also a user friendly one and supports the current WordPress versions.','vw-travel'); ?></p>
		    	<div class="pro-links">
			    	<a href="<?php echo esc_url( VW_TRAVEL_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'vw-travel'); ?></a>
					<a href="<?php echo esc_url( VW_TRAVEL_BUY_NOW ); ?>"><?php esc_html_e('Buy Pro', 'vw-travel'); ?></a>
					<a href="<?php echo esc_url( VW_TRAVEL_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'vw-travel'); ?></a>
				</div>
		    </div>
		    <div class="col-right-pro">
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/responsive.png" alt="" />
		    </div>
		    <div class="featurebox">
			    <h3><?php esc_html_e( 'Theme Features', 'vw-travel' ); ?></h3>
				<hr class="h3hr">
				<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th></th>
								<th><?php esc_html_e('Free Themes', 'vw-travel'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'vw-travel'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Slider Settings', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Number of Slides', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('4', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('Unlimited', 'vw-travel'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('6', 'vw-travel'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'vw-travel'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Theme sections', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('2', 'vw-travel'); ?></td>
								<td class="table-img"><?php esc_html_e('11', 'vw-travel'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Contact us Page Template', 'vw-travel'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'vw-travel'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Blog Templates & Layout', 'vw-travel'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'vw-travel'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Page Templates & Layout', 'vw-travel'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('2(Left/Right Sidebar)', 'vw-travel'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Color Pallete For Particular Sections', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Global Color Option', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Reordering', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Demo Importer', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Full Documentation', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Latest WordPress Compatibility', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Woo-Commerce Compatibility', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support 3rd Party Plugins', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Secure and Optimized Code', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Exclusive Functionalities', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Enable / Disable', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Google Font Choices', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Gallery', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Simple & Mega Menu Option', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Shortcodes', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Premium Membership', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Budget Friendly Value', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Priority Error Fixing', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Feature Addition', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('All Access Theme Pass', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Seamless Customer Support', 'vw-travel'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( VW_TRAVEL_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'vw-travel'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="free_pro" class="tabcontent">
		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-star-filled"></span><?php esc_html_e('Pro Version', 'vw-travel'); ?></h4>
				<p> <?php esc_html_e('To gain access to extra theme options and more interesting features, upgrade to pro version.', 'vw-travel'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( VW_TRAVEL_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get Pro', 'vw-travel'); ?></a>
				</div>
		  	</div>
		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-cart"></span><?php esc_html_e('Pre-purchase Queries', 'vw-travel'); ?></h4>
				<p> <?php esc_html_e('If you have any pre-sale query, we are prepared to resolve it.', 'vw-travel'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( VW_TRAVEL_CONTACT ); ?>" target="_blank"><?php esc_html_e('Question', 'vw-travel'); ?></a>
				</div>
		  	</div>
		  	<div class="col-3">		  		
		  		<h4><span class="dashicons dashicons-admin-customizer"></span><?php esc_html_e('Child Theme', 'vw-travel'); ?></h4>
				<p> <?php esc_html_e('For theme file customizations, make modifications in the child theme and not in the main theme file.', 'vw-travel'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( VW_TRAVEL_CHILD_THEME ); ?>" target="_blank"><?php esc_html_e('About Child Theme', 'vw-travel'); ?></a>
				</div>
		  	</div>

		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-admin-comments"></span><?php esc_html_e('Frequently Asked Questions', 'vw-travel'); ?></h4>
				<p> <?php esc_html_e('We have gathered top most, frequently asked questions and answered them for your easy understanding. We will list down more as we get new challenging queries. Check back often.', 'vw-travel'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( VW_TRAVEL_FAQ ); ?>" target="_blank"><?php esc_html_e('View FAQ','vw-travel'); ?></a>
				</div>
		  	</div>

		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-sos"></span><?php esc_html_e('Support Queries', 'vw-travel'); ?></h4>
				<p> <?php esc_html_e('If you have any queries after purchase, you can contact us. We are eveready to help you out.', 'vw-travel'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( VW_TRAVEL_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Contact Us', 'vw-travel'); ?></a>
				</div>
		  	</div>
		</div>
	</div>
</div>
<?php } ?>