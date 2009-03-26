package no.airdog.model
{
	[RemoteClass(alias="AmfOpplastningObjekt")]
	[Bindable]
	public class OpplastningObjekt
	{
		public var tekst:String;
		public var filtype:String;
		public var overskriv:Boolean;
	}
}