## Laravel Ordnerstruktur

- **Root-Verzeichnis**
  - `app`: Enthält den Kerncode der Anwendung.
  - `bootstrap`: Beinhaltet die `app.php`, die das Framework initialisiert, sowie einen `cache`-Ordner für optimierte Performance.
  - `config`: Alle Konfigurationsdateien der Anwendung.
  - `database`: Beinhaltet Datenbankmigrationen, Modellfabriken und Seeds.
  - `public`: Enthält die `index.php`, den Einstiegspunkt für alle Anfragen, sowie Assets wie Bilder, JavaScript und CSS.
  - `resources`: Beinhaltet Views und unkompilierte Assets wie CSS oder JavaScript.
  - `routes`: Enthält alle Routen-Definitionen der Anwendung (z.B. `web.php`, `api.php`).
  - `storage`: Beinhaltet Logs, kompilierte Blade-Templates, Dateibasierte Sessions und Caches.
  - `tests`: Enthält automatisierte Tests (z.B. PHPUnit-Tests).
  - `vendor`: Beinhaltet Composer-Abhängigkeiten.

### App-Verzeichnis

- **Http**: Enthält Controller, Middleware und Anfragen.
- **Models**: Beinhaltet alle Eloquent-Modellklassen.
- **Providers**: Beinhaltet alle Service-Provider der Anwendung.