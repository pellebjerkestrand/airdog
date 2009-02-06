package no.airdog.controller
{
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.messaging.ChannelSet;
	import mx.messaging.channels.AMFChannel;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.RemoteObject;
	
	import no.airdog.domain.hund.Hund;
	//import no.airdog.facade.AirdogFacade;
	
	[Bindable]
	public class HundController
	{
 		private var ro:RemoteObject;
        
		public var hunder:ArrayCollection = new ArrayCollection();
		//public var facade:AirdogFacade;
		
		public function HundController()
		{
			//getAlleHunder2();
			getDummyHunder();
		}
		
		public function getAlleHunder2():void
		{
			var channelSet:ChannelSet = new ChannelSet();
			
			var amfChannel:AMFChannel = new AMFChannel();
			ro = new RemoteObject();
			ro.addEventListener(ResultEvent.RESULT, onResult);
			ro.addEventListener(FaultEvent.FAULT, onFault);
			
			amfChannel.uri = "http://localhost/helloamf/";
			
			channelSet.channels = [amfChannel];
			
			ro.channelSet = channelSet;
			ro.source = "HundController";
			ro.destination = "zend";
			ro.getOperation("getAlleHunder").send();
		}

        public function onResult(event:ResultEvent):void 
        {
            hunder = new ArrayCollection(event.result as Array);
        }

        public function onFault(event:FaultEvent):void 
        {
         // Deal with event.fault.faultString, etc.
            Alert.show(event.fault.faultString, 'Error');
        }
		
		/*public function getAlleHunder() : void
		{
			facade.getAlleHunder(onGetAlleHunder);
		}*/
		
		private function getDummyHunder():void
		{
			var tmpCollection:ArrayCollection = new ArrayCollection();
			
			for (var i:int = 0; i < 100; i++)
			{
				var tempHund:Hund = new Hund();
				tempHund.id = i;
				tempHund.navn = "<NAVN " + i + ": TESTNAVN>";
				tempHund.tittel = "<TITTEL " + i + ">";
				tempHund.bilde = "Hund1.jpg";
				tempHund.foreldre = "<FORELDRE>";
				tempHund.kjonn = "<KJØNN>";
				tempHund.oppdretter = "<OPPDRETTER>";
				tempHund.eier = "<EIER>";
				tmpCollection.addItem(tempHund);
			}
			
			hunder = tmpCollection;
		}
		
		private function onGetAlleHunder(arrHunder:ArrayCollection) : void
		{
			hunder = arrHunder;
		}
	}
}