# Cocktailmachine


## PHP Installieren
[https://php.new/](https://php.new/)
- ` Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows')) `

## Auführung
- `cd Frontend` (Navigieren zum Frontend Ordner)
- `php artisan migrate:fresh`  (um Datenbanken zu löschen und neu auf zu setzen)
- `php artisan serve` (Lokal PHP Server starten)
