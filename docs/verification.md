# Verification — November 9, 2026

Environment: Windows, PHP 8.4.0, Laravel 12.71.0, SQLite, Node.js 22.16.0. Composer resolves dependencies for PHP 8.2.0; runtime verification used PHP 8.4.0.

## Database

Ran `php artisan migrate`, `php artisan migrate:rollback`, and `php artisan migrate` successfully. All six migration `up()` and `down()` methods completed. Then ran `php artisan db:seed` on the empty tables.

Also ran `php artisan migrate:rollback --step=1` followed by `php artisan migrate` to verify that the separate views-column migration drops and recreates that column independently.

The live Tinker session confirmed:

| Query | Result |
| --- | ---: |
| `Author::count()` | 5 |
| `Post::count()` | 51 |
| `Post::where('is_published', false)->count()` | 10 |

In that same session, `Post::find(1)` loaded a post; its title was prefixed with `Purok Rabanes: `; `save()` returned `true`; and another `find(1)` returned the updated title. See [tinker.png](tinker.png) and [tinker.txt](tinker.txt).

## Automated tests

`php artisan test` passed: **5 tests, 23 assertions**. The suite covers seeded counts and the personal pinned post, seven-post pagination, combined search/category filters, preserved pagination query strings, empty results, view increments, draft and missing-post 404s, and the home redirect.

`composer validate --no-check-publish` passed. Laravel Pint formatted the application, database, route, and test PHP files.

## Frontend and browser

`npm ci` and `npm run build` completed successfully. Browser verification ran against `http://127.0.0.1:8010/posts` in Edge with the production Vite assets.

- The page returned HTTP 200 with the required site title and seven cards.
- The personal pinned post appeared first.
- Searching for `Clean-up` returned the personal post.
- Opening that post displayed its content and increased the counter to 1.
- An unmatched search displayed the required empty-state message.
- At 390px width the page had no horizontal overflow.
- No browser JavaScript errors occurred during those checks.

Screenshots: [desktop](bulletin-desktop.png), [mobile](bulletin-mobile.png).

The SQLite database, application key, dependencies, and compiled frontend assets are local runtime files excluded from version control. Fresh installs recreate them using the README instructions. Faker content varies between fresh seed runs.
