# MVJMHS Journal — Full Documentation

Complete guide for **Open Journal Systems (OJS) 3.5.0-5** used by the **MVJMHS Journal**.

Live domain: **https://mvjmhs.com**  
Contact email (all system mail): **info@mvjmhs.com**  
Editorial office: **229, Green Road, Dhanmondi, Dhaka-1205, Bangladesh**

---

## Table of contents

1. [Project overview](#1-project-overview)
2. [Local XAMPP (development)](#2-local-xampp-development)
3. [Production hosting layout](#3-production-hosting-layout)
4. [Hosting requirements](#4-hosting-requirements)
5. [Database](#5-database)
6. [config.inc.php (production)](#6-configincphp-production)
7. [Homepage at https://mvjmhs.com/ (pretty URLs)](#7-homepage-at-httpsmvjmhscom-pretty-urls)
8. [Domain email (SMTP)](#8-domain-email-smtp)
9. [Upload and go live](#9-upload-and-go-live)
10. [Permissions](#10-permissions)
11. [Admin access](#11-admin-access)
12. [Git and .gitignore](#12-git-and-gitignore)
13. [HTTP 500 troubleshooting](#13-http-500-troubleshooting)
14. [After go-live checklist](#14-after-go-live-checklist)
15. [Common problems](#15-common-problems)
16. [Files in this project](#16-files-in-this-project)

---

## 1. Project overview

| Item | Value |
|------|--------|
| Application | Open Journal Systems (OJS) |
| Version | 3.5.0-5 (LTS) |
| Journal name | MVJMHS |
| Journal path (internal) | `mvjmhs` |
| Public homepage | `https://mvjmhs.com/` |
| Time zone | Asia/Dhaka |
| Local folder | `C:\xampp_82\htdocs\veh\ojs\ojs-3.5.0-5` |
| Local files dir | `C:\xampp_82\files\ojs` |
| Hosting document root | `public_html` (main domain `mvjmhs.com`, not redirected) |

OJS stores the journal as path `mvjmhs`. By default that becomes:

`https://mvjmhs.com/index.php/mvjmhs/index`

Production is configured so visitors use only:

**https://mvjmhs.com/**

---

## 2. Local XAMPP (development)

### 2.1 Requirements (already used on this PC)

- XAMPP with **PHP 8.2**
- MySQL/MariaDB running
- Database name: `ojs`
- User: `root` (no password)

### 2.2 Local URLs

| Page | URL |
|------|-----|
| Site root | http://localhost/veh/ojs/ojs-3.5.0-5/ |
| Journal | http://localhost/veh/ojs/ojs-3.5.0-5/index.php/mvjmhs |
| Login | http://localhost/veh/ojs/ojs-3.5.0-5/index.php/index/login |

### 2.3 Local `config.inc.php` (do not upload this file)

These values are for XAMPP only:

```ini
installed = On
base_url = "http://localhost/veh/ojs/ojs-3.5.0-5"
allowed_hosts = '["localhost"]'
restful_urls = Off

[database]
host = localhost
username = root
password =
name = ojs

[files]
files_dir = "C:/xampp_82/files/ojs"

[email]
default = log
```

Local email is **logged**, not sent. Production uses SMTP (see section 8).

### 2.4 Export database before deploy

```powershell
C:\xampp_82\mysql\bin\mysqldump.exe -u root ojs > C:\xampp_82\tmp\ojs_mvjmhs_backup.sql
```

Import that SQL file into the hosting database with phpMyAdmin.

---

## 3. Production hosting layout

cPanel domain mapping:

| Domain | Type | Document root |
|--------|------|----------------|
| mvjmhs.com | Main domain | `/public_html` |
| Redirect | Off | — |

**Correct live layout:**

```text
/home/mvjmhs/                    ← cPanel home (confirm name in File Manager)
└── public_html/                 ← https://mvjmhs.com/
    ├── index.php
    ├── config.inc.php           ← production config only (must be named exactly this)
    ├── .htaccess                ← from .htaccess.production
    ├── lib/
    ├── plugins/
    ├── cache/                   ← writable
    ├── public/                  ← writable
    ├── files/                   ← writable private uploads
    │   └── .htaccess            ← Deny from all
    └── ...
```

Rules:

- Put OJS **inside `public_html`**, not inside a folder named `ojs-3.5.0-5`.
- Never leave `config.inc.php.production` in `public_html`. That file is downloaded as plain text and exposes passwords.
- In File Manager, copy the **full path** from the top bar. If home is not `mvjmhs`, change `files_dir` to match.

Example `files_dir`:

```ini
files_dir = /home/mvjmhs/public_html/files
```

---

## 4. Hosting requirements

### PHP

- Use **PHP 8.2 or 8.3**
- Do **not** use PHP **8.4** (this host was seen running 8.4.23 and returning HTTP 500)
- Memory: 512M or higher
- Upload size: 64M or higher

cPanel: **MultiPHP Manager** → `mvjmhs.com` → PHP 8.2 or 8.3 → Apply.

### PHP extensions

Enable:

`mysqli`, `pdo_mysql`, `gd`, `intl`, `mbstring`, `xml`, `zip`, `curl`, `openssl`, `bcmath`, `fileinfo`, `dom`, `iconv`, `json`

### Database

- MySQL 5.7.22+ or MariaDB 10.3+

### SSL

Enable Let’s Encrypt (or equivalent) for:

- `mvjmhs.com`
- `www.mvjmhs.com`

Then set `force_ssl = On` in `config.inc.php`.

---

## 5. Database

### Hosting database (cPanel)

| Setting | Value |
|---------|--------|
| Host | `localhost` |
| Database name | `mvjmhs_veh_database` |
| Username | `mvjmhs_veh_database` |
| Password | (cPanel password; keep quoted in config) |

In `config.inc.php` the password **must be in double quotes** because it contains `]`, `}`, and `&`:

```ini
[database]
driver = mysqli
host = localhost
username = mvjmhs_veh_database
password = "YOUR_DB_PASSWORD"
name = mvjmhs_veh_database
```

User must have **ALL PRIVILEGES** on that database.

### Import

1. cPanel → phpMyAdmin  
2. Select `mvjmhs_veh_database`  
3. Import `ojs_mvjmhs_backup.sql`

### Journal rows (already in local DB)

- `journals.path` = `mvjmhs`
- Journal name = `MVJMHS`
- Contact email = `info@mvjmhs.com`
- Site contact = `info@mvjmhs.com`

If you change the journal path in the database, you must also change `base_url[mvjmhs]` in config.

---

## 6. config.inc.php (production)

Ready file in this project:

`ojs-3.5.0-5/config.inc.php.production`

**On the server it must be named `config.inc.php`.**

### 6.1 Required production values

```ini
[general]
app_key = "base64:aRTQJj2FHnTOD+PNRFKMJbYwS7B5XvFY9TDTBRK2KyM="
installed = On
base_url = "https://mvjmhs.com"
base_url[index] = https://mvjmhs.com/index
base_url[mvjmhs] = https://mvjmhs.com
restful_urls = On
allowed_hosts = '["mvjmhs.com", "www.mvjmhs.com"]'
time_zone = Asia/Dhaka

[database]
driver = mysqli
host = localhost
username = mvjmhs_veh_database
password = "YOUR_DB_PASSWORD"
name = mvjmhs_veh_database

[files]
files_dir = /home/mvjmhs/public_html/files
public_files_dir = public

[security]
force_ssl = On

[email]
default = smtp
smtp = On
smtp_server = mail.mvjmhs.com
smtp_port = 587
smtp_auth = tls
smtp_username = info@mvjmhs.com
smtp_password = YOUR_MAILBOX_PASSWORD
allow_envelope_sender = On
default_envelope_sender = info@mvjmhs.com
force_default_envelope_sender = On
force_dmarc_compliant_from = On
dmarc_compliant_from_displayname = 'MVJMHS Journal'
```

Keep the same `app_key` as the local install. Do not generate a new key after importing the database.

### 6.2 After the site works

In `[debug]` set:

```ini
show_stacktrace = Off
display_errors = Off
```

Leave them **On** only while fixing a 500 error.

---

## 7. Homepage at https://mvjmhs.com/ (pretty URLs)

### Why OJS used `/index.php/mvjmhs/index`

OJS always identifies a journal by **path** (`mvjmhs`). Without extra settings, every journal URL includes that path and `index.php`.

### How the public URL becomes the domain only

Three settings together:

1. **`base_url[mvjmhs] = https://mvjmhs.com`**  
   Journal pages are generated at the domain root, not under `/mvjmhs`.

2. **`base_url[index] = https://mvjmhs.com/index`**  
   Site-level pages (multi-journal admin) stay under `/index`.

3. **`restful_urls = On` plus `.htaccess`**  
   Removes `index.php` from URLs.

### `.htaccess`

Project file: `ojs-3.5.0-5/.htaccess.production`

Upload to `public_html` and **rename to `.htaccess`**.

It:

- Rewrites all non-file requests to `index.php`
- Redirects old URLs to `/`:
  - `/index.php/mvjmhs`
  - `/index.php/mvjmhs/index`
  - `/mvjmhs`
  - `/mvjmhs/index`

**Do not use this `.htaccess` on local XAMPP.** Local OJS is in a subfolder; `RewriteBase /` would break localhost.

### Live URLs (after this setup)

| Page | URL |
|------|-----|
| Homepage | https://mvjmhs.com/ |
| Author guidelines | https://mvjmhs.com/about/submissions |
| Register | https://mvjmhs.com/user/register |
| Login (journal) | https://mvjmhs.com/login |
| Site admin login | https://mvjmhs.com/index/login |
| Current issue | https://mvjmhs.com/issue/current |

If rewrite is off, OJS still works with:

`https://mvjmhs.com/index.php/mvjmhs`

---

## 8. Domain email (SMTP)

Use **one mailbox everywhere**: `info@mvjmhs.com`

### 8.1 Create the mailbox

cPanel → **Email Accounts** → create `info@mvjmhs.com`.

Typical SMTP:

| Setting | Value |
|---------|--------|
| Server | `mail.mvjmhs.com` |
| Port | `587` |
| Encryption | TLS |
| Username | `info@mvjmhs.com` |
| Password | mailbox password |

If 587 fails, try port `465` and `smtp_auth = ssl`.

### 8.2 OJS config

See the `[email]` block in section 6.

Log in to **webmail** first to confirm the mailbox password works.

### 8.3 Addresses already set in the database (local)

- Admin user email: `info@mvjmhs.com`
- Site contact email: `info@mvjmhs.com`
- Journal contact email: `info@mvjmhs.com`

After import, confirm in:

**Settings → Journal → Contact**  
**Website → Appearance** (homepage contact block)

---

## 9. Upload and go live

Do these in order.

1. Set PHP to **8.2 or 8.3** for `mvjmhs.com`.
2. Enable SSL for `mvjmhs.com` and `www`.
3. Create MySQL database/user and import SQL.
4. Upload **all OJS files** into `public_html` (contents of `ojs-3.5.0-5`, not the parent `veh/ojs` folder).
5. Create `public_html/files` and upload `files/.htaccess`.
6. Upload `config.inc.php.production` → rename to **`config.inc.php`**.  
   Delete any leftover `config.inc.php.production`.
7. Upload `.htaccess.production` → rename to **`.htaccess`**.
8. Set folder permissions (section 10).
9. Put the mailbox password in `[email] smtp_password`.
10. Open https://mvjmhs.com/
11. Log in and change the admin password.
12. Turn `display_errors` Off when the site is stable.

Copy uploaded files from local `C:\xampp_82\files\ojs` into `public_html/files` if you have submissions or public files.

---

## 10. Permissions

| Path | Permission |
|------|------------|
| `public_html/cache/` | 755 or 775 |
| `public_html/public/` | 755 or 775 |
| `public_html/files/` | 755 or 775 |
| `config.inc.php` | 644 |

If uploads fail, ask the host to confirm the web user can write those folders.

Clear cache after config changes: delete files **inside** `cache/` (keep the folders).

---

## 11. Admin access

| Item | Value |
|------|--------|
| Username | `admin` |
| Default password | `admin123` — **change immediately on live** |
| Email | `info@mvjmhs.com` |

Change password: **User → Profile → Password** after login.

---

## 12. Git and .gitignore

GitHub remote used during setup: `https://github.com/mdshiabulcse/veh_ojs.git`

Local branch was `master`. Push with:

```bash
git push -u origin master
```

If you need `main`:

```bash
git branch -m master main
git push -u origin main
```

**Never commit:**

- `config.inc.php`
- `config.inc.php.production` (contains DB password)
- `*.sql` dumps
- `cache/` generated files
- `public/journals/` uploads

`.gitignore` is already set in `ojs-3.5.0-5/.gitignore`.

If `config.inc.php.production` was ever public on the domain, **change the MySQL password** in cPanel and update `config.inc.php`.

---

## 13. HTTP 500 troubleshooting

A blank **HTTP 500** on https://mvjmhs.com/ is almost always one of these.

### 13.1 PHP 8.4

Headers showed `X-Powered-By: PHP/8.4.23`. Switch to **8.2 or 8.3**.

### 13.2 Wrong config file name

OJS reads only `config.inc.php`.

If you upload `config.inc.php.production` and leave the old file, the site still uses XAMPP settings (`localhost`, Windows `files_dir`) and crashes.

Also, `.production` is **not** executed as PHP, so the file can be **downloaded** with the database password.

### 13.3 allowed_hosts

Must include the real host:

```ini
allowed_hosts = '["mvjmhs.com", "www.mvjmhs.com"]'
```

Error log line: `Server host "mvjmhs.com" not allowed!`

### 13.4 files_dir

Path must exist and be writable. Use the path from File Manager, for example:

`/home/mvjmhs/public_html/files`

### 13.5 Database

Wrong user/password, or password not quoted, causes a 500.

### 13.6 See the real error

Temporarily:

```ini
[debug]
show_stacktrace = On
display_errors = On
```

Or cPanel → **Errors** / `public_html/error_log`.

---

## 14. After go-live checklist

- [ ] https://mvjmhs.com/ opens (not a 500)
- [ ] Address bar stays on `https://mvjmhs.com/` for the homepage
- [ ] CSS/theme loads
- [ ] Old URL `/index.php/mvjmhs/index` redirects to `/`
- [ ] Admin password changed
- [ ] `info@mvjmhs.com` mailbox exists and SMTP password is set
- [ ] Test registration or password-reset email
- [ ] `display_errors = Off`
- [ ] `config.inc.php.production` deleted from `public_html`
- [ ] `files/` is not listable in the browser

---

## 15. Common problems

| Problem | Fix |
|---------|-----|
| Homepage still `/index.php/mvjmhs/index` | Set `restful_urls = On`, `base_url[mvjmhs]`, upload `.htaccess` |
| Redirect loop | Enable SSL first, then `force_ssl = On` |
| Page has no CSS | Enable default theme; clear `cache/` |
| Emails not sending | Use SMTP + `info@mvjmhs.com`; test webmail login |
| Upload errors | Check `files_dir` and folder permissions |
| Buttons go to `/dashboard` | Do not use root-relative `/index.php/...` on localhost; on live use `https://mvjmhs.com/about/submissions` |
| Git `src refspec main does not match any` | Branch is `master` → `git push -u origin master` |

---

## 16. Files in this project

| File | Purpose |
|------|---------|
| `ojs-3.5.0-5/` | OJS application |
| `ojs-3.5.0-5/config.inc.php` | Local XAMPP config (do not deploy) |
| `ojs-3.5.0-5/config.inc.php.production` | Live config template → rename to `config.inc.php` on server |
| `ojs-3.5.0-5/.htaccess.production` | Live rewrite rules → rename to `.htaccess` on server |
| `ojs-3.5.0-5/files/.htaccess` | Block web access to uploads |
| `ojs-3.5.0-5/.gitignore` | Ignore secrets, cache, SQL |
| `MVJMHS-OJS-DOCUMENTATION.md` | This document |
| `HOSTING-DEPLOYMENT-MVJMHS.md` | Shorter hosting notes (see this file for the full guide) |

---

## Quick production snippet

```ini
base_url = "https://mvjmhs.com"
base_url[index] = https://mvjmhs.com/index
base_url[mvjmhs] = https://mvjmhs.com
restful_urls = On
allowed_hosts = '["mvjmhs.com", "www.mvjmhs.com"]'
files_dir = /home/mvjmhs/public_html/files
force_ssl = On
```

Homepage visitors should only need:

**https://mvjmhs.com/**
