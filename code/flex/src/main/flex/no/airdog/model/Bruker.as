package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	[RemoteClass(alias="AmfBruker")]
	[Bindable]
	public class Bruker
	{		
		public var epost:String;
		public var passord:String;
		public var innlogget:Boolean = false;
		public var sattKlubb:String;
		public var klubb:ArrayCollection;
		public var roller:ArrayCollection;
		public var rettigheter:ArrayCollection;
	}
}