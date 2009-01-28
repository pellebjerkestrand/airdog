<?php

$parseString = "" .
		"323" .
		"|" .
		"S122" .
		"|" .
		"&32266/42332074" .
		"|" .
		"2323" .
		"|" .
		"HU233L223232332DE23Hei" .
		"|" .
		"&6236/205" .
		"|" .
		"&622322/5316" .
		"|" .
		"10123334751" .
		"|" .
		"|" .
		"|" .
		"|" .
		"|" .
		"|" .
		"|" .
		"H" .
		"|" .
		"|" .
		"|" .
		"|" .
		"|";
		
list($RAID, $KUID, $HUID, $Tittel, $Navn,$HUIDFar,$HUIDMor,$IDNR,$FargeBeskrivelse,$FargeVariant,$AD,
	$HD,$Haarlag,$IDMerk,$Kjoenn,$PEID,$EndretAv,$EndretDato,$RegDato,$Stoerrelse) = split('[|]', $parseString);

echo "Rase ID: $RAID, Kull ID: $KUID, Hunden ID: $HUID, Tittel: $Tittel, Navn: $Navn, RegNR til far: $HUIDFar, RegnNR til mor: $HUIDMor," .
		"Intern NKK greier: $IDNR, Fargen pŒ hunden: $FargeBeskrivelse, Mer farge: $FargeVariant," .
		"¯yesykdom $AD, Hoftesykdom: $HD, HŒrlag: $Haarlag, ID Merke: $IDMerk, Kj¿nn: $Kjoenn," .
		"Eier n¿kkel: $PEID,  Endret av: $EndretAv, Endret dato: $EndretDato, Registrert dato: $RegDato, St¿rrelse: $Stoerrelse";


?>


<!-- RAID|KUID|HUID|Tittel|Navn|HUIDFar|HUIDMor|IDNR|FargeBeskrivelse|FargeVariant|AD|HD|Haarlag|IDMerk|Kjoenn|PEID|EndretAv|EndretDato|RegDato|Stoerrelse

RAID=Rase id, feks pointer er 348
KUID=kull id 
HUID=hundens id, ogsŒ kalt registreringsnr(regnr)
Tittel=hvilke titler hunden har feks Norsk jakt champion(N JCH)
Navn= Navnet pŒ hunden
HUIDFar=regnr for far
HUIDMor=regnr for mor
IDNR=Litt usikker men jeg tror det er en id kollonne som ikke brukes noe annet enn internt i NKKs applikasjon
FargeBeskrivelse=fargen pŒ hunden, feks hvit m/brune tegninger
FargeVariant=litt av det samme som forrige
AD=er en ¿yesykdom som enkelte tester hunden sin for
HD=er en hoftesykdom som man r¿ntger hunden sin for
Haarlag=selvforklarende, som oftes ikke i bruk for pointer og breton iom rasebeskrivelsen definerer dette
IDMerk=har hunden en id chip/stempel i ¿ret
Kjoenn=hann og tispe
PEID=eier n¿kkel
EndretAv=selvforklarende
EndretDato=selvforklarende
RegDato=selvforklarende
Stoerrelse= aner ikke -->