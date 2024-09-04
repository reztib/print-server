# Print-Server
Webserver, auf dem Dateien hochgeladen werden, die dann mittels CUPS (Common Unix Printing System) gedruckt werden.

## Hinweis
Der Print-Server funktioniert nur, wenn der Drucker schon korrekt unter Linux eingerichtet ist. Am besten vorher mit dem Befehl `lp <druckername> <dateiname>` ausprobieren. 

Sollte der Drucker noch nicht eingerichtet sein, finden sich online genug Anleitungen zum Einrichten des Druckers für jede Distribution. Dieser Server wurde auf Ubuntu getestet.

## Abhängigkeiten
- **CUPS**: `sudo apt-get install cups`
- **Webserver**: Apache (`sudo apt-get install apache2`) oder Nginx (`sudo apt-get install nginx`)
- **PHP**: `sudo apt-get install php php-curl php-xml php-mbstring`

## Einrichtung
Benutzer zur lpadmin-Gruppe für die Druckerverwaltung hinzufügen: `sudo usermod -aG lpadmin $USER`

## Firewall-Einstellungen
Notwendige Ports öffnen:
- `sudo ufw allow 631/tcp` (Internet Printing Protocol)
- `sudo ufw allow 80/tcp` (HTTP)

## Häufige Fehler und Lösungen
Der Apache2-User kann standardmäßig nicht auf die Ordner `uploads` und `error` zugreifen, er muss dafür erst freigeschaltet werden:

`sudo chown -R www-data:www-data /pfad/zum/print-server/uploads`

`sudo chown -R www-data:www-data /pfad/zum/print-server/errors`

Berechtigungen erteilen:

`sudo chmod -R 755 pfad/zum/print-server/uploads`

`sudo chmod -R 755 pfad/zum/print-server/errors`

Diese Befehle ändern den Besitzer der Ordner zu `www-data` und setzen die Berechtigungen so, dass `www-data` vollen Zugriff hat.
