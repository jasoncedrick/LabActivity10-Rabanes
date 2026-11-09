# Barangay Bulletin - Purok Rabanes

Laravel 12 / SQLite / Blade / Tailwind CSS 4. Lab Activity 10.

## Personalization
- Author: Kagawad Jason Cedrick Rabanes, kagawad.rabanes@bulletin.test.
- 7 posts per page because Rabanes has 7 letters.
- Categories: Announcement, Health, Peace & Order, Ayuda, Education.
- Custom category: Education.
- Pinned post: Purok Rabanes Clean-up Drive.
- Birthday post date: November 23, 2026, using the month/day from the supplied project.
- Only is_published controls visibility, as requested in the lab. The birthday post is intentionally visible even before November 23.

## Run on Windows (PowerShell in this project folder)
Install PHP 8.2+ with SQLite extensions, Composer, and Node.js 20.19+ or 22.12+ first.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File -Force
php artisan migrate:fresh --seed
npm install
npm run dev
```
Keep that terminal running. In a second terminal in the same folder:
```powershell
php artisan serve
```
Open http://127.0.0.1:8000/posts.
This is a Laravel application: its entry point is `public/index.php`, not the workspace's blank `index.html`. For Apache/XAMPP, point a virtual host's document root to this project's `public` directory.

For a built frontend without a running Vite development server, run `npm run build`, then `php artisan serve`. The local verification server used port 8010; use `php artisan serve --port=8010` to use that same address.

On macOS/Linux use `cp .env.example .env` and `touch database/database.sqlite` instead of the PowerShell commands.
Keep DB_CONNECTION=sqlite and DB_DATABASE commented out.
`migrate:fresh` deletes existing database tables; use it for this lab database only.

## Verify migrations and features
```powershell
php artisan migrate:rollback
php artisan migrate
php artisan db:seed
php artisan test
```
After the initial fresh migration, rollback reverses that migration batch, including the separate views migration. Seeding afterward restores the demo data.
To test just the last (views) migration instead, run `php artisan migrate:rollback --step=1`, then `php artisan migrate`; no reseed is needed for that sequence.

## Required Tinker screenshot
```powershell
php artisan tinker
```
Run these lines inside Tinker (do not include prompt arrows):
```php
App\Models\Author::count();
App\Models\Post::count();
App\Models\Post::where('is_published', false)->count();
$post = App\Models\Post::find(1);
$post->title = 'Purok Rabanes: ' . $post->title;
$post->save();
App\Models\Post::find(1)->title;
```
The first three results are 5, 51, and 10. [docs/tinker.png](docs/tinker.png) captures a live Tinker terminal session showing those counts, `find(1)`, a title change, `save()` returning true, and the title loaded again from SQLite. [docs/tinker.txt](docs/tinker.txt) contains the captured terminal text. Running the title-change command again adds another prefix; fresh seeding resets it.

## Files to understand for lab defense
- migrations: up creates/changes tables; down reverses the change. Authors must exist before the posts foreign key.
- models: $fillable permits mass assignment; casts turn stored values into booleans/dates.
- factories: fake() generates data; draft() changes publication fields.
- seeders: create the personal author, four factory authors, forty published posts, ten drafts, and one personal pinned post.
- PostController@index: conditional query filters, pinned-first sorting, seven-row pagination, and retained query strings.
- PostController@show: findOrFail, draft protection, and views saved with save().
- Blade views: escaped output, filter form, cards, empty state, and Tailwind pagination.

## Submission checklist
- Run the commands above and inspect search, category filtering, page 2, post details, and draft 404s.
- Review the included `docs/tinker.png` and repeat the Tinker steps for practice.
- Repository: https://github.com/jasoncedrick/LabActivity10-Rabanes. Submit this URL on Moodle.
- Do not commit .env, vendor/, node_modules/, or database.sqlite (gitignore covers them).
- The commit history records the supplied project import, local setup, and verification evidence.
- Review and adapt the code so you can explain it. Follow your class rules on acknowledging assistance.

## Validation status
Verified locally on November 9, 2026 with PHP 8.4, Laravel 12, SQLite, and Node.js 22.16. The Composer lock file resolves against PHP 8.2 for compatibility with the lab's minimum version.

- `php artisan test`: **5 passed, 23 assertions**.
- Full migration rollback and re-migration passed; the separate views migration also rolled back and reapplied successfully.
- `npm ci` and `npm run build`: passed.
- `composer validate`: passed.
- Browser checks: seven cards per page, pinned post first, title search, detail page, view increment, empty results, and a 390px mobile layout without horizontal overflow.

See [docs/verification.md](docs/verification.md) for the evidence and [desktop preview](docs/bulletin-desktop.png).

## Development notes

Started from the supplied `LabActivity10-Rabanes.zip`. Codex assisted with local setup, dependency compatibility, formatting, verification, evidence capture, and documentation. The personalized details were retained from that archive.
