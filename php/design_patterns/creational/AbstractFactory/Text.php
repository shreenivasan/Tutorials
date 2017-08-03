namespace design_patterns/creatational/AbstractFactory;

Abstract class Text{
	
	private $text;

	public function __construct(string $text){
		$this->text = $text;
	}

}
