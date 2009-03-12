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

        public var rendererHoyde:int;
        public var renderer:IFactory;
		public var provider:ArrayCollection;
	}
}