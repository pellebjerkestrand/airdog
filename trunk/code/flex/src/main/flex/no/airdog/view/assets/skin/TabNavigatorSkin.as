 package no.airdog.view.assets.skin 
{
    
import mx.skins.ProgrammaticSkin;
import flash.display.Graphics;
    
public class TabNavigatorSkin extends ProgrammaticSkin 
{

    public function TabNavigatorSkin():void 
    {    
        super();
    }
    
    override protected function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void 
    {
        
        super.updateDisplayList(unscaledWidth, unscaledHeight);
    
        var g:Graphics = graphics;
        g.clear();
                        
        // upper tab rect
        drawRoundRect(0,0,unscaledWidth, unscaledHeight,10,0xFFFFFFF,1,null,"linear",null,null);
        // bottm tab rect
        drawRoundRect(0,unscaledHeight -10 ,unscaledWidth, 10,0,0xFFFFFFF,1,null,"linear",null,null);
        
        // corners
        g.lineStyle(3, 0xFFFFFF);
        // left corner
        g.moveTo(-3,unscaledHeight);
        g.curveTo(0,unscaledHeight, 0, unscaledHeight - 3 );
        // right corner
        g.moveTo(3 + unscaledWidth ,unscaledHeight);
        g.curveTo(unscaledWidth,unscaledHeight, unscaledWidth, unscaledHeight - 3 );
    
                        
      }
            
    }
}