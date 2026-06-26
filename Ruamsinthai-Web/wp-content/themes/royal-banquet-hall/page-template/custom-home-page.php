<?php
/**
 * Template Name: Custom Home
 */
get_header(); ?>

<main id="skip-content" role="main">

	<?php do_action( 'luzuk_royal_banquet_hall_above_slider' ); ?>

	<?php if( get_theme_mod('luzuk_royal_banquet_hall_slider_hide_show') != ''){ ?>
	<section id="slider">	  
		<div class="slider-overlay"></div>
		<div class="container">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			    <?php $luzuk_royal_banquet_hall_slider_pages = array();
			    for ( $count = 1; $count <= 4; $count++ ) {
			        $mod = intval( get_theme_mod( 'luzuk_royal_banquet_hall_slider'. $count ));
			        if ( 'page-none-selected' != $mod ) {
			          $luzuk_royal_banquet_hall_slider_pages[] = $mod;
			        }
			    }
		      	if( !empty($luzuk_royal_banquet_hall_slider_pages) ) :
			        $args = array(
			          	'post_type' => 'page',
			          	'post__in' => $luzuk_royal_banquet_hall_slider_pages,
			          	'orderby' => 'post__in'
			        );
		        	$query = new WP_Query( $args );
		        if ( $query->have_posts() ) :
		          	$i = 1;
		    	?>   
		    	 <div class="carousel-inner" role="listbox">
				    <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
			        <div <?php if($i == 1){echo 'class="carousel-item fade-in-image active"';} else{ echo 'class="carousel-item fade-in-image"';}?>>
						<div class="row mr-0">				
							<div class="content">
								<h2> <?php the_title(); ?> </h2>
								<?php 
									$luzuk_royal_banquet_hall_slider_excerpt_length = get_theme_mod('luzuk_royal_banquet_hall_slider_excerpt_length','15');
								
									if( $luzuk_royal_banquet_hall_slider_excerpt_length != ''){?>
									<p ><?php $luzuk_royal_banquet_hall_excerpt = get_the_excerpt(); echo esc_html( luzuk_royal_banquet_hall_string_limit_words( $luzuk_royal_banquet_hall_excerpt, esc_attr(get_theme_mod('luzuk_royal_banquet_hall_slider_excerpt_length','15') ) )); ?></p>
								<?php } ?>
								<div class="sbtn" >				
									<a href="<?php echo esc_url(get_theme_mod('luzuk_royal_banquet_hall_sliderbtnlink', '#')); ?>">
											
										<?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_sliderbtntext', 'Book a Hall')); ?>
										<span>	
											<i class="fa-solid fa-arrow-right"></i>
										</span>
									</a>
								</div>
							</div>
						
							<div class="slideimg">
								<!-- <img src="<//?php echo esc_url(get_template_directory_uri() . '/assets/images/slider1.jpeg'); ?>" alt="Default Image" /> -->
								<?php
									if (has_post_thumbnail()) {
										// If post has thumbnail, display it
										?>
										<img src="<?php echo esc_url(the_post_thumbnail_url('full')); ?>" alt="</?php the_title_attribute(); ?> "/>
										<?php
									} else {
										// If post does not have thumbnail, display default image
										?>
										<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/slider1.jpeg'); ?>" alt="Default Image" />
										<?php
									}

								?>
								<div class="">
									<div class="imgbrd">
										<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/sliderimgbrd.png'); ?>" alt="Default Image" />
									</div>
								</div>
							</div>
						</div>
			        </div>
				      <?php $i++; endwhile; 
				      	wp_reset_postdata();?>
			    <?php else : ?>

			    </div>
			    <div class="no-postfound"></div>
	      		<?php endif;
			    endif;?>
				<div class="slidebtn">
				    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
							
						<span class="carousel-control-prev-icon" aria-hidden="true">
						  <i class="fa fa-angle-double-left"></i>
				      	</span>
				      	<span class="screen-reader-text"><?php esc_html_e( 'Prev','royal-banquet-hall' );?></span>
				    </a>
				    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						
						<span class="carousel-control-next-icon" aria-hidden="true">
						  <i class="fa fa-angle-double-right" ></i>
				      	</span>
				      	<span class="screen-reader-text"><?php esc_html_e( 'Next','royal-banquet-hall' );?></span>
				    </a>
				</div>
		  		<div class="clearfix"></div>
			</div> 
		</div>
	</section>
	<?php }?>
	
	<?php do_action('luzuk_royal_banquet_hall_below_slider'); ?>

	<section id="aboutus-section">
		<div class="container">
			<div class="row mr-0">
				<div class="leftside">
					<div class="sub-imginn">
						<?php 
							$luzuk_royal_banquet_hall_aboutus_img2 = get_theme_mod('luzuk_royal_banquet_hall_aboutus_img2');

							if(!empty($luzuk_royal_banquet_hall_aboutus_img2)){
								echo '<img alt="'. esc_html(get_the_title()) .'" src="'.esc_url($luzuk_royal_banquet_hall_aboutus_img2).'" class="img-responsive secondry-bg-img" />';
							}else{
								echo '<img alt="luzuk_royal_banquet_hall_aboutus_img2" src="'.get_template_directory_uri().'/assets/images/abthead.png" class="img-responsive" />';
							}
						?>
					</div>
					<div class="middlebx">
					<?php 
						$luzuk_royal_banquet_hall_aboutus_img1 = get_theme_mod('luzuk_royal_banquet_hall_aboutus_img1');

						if(!empty($luzuk_royal_banquet_hall_aboutus_img1)){
							echo '<img alt="'. esc_html(get_the_title()) .'" src="'.esc_url($luzuk_royal_banquet_hall_aboutus_img1).'" class="img-responsive secondry-bg-img" />';
						}else{
							echo '<img alt="luzuk_royal_banquet_hall_aboutus_img1" src="'.get_template_directory_uri().'/assets/images/abt1.png" class="img-responsive" />';
						}
					?>
					</div>
					<div class="btimgbx">
						<div class="row mr-0">
							<div class="flweimg">
								<?php 
									echo '<img alt="luzuk_royal_banquet_hall_aboutus_image3" src="'.get_template_directory_uri().'/assets/images/abt3.png" class="img-responsive" />';
								?>
							</div>
							<div class="sub-imgbtm">
								<?php 
									$luzuk_royal_banquet_hall_aboutus_img3 = get_theme_mod('luzuk_royal_banquet_hall_aboutus_img3');

									if(!empty($luzuk_royal_banquet_hall_aboutus_img3)){
										echo '<img alt="'. esc_html(get_the_title()) .'" src="'.esc_url($luzuk_royal_banquet_hall_aboutus_img3).'" class="img-responsive secondry-bg-img" />';
									}else{
										echo '<img alt="luzuk_royal_banquet_hall_aboutus_img3" src="'.get_template_directory_uri().'/assets/images/abt2.png" class="img-responsive" />';
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="rightside">
				
						<div class="sub-title">
							<h6><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutusheading', 'Know About US')); ?></h6>
						</div>

						<div class="title">
							<h4><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutustitle', 'Lorem Ipsum Are Many Variations Available Bat Believable.')); ?></h4>
						</div>

						<div class="description">
							<p><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutusdescription', "There are many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form, words which don't look believable.")); ?></p>
						</div>
						<div class="row mr-0">
							<div class="box box1">
								<div class="row mr-0">
									<div class="icnbx">
										<i class="fa fa-star" aria-hidden="true"></i>
									</div>
									<div class="conbx">
										<h5><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutusbox1heading', 'Unsurpassed atmosphere')); ?></h5>
										<p><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutusbox1description', 'Lorem Ipsum are many variations available bat believable.')); ?></p>
									</div>
								</div>
							</div>
							<div class="box box2">
								<div class="row mr-0">
									<div class="icnbx">
										<i class="fa fa-user" aria-hidden="true"></i>
									</div>
									<div class="conbx">
										<h5><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutusbox2heading', 'Wedding coordination')); ?></h5>
										<p><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutusbox2description', 'Lorem Ipsum are many variations available bat believable.')); ?></p>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"> </div>
						<div class="sign">
							<div class="row mr-0">
								<div class="s-img">
								<?php 
									$luzuk_royal_banquet_hall_aboutus_signimg = get_theme_mod('luzuk_royal_banquet_hall_aboutus_signimg');

									if(!empty($luzuk_royal_banquet_hall_aboutus_signimg)){
										echo '<img alt="'. esc_html(get_the_title()) .'" src="'.esc_url($luzuk_royal_banquet_hall_aboutus_signimg).'" class="img-responsive secondry-bg-img" />';
									}else{
										echo '<img alt="luzuk_royal_banquet_hall_aboutus_signimg" src="'.get_template_directory_uri().'/assets/images/abt4.png" class="img-responsive" />';
									}
								?>		
								</div>
								<div class="s-conbx">					
									<h3><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutussignheading', 'David Anderson')); ?></h3>
									<p><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_aboutussigndescription', 'Lorem Ipsum is simply')); ?></p>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php do_action('luzuk_royal_banquet_hall_below_aboutus_section'); ?>

	<section id="services-section">
		<div class="container"> 
			<div class="headbx">		
				<h4 class="subheading"><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_servicessubheading')); ?></h4>
				<h2 class="heading"><?php echo esc_html(get_theme_mod('luzuk_royal_banquet_hall_servicesheading')); ?></h2>				
			</div>
		</div>
		<div class="container">
			<div class="content">
				<div class="row mr-0">
					<?php
					// Check if any page is selected from customizer
					$pages_selected = false;
					for ($i = 1; $i <= 6; $i++) {
						$selected_page_id = get_theme_mod('luzuk_royal_banquet_hall_page_setting_' . $i);
						if ($selected_page_id) {
							$pages_selected = true;
							break;
						}
					}

					// Display pages in slider if selected, otherwise show a message
					if ($pages_selected) {
						// Loop through each selected page and display in the slider
						for ($i = 1; $i <= 7; $i++) {
							$selected_page_id = get_theme_mod('luzuk_royal_banquet_hall_page_setting_' . $i);
							if ($selected_page_id) {
								$page = get_post($selected_page_id);
								?>
								<!-- <div class="item"> -->
								<div class="mainserbx">
									<div class="serbx">
										<div class="serimgbx">
											<a href="<?php echo get_permalink($page->ID); ?>">
												<?php echo get_the_post_thumbnail($page->ID, 'medium'); ?>
											</a>
										
											<div class="serbxinn">		
												<a href="<?php echo get_permalink($page->ID); ?>">
													<h4><?php echo $page->post_title; ?></h4>
												</a>
												<p><?php echo get_the_excerpt($page->ID); ?></p>
												<div class="ser-btn">							
													<a href="<?php echo get_permalink($page->ID); ?>">
														<?php _e('Learn More', 'royal-banquet-hall'); ?>
													</a>			
												</div>	
											</div>
										</div>
									</div>
								</div>

							<?php }
						}
					} else {
						// Display message if no pages are selected
						echo '<p>Please select pages from the customizer</p>';
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<?php do_action('luzuk_royal_banquet_hall_below_services_section'); ?>

	<div class="container">
	  	<?php while ( have_posts() ) : the_post(); ?>
	  		<div class="lz-content">
	        	<?php the_content(); ?>
	        </div>
	    <?php endwhile; // end of the loop. ?>
	</div>
</main>

<?php get_footer(); ?>