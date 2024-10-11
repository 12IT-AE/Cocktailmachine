# Cocktailmachine


## PHP und Laravel Installieren

### PHP Installieren
1. **PHP herunterladen und installieren:**
    - Führe das folgende PowerShell-Skript aus, um PHP zu installieren:
      ```powershell
      Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows'))
      ```

### Laravel Installieren
1. **Composer installieren:**
    - Besuche die [Composer-Website](https://getcomposer.org/) und lade den Installer herunter.
    - Folge den Anweisungen zur Installation von Composer.

2. **Laravel installieren:**
    - Öffne die Kommandozeile und führe den folgenden Befehl aus, um Laravel global zu installieren:
      ```bash
      composer global require laravel/installer
      ```

3. **Neues Laravel-Projekt erstellen:**
    - Navigiere zu dem Verzeichnis, in dem das neue Projekt erstellt werden soll, und führe den folgenden Befehl aus:
      ```bash
      laravel new project-name
      ```

## XAMPP Installieren und MySQL Server Starten

1. **XAMPP herunterladen und installieren:**
    - Besuche die [XAMPP-Website](https://www.apachefriends.org/index.html).
    - Lade die neueste Version von XAMPP für das Betriebssystem herunter.
    - Führe das Installationsprogramm aus und folge den Anweisungen auf dem Bildschirm.

2. **XAMPP starten:**
    - Öffne das XAMPP Control Panel.
    - Starte den MySQL-Server, indem auf die entsprechenden "Start"-Buttons geklickt wird.

3. **Überprüfen der MySQL-Verbindung:**
    - Öffne den Webbrowser und gehe zu `http://localhost/phpmyadmin`.
    - Stelle sicher, dass auf die phpMyAdmin-Oberfläche zugegriffen werden kann, um die MySQL-Datenbanken zu verwalten.


## Projekt ausführen
1. **Zum Projektverzeichnis navigieren:**
    ```bash
    cd project-name
    ```

2. **Datenbanken migrieren:**
    ```bash
    php artisan migrate:fresh
    ```

3. **Lokalen PHP-Server starten:**
    ```bash
    php artisan serve
    ```
