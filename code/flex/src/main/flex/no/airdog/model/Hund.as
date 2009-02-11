package no.airdog.model
{
	[RemoteClass(alias="AmfHund")]
	[Bindable]
	public class Hund
	{		
		public var hundId : String;	
		public var tittel : String;
		public var navn : String;    	
		public var bilde : String;
		public var morId : String;
		public var morNavn : String;
		public var farId : String;
		public var farNavn : String;
		public var oppdretterId : String;
		public var oppdretter : String;
		public var eierId : String;
		public var eier : String;
		public var kjonn : String;
		public var rase : String;
		public var kullId : String
	}
}