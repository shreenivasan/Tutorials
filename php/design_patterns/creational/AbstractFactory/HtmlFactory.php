namespace design_patterns/creational/AbstractFactory;

class HtmlFactory extends AbstractFactory{

	public function createText(string $content):Text{
		
		return new HtmlText($content);
	}
}
