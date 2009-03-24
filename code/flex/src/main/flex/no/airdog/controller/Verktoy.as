package no.airdog.controller
{
	import flash.utils.ByteArray;
	
	public class Verktoy
	{	
		public static function sammenliknObjekt(objekt1:Object,objekt2:Object):Boolean
		{
		    var buffer1:ByteArray = new ByteArray();
		    buffer1.writeObject(objekt1);
		    var buffer2:ByteArray = new ByteArray();
		    buffer2.writeObject(objekt2);
		 	
		    var storrelse:uint = buffer1.length;
		    if (buffer1.length == buffer2.length)
		    {
		        buffer1.position = 0;
		        buffer2.position = 0;
		 
		        while (buffer1.position < storrelse)
		        {
		            var v1:int = buffer1.readByte();
		            if (v1 != buffer2.readByte())
		            {
		                return false;
		            }
		        }    
		        return true;                        
		    }
		    return false;
		}
	}
}