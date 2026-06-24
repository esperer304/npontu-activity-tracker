# Npontu Applications Support — Activity Tracker

A Laravel 12 web application for tracking the daily activities of an applications support team. Built as the take-home assignment for Npontu Technologies' Platforms Developer interview.

> **Brief in one line:** track recurring daily support checks (e.g. *"Daily SMS count in comparison to SMS count from logs"*), let personnel mark them done/pending with a remark, and keep a complete audit trail so shifts can hand work over to each other.

---

## Stack

| Layer | Choice |
|---|---|
| Backend | Laravel 12 · PHP 8.5 |
| Auth | Laravel Breeze (Blade stack) |
| Frontend | Blade · Tailwind CSS · Alpine.js |
| Database | SQLite (default) — swappable to MySQL/PostgreSQL via `.env` |
| Build | Vite |

---

## Quick start

```bash
git clone https://github.com/esperer304/npontu-activity-tracker.git
cd npontu-activity-tracker

composer install
npm install

cp .env.example .env
php artisan key:generate

# Create + seed the SQLite DB
touch database/database.sqlite
php artisan migrate --seed

# Build front-end assets
npm run build

# Start the dev server
php artisan serve
```

Then open **http://127.0.0.1:8000**.

### Test accounts (password for all: `password`)

| Role | Email | Name |
|---|---|---|
| Admin | `admin@npontu.test` | Lona Ayeh |
| Support | `ama@npontu.test` | Ama Boateng |
| Support | `kwame@npontu.test` | Kwame Asare |
| Support | `yaa@npontu.test` | Yaa Mensah |

The seeder also creates 6 realistic activities (SMS reconciliation, payment gateway, USSD, backups, email queue, partner APIs) and ~160 historical updates spread across the last two weeks, so the daily board and reports view have data to show on first boot.

---

## Brief — requirement coverage

| # | Requirement | Where it lives |
|---|---|---|
| 1 | Input activities | `app/Http/Controllers/ActivityController.php` · `resources/views/activities/create.blade.php` |
| 2 | Update status (done/pending) + remark | `app/Http/Controllers/ActivityUpdateController.php` · inline form on every board row |
| 3 | Capture bio + time of updater | `user_id` set from `$request->user()`; `created_at` automatic. Bio fields (`employee_id`, `phone`, `department`, `role`) added in `add_bio_fields_to_users_table` migration |
| 4 | Daily hand-over view | `app/Http/Controllers/DailyBoardController.php` · `resources/views/board/index.blade.php` — per-activity collapsible timeline shows every update logged for the day |
| 5 | Date-range reports | `app/Http/Controllers/ReportController.php` · `index()` paginates filtered results; `export()` streams CSV in 500-row chunks |
| 6 | Authentication | Laravel Breeze + `auth` middleware on every app route. Passwords bcrypt-hashed via the `password => 'hashed'` cast on the User model |

---

## Architecture

### Three tables, three relationships

```
users (extended)         activities                activity_updates
────────────────         ──────────                ─────────────────
id                       id                        id
employee_id              title                     activity_id ──► activities.id
name                     description               user_id     ──► users.id
phone                    created_by ──► users      status      (done | pending)
department               is_active                 remark
role (admin | support)   timestamps                created_at
email + password                                   updated_at
```

- `Activity hasMany ActivityUpdate` plus `hasOne latestUpdate` using `latestOfMany()` — lets the board render "current status" without subqueries or N+1.
- `activity_updates` is an **append-only event log**: every status change is a new row, never an overwrite. This is what makes the audit trail and shift hand-over reliable.

### Request lifecycle — "log a status update"

```
Browser ──POST /activities/{id}/updates──► auth middleware ──► ActivityUpdateController::store
                                                                       │
                                            validate(status, remark)   │
                                                                       ▼
                                                  $activity->updates()->create([
                                                    'user_id' => $request->user()->id,  ← who
                                                    'status'  => $data['status'],
                                                    'remark'  => $data['remark'],
                                                  ])                  ↑ when (automatic)
                                                                       │
                                                        302 back to /board
```

The actor is taken from the session — not from the form — so a user cannot impersonate someone else by tampering with hidden fields.

---

## Non-functional considerations

| Concern | How it's handled |
|---|---|
| **Audit immutability** | `activity_updates` is append-only; no UPDATE or DELETE routes. The full history of every change is permanent. |
| **CSRF** | Laravel's `@csrf` directive on every form; verified by middleware. |
| **Password security** | Bcrypt via the `password => 'hashed'` model cast; never stored or logged in plaintext. |
| **SQL injection** | All queries go through Eloquent / the query builder — parameterised by default. |
| **Input validation** | Every controller method validates via `$request->validate([…])` with explicit rules (enum, max length, exists checks on filter IDs). |
| **N+1 queries** | All index/board/report queries use `with([…])` eager loading. |
| **Hot-path indexes** | `(activity_id, created_at)`, `(user_id, created_at)`, and `created_at` on `activity_updates`. |
| **Memory-safe exports** | CSV export streams via `chunk(500, …)` — won't OOM on multi-month date ranges. |
| **Pagination** | Reports table paginated (25/page); activities list paginated (20/page). |
| **Soft archive** | Deleting an activity flips `is_active=false` so historical reports stay queryable. |

---

## UI

The interface uses Npontu's brand palette (green `#1F7A3A`, yellow `#F5C518`, white) and is organised around three views:

- **Daily board** — today's activities with current status pill, latest remark, who/when, and an expandable per-activity timeline of every update that happened during the day. This is the headline view for shift hand-over.
- **Activities** — master list of recurring checks; admin can create / edit / archive.
- **Reports** — filterable by date range, activity, personnel, and status; with summary stats and CSV export.

### Light / dark mode

Toggle via the sun / moon button in the top bar. Preference is persisted in `localStorage` and applied via a FOUC-safe inline bootstrap script before paint, so there's no white flash on dark-mode reload. Falls back to the OS `prefers-color-scheme` on first visit.

### Mobile responsive

Sidebar collapses to a hamburger-triggered off-canvas drawer below the `lg` breakpoint (1024px). Stat grids reflow from 4 columns → 2 columns, the inline status-update form stacks vertically, and tables in Activities / Reports scroll horizontally to preserve column alignment on narrow viewports.

---

## What's deliberately not in this build (honest scope)

| Out of scope | Why / what you'd do for production |
|---|---|
| Automated tests (PHPUnit / Pest) | Manually verified every flow end-to-end in the browser. For production I'd add feature tests for `ActivityUpdateController::store`, the date-range report query, and the auth gate. |
| Email-sending for password resets | No SMTP configured for the demo; resets land in `storage/logs/`. Set `MAIL_MAILER=smtp` + provider creds for production. |
| Role-based access control gates | The `role` column is on the users table; would add a Gate / Policy to restrict activity create / archive to admins. Kept open for grading convenience. |
| Closed registration | Production version would lock `/register` and have admins invite users via email. |

---

## Submitted by

**Lona Ayeh** — Platforms Developer interview, Npontu Technologies, June 2026.

