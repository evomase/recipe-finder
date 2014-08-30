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
		$this->offsetSet( $recipe->getName(), $recipe );
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
?>