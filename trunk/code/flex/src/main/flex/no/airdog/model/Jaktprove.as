package no.airdog.model
{

	[RemoteClass(alias="AmfJaktprove")]
	[Bindable]
	public class Jaktprove
	{
		public var proveNr:String;
		public var proveDato:String;
		public var partiNr:String;
		public var klasse:int;
		public var dommerId1:String;
		public var dommerId2:String;
		public var hundId:String;
		public var slippTid:String;
		public var egneStand:String;
		public var egneStokk:String;
		public var tomStand:String;
		public var makkerStand:String;
		public var makkerStokk:String;
		public var jaktlyst:String;
		public var fart:String;
		public var stil:String;
		public var selvstendighet:String;
		public var bredde:String;
		public var reviering:String;
		public var samarbeid:String;
		public var presUpresis:int;
		public var presNoeUpresis:int;
		public var presPresis:int;
		public var reisNekter:int;
		public var reisNoelende:int;
		public var reisVillig:int;
		public var reisDjerv:int;
		public var sokStjeler:int;
		public var sokSpontant:int;
		public var appIkkeGodkjent:int;
		public var appGodkjent:int;
		public var rappInnkalt:int;
		public var rappSpont:int;
		public var premiegrad:String;
		public var certifikat:int;
		public var regAv:String;
		public var regDato:String;
		public var raseId:int;
		public var manueltEndretAv:String;
		public var manueltEndretDato:String;
	}
}