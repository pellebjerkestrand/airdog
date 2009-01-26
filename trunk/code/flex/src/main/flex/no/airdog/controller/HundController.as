package no.airdog.controller
{
	import flash.events.Event;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import mx.collections.ArrayCollection;
	import mx.utils.ArrayUtil;
	import no.airdog.domain.hund.Hund;  
	import flash.xml.XMLDocument;
	
	public class HundController
	{
		private var hunder:ArrayCollection;
		private var xmlString:URLRequest = new URLRequest("../assets/Hunder.xml");
		private var xmlLoader:URLLoader = new URLLoader(xmlString);
		private var defaultXML:XMLDocument = new XMLDocument();
		
		public function get alleHunder():ArrayCollection
		{
			//return getDummyHunder();
			return getDummyHunder();
		}
		
		private function getDummyHunder():ArrayCollection
		{
		    var xml:XML = XML(xmlLoader.data);
		    defaultXML.parseXML(xml.toXMLString());

			hunder = new ArrayCollection(mx.utils.ArrayUtil.toArray(defaultXML));
			
			return hunder;
		}	
	}
}