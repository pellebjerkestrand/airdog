package no.airdog.controller
{
	import flash.errors.IllegalOperationError;
	import flash.events.*;
	import flash.net.*;
	
	import mx.controls.*;
	
	import no.airdog.model.Opplastning;
	import no.airdog.services.Components;
    
    /**
    * Controller for filopplasteren
    */
	public class Filopplaster
	{
		private var adresse:String;
        private var fr:FileReference;
        private var pBar:ProgressBar;
		private var bildeTyper:FileFilter;
		private var tekstTyper:FileFilter;
		private var alleTyper:Array;
		private var maksfilStorrelse:Number;	
		private var uploadtekst:TextArea; 
		private var opplastning:Opplastning;
		
		/**
		 * Kontruktør som mottar
		 * @param urlAdresse - Adresse til filopplaster servicen på server
		 */
		public function Filopplaster(urlAdresse:String)
		{
			adresse = urlAdresse;
			
			opplastning = Components.instance.session.datOpplastning;
			opplastning.ferdig = false;
			opplastning.startet = false;
			opplastning.resultat = "";
			
			settFilrestriksjoner();
			fr = new FileReference();
            lagEventListerner();
		}
		
		/**
		 * Setter restriksjoner for filtyper og størrelse på filen
		 */
		private function settFilrestriksjoner():void
        {
        	bildeTyper = new FileFilter("Bilder (*.jpg, *.jpeg, *.gif, *.png)", "*.jpg; *.jpeg; *.gif; *.png");
        	tekstTyper = new FileFilter("Tekstfiler (*.dat)", "*.dat");
        	alleTyper = new Array(bildeTyper, tekstTyper); 
        	maksfilStorrelse = 50 * 1024;
        }
        
        /**
        * Setter fr(FileReference) sine event lyttere
        */       
        private function lagEventListerner():void
        {
       		fr.addEventListener(Event.SELECT, selectHandler);
            fr.addEventListener(Event.OPEN, openHandler);
            fr.addEventListener(ProgressEvent.PROGRESS, progressHandler);
            fr.addEventListener(Event.COMPLETE, completeHandler);
            fr.addEventListener(IOErrorEvent.IO_ERROR, ioErrorHandler);
            fr.addEventListener(DataEvent.UPLOAD_COMPLETE_DATA, uploadCompleteHandler);
        }

		/**
		 * Funksjonen brukes av view for å starte browsing etter fil
		 */
        public function velgFil():void
        {
       		try
			{
				fr.browse(alleTyper);
			}
			catch (io:IllegalOperationError)
			{
				Alert.show( String(io.message), "feil fil format", 0);
			}	
        }
		
		/**
		 * Funksjonen sjekker om filstørrelsen er større en lovlig filstørrelse og viser
		 * feilmelding hvis den er for stor.
		 * Så prøver den å laste opp filen
		 */
        private function selectHandler(event:Event):void
        { 
        	opplastning.startet = true;
        	var filstorrelse:Number = Math.round( fr.size / 1024 );
        	 
			if ( filstorrelse <= maksfilStorrelse )
			{
	    		var request:URLRequest = new URLRequest();
	            request.url = adresse;   
	    	    try
			    {
	            	fr.upload(request);
			    }
			    catch (error:Error)
			    {
			        trace("Kunen ikke laste opp fil.");
			    }
			} 
			else {
				Alert.show(String("Filen er for stor! \n\nVelg en fil som er mindre "+ filstorrelse + "KB" ), 
				"Filstørrelse feil", Alert.OK);
			} 
        }
		
		/**
		 * Når browsingen starter settes prosessbaren sin label
		 */
        private function openHandler(event:Event):void
        {
            opplastning.progressBar.label = "Laster opp...";
        }
        
        /**
        * Ved feil med server oppkobling vil det kommer en boks som sier ifra
        * Det vil også bli sagt ifra i prosessbaren sin label
        */
       	private function ioErrorHandler( event:IOErrorEvent ):void 
		{
			Alert.show( "Kan ikke koble til server", "Server feil");
			opplastning.progressBar.label = "Kan ikke koble til server";
		}
		
		/**
		 * Funksjonen blir kaldt når prosessen er startet og setter prosessbaren til å vise prosent ferdig
		 * og vise antall KB ferdig av antall KB
		 * Den setter også prosessbaren til å vise en økende bar
		 */
        private function progressHandler(event:ProgressEvent):void
        {
            opplastning.progressBar.label = "Laster opp %3%% : " + Math.round( event.bytesLoaded / 1024 ) + " KB av " +
												   Math.round( event.bytesTotal / 1024 ) + " KB ";
            opplastning.progressBar.setProgress(event.bytesLoaded, event.bytesTotal);
        }
        
        /**
        * Handleren setter progressbar til 100% og labelen til at filen ble lastet opp
        */
        private function completeHandler(event:Event):void
        {
        	opplastning.progressBar.setProgress(100, 100);
        	opplastning.progressBar.label = "Filen " + fr.name + " ble lastet opp";         	
        }
        
        /**
        * Mottar data fra server og printer det ut
        * Setter opplasningen til fullført
        */
        private function uploadCompleteHandler(event:DataEvent):void
        {
        	opplastning.resultat += event.data as String;
        	opplastning.ferdig = true;
        }		

	}
}