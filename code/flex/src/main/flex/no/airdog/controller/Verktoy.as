package no.airdog.controller
{
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	import flash.net.navigateToURL;
	import flash.utils.ByteArray;
	
	import mx.controls.DataGrid;
	
	import no.airdog.services.Components;

	
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
		
		public static function ucfirst(str:String):String
		{
			return str.substr(0,1).toUpperCase()+str.substr(1).toLowerCase();
		}
		
		public static function ucwords(str:String):String
		{
			var myArr:Array = str.split(' ');
			for (var i:int = 0; i < myArr.length; i++)
			{
				myArr[i] = ucfirst(myArr[i]);
			}
			return myArr.join(' ');
		}
		
		public static function stripHTML(html:String):String
		{
			return html.replace(/<.*?>/g, "");
		}
		
		public static function eksporterDataGrid(dg:DataGrid, navn:String):void
        {
            var str:String = new String();
            var rows:Number = 0;
                           
            for(var i:int = 0; i < dg.columns.length; i++) 
            {
                str += dg.columns[i].headerText + "\t";
            }
            
            str += "\n";
            
            for(var j:int =0; j < dg.dataProvider.length; j++) 
            {                    
                for(var k:int=0; k < dg.columns.length; k++) 
                {     
                	               
                    if(dg.dataProvider.getItemAt(j) != undefined && dg.dataProvider.getItemAt(j) != null) 
                    {
                    	
                        if(dg.columns[k].labelFunction != undefined && dg.columns[k].labelFunction != null) 
                        {
                            str += dg.columns[k].labelFunction(dg.dataProvider.getItemAt(j),dg.columns[k]) + "\t";
                        } 
                        else 
                        { 
                        	
                            var data:String = new String();
                            
                            if (dg.dataProvider.getItemAt(j) != null && dg.columns[k] != null && dg.columns[k].dataField != null && dg.dataProvider.getItemAt(j)[dg.columns[k].dataField] != null)
                            {
                            	data = dg.dataProvider.getItemAt(j)[dg.columns[k].dataField].toString();
                            }
                            else
                            {
                                data = "";
                            }
							 
                            data = data.replace("\"", "");
                            str += data + "\t";
                        }
                    }
                }
                
                rows++;
                str += "\n";
            }
            
            var variables:URLVariables = new URLVariables(); 
            variables.tekst = str;
        	variables.navn = navn;
            
            var urlExcelExport:String = Components.instance.services.rootPath + "controller/Excel.php";
            
            var u:URLRequest =  new URLRequest(urlExcelExport);
            u.method = URLRequestMethod.POST; 
            u.data = variables; 
          
            navigateToURL(u, "_self");
        }
        
        public static function lagAarbok(hundId:String, aar:String, kjonn:String):void
        {
            var variabler:URLVariables = new URLVariables(); 
            variabler.hundId = hundId;
        	variabler.aar = aar;
        	variabler.kjonn = kjonn;
        	variabler.brukerEpost = Components.instance.session.bruker.epost;
        	variabler.brukerPassord = Components.instance.session.bruker.passord;
        	variabler.klubbId = Components.instance.session.bruker.sattKlubb.raseid;
            
            var urlLagArrbok:String = Components.instance.services.rootPath + "controller/Aarbok.php";
            
            var u:URLRequest =  new URLRequest(urlLagArrbok);
            u.method = URLRequestMethod.POST; 
            u.data = variabler; 
          
            navigateToURL(u, "_self");
        }
	}
}