# Genesis Simple FAQ
A simple plugin to handle FAQ layout and interaction with a shortcode.

## Usage
Adding a FAQ is easy, and relies on custom post types to organize and format your FAQs. To add an FAQ, do the following:

1. Navigate in the menu to Genesis Simple FAQs > Add New.
2. Enter a question in the Title box (required).
3. Enter an answer into the Content Editor (required).
3. Set a category, if applicable (optional).
4. Hit publish.

To find the shortcode for that specific FAQ:

1. Navigate to Genesis Simple FAQ > All FAQs.
2. The shortcode will be displayed in the table for each FAQ.

You can show FAQs by one ore more ID:

`[gs_faq id="53,41"]`

Or by one ore more category:

`[gs_faq cat="1,2,3,4"]`

- **id**: The FAQ id, either singular or a comma-separated list.
- **cat**: The FAQ category id, either singular or a comma-separated list.

## Filters
Currently, there are three filters: one to toggle JS animation on or off, one to control critical CSS output, and one to control the default FAQ markup.

### JS Animation (jQuery Only)
By default, animation is set to true. This will add a slide animation to showing/hiding the FAQ. To remove JS animation and rely on classes to do your state-changing, add the following to your `functions.php` file:

`add_filter( 'gs_faq_js_animation', '__return_false' );`

### Critical CSS
You can modify the CSS output using the following filter (styles are minified on the front-end):

```php
add_filter( 'gs_faq_critical_styles', 'your_custom_function' );
function your_custom_function( $styles ) {

	$styles = sprintf(
		'.gs-faq {
			padding: 5px 0;
		}

		.gs-faq__question {
			display: block;
			text-align: left;
			width: 100%;
		}

		.gs-faq__answer {
			display: none;
			padding: 5px;
		}'
	);

	return $styles;

}
```

### Default Markup
The following filter accepts 3 parameters:
- `$template`: Full string of HTML to output.
- `$question`: The title of the FAQ, usually a question.
- `$answer`: The content of the FAQ, usually the answer.
```php
add_filter( 'gs_faq_template', 'your_custom_function', 10, 3 );
function your_custom_function( $template, $question, $answer ) {

	$template = sprintf(
		'The question: %s, and the answer: %s.',
		$question,
		$answer
	);

	return $template;

}
```
