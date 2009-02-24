package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	[RemoteClass(alias="AmfAvkom")]
	[Bindable]
	public class Avkom
	{
		public var med:String;
		public var medId:String;
		public var kullId:String;
		public var liste:ArrayCollection;
	}
}