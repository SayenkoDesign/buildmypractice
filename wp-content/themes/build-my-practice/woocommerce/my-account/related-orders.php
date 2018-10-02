<?php
/**
 * Related Orders table on the View Subscription page
 *
 * @author   Prospress
 * @category WooCommerce Subscriptions/Templates
 * @version  2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<header>
	<h2><?php esc_html_e( 'Related Orders', 'woocommerce-subscriptions' ); ?></h2>
</header>

<table class="shop_table shop_table_responsive my_account_orders">

	<thead>
		<tr>
			<th class="order-number"><span class="nobr"><?php esc_html_e( 'Order', 'woocommerce-subscriptions' ); ?></span></th>
			<th class="order-date"><span class="nobr"><?php esc_html_e( 'Date', 'woocommerce-subscriptions' ); ?></span></th>
			<th class="order-status"><span class="nobr"><?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?></span></th>
			<th class="order-total"><span class="nobr"><?php echo esc_html_x( 'Total', 'table heading', 'woocommerce-subscriptions' ); ?></span></th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ( $subscription_orders as $subscription_order ) {
			$order      = wc_get_order( $subscription_order );
			$item_count = $order->get_item_count();
			$order_date = wcs_get_datetime_utc_string( wcs_get_objects_property( $order, 'date_created' ) );

			?><tr class="order">
				<td class="order-number" data-title="<?php esc_attr_e( 'Order Number', 'woocommerce-subscriptions' ); ?>">
					<?php echo esc_html( $order->get_order_number() ); ?>
					</a>
				</td>
				<td class="order-date" data-title="<?php esc_attr_e( 'Date', 'woocommerce-subscriptions' ); ?>">
					<time datetime="<?php echo esc_attr( gmdate( 'Y-m-d', wcs_date_to_time( $order_date ) ) ); ?>" title="<?php echo esc_attr( wcs_date_to_time( $order_date ) ); ?>"><?php echo wp_kses_post( date_i18n( get_option( 'date_format' ), wcs_date_to_time( $order_date ) ) ); ?></time>
				</td>
				<td class="order-status" data-title="<?php esc_attr_e( 'Status', 'woocommerce-subscriptions' ); ?>" style="white-space:nowrap;">
					<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
				</td>
				<td class="order-total" data-title="<?php echo esc_attr_x( 'Total', 'Used in data attribute. Escaped', 'woocommerce-subscriptions' ); ?>">
					<?php
					// translators: $1: formatted order total for the order, $2: number of items bought
					echo wp_kses_post( sprintf( _n( '%1$s for %2$d item', '%1$s for %2$d items', $item_count, 'woocommerce-subscriptions' ), $order->get_formatted_order_total(), $item_count ) );
					?>
				</td>
				
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_subscription_details_after_subscription_related_orders_table', $subscription ); ?>
