# Lab evidence

- [tinker.png](tinker.png): screenshot of a live Laravel Tinker session.
- [tinker.txt](tinker.txt): terminal text from that same session.
- [bulletin-desktop.png](bulletin-desktop.png): desktop bulletin view.
- [bulletin-mobile.png](bulletin-mobile.png): mobile bulletin view at 390px wide.
- [verification.md](verification.md): commands run and observed results.

The Tinker screenshot was captured from an xterm.js terminal connected through a Windows pseudoterminal to the actual `php artisan tinker --no-ansi` process. Commands were entered into one running session against the local SQLite database. Its output was not manually recreated. The displayed title change was saved to the database.
