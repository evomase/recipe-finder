<?php
/**
 * The recipe class
 * 
 * @author David Ogilo
 */
class Recipe {
	
	const FIELD_NAME = 'name';
	const FIELD_INGREDIENTS = 'ingredients';
	
	private $name;
	private $ingredients;
	private $outOfDate;
	private $items;
	private $minOutOfDate;
	private $valid;
	
	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @param array $ingredients
	 * @return void
	 */
	public function __construct( $name, Array $ingredients )
	{
		$this->name = $name;
		$this->ingredients = $ingredients;
		$this->minOutOfDate = 0;
		$this->valid = false;
		
		$this->populateItems();
		
		//adds the recipe to the recipe collection
		RecipeCollection::getInstance()->addRecipe( $this );
	}
	
	/**
	 * Retrieves the items from the fridge and populate the items array
	 * 
	 * @return void;
	 */
	private function populateItems()
	{
		if ( empty( $this->ingredients ) )
			return;
		
		foreach( $this->ingredients as $ingredient )
		{
			if ( !( $item = Fridge::getInstance()->getItem( $ingredient[Item::FIELD_NAME] ) ) || $ingredient[Item::FIELD_AMOUNT] > $item->getAmount() )
			{
				$this->valid = false;
				$this->items = array();
				
				break;
			}
		
			$useBy = $item->getUseBy();
			
			$this->valid = ( $useBy >= REQUEST_TIME )?: false;
			$this->minOutOfDate = ( empty( $this->minOutOfDate ) || $useBy <= $this->minOutOfDate )? $useBy : $this->minOutOfDate;
			
			$this->items[$item->getName()] = $item;
		}
	}
	
	/**
	 * Returns the name of the recipe
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Returns the array of items associated to this recipe
	 * 
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}
	
	/**
	 * Checks if this recipe is valid, i.e all items are retrieved and not out of date
	 * 
	 * @return boolean
	 */
	public function isValid()
	{
		return $this->valid;
	}
	
	/**
	 * Compare function (used for sorting)
	 * 
	 * @param Recipe $recipe
	 * @return number
	 */
	public function compareTo( Recipe $recipe )
	{
		if ( $recipe->minOutOfDate == $this->minOutOfDate )
			return 0;
		
		return ( $this->minOutOfDate < $recipe->minOutOfDate )? -1 : 1;
	}
}
?>