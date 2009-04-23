package no.airdog.model
{
	[RemoteClass(alias="AmfNyhet")]
	[Bindable]
	public class Nyhet
	{
		public var tittel:String;
		public var tekst:String;
		public var dato:String;
		public var url:String;
	}
}