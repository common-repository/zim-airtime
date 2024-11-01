<?php
/**
 * Provide a landing page for when an airtime query is received from techzim.co.zw/airtime-queries
 *
 * This file is used to markup the landing page that is seen by customer after filling an airtime query form.
 *
 * @link       https://www.techzim.co.zw
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/public/partials
 */

get_header();
?>
<style type="text/css">
.site-title,
.site-description {
	position: absolute;
	clip: rect(1px, 1px, 1px, 1px);
}
</style>
<div id="content" class="site-content container">
	<div class="content-inside">
		<div id="primary" class="content-area">
<?php
$entry_id = ( isset( $_REQUEST['techzim_airtime_query_id'] ) && ! empty( $_REQUEST['techzim_airtime_query_id'] ) ) ? sanitize_key( $_REQUEST['techzim_airtime_query_id'] ) : '';

if ( empty( $entry_id ) ) {
	?>
			<h1>Looks like we can't find what you're looking for.</h1>
		</div>
	</div>
</div>
<?php
get_footer();
exit;
}
?>
		<h3>Thank you!<br><br>Your Techzim Airtime Query ID is <?php echo $entry_id; ?></h3>
		<p>We will attend to your query as soon as possible.</p>
		</div>
	</div>
</div>

<?php

get_footer();
