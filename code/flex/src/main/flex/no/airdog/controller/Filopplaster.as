package no.airdog.controller
{
	import flash.errors.IllegalOperationError;
	import flash.events.*;
	import flash.net.*;
	import mx.controls.*;
	import no.airdog.model.Opplastning;
	import no.airdog.services.Components;
    
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
		
		private function settFilrestriksjoner():void
        {
        	//bildeTyper = new FileFilter("Bilder (*.jpg, *.jpeg, *.gif, *.png)", "*.jpg; *.jpeg; *.gif; *.png");
        	tekstTyper = new FileFilter("Tekstfiler (*.dat)", "*.dat");
        	alleTyper = new Array(tekstTyper); 
        	maksfilStorrelse = 50 * 1024;
        }
               
        private function lagEventListerner():void
        {
       		fr.addEventListener(Event.SELECT, selectHandler);
            fr.addEventListener(Event.OPEN, openHandler);
            fr.addEventListener(ProgressEvent.PROGRESS, progressHandler);
            fr.addEventListener(Event.COMPLETE, completeHandler);
            fr.addEventListener(IOErrorEvent.IO_ERROR, ioErrorHandler);
            fr.addEventListener(DataEvent.UPLOAD_COMPLETE_DATA, uploadCompleteHandler);
        }

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
		
        private function openHandler(event:Event):void
        {
            opplastning.progressBar.label = "Laster opp...";
        }
        
       	private function ioErrorHandler( event:IOErrorEvent ):void 
		{
			Alert.show( "Kan ikke koble til server", "Server feil");
			opplastning.progressBar.label = "Kan ikke koble til server";
		}
		
        private function progressHandler(event:ProgressEvent):void
        {
            opplastning.progressBar.label = "Laster opp %3%% : " + Math.round( event.bytesLoaded / 1024 ) + " KB av " +
												   Math.round( event.bytesTotal / 1024 ) + " KB ";
            opplastning.progressBar.setProgress(event.bytesLoaded, event.bytesTotal);
        }

        private function completeHandler(event:Event):void
        {
        	opplastning.progressBar.setProgress(100, 100);
        	opplastning.progressBar.label = "Filen " + fr.name + " ble lastet opp";         	
        }

        private function uploadCompleteHandler(event:DataEvent):void
        {
        	opplastning.resultat += event.data as String;
        	opplastning.ferdig = true;
        }		

	}
}