package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	[RemoteClass(alias="AmfAvkom")]
	[Bindable]
	public class Avkom
	{
		public var med:String;
		public var medId:String;
		
		//Brukes ikke!
		public var liste:ArrayCollection;	
	}
}