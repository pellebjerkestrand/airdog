package no.airdog.model
{
	import flash.net.registerClassAlias;
	import flash.utils.ByteArray;
	
	import mx.collections.ArrayCollection;
	import mx.core.*;
	
	import no.airdog.view.renderer.hundeListeRenderer.NavnRendererStor;
	
	[Bindable]
	public class Session
	{
		public var arrangementer:ArrayCollection = new ArrayCollection();
		public var alleBrukere:ArrayCollection = new ArrayCollection();
        public var alleRettigheter:ArrayCollection = new ArrayCollection();   
		public var arsgjennomsnitt:ArrayCollection = new ArrayCollection();  
        public var avkomListe:ArrayCollection = new ArrayCollection();
        public var backupTabeller:ArrayCollection;
        public var backupKopier:ArrayCollection;
        public var backupFiler:ArrayCollection;
        public var bruker:Bruker = new Bruker();
        public var datOpplastning:Opplastning = new Opplastning();
        public var bildeOpplastning:Opplastning = new Opplastning();
        public var fiktivtStamtre:Hund;
     	public var hovedNavigasjon:Navigasjon = new Navigasjon();
     	public var hundNavigasjon:Navigasjon = new Navigasjon();
		public var hundprofil:Hund;
     	public var cupListe:ArrayCollection;
     	public var hundesokListe:Hundeliste = new Hundeliste(60, new ClassFactory(no.airdog.view.renderer.hundeListeRenderer.NavnRendererStor));
        public var jaktproveListe:ArrayCollection = new ArrayCollection();
        public var jaktproveListeAar:ArrayCollection = new ArrayCollection();
        public var jaktproveSammendrag:Jaktprove = new Jaktprove();
        public var jaktproveSammendragAar:ArrayCollection = new ArrayCollection();
        public var nyheter:ArrayCollection;
        public var provestatistikk:ArrayCollection = new ArrayCollection();
        public var rollersRettigheter:ArrayCollection = new ArrayCollection();
        public var rollersBrukere:ArrayCollection = new ArrayCollection();
        public var stamtre:Hund;
        public var utstillingListe:ArrayCollection = new ArrayCollection();
        public var aarbokHund:Hund;
        public var tomtSok:Boolean;
        
        public function Session()
        {
        	registerClassAlias("no.airdog.model.Session", Session);
			registerClassAlias("no.airdog.model.Hundeliste", Hundeliste);
			registerClassAlias("no.airdog.model.Navigasjon", Navigasjon);
			
			registerClassAlias("mx.collections.ArrayCollection", ArrayCollection);
			registerClassAlias("mx.core.int", int);
        }
        
        public function clone():Session
		{	
		    var myBA:ByteArray = new ByteArray();
		    myBA.writeObject(this);
		    myBA.position = 0;
		    return myBA.readObject() as Session;
		}
	}
}