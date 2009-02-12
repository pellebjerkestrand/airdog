package no.airdog.model
{
	import mx.collections.ArrayCollection;
	
	//[RemoteClass(alias="AmfBruker")]
	[RemoteClass(alias="LoginVO")]
	[Bindable]
	public class Bruker
	{		
		public var brukernavn:String;
		public var passord:String;
		public var innlogget:Boolean = false;
		
		//login example
		public var CURRENT_USER_ROLE:String="";
		public var admingranted:Boolean = false;
		public var supergranted:Boolean = false;
	}
}