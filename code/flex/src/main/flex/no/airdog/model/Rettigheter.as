package no.airdog.model
{
	[RemoteClass(alias="AmfRettigheter")]
	[Bindable]
	public class Rettigheter
	{
		public var lese:Boolean;
		public var redigerHund:Boolean;
		public var redigerJaktprove:Boolean;
		public var redigerUtstilling:Boolean;
		public var importerDatabase:Boolean;
		public var leggInnJaktprove:Boolean;
		public var slettJaktprove:Boolean;
		public var rolleRettighetHandtering:Boolean;
		public var klubbRolleBrukerHandtering:Boolean;
		public var administrereBackup:Boolean;
		public var redigerEgenBruker:Boolean;
		public var arrangementer:Boolean;
		public var lagAarbok:Boolean;
		public var redigerKlubb:Boolean;
		
		public var administrere:Boolean;
	}
}


