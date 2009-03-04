package no.airdog.controller
{
	import flash.display.DisplayObject;
	
	import no.airdog.model.*;
	
	public interface IController
	{
		function visLoggInnVindu(parent:DisplayObject):void
		function fjernLoggInnVindu():void
		function settBrukersKlubb(klubb:String, klubbId:String):void;
		function loggInn(brukernavn:String, passord:String):void
		function loggUt():void
		function lastOppDatFil():void
		function sokHund(soketekst:String):void
		function hentAvkom(hundId:String):void
		function hentJaktprove(hundId:String):void
		function visHund(hundId:String):void
		function hentBrukersRettigheter():void
		function hentBrukersRoller():void
		function hentStamtre(hundId:String, dybde:int):void
		function redigerJaktprove(
		    proveNr:String,
			proveDato:String,
			partiNr:String,
			klasse:String,
			dommerId1:String,
			dommerId2:String,
			hundid:String,
			slippTid:String,
			egneStand:String,
			egneStokk:String,
			tomStand:String,
			makkerStand:String,
			makkerStokk:String,
			jaktlyst:String,
			fart:String,
			stil:String,
			selvstendighet:String,
			bredde:String,
			reviering:String,
			samarbeid:String,
			presUpresis:String,
			presNoeUpresis:String,
			presPresis:String,
			reisNekter:String,
			reisNoelende:String,
			reisVillig:String,
			reisDjerv:String,
			sokStjeler:String,
			sokSpontant:String,
			appIkkeGodkjent:String,
			appGodkjent:String,
			rappInnkalt:String,
			rappSpont:String,
			premiegrad:String,
			certifikat:String,
			regAv:String,
			regDato:String,
			raseId:String,
			manueltEndretAv:String,
			manueltEndretDato:String
		):void
		function redigerHund(verdier:Object):void 
		function sokArsgjennomsnitt(hund:String, ar:String):void
		function slettJaktprove(jaktproveId:String):void
		function leggInnJaktProve(
		    proveNr:String,
			proveDato:String,
			partiNr:String,
			klasse:String,
			dommerId1:String,
			dommerId2:String,
			hundid:String,
			slippTid:String,
			egneStand:String,
			egneStokk:String,
			tomStand:String,
			makkerStand:String,
			makkerStokk:String,
			jaktlyst:String,
			fart:String,
			stil:String,
			selvstendighet:String,
			bredde:String,
			reviering:String,
			samarbeid:String,
			presUpresis:String,
			presNoeUpresis:String,
			presPresis:String,
			reisNekter:String,
			reisNoelende:String,
			reisVillig:String,
			reisDjerv:String,
			sokStjeler:String,
			sokSpontant:String,
			appIkkeGodkjent:String,
			appGodkjent:String,
			rappInnkalt:String,
			rappSpont:String,
			premiegrad:String,
			certifikat:String,
			regAv:String,
			regDato:String,
			raseId:String,
			manueltEndretAv:String,
			manueltEndretDato:String
		):void
		function visLeggInnJaktproveVindu(parent:DisplayObject):void
		function fjernLeggInnJaktproveVindu():void
		function visRedigerJaktproveVindu(parent:DisplayObject, jaktprove:Object):void
		function fjernRedigerJaktproveVindu():void
	}
}