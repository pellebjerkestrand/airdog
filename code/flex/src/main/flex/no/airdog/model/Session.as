package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	public class Session
	{        
        [Bindable]
        public var datOpplastning:Opplastning = new Opplastning();
        
        [Bindable]
        public var hundeliste:ArrayCollection;
        
        [Bindable]
        public var hundprofil:Hund;
        
        [Bindable]
        public var navigasjonNr:int = 0;
        
        [Bindable]
        public var navigasjonLaster:Boolean = false;
	}
}