# Genesis Simple FAQ
A simple plugin to handle FAQ layout and interaction with a shortcode.

## Usage
Adding a FAQ is very easy, just use the following syntax:

`[genesis_faq title="Your question goes here?"]
Your answer goes here. It can span multiple paragraphs.
[/genesis_faq]`

## Filters
Currently, there are three filters: one to toggle JS animation on or off, one to control critical CSS output, and one to control the default FAQ markup.

### JS Animation (jQuery Only)
By default, animation is set to true. To remove JS animation and rely on classes, add the following to your `functions.php` file:

```php
add_filter( 'genesis_simple_faq_js_animation', '__return_false' );
```

### Critical CSS
You can modify the CSS output using the following filter (styles are minified on the front-end):

```php
add_filter( 'genesis_simple_faq_print_styles', 'your_custom_function' );
function your_custom_function( $styles ) {

	$styles = sprintf(
		'.genesis-simple-faq {
			padding: 5px 0;
		}

		.genesis-simple-faq__question {
			display: block;
			text-align: left;
			width: 100%%;
		}

		.genesis-simple-faq__answer {
			display: none;
			padding: 5px;
		}'
	);

	return $styles;

}
```

### Default Markup
Alter the markup used for each question and answer with this filter:

```php
add_filter( 'genesis_simple_faq_output', 'prefix_custom_faq_format', 10, 3 );
/**
 * Modify the HTML used in Genesis Simple FAQ questions and answers.
 *
 * @param string $output The HTML to output.
 * @param array  $atts   The attributes from the shortcode.
 * @param string $answer The content of the shortcode; the answer to the question.
 * @return string
 */
function prefix_custom_faq_format( $output, $atts, $answer ) {

	$output = sprintf( '<div class="genesis-simple-faq custom-class">
					<button class="genesis-simple-faq__question" aria-expanded="false">%s</button>
					<div class="genesis-simple-faq__answer">%s</div>
				</div>', esc_html( $atts['title'] ), $answer );

	return $output;

}
```
