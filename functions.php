<?php
require 'plugin-update-checker-5.4/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/collinblank/redirect_management_tool/',
	__FILE__,
	'redirect_management_tool'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

//Optional: If you're using a private repository, specify the access token like this:
// $myUpdateChecker->setAuthentication('your-token-here');
?>

<?php
// Enque custom Javascript functions to header
function redirect_manager_scripts_styles()
{
	wp_enqueue_style('styles', get_stylesheet_directory_uri() . '/src/css/custom-style.css', array(), false, 'screen');
	wp_enqueue_script('scripts', get_template_directory_uri() . '/src/js/custom-scripts.js', array(), false, array('strategy' => 'defer'));
}
add_action('wp_enqueue_scripts', 'redirect_manager_scripts_styles');

// Default functions with blankslate theme below
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
	load_theme_textdomain('blankslate', get_template_directory() . '/languages');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('responsive-embeds');
	add_theme_support('automatic-feed-links');
	add_theme_support('html5', array('search-form', 'navigation-widgets'));
	add_theme_support('woocommerce');
	global $content_width;
	if (!isset($content_width)) {
		$content_width = 1920;
	}
	register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}
add_action('admin_notices', 'blankslate_notice');
function blankslate_notice()
{
	$user_id = get_current_user_id();
	$admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$param = (count($_GET)) ? '&' : '?';
	if (!get_user_meta($user_id, 'blankslate_notice_dismissed_10') && current_user_can('manage_options'))
		echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'blankslate') . '</big></a>' . wp_kses_post(__('<big><strong>🏆 Thank you for using BlankSlate!</strong></big>', 'blankslate')) . '<p>' . esc_html__('Powering over 10k websites! Buy me a sandwich! 🥪', 'blankslate') . '</p><a href="https://github.com/bhadaway/blankslate/issues/57" class="button-primary" target="_blank"><strong>' . esc_html__('How do you use BlankSlate?', 'blankslate') . '</strong></a> <a href="https://opencollective.com/blankslate" class="button-primary" style="background-color:green;border-color:green" target="_blank"><strong>' . esc_html__('Donate', 'blankslate') . '</strong></a> <a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank"><strong>' . esc_html__('Review', 'blankslate') . '</strong></a> <a href="https://github.com/bhadaway/blankslate/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank"><strong>' . esc_html__('Support', 'blankslate') . '</strong></a></p></div>';
}
add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed()
{
	$user_id = get_current_user_id();
	if (isset($_GET['dismiss']))
		add_user_meta($user_id, 'blankslate_notice_dismissed_10', 'true', true);
}
add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue()
{
	wp_enqueue_style('blankslate-style', get_stylesheet_uri());
	wp_enqueue_script('jquery');
}
add_action('wp_footer', 'blankslate_footer');
function blankslate_footer()
{
?>
	<script>
		jQuery(document).ready(function($) {
			var deviceAgent = navigator.userAgent.toLowerCase();
			if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
				$("html").addClass("ios");
				$("html").addClass("mobile");
			}
			if (deviceAgent.match(/(Android)/)) {
				$("html").addClass("android");
				$("html").addClass("mobile");
			}
			if (navigator.userAgent.search("MSIE") >= 0) {
				$("html").addClass("ie");
			} else if (navigator.userAgent.search("Chrome") >= 0) {
				$("html").addClass("chrome");
			} else if (navigator.userAgent.search("Firefox") >= 0) {
				$("html").addClass("firefox");
			} else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
				$("html").addClass("safari");
			} else if (navigator.userAgent.search("Opera") >= 0) {
				$("html").addClass("opera");
			}
		});
	</script>
<?php
}
add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
	$sep = esc_html('|');
	return $sep;
}
add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
	if ($title == '') {
		return esc_html('...');
	} else {
		return wp_kses_post($title);
	}
}
function blankslate_schema_type()
{
	$schema = 'https://schema.org/';
	if (is_single()) {
		$type = "Article";
	} elseif (is_author()) {
		$type = 'ProfilePage';
	} elseif (is_search()) {
		$type = 'SearchResultsPage';
	} else {
		$type = 'WebPage';
	}
	echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}
add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts)
{
	$atts['itemprop'] = 'url';
	return $atts;
}
if (!function_exists('blankslate_wp_body_open')) {
	function blankslate_wp_body_open()
	{
		do_action('wp_body_open');
	}
}
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link()
{
	echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}
