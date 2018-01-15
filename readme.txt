=== Genesis Simple FAQ ===
Contributors: studiopress, calvinkoepke, nathanrice, modernnerd
Tags: genesis, faq
Requires at least: 4.8
Tested up to: 4.8
Stable tag: 0.9.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple plugin to handle FAQ layout and interaction with a shortcode.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

== Usage ==

Adding a FAQ is easy and relies on custom post types to organize and format your FAQs. To add an FAQ, do the following:

1. Go to Genesis Simple FAQ > All FAQs.
2. Enter a question in the Title box (required).
3. Enter an answer into the Content Editor (required).
3. Set a category, if applicable (optional).
4. Click publish.

To find the shortcode for that specific FAQ:

1. Go to Genesis Simple FAQ > All FAQs.
2. The shortcode will be displayed in the table for each FAQ.

When using the shortcode to display your FAQs, you can either display all FAQs by adding the shortcode without any parameters:

`[gs_faq]`

Or you can customize the display of FAQs using the following parameters:

- **id**: The FAQ ID, either singular or a comma-separated list.
- **cat**: The FAQ category ID, either singular or a comma-separated list.
- **limit**: The number of FAQs that should be displayed.

For example, FAQs can be displayed using one or more FAQ post type ID:

`[gs_faq id="12, 24"]`

Or by one or more category ID:

`[gs_faq cat="10, 11"]`

You can also specify how many FAQs will be displayed. For example:

`[gs_faq cat="10, 11" limit="10"]`

By default, the limit is set to the number of posts you've set to display in Settings > Reading.
Enter `-1` to display an infinite number of FAQs.

NOTE: shortcodes should not be entered on consecutive lines, like so:

`
[gs_faq id="X"]
[gs_faq id="X"]

`

Instead, shortcodes should be separated by at least one blank line, like so:

`
[gs_faq id="X"]

[gs_faq id="X"]

`

You can also show FAQs by using the built in widget. Just go to the Appearance > Widgets screen and drag the Genesis Simple FAQ widget to the widget area where you would like it to display. Then, enter a title and select a category to display FAQs from, and click save.

## Filters
Currently, there are three filters: one to toggle JS animation on or off, one to control critical CSS output, and one to control the default FAQ markup.

### JS Animation (jQuery Only)
By default, animation is set to true. This will add a slide animation to showing/hiding the FAQ. To remove JS animation and rely on classes to do your state-changing, add the following to your `functions.php` file:

`add_filter( 'gs_faq_js_animation', '__return_false' );`

### Critical CSS
You can modify the CSS output using the following filter (styles are minified on the front-end):

`
add_filter( 'gs_faq_critical_styles', 'your_custom_function' );
function your_custom_function( $styles ) {

	$styles =
		'.gs-faq {
			padding: 5px 0;
		}

		.gs-faq__question {
			display: block;
			text-align: left;
			width: 100%%;
		}

		.gs-faq__answer {
			display: none;
			padding: 5px;
		}';

	return $styles;

}
`

### Default Markup
The following filter accepts 3 parameters:
- `$template`: Full string of HTML to output.
- `$question`: The title of the FAQ, usually a question.
- `$answer`: The content of the FAQ, usually the answer.

`
add_filter( 'gs_faq_template', 'your_custom_function', 10, 3 );
function your_custom_function( $template, $question, $answer ) {

	$template = sprintf(
		'The question: %s, and the answer: %s.',
		$question,
		$answer
	);

	return $template;

}
`

== Changelog ==

= 0.9.1 =

* Add non-JS support.
* Add CSS opt out filter.
* Add category ID to taxonomy page.
* Set default to show all FAQs.

= 0.9.0 =

* Initial release
