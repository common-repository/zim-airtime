<?php
/**
 * Provide a landing page for when an airtime order is received
 *
 * This file is used to markup the landing page that is seen by a customer after buying airtime.
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
$order_id = ( isset( $_REQUEST['techzim_airtime_diaspora_order_id'] ) && ! empty( $_REQUEST['techzim_airtime_diaspora_order_id'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['techzim_airtime_diaspora_order_id'] ) ) : '';

if ( empty( $order_id ) ) {
	?>
			<h1>Looks like we can't find what you're looking for.</h1>
		</div>
	</div>
</div>
	<?php
	get_footer();
	exit;
}

$paypal_payment_id = ( isset( $_REQUEST['token'] ) && ! empty( $_REQUEST['token'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['token'] ) ) : '';

error_reporting(0);

?>
		<h3>Your Techzim Order ID is <?php echo esc_html( $order_id ); ?></h3>
		<p>Looks like the order has been cancelled. You can still pay for it by clicking <a href="https://www.paypal.com/checkoutnow?token=<?php echo esc_attr( $paypal_payment_id ); ?>">here</a></p>
		<p>For any queries and support, click the chat icon on <a href="<?php echo site_url() ?>/airtime">this page</a></p>
		</div>
	</div>
</div>

<?php

get_footer();
