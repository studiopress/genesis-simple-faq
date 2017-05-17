<!-- a link based action button -->
<a class="button-primary plugin-boilerplate-ajax-link enabled" data-sample="data"><?php _e( 'Submit', 'plugin-boilerplate' ); ?></a>

<!-- a form based action button -->
<form method="post" action="" name="plugin-boilerplate-ajax-form">
	<input type="submit" value="Begin Import" class="button-primary plugin-boilerplate-ajax-submit" />
</form>
<div class="plugin-boilerplate-ajax-results"></div>
<img src="<?php echo includes_url( 'images/wpspin.gif' ); ?>" class="waiting plugin-boilerplate-ajax-spinner" style="display:none;" />
