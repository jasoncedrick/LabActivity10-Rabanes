# Barangay Bulletin – Purok Rabanes

Laravel 12 / SQLite / Blade / Tailwind CSS 4. Lab Activity 10.

## Personalization
- Author: Kagawad Jason Cedrick Rabanes, kagawad.rabanes@bulletin.test.
- 7 posts per page because Rabanes has 7 letters.
- Categories: Announcement, Health, Peace & Order, Ayuda, Education.
- Custom category: Education.
- Pinned post: Purok Rabanes Clean-up Drive.
- Birthday post date: November 23, 2026. The lab asks for the birthday month/day in 2026; the actual birth year is 2004.
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
The first three results should be 5, 51, and 10. Capture your actual Tinker session with Windows Snipping Tool and save it as `docs/tinker.png`. That screenshot is not included because the code has not run in PHP here.

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
- Save your real docs/tinker.png.
- Create public GitHub repository `LabActivity10-Rabanes` and submit its URL on Moodle.
- Do not commit .env, vendor/, node_modules/, or database.sqlite (gitignore covers them).
- Make meaningful commits as you review and change the project; no fabricated commit history is supplied.
- Review and adapt the code so you can explain it. Follow your class rules on acknowledging assistance.

## Validation status
Includes feature tests for counts, personal post data, ordering, pagination, filters, empty results, view counting, and draft/missing-page protection. PHP/Composer execution was unavailable in the preparation environment. Run `php artisan test` locally; these tests have not yet been executed.

Frontend validation: npm install and npm run build completed successfully.
