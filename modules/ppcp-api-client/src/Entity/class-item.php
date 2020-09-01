<?php
/**
 * The item object.
 *
 * @package Inpsyde\PayPalCommerce\ApiClient\Entity
 */

declare(strict_types=1);

namespace Inpsyde\PayPalCommerce\ApiClient\Entity;

/**
 * Class Item
 */
class Item {


	public const PHYSICAL_GOODS = 'PHYSICAL_GOODS';
	public const DIGITAL_GOODS  = 'DIGITAL_GOODS';

	/**
	 * The name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The unit amount.
	 *
	 * @var Money
	 */
	private $unit_amount;

	/**
	 * The quantity.
	 *
	 * @var int
	 */
	private $quantity;

	/**
	 * The description.
	 *
	 * @var string
	 */
	private $description;

	/**
	 * The tax.
	 *
	 * @var Money|null
	 */
	private $tax;

	/**
	 * The SKU.
	 *
	 * @var string
	 */
	private $sku;

	/**
	 * The category.
	 *
	 * @var string
	 */
	private $category;

	/**
	 * Item constructor.
	 *
	 * @param string     $name The name.
	 * @param Money      $unit_amount The unit amount.
	 * @param int        $quantity The quantity.
	 * @param string     $description The description.
	 * @param Money|null $tax The tax.
	 * @param string     $sku The SKU.
	 * @param string     $category The category.
	 */
	public function __construct(
		string $name,
		Money $unit_amount,
		int $quantity,
		string $description = '',
		Money $tax = null,
		string $sku = '',
		string $category = 'PHYSICAL_GOODS'
	) {

		$this->name        = $name;
		$this->unit_amount = $unit_amount;
		$this->quantity    = $quantity;
		$this->description = $description;
		$this->tax         = $tax;
		$this->sku         = $sku;
		$this->category    = ( self::DIGITAL_GOODS === $category ) ?
			self::DIGITAL_GOODS : self::PHYSICAL_GOODS;
	}

	/**
	 * Returns the name of the item.
	 *
	 * @return string
	 */
	public function name(): string {
		return $this->name;
	}

	/**
	 * Returns the unit amount.
	 *
	 * @return Money
	 */
	public function unit_amount(): Money {
		return $this->unit_amount;
	}

	/**
	 * Returns the quantity.
	 *
	 * @return int
	 */
	public function quantity(): int {
		return $this->quantity;
	}

	/**
	 * Returns the description.
	 *
	 * @return string
	 */
	public function description(): string {
		return $this->description;
	}

	/**
	 * Returns the tax.
	 *
	 * @return Money|null
	 */
	public function tax(): ?Money {
		return $this->tax;
	}

	/**
	 * Returns the SKU.
	 *
	 * @return string
	 */
	public function sku(): string {
		return $this->sku;
	}

	/**
	 * Returns the category.
	 *
	 * @return string
	 */
	public function category(): string {
		return $this->category;
	}

	/**
	 * Returns the object as array.
	 *
	 * @return array
	 */
	public function to_array(): array {
		$item = array(
			'name'        => $this->name(),
			'unit_amount' => $this->unit_amount()->to_array(),
			'quantity'    => $this->quantity(),
			'description' => $this->description(),
			'sku'         => $this->sku(),
			'category'    => $this->category(),
		);

		if ( $this->tax() ) {
			$item['tax'] = $this->tax()->to_array();
		}

		return $item;
	}
}