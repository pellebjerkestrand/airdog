package no.airdog.model
{
	import mx.collections.ArrayCollection;
	import mx.core.*;
	public class Hundeliste
	{
		
		public function Hundeliste(hoyde:int, itemRenderer:IFactory)
		{
			rendererHoyde = hoyde;
			renderer = itemRenderer;
		}

		[Bindable]
        public var rendererHoyde:int;
        
        [Bindable]
        public var renderer:IFactory;
       
		[Bindable]
		public var provider:ArrayCollection;
	}
}