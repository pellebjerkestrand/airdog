package no.airdog.model
{
	[RemoteClass(alias="AmfHund")]
	[Bindable]
	public class Hund
	{		
		public var id : String;	
		public var tittel : String;
		public var navn : String;    	
		public var bilde : String;
		public var foreldre : String;
		public var oppdretter : String;
		public var kjonn : String;
		public var eier : String;
	}
}