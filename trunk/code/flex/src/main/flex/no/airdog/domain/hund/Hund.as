package no.airdog.domain.hund
{
	import no.airdog.domain.Entity;

	[Bindable]
	public class Hund implements Entity
	{		
		/* huid */
		private var huid : String;	
		public function get id():* { return huid; }
    	public function set id(value:*):void { huid = value; }
		
		/* tittel */
		private var _tittel : String;
		public function get tittel():* { return _tittel; }
    	public function set tittel(value:*):void { _tittel = value; }
		
		/* navn */
		private var _navn : String;    	
		public function get navn():* { return _navn; }
    	public function set navn(value:*):void { _navn = value; }
    	
		public function equals( other:Entity ):Boolean
		{
			if (this == other) return true;
			if (other == null) return false;
			if (id == null) {
				if (other.id != null) return false;
			} else if (!(id == other.id)) return false;
			
			return true;
		}	
	}
}