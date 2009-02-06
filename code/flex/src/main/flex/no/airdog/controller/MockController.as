package no.airdog.controller
{
	import mx.controls.Label;
	import mx.controls.ProgressBar;
	import mx.collections.ArrayCollection;
	
	import no.airdog.model.*;
	import no.airdog.services.Components;
	
	public class MockController implements IController
	{
		[Bindable]
        public var statusLabel:Label;
        
        public function MockController()
        {
        	var tmpCollection:ArrayCollection = Components.instance.session.hundeliste;
			
			for (var i:int = 0; i < 100; i++)
			{
				var tempHund:Hund = new Hund();
				tempHund.id = i.toString();
				tempHund.navn = "<NAVN " + i + ": TESTNAVN>";
				tempHund.tittel = "<TITTEL " + i + ">";
				tempHund.bilde = "Hund1.jpg";
				tempHund.foreldre = "<FORELDRE>";
				tempHund.kjonn = "<KJØNN>";
				tempHund.oppdretter = "<OPPDRETTER>";
				tempHund.eier = "<EIER>";
				tmpCollection.addItem(tempHund);
			}
        }

		public function setStatusLabel(text:String):void
		{
			statusLabel.text = text + " (Mock)";
		}
		
		public function login(username:String):void
		{
		}
		
		public function logout():void
		{
		}
		
		public function lastOppDatFil():void
		{
			Components.instance.session.datOpplastning.progressBar.setProgress(100,100);
			Components.instance.session.datOpplastning.progressBar.label = "Ferdig (Mock)";
			Components.instance.session.datOpplastning.ferdig = true;			
		}
	}
}