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
}
add_action('wp_enqueue_scripts', 'redirect_manager_scripts_styles');

function enqueue_custom_scripts()
{
	// Register scripts without loading them yet
	wp_register_script('main-script', get_template_directory_uri() . '/src/js/main.js', array(), '1.0', true);

	// Enqueue main script
	wp_enqueue_script('main-script');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Single filter to handle all module scripts
add_filter('script_loader_tag', function ($tag, $handle, $src) {
	// List all module script handles
	$module_scripts = array(
		'main-script'
	);

	// If the script handle is in the list, add type="module"
	if (in_array($handle, $module_scripts)) {
		$tag = '<script type="module" src="' . esc_url($src) . '"></script>';
	}
	return $tag;
}, 10, 3);









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

// FORM ACTIONS
require 'functions/form-handlers/validation/validator.php';
require 'functions/form-handlers/form-submission.php';

// Handle form submissions (adding/edting) for servers 
require 'functions/form-handlers/server-form-submit.php';
add_action('admin_post_server_form', 'handle_server_form_submit');

// Handle form submissions (adding/edting) for websites 
require 'functions/form-handlers/website-form-submit.php';
add_action('admin_post_website_form', 'handle_website_form_submit');

// Handle form submissions (adding/editing) for redirect rules
require 'functions/form-handlers/redirect-rule-form-submit.php';
add_action('admin_post_redirect_rule_form', 'handle_redirect_rule_form_submit');

// Handle disabling any item
require 'functions/form-handlers/disable-item.php';
add_action('admin_post_disable_item', 'handle_disable_item');

// Committing rules to file
require('functions/commit-rules-to-file.php');
require('functions/form-handlers/commit-rules-form-submit.php');
add_action('admin_post_commit_rules_to_file', 'handle_commit_rules_form_submission');

// Committing single rule to file
require('functions/form-handlers/commit-single-rule-form-submit.php');
add_action('admin_post_commit_single_rule', 'handle_commit_single_rule_form_submission');

// Uploading rules to database from csv file
// Collin's parse function here
require('functions/form-handlers/upload-rules-form-submit.php');
add_action('admin_post_upload_rules', 'handle_upload_rules_form_submit');

if (class_exists('Walker_Nav_Menu')) {
	class Icon_Walker_Nav_Menu extends Walker_Nav_Menu
	{
		public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
		{
			// Define icons for specific menu items
			$icons = array(
				'Servers' => '<i class="fa-solid fa-server"></i>',
				'Websites' => '<i class="fa-solid fa-desktop"></i>',
				'Redirect Rules' => '<i class="fa-solid fa-arrows-turn-to-dots"></i>',
				'Redirect Flags' => '<i class="fa-solid fa-flag"></i>'
			);

			// Get icon based on menu item title, or use an empty string if not defined
			$icon = isset($icons[$item->title]) ? $icons[$item->title] : '';

			// Build the list item with the icon and link text
			$output .= sprintf(
				'<li class="%s"><a href="%s">%s %s</a></li>',
				esc_attr(implode(' ', $item->classes)),
				esc_url($item->url),
				$icon,
				esc_html($item->title)
			);
		}
	}
}

// UTILS
require 'functions/utils/get_from_path.php';
require 'functions/utils/get_full_from_url.php';
require 'functions/utils/format_date_to_est.php';

// CSV Parser
require 'functions/csv-parser.php';
