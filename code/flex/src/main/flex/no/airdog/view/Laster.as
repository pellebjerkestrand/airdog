//egen lasteskjerm
package no.airdog.view
{
    import flash.display.Loader;
    import flash.display.Sprite;
    import flash.events.Event;
    import flash.events.ProgressEvent;
    import flash.events.TimerEvent;
    import flash.geom.Rectangle;
    import flash.net.URLRequest;
    import flash.text.TextField;
    import flash.utils.Timer;
    import flash.utils.getTimer;

    import mx.events.FlexEvent;
    import mx.preloaders.IPreloaderDisplay;

    public class Laster extends Sprite implements IPreloaderDisplay
    {
    	// venter så lenge som det her (millisekunder) selv om lastinga er ferdig
        private var _minimumDuration:Number = 3000;

        // implementasjonsvariabler så alt fungerer som det skal
        private var _IsInitComplete		: Boolean = false;
        private var _timer 				: Timer;			// for å tegne lastestolpa
        private var _bytesLoaded 		: uint = 0;
        private var _bytesExpected 		: uint = 1;			// for å unngå deling på 0
        private var _fractionLoaded 	: Number = 0;		// brukes til bredden på lastestolpa
        private var _preloader			: Sprite;
        private var _currentStatus		: String;			// statusen: laster, kjører osv
        
        // visningsinstillinger, settes egentlig i mx:Application, men det funker ikke alltid
        private var _backgroundColor	: uint = 0x000000;
        private var _stageHeight		: Number = 1;
        private var _stageWidth			: Number = 1;
        private var _loadingBarColour	: uint = 0x8a0000;
        
        // elementer i visninga
        private var _loadingBar 		: Rectangle;		// lastestolpa
        private var loadingImage 		: flash.display.Loader;
        private var progressText		: TextField;
        private var statusText			: TextField;
        
        public function Laster()
        {
            super();
        }
        
        // kalles når applikasjonen er klar for lasteskjermen
        public function initialize():void
        {
        	drawBackground();

			// laster logoen vår
			loadingImage = new flash.display.Loader();       
			loadingImage.contentLoaderInfo.addEventListener( Event.COMPLETE, loader_completeHandler);
			loadingImage.load(new URLRequest("no/airdog/view/assets/airdoglogo200clean.png")); // This path needs to be relative to your swf on the server, you could use an absolute value if you are unsure
        }
        
        private function loader_completeHandler(event:Event):void
        {
        	// logoen er ferdiglasta
        	
        	// tegner loadingImage (logoen som er satt i funksjonen over)
            addChild(loadingImage);
            loadingImage.width = 200;
            loadingImage.height= 200;
            loadingImage.x = Math.round(parent.width / 2) - Math.round(loadingImage.width / 2);
            loadingImage.y = Math.round(parent.height / 2) - Math.round(loadingImage.height / 2);
            
			// tegner lastestolpa - x,y,width,height
            _loadingBar = new Rectangle(loadingImage.x, (loadingImage.y + loadingImage.height + 5), loadingImage.width, 10);
            
            // lager tekstfelt for progressText
            progressText = new TextField(); 
            progressText.x = loadingImage.x;    
            progressText.y = _loadingBar.y + 15;
            progressText.width = 200;
            progressText.height = 20;
            progressText.textColor = 0x8a0000;
            addChild(progressText);
			
			// lager tekstfelt for statusText
            statusText = new TextField(); 
            statusText.x = loadingImage.x;    
            statusText.y = progressText.y + 15;
            statusText.width = 200;
            statusText.height = 20;
            statusText.textColor = 0x8a0000;
            addChild(statusText);
            
            // endres først av completeHandler()
            _currentStatus = 'Laster';

			// timer for å tegne elementene ofte. ingen lastestolpe uten
            _timer = new Timer(50);
            _timer.addEventListener(TimerEvent.TIMER, timerHandler);
            _timer.start();
        }
        
        // kalles flere ganger helt til lastinga er ferdig
        private function draw():void
        {
			graphics.beginFill( _loadingBarColour , 1);
            graphics.drawRect(_loadingBar.x, _loadingBar.y, _loadingBar.width * _fractionLoaded, _loadingBar.height);
            graphics.endFill();
            progressText.text = (Math.round(_bytesLoaded / 1024)).toString() + ' KB av ' + (Math.round(_bytesExpected / 1024)) + ' KB lastet';
            statusText.text = _currentStatus;
        }
        
        private function drawBackground():void
        {
			// tegner bakgrunnen
			graphics.beginFill( _backgroundColor, 1);
 			graphics.drawRect( 0, 0, stageWidth, stageHeight);
			graphics.endFill();
        }
        
        
        // setter lyttere før resten av lasteren kjøres
        public function set preloader(value:Sprite):void
        {
            _preloader = value;
        
            value.addEventListener(ProgressEvent.PROGRESS, progressHandler);    
            value.addEventListener(Event.COMPLETE, completeHandler);
            
            value.addEventListener(FlexEvent.INIT_PROGRESS, initProgressHandler);
            value.addEventListener(FlexEvent.INIT_COMPLETE, initCompleteHandler);
        }

		// get og set for verdier. flesteparten settes i mx:Application
        public function set backgroundAlpha(alpha:Number):void{}
        public function get backgroundAlpha():Number { return 1; }
        
        public function set backgroundColor(color:uint):void { _backgroundColor = color; }
        public function get backgroundColor():uint { return _backgroundColor; }
        
        public function set backgroundImage(image:Object):void {}
        public function get backgroundImage():Object { return null; }
        
        public function set backgroundSize(size:String):void {}
        public function get backgroundSize():String { return "auto"; }
        
        public function set stageHeight(height:Number):void { _stageHeight = height; }
        public function get stageHeight():Number { return _stageHeight; }

        public function set stageWidth(width:Number):void { _stageWidth = width; }
        public function get stageWidth():Number { return _stageWidth; }

        //  lyttere
        
        // kalles mens lastinga pågår
        private function progressHandler(event:ProgressEvent):void
        {
            _bytesLoaded = event.bytesLoaded;
            _bytesExpected = event.bytesTotal;
            _fractionLoaded = Number(_bytesLoaded) / Number(_bytesExpected);
        }
        
        // kalles når lastinga er ferdig
        private function completeHandler(event:Event):void
        {
        	_currentStatus = 'Lastet ferdig';
        	trace(_currentStatus);
        }
    
        // kalles når AirDog kjøres     
        private function initProgressHandler(event:Event):void
        {
        	if( !_IsInitComplete)
        	{
            	_currentStatus = 'Starter AirDog';
            	trace(_currentStatus);
         	}
        }
    
        // kalles når nedlasting og kjøring er ferdig
        private function initCompleteHandler(event:Event):void
        {
        	_currentStatus = 'AirDog starter';
        	trace(_currentStatus);
            _IsInitComplete = true;
            
        }

        // kalles så ofte som mulig
        private function timerHandler(event:Event):void
        {
            if ( _IsInitComplete && getTimer() > _minimumDuration )
            {    
                // alt er nå klart
                // venter i _minimumDuration/1000 sekunder
                _timer.stop();
                _timer.removeEventListener(TimerEvent.TIMER,timerHandler);
                dispatchEvent(new Event(Event.COMPLETE));
            }
            else
            {
            	// tegner/oppdaterer skjermen med det siste som har skjedd
                draw();
            }
        }
    }
}