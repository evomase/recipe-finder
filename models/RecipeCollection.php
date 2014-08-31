<?php
class RecipeCollection extends ArrayObject {
	
	private static $_instance;
	
	/**
	 * Constructor
	 * 
	 * @param mixed $input
	 * @param number $flags
	 * @param string $iterator_class
	 * @throws RuntimeException
	 */
	public function __construct( $input = array(), $flags = 0, $iterator_class = 'ArrayIterator' )
	{
		if ( !empty( self::$_instance ) )
			throw new RuntimeException( 'Only one instance of RecipeCollection should exist, use RecipeCollection::getInstance() instead' );
		else
			self::$_instance = $this;
		
		parent::__construct( $input, $flags, $iterator_class );
	}
	
	/**
	 * Returns an instance of RecipeCollection
	 * 
	 * @return RecipeCollection
	 */
	public static function getInstance()
	{
		if ( empty( self::$_instance ) )
			self::$_instance = new RecipeCollection();
		
		return self::$_instance;
	}
	
	/**
	 * Adds a recipe to the collection
	 * 
	 * @param Recipe $recipe
	 */
	public function addRecipe( Recipe $recipe )
	{
		$name = $recipe->getName();
		
		if ( $this->offsetExists( $name ) )
			$this->offsetUnset( $name );
		
		$this->offsetSet( $name, $recipe );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ArrayObject::asort()
	 */
	public function asort()
	{
		$this->uasort( function( Recipe $a, Recipe $b ){
			return $a->compareTo( $b );
		});
	}
	
	/**
	 * Returns a single valid recipe 
	 * 
	 * @return null|Recipe
	 */
	public function getValidRecipe()
	{
		if ( !( $this->count() ) )
			return null;
		
		$this->asort();
		
		$recipes = array_filter( $this->getArrayCopy(), function( Recipe $recipe ){
			return $recipe->isValid();
		});
		
		if ( empty( $recipes ) )
			return null;
		
		return current( $recipes );
	}
	
	/**
	 * Import recipes from a JSON file
	 * 
	 * @param string $file
	 * @return boolean
	 */
	public function importFromJSON( $file )
	{
		if ( !is_file( $file ) || !is_readable( $file ) || !( $recipes = file_get_contents( $file ) ) )
			return false;
		
		$recipes = @json_decode( $recipes, true );
		
		if ( empty( $recipes ) )
			return false;
		
		foreach( $recipes as $recipe )
		{
			if ( empty( $recipe[Recipe::FIELD_NAME] ) || empty( $recipe[Recipe::FIELD_INGREDIENTS] ) )
				continue;
			
			new Recipe( $recipe[Recipe::FIELD_NAME], $recipe[Recipe::FIELD_INGREDIENTS] );
		}
		
		return true;
	}
}
?>