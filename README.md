# Print-Server
Ein vielseitiger Webserver für Unix-basierte Systeme, der das Hochladen und direkte Drucken von Dateien über CUPS (ehem. Common UNIX Printing System) ermöglicht. Der Server ist ideal für Heimnetzwerke, in denen eine einfache Netzwerkdrucklösung benötigt wird.

## Hinweis
Der Print-Server funktioniert nur, wenn der Drucker bereits unter Linux eingerichtet ist. Teste die Funktionalität mit `lp <druckername> <dateiname>`. Falls der Drucker noch nicht eingerichtet ist, stehen online zahlreiche Anleitungen zur Verfügung. Dieser Server wurde auf Ubuntu und Raspbian OS getestet, sollte aber auf jedem unixoiden Betriebssystem funktionieren. 

## Abhängigkeiten
- **CUPS**: `sudo apt-get install cups`
- **Webserver apache2**: `sudo apt-get install apache2`
- **PHP**: `sudo apt-get install php php-curl php-xml php-mbstring`

## Einrichtung
1. Benutzer zur `lpadmin`-Gruppe hinzufügen, um Druckverwaltungsrechte zu erhalten
```bash
    sudo usermod -aG lpadmin $USER
```

2. Umgebungsvariablen für Nutzername und Passwort setzen

- apache2-Umgebungsvariablen bearbeiten:
```bash
    sudo nano /etc/apache2/envvars
```

- am Ende der Datei hinzufügen:
```bash
    export PRINT_SERVER_USERNAME="[Nutzername]"
    export PRINT_SERVER_PASSWORD="[Passwort]"
```

- apache2 neustarten:
```bash
    sudo systemctl restart apache2
```

(Tipp: ```phpinfo```-Datei erstellen, um zu überprüfen, ob die Umgebungsvariablen richtig gesetzt wurden. Die Datei sollte aus Sicherheitsgründen danach gelöscht werden)

3. Beim ersten Druckauftrag werden die Ordner `uploads` und `errors` erstellt. `uploads` speichert die gedruckten Dokumente, `errors` speichert Fehlerprotokolle zur Diagnose

## Häufige Fehler und Lösungen

### Firewall-Einstellungen
Notwendige Ports öffnen:

**Internet Printing Protocol**: `sudo ufw allow 631/tcp`

**HTTP**: `sudo ufw allow 80/tcp`

### Zugriff auf uploads- und errors-Verzeichnisse
Der apache2-User benötigt Zugriff auf die Verzeichnisse `uploads` und `errors`. Die Berechtigungen müssen wie folgt gesetzt sein:

```bash
    sudo chown -R www-data:www-data /pfad/zum/print-server/uploads
    sudo chown -R www-data:www-data /pfad/zum/print-server/errors
    sudo chmod -R 755 /pfad/zum/print-server/uploads
    sudo chmod -R 755 /pfad/zum/print-server/errors
```

## Weitere Arbeiten
**Unterstützung für andere Webserver**: Derzeit läuft der Server unter Apache auf einem Raspberry Pi. Wenn jemand den Server unter nginx oder einem anderen Webserver zum Laufen bringt, insbesondere mit den Umgebungsvariablen, freue ich mich über Pull Requests!

**Automatische Druckereinrichtung**: Derzeit muss der Nutzer den Drucker vor der Verwendung des Servers selbst einrichten. Ein Installationsskript, das dies automatisiert, wäre eine hilfreiche Ergänzung.