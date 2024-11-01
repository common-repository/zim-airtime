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

error_reporting(0);

$settings = get_option( $this->techzim_airtime . '-settings' );
$vendor_name = isset( $settings['vendor_name'] ) && ! empty( $settings['vendor_name'] ) ? $settings['vendor_name'] : 'Techzim';
$use_netone_pinless = get_option( $this->techzim_airtime . '-use-netone-pinless' );
?>
		<h3>Thank you!<br><br>Your Techzim Order ID is <?php echo esc_html( $order_id ); ?></h3>
		<?php $pinless_recharge = ( isset( $_REQUEST['pinless'] ) && ! empty( $_REQUEST['pinless'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['pinless'] ) ) : '';
		if ($pinless_recharge == 'false') {
			try {
				$url = 'https://europe-west2-techzim-airtime-system.cloudfunctions.net/get_netone_pinful_recharge_vouchers';
				$transaction_source_url = home_url();

				if(strpos($transaction_source_url, 'localhost') || strpos($transaction_source_url, 'testing.techzim')){
					$url = 'https://europe-west2-test-techzim-airtime-system.cloudfunctions.net/get_netone_pinful_recharge_vouchers';
					$transaction_source_url = 'https://testing.techzim.market';
				}

				$data = array (
					"transaction_source_url" => $transaction_source_url,
					"order_id" => $order_id
				);
				
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$order_data = curl_exec($curl);
				curl_close($curl);
				$order_data = (array) json_decode($order_data);
			
			
				$order_details = (array) $order_data['order_data'];
			} catch(Exception $e) {
				error_log("Failed to get order ".$order_id." to check voucher details ".$e->getMessage(), 0);
			}
			$status = $order_data['status'];
			$recharge_vouchers = (array) $order_data['recharge_vouchers'];
			if ($status == 'completed') {
				?>
				<p>
					Due to NetOne challenges, we can't recharge your number directly. Here are recharge PINs for you to manually recharge by dialing *133*RechargePIN# :<br>
					<ul>
						<?php foreach($recharge_vouchers as $rv) { ?>
							<li>$<?php echo $rv->value; ?> - <?php echo $rv->voucher; ?></li>
						<?php } ?>
					</ul>
				</p>
			<?php } else { ?>
				<p> Due to NetOne challenges, we can't recharge your number directly. We are getting your recharge PINs ready. Please wait a second and then click 'Refresh' to load your PINs<br>
					<a href="<?php echo home_url().'/airtime-order-received/?techzim_airtime_diaspora_order_id='.$order_id.'&pinless=false'; ?>">
						<button class="tz-a-tw-btn-orange" type="button">
							Refresh
						</button>
					</a>
				</p>
			<?php } ?>
		
		<?php }
		if ($pinless_recharge != $use_netone_pinless ) {
			update_option( 'techzim-airtime-use-netone-pinless', $pinless_recharge, null );
		} ?>
		<p>For any queries and support, click the chat icon on <a href="<?php echo site_url() ?>/airtime">this page</a></p>
		</div>
	</div>
</div>

<?php

get_footer();
