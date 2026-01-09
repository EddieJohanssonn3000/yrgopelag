# Yrgopelag Hotel Project

Detta projekt är ett skolprojekt inom kurserna Programmering och Datakällor. Syftet är att bygga ett webbprojekt i PHP som efterliknar ett hotell i världen *Yrgopelag*, där besökare kan boka rum under ett givet datumintervall och hotellet kommunicerar med en extern Centralbank-API.

Fokus i projektet ligger på fungerande backend-logik, korrekt databashantering och tydlig kodstruktur snarare än avancerad design.

# Projektets mål

* Skapa ett hotell med tre rum (budget, standard, luxury)
* Möjliggöra bokning av rum för specifika datum (januari 2026)
* Integrera med Yrgopelags centralbank (API)
* Spara bokningar i en SQL-databas
* Visa bokningsresultat för användaren
* Följa givna regler kring features, stjärnor och bokningsflöde

# Centralbank-API

Projektet kommunicerar med Yrgopelags Centralbank via ett REST-API för att:

* Validera betalning (deposit)
* Skapa kvitto (receipt) för genomförda bokningar

Vid skapande av receipt skickas endast följande data för valda tillval (features):

* activity (t.ex. water, games, wheels, hotel-specific)
* tier (economy, basic, premium, superior)

API:t validerar features baserat på activity + tier, och projektet använder konsekvent dessa värden utan extra speciallogik i backend.

# Features & tillval

Användaren kan välja tillval (features) uppdelade i olika kategorier såsom water, games, wheels och hotel-specific.
Varje feature har en tier som påverkar priset.

Alla tillval skickas till Centralbank-API:t som:
{ activity, tier }
enligt API:ts datamodell.


# Projektstruktur

# Daniella’s feedback – great job! These are just some improvement suggestions.

CSS is really good but you could improve and save the colors in variables.

The room images and information could be stored in an array and generated dynamically, which would make the code more maintainable and easier to update.

The layout works well, but the semantic structure could be improved by replacing div elements with more meaningful HTML elements such as article, figure, and header, which would improve accessibility and content structure.

JavaScript could be used to connect the room categories in the navbar with the corresponding room sections on the page, so that clicking a room link (for example “Budget Room”) scrolls the user to the correct room information.
       
It could be an improvement to make the star rating dynamic instead of hardcoded, allowing it to be updated more easily.

I see some error messages on Swedish, maybe use same language through the hole code ex. ($errors[] = 'Utcheckningsdatum måste vara efter incheckningsdatum.’;)

To be safe and protected of your database I would recommend you to store your database file in .gitignore.

Projektet är uppdelat för att tydligt separera backend-logik och presentation.

# Git & arbetsflöde

Projektet utvecklas med GitHub och GitHub Desktop med följande branch-struktur:

*  main – stabil version
*  dev – samlingsbranch för färdiga features
* feature/* – en branch per funktion

Varje feature byggs isolerat och mergas in i dev när den är färdig.


