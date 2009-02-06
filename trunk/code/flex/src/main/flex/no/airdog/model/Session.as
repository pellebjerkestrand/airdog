package no.airdog.model
{
	import no.airdog.view.DatOpplastning;
	
	import mx.collections.ArrayCollection;
	
	public class Session
	{        
        [Bindable]
        public var datOpplastning:Opplastning = new Opplastning();
        
        [Bindable]
        public var hundeliste:ArrayCollection = new ArrayCollection();
	}
}