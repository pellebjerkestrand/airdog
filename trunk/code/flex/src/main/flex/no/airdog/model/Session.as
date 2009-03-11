package no.airdog.model
{
	import flash.net.registerClassAlias;
	import flash.utils.ByteArray;
	
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
        public var stamtre:Hund;
        
        [Bindable]
        public var arsgjennomsnitt:ArrayCollection = new ArrayCollection();
        
        [Bindable]
        public var jaktprove:Jaktprove;

		[Bindable]
        public var alleRoller:ArrayCollection = new ArrayCollection();
        
        [Bindable]
        public var alleRettigheter:ArrayCollection = new ArrayCollection();
        
        [Bindable]
        public var rollersRettigheter:ArrayCollection = new ArrayCollection();
        
        public function clone():Session
		{
			registerClassAlias("no.airdog.model.Session", Session);
			registerClassAlias("no.airdog.model.Hundeliste", Hundeliste);
			registerClassAlias("no.airdog.model.Navigasjon", Navigasjon);
			
			registerClassAlias("mx.collections.ArrayCollection", ArrayCollection);
			registerClassAlias("mx.core.int", int);
			
		    var myBA:ByteArray = new ByteArray();
		    myBA.writeObject(this);
		    myBA.position = 0;
		    return myBA.readObject() as Session;
		}
	}
}