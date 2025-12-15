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


# Projektstruktur

Projektet är uppdelat för att tydligt separera backend-logik och presentation.

# Git & arbetsflöde

Projektet utvecklas med GitHub och GitHub Desktop med följande branch-struktur:

*  main – stabil version
*  dev – samlingsbranch för färdiga features
* feature/* – en branch per funktion

Varje feature byggs isolerat och mergas in i dev när den är färdig.


