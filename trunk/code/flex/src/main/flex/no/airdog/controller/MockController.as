package no.airdog.controller
{
	import mx.controls.Label;
	import mx.controls.ProgressBar;
	
	import no.airdog.model.Opplastning;

	import no.airdog.services.Components;
	
	public class MockController implements IController
	{
		[Bindable]
        public var statusLabel:Label;

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