package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	[RemoteClass(alias="AmfCup")]
	[Bindable]
	public class Cup
	{
		public var hundId:String;
		public var hundNavn:String;
		public var tittel:String;
		public var eier:String;
		public var poeng:int;
		public var plass:int;
		public var prover:ArrayCollection;
	}
}