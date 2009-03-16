package no.airdog.model
{
	import flash.net.registerClassAlias;
	import flash.utils.ByteArray;
	
	import mx.collections.ArrayCollection;
	import mx.core.*;
	
	import no.airdog.view.HundeListeRenderer.NavnRendererStor;
	
	[Bindable]
	public class Session
	{     
        public var datOpplastning:Opplastning = new Opplastning();
             
     	public var hundesokListe:Hundeliste = new Hundeliste(60, new ClassFactory(no.airdog.view.HundeListeRenderer.NavnRendererStor));
        
        public var hundprofil:Hund;
        
        public var avkomListe:ArrayCollection = new ArrayCollection();
        
        public var jaktproveListe:ArrayCollection = new ArrayCollection();
        
        public var jaktproveSammendrag:ArrayCollection = new ArrayCollection();
        
        public var utstillingListe:ArrayCollection = new ArrayCollection();
        
        public var hovedNavigasjon:Navigasjon = new Navigasjon();
        
        public var bruker:Bruker = new Bruker(); 
        
        public var stamtre:Hund;
        
        public var fiktivtStamtre:Hund;
        
        public var arsgjennomsnitt:ArrayCollection = new ArrayCollection();
        
        public var jaktprove:Jaktprove;

        public var alleRoller:ArrayCollection = new ArrayCollection();
        
        public var alleRettigheter:ArrayCollection = new ArrayCollection();
        
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