package no.airdog.model
{
	import mx.controls.ProgressBar;
	
	[Bindable]
	public class Opplastning
	{
		public var resultat:String;
		public var progressBar:ProgressBar;
		public var ferdig:Boolean;
		public var startet:Boolean;
		public var venterSQL:Boolean;
	}
}