add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
	if (!is_admin()) {
		return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
	}
}
add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
	if (!is_admin()) {
		global $post;
		return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
	}
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes)
{
	unset($sizes['medium_large']);
	unset($sizes['1536x1536']);
	unset($sizes['2048x2048']);
	return $sizes;
}
add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
	register_sidebar(array(
		'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
		'id' => 'primary-widget-area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script()
{
	if (get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
function blankslate_custom_pings($comment)
{
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
<?php
}
add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count)
{
	if (!is_admin()) {
		global $id;
		$get_comments = get_comments('status=approve&post_id=' . $id);
		$comments_by_type = separate_comments($get_comments);
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}


// CUSTOM FUNCTIONS BELOW THIS LINE

// require 'validator.php';

// // Submit server form data to database table
// session_start();
// if (isset($_POST['add_server'])) {
// 	$server_name = $_POST['server_name'];
// 	$server_domain = $_POST['server_domain'];

// 	// Validation
// 	$errors = [];

// 	if (!Validator::string($server_name, 4, 50)) {
// 		if (strlen($server_name) == 0) {
// 			$errors['server_name'] = 'Please enter a value for your server name (including 4 to 50 letters and spaces).';
// 		} else {
// 			$errors['server_name'] = $server_name . ' is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
// 		}
// 	}

// 	if (!Validator::string($server_domain, 6, 100) || !Validator::url($server_domain)) {
// 		if (strlen($server_name) == 0) {
// 			$errors['server_domain'] = 'Please enter a value for your server domain.';
// 		} else {
// 			$errors['server_domain'] = $server_domain . ' is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.';
// 		}
// 	}

// 	if (!empty($errors)) {
// 		$_SESSION['form_errors'] = $errors;
// 		unset($_SESSION['form_success']);
// 		return false;
// 	} else {
// 		$table_name = 'servers';
// 		$data = array(
// 			'name' => $server_name,
// 			'domain' => $server_domain,
// 		);
// 		$result = $wpdb->insert($table_name, $data, $format = NULL);

// 		if ($result == 1) {

// 			// Redirect to prevent form resubmission

// 			echo "<script>console.log('Server saved');</script>";
// 			$_SESSION['form_success'] = true;

// 			$new_url = add_query_arg('success', $result, get_permalink());
// 			wp_redirect($new_url, 303);
// 			exit;
// 		} else {
// 			echo "<script>console.log('Unable to save server');</script>";
// 		}
// 		unset($_SESSION['errors']);
// 		return true;
// 	}
// }


require 'functions/form-handlers/validator.php';
session_start();

// if (isset($_POST['add_server'])) {
// 	add_server();
// 	$new_url = add_query_arg('success', $result, get_permalink());
// 	wp_redirect($new_url, 303);
// 	exit;
// }

// function add_server()
if (isset($_POST['add_server'])) {
	unset($_SESSION['form_errors']);
	unset($_SESSION['form_success']);

	$server_name = $_POST['server_name'];
	$server_domain = $_POST['server_domain'];

	// Validation
	$errors = [];

	if (!Validator::string($server_name, 4, 50) || !Validator::letters_and_spaces($server_name)) {
		if (strlen($server_name) == 0) {
			$errors['server_name'] = 'Please enter a value for your server name (including 4 to 50 letters and spaces).';
		} else {
			$errors['server_name'] = $server_name . ' is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
		}
	}

	if (!Validator::string($server_domain, 6, 100) || !Validator::url($server_domain)) {
		if (strlen($server_name) == 0) {
			$errors['server_domain'] = 'Please enter a value for your server domain.';
		} else {
			$errors['server_domain'] = $server_domain . ' is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.';
		}
	}

	if (!empty($errors)) {
		$_SESSION['form_errors'] = $errors;
		$new_url = str_replace("?success=1", "", get_permalink());
		$new_url = add_query_arg('errors', count($errors), $new_url);
		wp_redirect($new_url, 303);
		exit;
		return false;
	} else {
		$table_name = 'servers';
		$data = array(
			'name' => $server_name,
			'domain' => $server_domain,
		);
		$result = $wpdb->insert($table_name, $data, $format = NULL);

		if ($result == 1) {
			// Redirect to prevent form resubmission
			$_SESSION['form_success'] = 'A new server has been successfully created.';
			echo "<script>console.log('Server saved');</script>";

			// attempt redirect!
			$new_url = str_replace("?errors=1", "", get_permalink());
			$new_url = str_replace("?errors=2", "", get_permalink());
			$new_url = add_query_arg('success', $result, $new_url);
			wp_redirect($new_url, 303);
			exit;
			return true;
		} else {
			echo "<script>console.log('Unable to save server');</script>";
		}
	}
}


if (isset($_POST['edit_server'])) {
	$table_name = 'servers';
	$item_id = $_POST['item_id'];
	$data = array(
		'name' => $_POST['server_name'],
		'domain' => $_POST['server_domain'],
	);
	$where = array(
		'id' => $item_id
	);

	$result = $wpdb->update($table_name, $data, $where);

	if ($result == 1) {
		echo "<script>console.log('Server edited');</script>";
		// Redirect to prevent form resubmission
		$new_url = add_query_arg('edited', $item_id, get_permalink());
		wp_redirect($new_url, 303);
		exit;
	} else {
		echo "<script>console.log('Unable to edit server');</script>";
	}
}

if (isset($_POST['disable_server'])) {
	$table_name = 'servers';
	$item_id = $_POST['item_id'];
	$data = array(
		'disabled' => 1
	);
	$where = array(
		'id' => $item_id
	);

	$result = $wpdb->update($table_name, $data, $where);

	if ($result == 1) {
		echo "<script>console.log('Server disabled');</script>";
		// Redirect to prevent form resubmission
		$new_url = add_query_arg('disabled', $item_id, get_permalink());
		wp_redirect($new_url, 303);
		exit;
	} else {
		echo "<script>console.log('Unable to disable server');</script>";
	}
}


// Show private pages in menu builder
add_filter('nav_menu_meta_box_object', 'show_private_pages_menu_selection');
/**
 * Add query argument for selecting pages to add to a menu
 */
function show_private_pages_menu_selection($args)
{
	if ($args->name == 'page') {
		$args->_default_query['post_status'] = array('publish', 'private');
	}
	return $args;
}
