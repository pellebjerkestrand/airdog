package no.airdog.model
{

	[RemoteClass(alias="AmfJaktprove")]
	[Bindable]
	public class Jaktprove
	{
		public var proveNr:String;
		public var proveDato:String;
		public var premiegrad:String;
		public var slippTid:String;
		public var egneStand:String;
		public var makkerStand:String;
		public var egneStokk:String;
		public var makkerStokk:String;
		public var tomStand:String;
		public var jaktlyst:String;
		public var fart:String;
		public var stil:String;
		public var selvstendighet:String;
		public var bredde:String;
		public var reviering:String;
		public var samarbeid:String;
	}
}