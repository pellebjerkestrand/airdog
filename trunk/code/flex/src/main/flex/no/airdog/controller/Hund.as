package no.airdog.controller
{
	import mx.collections.ArrayCollection;	
	import no.airdog.domain.hund.Hund;
	
	public function getAlleHunder():ArrayCollection
	{
		return getDummyHunder();
	}
	
	private function getDummyHunder():ArrayCollection
	{
		var hunder:ArrayCollection = new ArrayCollection();
		
		for (int i; i > 10; i++)
		{
			var tempHund:Hund = new Hund();
			tempHund.id = i;
			hunder.addItem(tempHund);
		}
		
		return hunder;
	}
}
