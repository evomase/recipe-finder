<?php
/**
 * The class for an item, used for Fridge and Recipe
 * 
 * @author David Ogilo
 */
class Item {
	
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
}
?>