# Genesis Simple FAQ
A simple plugin to handle FAQ layout and interaction with a shortcode.

## Usage
Adding a FAQ is very easy, just use the following syntax:

`[genesis_faq title="Question Here."]
Answer paragraph goes here and it can be long.
[/gensis_faq]`

## Filters
Currently, there's three filters: one to toggle JS animation on or off, one to control critical CSS output, and one to control the default FAQ markup.

### JS Animation (jQuery Only)
By default, animation is set to true. To remove JS animation and rely on classes, add the following to your `functions.php` file:

`add_filter( 'genesis_simple_faq_animation', false )`

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
The following filter accepts 3 parameters:
- `$faq`: String of HTML to output.
- `$a`: Array of passed in attributes (default item is `$a['title']`).
- `$content`: The content the shortcode is wrapped around.
```php
add_filter( 'genesis_simple_faq_output', 'your_custom_function' );
function your_custom_function( $faq, $a, $content ) {

	$faq = 'new markup here';

	return $faq;

}
```
