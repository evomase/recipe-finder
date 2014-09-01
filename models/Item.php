<?php
/**
 * The class for an item, used for Fridge and Recipe
 * 
 * @author David Ogilo
 */
class Item {
	const FIELD_NAME = 'item';
	const FIELD_AMOUNT = 'amount';
	const FIELD_UNIT = 'unit';
	const FIELD_USE_BY = 'use_by';
	
	const UNIT_SLICES = 'slices';
	const UNIT_GRAMS = 'grams';
	const UNIT_MILLILITERS = 'milliliters';
	const UNIT_OF = 'of';
	
	private $name;
	private $amount;
	private $unit;
	private $useBy;
	
	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @param int $amount
	 * @param string $unit
	 * @param int $useBy
	 * 
	 * @return void
	 */
	public function __construct( $name, $amount, $unit, $useBy )
	{
		$this->name = $name;
		$this->amount = $amount;
		$this->unit = $unit;
		$this->useBy = $useBy;
		
		//adds the item to the fridge
		Fridge::getInstance()->addItem( $this );
	}
	
	/**
	 * Returns the name of the item
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Returns the "use by" timestamp
	 * 
	 * @return int
	 */
	public function getUseBy()
	{
		return $this->useBy;
	}
	
	/**
	 * Returns the amount of the item
	 * 
	 * @return int
	 */
	public function getAmount()
	{
		return $this->amount;
	}
}
?>