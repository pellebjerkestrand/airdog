package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	public class Session
	{        
        [Bindable]
        public var datOpplastning:Opplastning = new Opplastning();
             
     	[Bindable]
     	public var hundeliste:Hundeliste = new Hundeliste();
        
        [Bindable]
        public var hundprofil:Hund;
        
        [Bindable]
        public var hovedNavigasjon:Navigasjon = new Navigasjon();
        
	}
}