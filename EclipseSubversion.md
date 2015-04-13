#Eclipse og Subversion oppsett

## Subversion ##
En nødvendighet til prosjektet er en subversion klient. Varierende om hvilken maskin du bruker så er det forskjellige produkt på hjemmesiden til subversion http://subversion.tigris.org/
Anbefaler TortoiseSVN, Subclipse og SilkSvn for Windows.
SilkSvn eller lignende er nødvendig for senere når dere skal lage releaser for forskjellige versjoner samt at du enkelt kan sjekke ut prosjektet via kommandoprompten.

## Sjekke ut prosjektet ##
Stå i katalogen du bruker som kildekodemappe for dine forskjellige prosjekt og kjør en av disse kommandoene:
### Medlemmer ###
svn checkout https://airdog.googlecode.com/svn/ airdog --username your\_name
### Read-only ###
svn checkout http://airdog.googlecode.com/svn/trunk/ airdog-read-only

## Flexprosjektet ##

I motsetning til java så har ikke flex en hendig liten mvn eclipse:eclipse som kan kjøres for å sette opp prosjektet med alle filene. En grunn til at en ikke sjekker inn typiske prosjektfiler som .project, .actionScriptProperties og .flexProperties er at disse ofte inneholder fullstendige stier til baner som er forskjellige fra utvikler til utvikler. Kanskje liker noen å jobbe i linux, andre i mac, noen legger filene på C disken, mens andre på D osv, osv. Dette er ikke så farlig i begynnelsen av et prosjekt, men det tar ikke lange tiden før man har lyst til å refere til et swc bibliotek eller annet prosjekt.

### Alternativ måte ###
Ettersom prosjektet ikke har kommet godt igang enda og ikke har noen avhengigheter kan dette være enkleste måte å sette opp prosjektet på.
  1. Sjekk ut prosjektet (se over)
  1. Kopier hele innholdet i eclipse\_filer ut til code/flex folderen
  1. Nå kan prosjektet importeres i Eclipse via File==>Import

### Standardmåten ###

Standarden er å opprette et nytt prosjekt:
  1. **New Flex Project** fra Eclipse
  1. Under **project location** fylle inn stien flexprosjektet(...airdog\trunk\code\flex)
  1. Gi det ett navn (Airdog)
  1. Main source folder = src\main\flex
  1. Main application file = mainAirdog.mxml