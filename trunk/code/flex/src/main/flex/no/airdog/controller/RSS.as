package no.airdog.controller
{	
	import com.adobe.utils.XMLUtil;
	import com.adobe.xml.syndication.rss.Item20;
	import com.adobe.xml.syndication.rss.RSS20;
	
	import flash.events.Event;
	import flash.events.IOErrorEvent;
	import flash.events.SecurityErrorEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	
	import mx.collections.ArrayCollection;
	
	import no.airdog.model.Nyhet;
	import no.airdog.services.Components;
	
	public class RSS
	{	
		public function lagNyheterFraRSS(feedURL:String):void
		{
			var loader:URLLoader;
			
			var request:URLRequest = new URLRequest(feedURL);
			request.method = URLRequestMethod.GET;
		
			loader.addEventListener(Event.COMPLETE, onDataLoad);
			loader.addEventListener(IOErrorEvent.IO_ERROR, onIOError);
			loader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, onSecurityError);
			
			loader.load(request);
		}
		
		private function onDataLoad(e:Event):void
		{
			var rawRSS:String = URLLoader(e.target).data;
			parseRSS(rawRSS);
		}
		
		private function parseRSS(data:String):void
		{
			if(!XMLUtil.isValidXML(data))
			{
				writeOutput("Feil i klubbens RSS");
				return;
			}	
			
			var rss:RSS20 = new RSS20();
		
			rss.parse(data);
		
			var items:Array = rss.items;
			
			var news:ArrayCollection = new ArrayCollection;
			
			for each(var item:Item20 in items)
			{
				var tmp:Nyhet = new Nyhet;
				tmp.tittel = item.title;
				tmp.tekst = item.description;
				tmp.url = item.link;
				tmp.dato = item.pubDate.toLocaleDateString();
				news.addItem(tmp);
			}
			
			Components.instance.session.nyheter = news;
		}
		
		private function writeOutput(data:String):void
		{
			//outputField.text += data + "\n";
		}
		
		private function onIOError(e:IOErrorEvent):void
		{
			writeOutput("IOError : " + e.text);
		}
		
		private function onSecurityError(e:SecurityErrorEvent):void
		{
			writeOutput("SecurityError : " + e.text);
		}
	}
}