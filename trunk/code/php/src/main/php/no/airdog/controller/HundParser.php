<?php

$parseString = "323|345453|&15335/4354|Tittel|Hei&HŒHuden|&1212/2323|&213/57213270|1032332303067|Farge M/Svart||||||H|21232123323||||";
		
list($RAID, $KUID, $HUID, $Tittel, $Navn,$HUIDFar,$HUIDMor,$IDNR,$FargeBeskrivelse,$FargeVariant,$AD,
	$HD,$Haarlag,$IDMerk,$Kjoenn,$PEID,$EndretAv,$EndretDato,$RegDato,$Stoerrelse) = split('[|]', $parseString);
	
echo "Rase ID: $RAID<br>" .
		"Kull ID: $KUID<br>" .
		"Hunden ID: $HUID<br>" .
		"Tittel: $Tittel<br>" .
		"Navn: $Navn<br>" .
		"RegNR til far: $HUIDFar<br>" .
		"RegnNR til mor: $HUIDMor<br>" .
		"Intern NKK greier: $IDNR<br>" .
		"Fargen paa hunden: $FargeBeskrivelse<br>" .
		"Mer farge: $FargeVariant<br>" .
		"Oyesykdom $AD<br>" .
		"Hoftesykdom: $HD<br>" .
		"Haarlag: $Haarlag<br>" .
		"ID Merke: $IDMerk<br>" .
		"Kjonn: $Kjoenn<br>" .
		"Eier nokkel: $PEID<br>" .
		"Endret av: $EndretAv<br>" .
		"Endret dato: $EndretDato<br>" .
		"Registrert dato: $RegDato<br>" .
		"Storrelse: $Stoerrelse";
?>