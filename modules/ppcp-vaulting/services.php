<?php
/**
 * The vaulting module services.
 *
 * @package WooCommerce\PayPalCommerce\Vaulting
 */

declare(strict_types=1);

namespace WooCommerce\PayPalCommerce\Vaulting;

use WooCommerce\PayPalCommerce\Vendor\Psr\Container\ContainerInterface;
use WooCommerce\PayPalCommerce\Vaulting\Assets\MyAccountPaymentsAssets;
use WooCommerce\PayPalCommerce\Vaulting\Endpoint\DeletePaymentTokenEndpoint;

return array(
	'vaulting.module-url'                 => static function ( ContainerInterface $container ): string {
		return plugins_url(
			'/modules/ppcp-vaulting/',
			dirname( realpath( __FILE__ ), 3 ) . '/woocommerce-paypal-payments.php'
		);
	},
	'vaulting.repository.payment-token'   => static function ( ContainerInterface $container ): PaymentTokenRepository {
		$factory  = $container->get( 'api.factory.payment-token' );
		$endpoint = $container->get( 'api.endpoint.payment-token' );
		return new PaymentTokenRepository( $factory, $endpoint );
	},
	'vaulting.customer-approval-listener' => function( ContainerInterface $container ) : CustomerApprovalListener {
		return new CustomerApprovalListener(
			$container->get( 'api.endpoint.payment-token' ),
			$container->get( 'woocommerce.logger.woocommerce' )
		);
	},
	'vaulting.credit-card-handler'        => function( ContainerInterface $container ): VaultedCreditCardHandler {
		return new VaultedCreditCardHandler(
			$container->get( 'subscription.helper' ),
			$container->get( 'vaulting.repository.payment-token' ),
			$container->get( 'api.factory.purchase-unit' ),
			$container->get( 'api.factory.payer' ),
			$container->get( 'api.factory.shipping-preference' ),
			$container->get( 'api.endpoint.order' ),
			$container->get( 'onboarding.environment' ),
			$container->get( 'wcgateway.processor.authorized-payments' ),
			$container->get( 'wcgateway.settings' )
		);
	},
	'vaulting.payment-token-paypal'       => function( ContainerInterface $container ): PaymentTokenPayPal {
		return new PaymentTokenPayPal();
	},
	'vaulting.payment-tokens-migration'   => function( ContainerInterface $container ): PaymentTokensMigration {
		return new PaymentTokensMigration(
			$container->get( 'vaulting.payment-token-paypal' )
		);
	},
);
