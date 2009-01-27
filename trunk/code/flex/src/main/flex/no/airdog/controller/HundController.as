package no.airdog.controller
{
	import mx.collections.ArrayCollection;
	
	import no.airdog.domain.hund.Hund;
	import no.airdog.facade.AirdogFacade;
	
	[Bindable]
	public class HundController
	{
		public var hunder:ArrayCollection;
		
		public var facade:AirdogFacade;
		
		public function HundController()
		{
			hunder = getDummyHunder();
		}
		
		public function getAlleHunder() : void
		{
			facade.getAlleHunder(onGetAlleHunder);
		}
		
		private function getDummyHunder():ArrayCollection
		{
			var tmpCollection:ArrayCollection = new ArrayCollection();
			
			for (var i:int = 0; i < 10; i++)
			{
				var tempHund:Hund = new Hund();
				tempHund.id = i;
				tempHund.navn = "<NAVN " + i + ">";
				tempHund.tittel = "<TITTEL " + i + ">";
				tempHund.bilde = "Hund1.jpg";
				tempHund.foreldre = "<FORELDRE>";
				tempHund.kjonn = "<KJØNN>";
				tempHund.oppdretter = "<OPPDRETTER>";
				tempHund.eier = "<EIER>";
				tmpCollection.addItem(tempHund);	
			}
			
			return tmpCollection;
		}
		
		private function onGetAlleHunder(arrHunder:ArrayCollection) : void
		{
			hunder = arrHunder;
		}
	}
}