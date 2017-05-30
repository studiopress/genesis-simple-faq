# Genesis Simple FAQ
A simple plugin to handle FAQ layout and interaction with a shortcode.

## Usage
Adding a FAQ is very easy, just use the following syntax:

`[genesis_faq question="Question Here." answer="Answer paragraph goes here and it can be long."]`

## Filters
Currently, there's just one filter to toggle JS animation on or off. By default, it is on. To remove JS animation and rely on classes, add the following to your `functions.php` file:

`add_filter( 'genesis_simple_faq_animation', false )`
