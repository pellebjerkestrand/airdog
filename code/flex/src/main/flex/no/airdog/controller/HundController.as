package no.airdog.controller
{
	import mx.collections.ArrayCollection;
	import mx.utils.ArrayUtil;
	
	public class HundController
	{
		private var hunder:ArrayCollection;
		
		public function get alleHunder():ArrayCollection
		{
			return getDummyHunder();
		}
		
		private function getDummyHunder():ArrayCollection
		{
			var xml:XML = new XML();
			hunder = new ArrayCollection(mx.utils.ArrayUtil.toArray(xml));
			
			/*for (var i:int = 1; i <= 2; i++)
			{
				var tempHund:Hund = new Hund();
				tempHund.id = i;
				hunder.addItem(tempHund);
			}*/			
			
			return hunder;
		}	
	}
}
