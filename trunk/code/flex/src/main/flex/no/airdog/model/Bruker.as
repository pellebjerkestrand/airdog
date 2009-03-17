package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	[RemoteClass(alias="AmfBruker")]
	[Bindable]
	public class Bruker
	{		
		public var epost:String;
		public var fornavn:String;
		public var etternavn:String;
		public var passord:String;
		public var superadmin:Boolean;
		public var innlogget:Boolean = false;
		public var sattKlubb:String;
		public var sattKlubbId:String;
		public var klubber:ArrayCollection;
		public var roller:ArrayCollection;
		public var rettigheter:ArrayCollection;
	}
}