package no.airdog.controller
{
	import flash.events.Event;
	
	import mx.binding.utils.*;
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.events.BrowserChangeEvent;
	import mx.managers.BrowserManager;
	import mx.managers.IBrowserManager;
	import mx.utils.*;
	
	import no.airdog.model.Session;
	import no.airdog.services.*;
			
	public class Historie
	{
		private var historier:ArrayCollection;
		private var browserManager:IBrowserManager;
		
		public function Historie()
		{
			historier = new ArrayCollection();
			
			browserManager = BrowserManager.getInstance();
		    browserManager.addEventListener(BrowserChangeEvent.BROWSER_URL_CHANGE, hentPunkt);
		    browserManager.init("");
		    settPunkt();
		}
		
		public function settPunkt():void 
        {
        	var i:int = leggTilSession(Components.instance.session);
			browserManager.setFragment("state=" + i);
            browserManager.setTitle("AirDog");
        }
        
        public function nullstill():void
        {
        	historier.removeAll();
        }
		
		private function hentPunkt(e:Event):void 
		{            
        	var index:String = browserManager.fragment.substr(6);      
        	  
        	if (index != "" && parseInt(index))
        	{
        		var session:Session = hentSession(parseInt(index));
			
				if (session != null)
				{
					// Ting som ikke lar seg serialisere
					session.hundesokListe.renderer = Components.instance.session.hundesokListe.renderer;
					
					Components.instance.session = session;
				}		
				else
				{
        			Alert.show("Dette historiepunktet finnes ikke lenger.", "Historie");  
	        	}
        	}
        }  
		
		public function leggTilSession(session:Session):int
		{
			historier.addItem(session.clone());
			
			if (historier.length > 20)
				historier.setItemAt(null, historier.length - 20);
				
			return historier.length - 1;
		}
		
		public function hentSession(nr:int):Session
		{
			if (historier.length > nr)
			{
				return historier.getItemAt(nr) as Session;
			}
			
			return null;
		}
	}
}