# Print-Server
Webserver, auf dem Dateien hochgeladen werden, die dann mittels CUPS (Common Unix Printing System) gedruckt werden.

## Hinweis
Der Print-Server funktioniert nur, wenn der Drucker schon korrekt unter Linux eingerichtet ist. Am besten vorher mit dem Befehl `lp <druckername> <dateiname>` ausprobieren. 

Sollte der Drucker noch nicht eingerichtet sein, finden sich online genug Anleitungen zum Einrichten des Druckers für jede Distribution. Dieser Server wurde auf Ubuntu getestet.

## Abhängigkeiten
- **CUPS**: `sudo apt-get install cups`
- **Webserver**: Apache (`sudo apt-get install apache2`)
- **PHP**: `sudo apt-get install php php-curl php-xml php-mbstring`

## Einrichtung
1. Benutzer zur lpadmin-Gruppe für die Druckerverwaltung hinzufügen: `sudo usermod -aG lpadmin $USER`

2. Umgebungsvariablen für Nutzername und Passwort setzen
Nutzername und Passwort zum Druckserver müssen in den Einstellungen des apache2-Webservers festgelegt werden.

- `sudo nano /etc/apache2/envvars`
- Am Ende der Datei `export PRINT_SERVER_USERNAME="[Nutzername]"` und `export PRINT_SERVER_PASSWORD="[Passwort]"` hinzufügen
- Den apache2-Webserver mit `sudo systemctl restart apache2` neustarten, damit die Umgebungsvariablen gesetzt werden

(Tipp: `[IP-Adresse des Geräts]/print-server/info.php` aufrufen und dort unter "Environment" nachgucken, ob die Umgebungsvariablen richtig gesetzt wurden. Das Ganze ist der selbe Prozess wie das übliche Anlegen von Umgebungsvariablen unter Linux in `~/.bashrc`, aus Sicherheitsgründen kann apache2 aber nicht auf Umgebungsvariablen auf dem Gerät zugreifen. Aus Sicherheitsgründen gehört die Datei `info.php` danach gelöscht, da sich diese NICHT hinter einem Passwortschutz wie die anderen Seiten befindet)

Hinweis: Beim erstmaligen Drucken werden die Ordner `uploads` und `errors` erstellt. Dort landen die hochgeladenen Dateien zum späteren Wiederverwenden (`uploads`) und die Error-Ausgaben (`errors`) zum Nachvollziehen, was nicht geklappt hat.

## Firewall-Einstellungen
Notwendige Ports öffnen:
- `sudo ufw allow 631/tcp` (Internet Printing Protocol)
- `sudo ufw allow 80/tcp` (HTTP)

## Häufige Fehler und Lösungen
Der apache2-User `www-data` kann standardmäßig nicht auf die Ordner `uploads` und `errors` zugreifen, er muss dafür erst freigeschaltet werden:

`sudo chown -R www-data:www-data /pfad/zum/print-server/uploads`

`sudo chown -R www-data:www-data /pfad/zum/print-server/errors`

Berechtigungen erteilen:

`sudo chmod -R 755 pfad/zum/print-server/uploads`

`sudo chmod -R 755 pfad/zum/print-server/errors`

Diese Befehle ändern den Besitzer der Ordner zu `www-data` und setzen die Berechtigungen so, dass `www-data` vollen Zugriff hat.

## Weitere Arbeiten
- Verwendung dieses Servers auf einem anderen Webserver wie nginx. Ich habe das hier komplett auf meinem RaspberryPi und apache2 ausprobiert, konfiguriert und getestet, hauptsächlich aus Bequemlichkeit. Wenn es jemand hinbekommt, das hier auch auf einem nginx-Server zum laufen zu bekommen, was sich vor allem wegen den Umgebungsvariablen vielleicht als herausfordernd darstellen könnte, würde ich mich über eine Pull-Request freuen!
- Der User muss vor Verwendung des Servers den Drucker komplett selbst eingerichtet haben. Nutzerfreundlicher wäre es, wenn der Server bei erstmaliger Ausführung alles so einrichtet, dass der Server automatisch genutzt werden kann (vielleicht über eine Art install.sh oder so???)
