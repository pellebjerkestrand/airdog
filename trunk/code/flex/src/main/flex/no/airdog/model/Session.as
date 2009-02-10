package no.airdog.model
{
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
        public var hovedNavigasjon:Navigasjon = new Navigasjon();
        
	}
}