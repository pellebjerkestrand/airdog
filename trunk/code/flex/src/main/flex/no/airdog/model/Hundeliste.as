package no.airdog.model
{
	import mx.collections.ArrayCollection;
	import mx.core.IFactory;
	import mx.core.*;
	
	import no.airdog.view.HundeListeRenderer.NavnRendererStor;
	public class Hundeliste
	{

		[Bindable]
        public var storrelse:int = 60;
        
        [Bindable]
        public var renderer:IFactory = new ClassFactory(no.airdog.view.HundeListeRenderer.NavnRendererStor);
       
		[Bindable]
		public var provider:ArrayCollection;
	}
}