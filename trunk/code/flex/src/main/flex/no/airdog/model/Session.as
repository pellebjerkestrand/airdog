package no.airdog.model
{
	import mx.collections.ArrayCollection;
	import mx.core.*;
	
	import no.airdog.view.HundeListeRenderer.NavnRendererStor;
	
	public class Session
	{        
        [Bindable]
        public var datOpplastning:Opplastning = new Opplastning();
             
     	[Bindable]
     	public var hundesokListe:Hundeliste = new Hundeliste(60, new ClassFactory(no.airdog.view.HundeListeRenderer.NavnRendererStor));
        
        [Bindable]
        public var hundprofil:Hund;
        
        [Bindable]
        public var avkomListe:ArrayCollection = new ArrayCollection();
        
        [Bindable]
        public var jaktproveListe:ArrayCollection = new ArrayCollection();
        
        [Bindable]
        public var hovedNavigasjon:Navigasjon = new Navigasjon();
        
        [Bindable]
        public var bruker:Bruker = new Bruker();  
        
        [Bindable]
        public var rettigheter:ArrayCollection = new ArrayCollection();     
	}
}