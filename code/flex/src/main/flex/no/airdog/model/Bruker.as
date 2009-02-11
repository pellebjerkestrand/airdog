package no.airdog.model
{
	[RemoteClass(alias="AmfBruker")]
	[Bindable]
	public class Bruker
	{		
		public var brukernavn:String;	
		public var passord:String;
		public var innlogget:Boolean = false;
	}
}