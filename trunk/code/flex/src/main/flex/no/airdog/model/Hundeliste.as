package no.airdog.model
{
	import mx.collections.ArrayCollection;
	import mx.core.*;
	import flash.net.registerClassAlias;
	
	[Bindable]
	public class Hundeliste
	{
		
		public function Hundeliste(hoyde:int=30, itemRenderer:IFactory=null)
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