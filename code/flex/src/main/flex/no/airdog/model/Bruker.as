package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	//[RemoteClass(alias="AmfBruker")]
	[RemoteClass(alias="AmfBruker")]
	[Bindable]
	public class Bruker
	{		
		public var brukernavn:String;
		public var passord:String;
		public var innlogget:Boolean = false;
		public var GJELDENDE_BRUKERROLLE:String="";
	}
}