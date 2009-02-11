////////////////////////////////////////////////////////////////////////////////
//
//  Copyright (C) 2003-2006 Adobe Macromedia Software LLC and its licensors.
//  All Rights Reserved. The following is Source Code and is subject to all
//  restrictions on such code as contained in the End User License Agreement
//  accompanying this product.
//
////////////////////////////////////////////////////////////////////////////////

package assets.skins
{

import flash.display.DisplayObjectContainer;
import flash.display.GradientType;
import mx.containers.TabNavigator;
import mx.core.EdgeMetrics;
import mx.core.UIComponent;
import mx.skins.Border;
import mx.styles.IStyleClient;
import mx.styles.StyleManager;
import mx.utils.ColorUtil;
import mx.skins.halo.HaloColors;

/**
 *  The skin for all the states of a Tab in a TabNavigator or TabBar.
 */
public class TabSkin extends Border
{


	//--------------------------------------------------------------------------
	//
	//  Class variables
	//
	//--------------------------------------------------------------------------

	/**
	 *  @private
	 */
	private static var cache:Object = {};

	//--------------------------------------------------------------------------
	//
	//  Class methods
	//
	//--------------------------------------------------------------------------

	/**
	 *  @private
	 *  Several colors used for drawing are calculated from the base colors
	 *  of the component (themeColor, borderColor and fillColors).
	 *  Since these calculations can be a bit expensive,
	 *  we calculate once per color set and cache the results.
	 */
	private static function calcDerivedStyles(themeColor:uint,
											  borderColor:uint,
											  falseFillColor0:uint,
											  falseFillColor1:uint,
											  fillColor0:uint,
											  fillColor1:uint):Object
	{
		var key:String = HaloColors.getCacheKey(themeColor, borderColor,
												falseFillColor0,
												falseFillColor1,
												fillColor0, fillColor1);
		
		if (!cache[key])
		{
			var o:Object = cache[key] = {};

			// Cross-component styles.
			HaloColors.addHaloColors(o, themeColor, fillColor0, fillColor1);
			
			// Tab-specific styles.
			o.borderColorDrk1 =
				ColorUtil.adjustBrightness2(borderColor, 0);
			o.falseFillColorBright1 =
				ColorUtil.adjustBrightness(falseFillColor0, 0);
			o.falseFillColorBright2 =
				ColorUtil.adjustBrightness(falseFillColor1, 0);
		}
		
		return cache[key];
	}

	//--------------------------------------------------------------------------
	//
	//  Constructor
	//
	//--------------------------------------------------------------------------

	/**
	 *  Constructor.
	 */
	public function TabSkin()
	{
		super();
	}
	
	//--------------------------------------------------------------------------
	//
	//  Overridden properties
	//
	//--------------------------------------------------------------------------

	//----------------------------------
	//  borderMetrics
	//----------------------------------

	/**
	 *  @private
	 *  Storage for the borderMetrics property.
	 */
	private var _borderMetrics:EdgeMetrics = new EdgeMetrics(1, 1, 1, 1);

	/**
	 *  @private
	 */
	override public function get borderMetrics():EdgeMetrics
	{
		return _borderMetrics;
	}

	//----------------------------------
	//  measuredWidth
	//----------------------------------
	
	/**
	 *  @private
	 */
	override public function get measuredWidth():Number
	{
		return UIComponent.DEFAULT_MEASURED_MIN_WIDTH;
	}
	
	//----------------------------------
	//  measuredHeight
	//----------------------------------

	/**
	 *  @private
	 */
	override public function get measuredHeight():Number
	{
		return UIComponent.DEFAULT_MEASURED_MIN_HEIGHT;
	}
	
	//--------------------------------------------------------------------------
	//
	//  Overridden methods
	//
	//--------------------------------------------------------------------------

	/**
	 *  @private
	 */
	override protected function updateDisplayList(w:Number, h:Number):void
	{
		super.updateDisplayList(w, h);
		
	

		// User-defined styles.
		var backgroundAlpha:Number = getStyle("backgroundAlpha");		
		var backgroundColor:Number = getStyle("backgroundColor");
		var backgroundOnColor:Number = getStyle("backgroundOnColor");
		var backgroundOffColor:Number = getStyle("backgroundOffColor");
		var backgroundBorderColor:Number = getStyle("backgroundBorderColor");
		var borderColor:uint = getStyle("borderColor");
		var shadowColor:uint = getStyle("shadowColor");
		var shadowOnColor:uint = getStyle("shadowOnColor");
		var cornerRadius:Number = getStyle("cornerRadius");
		var fillAlphas:Array = getStyle("fillAlphas");
		var fillColors:Array = getStyle("fillColors");
		StyleManager.getColorNames(fillColors);
		var highlightAlphas:Array = getStyle("highlightAlphas");		
		var themeColor:uint = getStyle("themeColor");
		var tabHeight:uint = getStyle("tabHeight");
		
		// Placehold styles stub.
		var falseFillColors:Array = []; /* of Number*/ // added style prop
		falseFillColors[0] = backgroundOffColor; //0x999999; //ColorUtil.adjustBrightness2(fillColors[0], -5);
		falseFillColors[1] = backgroundOffColor; //0x999999; //ColorUtil.adjustBrightness2(fillColors[1], -5);
		
		// Derivative styles.
		var derStyles:Object = calcDerivedStyles(themeColor, borderColor,
												 falseFillColors[0],
												 falseFillColors[1],
												 fillColors[0], fillColors[1]);
		
		var drawBottomLine:Boolean =
			parent != null &&
			parent.parent != null &&
			parent.parent.parent != null &&
			parent.parent.parent is TabNavigator &&
			IStyleClient(parent.parent.parent).getStyle("borderStyle") != "none";
		
		drawBottomLine = false;
		
		var cornerRadius2:Number = Math.max(cornerRadius - 2, 0);
		var cr:Object = { tl: cornerRadius, tr: 0, bl: cornerRadius, br: cornerRadius };
		var cr2:Object = { tl: cornerRadius, tr: 0, bl: cornerRadius2, br: cornerRadius2 };

		graphics.clear();

		h = tabHeight;

		
		switch (name)
		{
			case "upSkin":
			case "overSkin":
			{

				// outer edge 
				drawRoundRect(
					0, 1, w - 2, h - 1, cr2,
					backgroundBorderColor, 1);

				// tab fill
				drawRoundRect(
					1, 2, w - 4, h - 3, cr2,
					backgroundOffColor, 1);
				
				//tab shadow top
				drawRoundRect(
						cornerRadius-1, 1, w - cornerRadius -2, 2, 0,
						shadowColor,1);	
					
			
				
	
				break;
			}


			case "disabledSkin":
			{
   				var disFillColors:Array = [ fillColors[0], fillColors[1] ];

   				var disFillAlphas:Array =
					[ Math.max( 0, fillAlphas[0] - 0.15),
					  Math.max( 0, fillAlphas[1] - 0.15) ];
			
			
				// tab fill
				drawRoundRect(
					1, 1, w - 2, h - 2, cr2,
					disFillColors, disFillAlphas,
					verticalGradientMatrix(0, 2, w - 2, h - 2));
			
				// outer edge
				drawRoundRect(
					0, 0, w, h - 1, cr,
					[ derStyles.borderColorDrk1, borderColor], 1,
					verticalGradientMatrix(0, 0, w, h - 6));
					
				break;
			}
			
			case "downSkin":
			case "selectedUpSkin":
			case "selectedDownSkin":
			case "selectedOverSkin":
			case "selectedDisabledSkin":
			{
				
				// outer edge 
				drawRoundRect(
					0, 1, w - 2, h+2, cr2,
					backgroundBorderColor, 1);

				// tab fill
				drawRoundRect(
					1, 1, w - 4, h+1, cr2,
					backgroundOnColor, 1);
					
				//tab shadow top
				drawRoundRect(
						cornerRadius-1, 1, w - cornerRadius -2, 2, 0,
						shadowOnColor,1);		
	
				break;
			}
		}
	}
}

}

