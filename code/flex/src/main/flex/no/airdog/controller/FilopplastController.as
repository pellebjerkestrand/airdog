package no.airdog.controller
{	
    import flash.errors.IllegalOperationError;
    import flash.events.*;
    import flash.net.*;
    
    import mx.controls.*;
    import mx.core.UIComponent;

    public class FilopplastController extends UIComponent
    {
    	private const ADRESSE:String = "http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/controller/FilopplastController.php";
        private var fr:FileReference;
        private var pBar:ProgressBar;
		private var bildeTyper:FileFilter;
		private var tekstTyper:FileFilter;
		private var alleTyper:Array;
		private var maksfilStorrelse:Number;	
		private var uploadtekst:TextArea; 

        public function FilopplastController()
        {
			settFilrestriksjoner();
        }
        
        private function settFilrestriksjoner():void
        {
        	bildeTyper = new FileFilter("Bilder (*.jpg, *.jpeg, *.gif, *.png)", "*.jpg; *.jpeg; *.gif; *.png");
        	tekstTyper = new FileFilter("Tekstfiler (*.dat)", "*.dat");
        	alleTyper = new Array(bildeTyper, tekstTyper); 
        	maksfilStorrelse = 50 * 1024;
        }
        
        public function start(pbar:ProgressBar, uploadtekst:TextArea):void
        {
        	this.uploadtekst = uploadtekst;
           	this.pBar = pbar;
            fr = new FileReference();

            lagEventListerner();
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
        	var filstorrelse:Number = Math.round( fr.size / 1024 );
        	 
			if ( filstorrelse <= maksfilStorrelse )
			{
	    		var request:URLRequest = new URLRequest();
	            request.url = ADRESSE;   
	    	    try
			    {
	            	fr.upload(request);
	            	pBar.visible = true;
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
            pBar.label = "Laster opp...";
        }
        
       	private function ioErrorHandler( event:IOErrorEvent ):void 
		{
			Alert.show( "Kan ikke koble til server", "Server feil");
		}

        private function progressHandler(event:ProgressEvent):void
        {
            pBar.label = "Laster opp %3%% : " + Math.round( event.bytesLoaded / 1024 ) + " KB av " +
												   Math.round( event.bytesTotal / 1024 ) + " KB ";
            
            pBar.setProgress(event.bytesLoaded, event.bytesTotal);
        }
        
        private function completeHandler(event:Event):void
        {
        	pBar.setProgress(100, 100);
   
        	pBar.label = "Filen " + fr.name + " ble lastet opp";         	
        }
        
        private function uploadCompleteHandler(event:DataEvent):void
        {
        	uploadtekst.visible = true;
        	uploadtekst.text += event.data as String;
        }		
    }
}