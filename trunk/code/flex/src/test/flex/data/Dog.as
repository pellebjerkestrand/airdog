package data
{
	import mx.controls.Image;
	
	[Bindable]
	public class Dog
	{
		public var id:int;
		public var name:String;
		
		public function toString():String
		{
			return name;
		}		
	}
}
