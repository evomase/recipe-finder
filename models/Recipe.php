<?php
/**
 * The recipe class
 * 
 * @author David Ogilo
 */
class Recipe {
	
	private $name;
	private $ingredients;
	private $outOfDate;
	private $items;
	private $minOutOfDate;
	
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
		$this->outOfDate = false;
		$this->minOutOfDate = REQUEST_TIME;
		
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
			if ( !( $item = Fridge::getInstance()->getItem( $ingredient['item'] ) ) )
				continue;
			
			$useBy = $item->getUseBy();
			
			$this->outOfDate = ( $useBy < REQUEST_TIME )? true : false;
			$this->minOutOfDate = ( $useBy <= $this->minOutOfDate )? $useBy : $this->minOutOfDate;
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