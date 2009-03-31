package no.airdog.model
{
	import mx.collections.ArrayCollection;
	import mx.controls.ProgressBar;
	
	[Bindable]
	public class Opplastning
	{
		public var objektliste:ArrayCollection = new ArrayCollection();
		public var objektType:String;
		public var resultat:String;
		public var progressBar:ProgressBar;
		public var ferdig:Boolean;
		public var startet:Boolean;
		public var venterSQL:Boolean;
		public var type:String;
	}
}