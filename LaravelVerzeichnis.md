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

### Weitere Verzeichnisse (werden bei Bedarf erstellt)

- **Broadcasting**: Beinhaltet alle Broadcast-Kanalklassen.
- **Console**: Enthält benutzerdefinierte Artisan-Befehle.
- **Events**: Beinhaltet Event-Klassen.
- **Exceptions**: Enthält benutzerdefinierte Ausnahmen.
- **Jobs**: Beinhaltet queuebare Jobs der Anwendung.
- **Listeners**: Enthält Klassen, die Events verarbeiten.
- **Mail**: Beinhaltet Mail-Klassen für E-Mails.
- **Notifications**: Enthält alle "transaktionalen" Benachrichtigungen.
- **Policies**: Beinhaltet Autorisierungsrichtlinienklassen.
- **Rules**: Enthält benutzerdefinierte Validierungsregeln.
