<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up until id="main-core".
 *
 * @package ThinkUpThemes
 */
?><!DOCTYPE html>

<html <?php language_attributes();?>>
<head>
<?php thinkup_hook_header();?>
<meta charset="<?php bloginfo('charset');?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="//gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/lib/scripts/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head();?>

</head>

<body <?php body_class();?><?php thinkup_bodystyle();?>>
<div id="body-core" class="hfeed site">

	<header id="site-header">

		<?php if (get_header_image()): ?>
			<div class="custom-header"><img src="<?php header_image();?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt=""></div>
		<?php endif; // End header image check. ?>

		<div id="pre-header">
			<div class="wrap-safari">
				<div id="pre-header-core" class="main-navigation">

					<?php if (has_nav_menu('pre_header_menu')): ?>
					<?php wp_nav_menu(array('container_class' => 'header-links', 'container_id' => 'pre-header-links-inner', 'theme_location' => 'pre_header_menu'));?>
					<?php endif;?>

					<?php /* Header Search */thinkup_input_headersearch();?>

					<?php /* Social Media Icons */social_media_buttons()?>

				</div>
			</div>
		</div>
		<!-- #pre-header -->

		<div id="header">
			<div id="header-core">

				<div id="logo">
					<a rel="home" href="<?php echo esc_url(home_url('/')); ?>"><?php /* Custom Logo */thinkup_custom_logo();?></a>
				</div>

			<?php /* Add responsive header menu */thinkup_input_responsivehtml();?>

			</div>
		</div>

		<div id="header" class="nav-background">
			<div id="header-core">
				<div id="header-links" style="float:none;" class="main-navigation">
					<div id="header-links-inner" class="header-links">
						<?php wp_nav_menu(array('container' => false, 'theme_location' => 'header_menu'));?>
					</div>
				</div>
			</div>
		</div>
		<!-- #header -->
		<?php /* Custom Slider */thinkup_input_sliderhome();?>

	</header>


	<!-- header -->


<?php
   if (is_front_page() or thinkup_check_ishome()) {
	   $front_options = get_option('ag_front_page_display_options');
	//    var_dump($front_options);

	$nt_featuring_text = get_theme_mod('ag_front_page_featuring_text');
	$nt_ex_name =  get_theme_mod('nt_exhibit_name');
	$nt_title = get_theme_mod('nt_title');
	$nt_caption = get_theme_mod('nt_caption');
	$nt_img = '"'. get_theme_mod('nt_exhibition_featured_image_upload') . '"';

	$featured_main_event = <<<HTML

   <div class="row align-middle">
	   <div class="col-md-8 border-10">
		   <img id="nt-featured-img" src=$nt_img/>
	   </div>
	   <div class="col-md-4 border border-10">
		   <div>
			   <h1 id="nt-exhibit-name">$nt_ex_name</h1>
			   <h2 id="nt-title"> $nt_title</h2>
			   <p id="nt-caption">$nt_caption</p>
		   </div>
	   </div>
   </div>
HTML;


	$slideshow = '<div class="row"><div class="col-md-12">'. ag_front_page_html() . '</div></div>';
	$ag_front_page_featuring_mas = get_theme_mod('ag_front_page_featuring_mas');
	$ag_front_page_fb = get_theme_mod('ag_front_page_flipbook');

	

	$masters_works = <<<HTML
	<div class="row">
		<div class="col-md-12">
			<h1 id="ag-front-page-featuring-mas">$ag_front_page_featuring_mas</h1>
		</div>   
	</div>
	<div class="row">
		<div class="col-md-12">
			$ag_front_page_fb
		</div>   
	</div>
HTML;

		$nt_html_featuring_text = '	<div class="row">
		<div class="col-md-12">
			<h1 id="ag-front-page-featuring-text">' .$nt_featuring_text .'</h1>
		</div>   
	</div>';

	   echo '<div class="container-fluid">';
	   
	   if($front_options != ""){ //This will choose what to open depending on what they have selected
		   switch($front_options){
			   
			   case 'Featured&Slideshow':
					echo $nt_html_featuring_text . $featured_main_event . $slideshow;
					break;

				case 'Slideshow&Masters':
					echo $nt_html_featuring_text . $slideshow . $masters_works;
					break;

				case 'Masters&Featured':
					echo $featured_main_event . $masters_works;
				break;

				case 'Featured':
					echo $nt_html_featuring_text . $featured_main_event;
				break;

				case 'Slideshow':
					echo $nt_html_featuring_text . $slideshow;
					break;

				case 'Masters':
					echo $masters_works;
					break;
					
				case 'All':
					echo $nt_html_featuring_text . $featured_main_event . $slideshow . $masters_works;
					break;
				default:

		   }
	   }
	   echo '</div>';
	   ?>
	  
		<?php
	}
	?>
	

	<!-- Ending Upcoming Events Section -->

	<?php /*  Call To Action - Intro */thinkup_input_ctaintro();?>
	<!-- <?php /*  Pre-Designed HomePage Content */thinkup_input_homepagesection();?> -->

	<div id="content">
	<div id="content-core">

		<div id="main">
		<div id="main-core">
		<?php /* Custom Intro */thinkup_custom_intro();?>

