package no.airdog.controller.old
{
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.messaging.ChannelSet;
	import mx.messaging.channels.AMFChannel;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.RemoteObject;
	
	//import no.airdog.domain.hund.Hund;
	//import no.airdog.facade.AirdogFacade;
	
	[Bindable]
	public class HundController
	{
 		private var ro:RemoteObject;
		
		public function HundController()
		{
		}
		
		public function getAlleHunder2(resultHandler:Function, faultHandler:Function=null):void
		{
			var channelSet:ChannelSet = new ChannelSet();
			
			var amfChannel:AMFChannel = new AMFChannel();
			ro = new RemoteObject();
			ro.addEventListener(ResultEvent.RESULT, resultHandler);
			ro.addEventListener(FaultEvent.FAULT, faultHandler);
			
			amfChannel.uri = "http://158.36.203.155:8888/AirDog%20-%20PHP/src/main/php/no/airdog/";
			
			channelSet.channels = [amfChannel];
			
			ro.channelSet = channelSet;
			ro.source = "Tutorials";
			ro.destination = "zend";
			ro.getOperation("getTutorials").send();
		}
	}
}