# Möglicher Status für User in "users"

**User können mehrere Status haben**

- `banned`: Nutzer wurde gebannt. Aus der Plattform. Lebenszeit.

- `shadowbanned`: Nutzer wurde von Agenten gemeldet und wird nun (ggf.) von Moderatoren überprüft.

- `temp ban`: Nutzer wurde aufgrund von kleineren Fehlverhalten vorübergehend gerbannt, bis Strafe vorbei ist od. sonstige Aktion erfüllt wurde.

- `approved`: Nutzer ist Mitglied auf Plattform.

- `partner`: **N/A**.

- `verified`: **N/A**.

- `pending`: Nutzer wurde temporär gesperrt, da eine Antwort/Aktion seitens der Organisation von ihm erwartet wird.

- `flagged`: **N/A**.

# Mögliche Fehlernachrichten und Codes, inkl. How-To-Fix [DEV ONLY]

- `Code 0`: Fehler ohne weitere Infos (**nicht triggerbar**)

- `Code 1`: Fehler während des Registrationsprozesses (Mehr Infos jeweils in der beigefügten Fehlernachricht von MySQL)  ---> Fehlercode befolgen, Support kontaktieren

- `Code 2`: Nutzer nicht in Datenbank gefunden ---> Einfach registrieren

- `Code 3`: Nutzer schon registriert.

## Kategorie: Nutzer, Ticket

- `Code C-1`: **N/A**: `shadowbanned`

- `Code C-2`: **N/A** (TEMP)

- `Code C-3`: **N/A** (Status: `in progress`) (TEMP)

- `Code C-4`: **N/A** (Status: `shadowbanned`) (PERM)

- `Code C-5`: **N/A** (Status: `temp ban`) (TEMP)

- `Code C-6`: Nutzer wurde gebannt auf Lebenszeit, aufgrund eines oder mehrerer Regelverstöße. (PERM, IRREVERSIBEL)

- `Code C-7`: Es wird eine Antwort od. Aktion des Nutzers seitens der Organisation erwartet. (TEMP)

- `Code C-8`: Bestätigung konnte nicht geschickt werden. **N**

- `Code C-9`: Channel nicht erkannt oder vorhanden. **N**

- `Code T-1`: Timeout.

- `Code T-2`: Argument ungültig oder nicht gefunden, obwohl required. 

- `Code T-3`: Code (UCP, Ticket) nicht einsehbar oder vorhanden.

- `Code T-4`: Nicht in Datenbank gefunden.

- `Code uK`: Unbekannter Fehler.

# Permissionssystem, Rollensystem

## Rollensystem

**User können mehrere Rollen haben**

### Permanente Rollen (Können auch entzogen werden)

- `approved`: (siehe Status)

- `partner`: **N/A**

- `admin`: Administrator der Organisation

- `moderator`: Moderatoren der Organisation

- `banned`: (siehe Status)

- `user`: regulärer User

- `verified`: **N/A**

- `s_team`: Agent der Organisation

- (?)


# Ticket Status

- `open`: Ticket is offen und wird zurzeit bearbeitet

- `closed`: Ticket wurde bearbeitet und geschlossen