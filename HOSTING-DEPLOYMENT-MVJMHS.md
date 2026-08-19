# MVJMHS OJS Hosting Deployment Guide

This document explains how to deploy **Open Journal Systems (OJS) 3.5.0-5** from your local XAMPP setup to a live hosting panel for the domain:

**https://mvjmhs.com**

Journal name: **MVJMHS**  
Journal path: **mvjmhs**

---

## 1. Project Summary

| Item | Value |
|------|-------|
| Application | Open Journal Systems (OJS) |
| Version | 3.5.0-5 |
| Required PHP | 8.2 or higher |
| Database | MySQL 5.7+ / MariaDB 10.3+ |
| Local project folder | `C:\xampp_82\htdocs\veh\ojs\ojs-3.5.0-5` |
| Local uploaded files | `C:\xampp_82\files\ojs` |
| Live domain | `mvjmhs.com` |
| Live journal URL | `https://mvjmhs.com/index.php/mvjmhs` |
| Admin login path | `https://mvjmhs.com/index.php/index/login` |

---

## 2. Hosting Requirements

Before uploading, confirm these in your hosting panel (cPanel, DirectAdmin, Plesk, etc.):

### PHP

- PHP **8.2+**
- Memory limit: **512M** or higher
- Upload limit: **64M** or higher

### Required PHP extensions

Enable all of these:

- `mysqli`
- `pdo_mysql`
- `gd`
- `intl`
- `mbstring`
- `xml`
- `zip`
- `curl`
- `openssl`
- `bcmath`
- `fileinfo`

### MySQL

- MySQL **5.7.22+** or MariaDB **10.3+**
- One empty database
- One database user with full privileges

### SSL

- Enable **Let's Encrypt SSL** for:
  - `mvjmhs.com`
  - `www.mvjmhs.com`

---

## 3. Recommended Server Folder Structure

Use this layout on the hosting server:

```text
/home/youruser/
├── public_html/                 ← Domain document root
│   ├── index.php
│   ├── config.inc.php
│   ├── lib/
│   ├── plugins/
│   ├── cache/
│   ├── public/
│   └── ...
└── ojs_files/                   ← Private upload folder (outside public_html)
```

Important:

- Upload OJS files directly into `public_html`
- Do **not** keep the local folder name `ojs-3.5.0-5` on production unless you want a long URL
- The `files_dir` folder must stay **outside** `public_html`

---

## 4. Export from Local XAMPP

### 4.1 Export database

Run this on your Windows PC:

```powershell
C:\xampp_82\mysql\bin\mysqldump.exe -u root ojs > C:\xampp_82\tmp\ojs_mvjmhs_backup.sql
```

This creates a database backup file:

`C:\xampp_82\tmp\ojs_mvjmhs_backup.sql`

### 4.2 Prepare files to upload

Upload these from local machine:

1. **OJS application files**
   - Source: `C:\xampp_82\htdocs\veh\ojs\ojs-3.5.0-5\`
   - Destination: `/home/youruser/public_html/`

2. **Uploaded/private files**
   - Source: `C:\xampp_82\files\ojs\`
   - Destination: `/home/youruser/ojs_files/`

### 4.3 Create upload zip (optional)

If File Manager upload is easier:

1. Zip the folder `ojs-3.5.0-5`
2. Upload zip to `public_html`
3. Extract inside `public_html`

After extraction, make sure this file exists:

`/home/youruser/public_html/index.php`

---

## 5. Create Database in Hosting Panel

In hosting panel:

1. Open **MySQL Databases**
2. Create database, example:
   - Database name: `youruser_mvjmhs`
3. Create user, example:
   - Username: `youruser_mvjmhs`
   - Password: strong password
4. Add user to database with **ALL PRIVILEGES**

Save these details:

| Setting | Example |
|---------|---------|
| DB Host | `localhost` |
| DB Name | `youruser_mvjmhs` |
| DB User | `youruser_mvjmhs` |
| DB Password | `YourStrongPassword` |

### Import database

1. Open **phpMyAdmin**
2. Select the new database
3. Click **Import**
4. Upload `ojs_mvjmhs_backup.sql`
5. Run import

---

## 6. Configure Domain in Hosting Panel

### 6.1 Point domain to hosting

At your domain registrar, set DNS to your hosting server:

| Type | Name | Value |
|------|------|-------|
| A | `@` | Hosting server IP |
| A or CNAME | `www` | Hosting server IP or `mvjmhs.com` |

### 6.2 Set document root

In hosting panel:

- Domain: `mvjmhs.com`
- Document root: `public_html`

### 6.3 Enable SSL

In hosting panel:

1. Open **SSL/TLS** or **Let's Encrypt**
2. Issue certificate for:
   - `mvjmhs.com`
   - `www.mvjmhs.com`
3. Enable **Force HTTPS** if available

---

## 7. Update `config.inc.php` on Server

Before editing, backup the live file:

```text
config.inc.php.bak
```

Then edit `/home/youruser/public_html/config.inc.php`.

### 7.1 General settings

```ini
[general]
app_key = "KEEP_YOUR_EXISTING_APP_KEY"
installed = On
base_url = "https://mvjmhs.com"
allowed_hosts = '["mvjmhs.com", "www.mvjmhs.com"]'
time_zone = "Asia/Dhaka"
restful_urls = Off
enable_beacon = Off
```

Important:

- Keep the existing `app_key` value from your local install
- Do not generate a new `app_key` after importing the database

### 7.2 Database settings

```ini
[database]
driver = mysqli
host = localhost
username = youruser_mvjmhs
password = YourStrongPassword
name = youruser_mvjmhs
debug = Off
```

Replace with your real hosting database credentials.

### 7.3 File settings

```ini
[files]
files_dir = /home/youruser/ojs_files
public_files_dir = public
```

Replace `youruser` with your actual hosting username.

Example on Linux hosting:

```ini
files_dir = /home/mvjmhs/ojs_files
```

### 7.4 Security settings

```ini
[security]
force_ssl = On
session_check_ip = On
salt = "KEEP_YOUR_EXISTING_SALT"
```

Enable `force_ssl = On` only after SSL certificate is active.

---

## 8. Configure Domain Email (SMTP)

OJS should send mail through your domain email, not the local `log` mode.

Recommended domain mail examples:

- `info@mvjmhs.com`
- `editor@mvjmhs.com`
- `support@mvjmhs.com`

### 8.1 Create email account in hosting panel

In hosting panel:

1. Open **Email Accounts**
2. Create mailbox, for example:
   - Email: `info@mvjmhs.com`
   - Password: strong mailbox password
3. Note SMTP details from hosting provider

Typical cPanel SMTP values:

| Setting | Common value |
|---------|--------------|
| SMTP server | `mail.mvjmhs.com` |
| SMTP port | `587` |
| Encryption | `TLS` |
| Username | full email address |
| Password | mailbox password |

Some hosts use:

- Port `465` with `SSL`
- Port `25` without encryption (less recommended)

### 8.2 Configure OJS email in `config.inc.php`

Replace the `[email]` section with:

```ini
[email]
default = smtp

sendmail_path = "/usr/sbin/sendmail -bs"

smtp = On
smtp_server = mail.mvjmhs.com
smtp_port = 587
smtp_auth = tls
smtp_username = info@mvjmhs.com
smtp_password = YourMailboxPassword

allow_envelope_sender = On
default_envelope_sender = info@mvjmhs.com
force_default_envelope_sender = On
force_dmarc_compliant_from = Off
require_validation = Off
```

If your host requires SSL on port 465, use:

```ini
smtp_port = 465
smtp_auth = ssl
```

### 8.3 Alternative: configure email in OJS admin panel

After login, you can also verify email settings here:

1. Login as admin
2. Go to **Site Administration**
3. Open **Settings → Site Settings → Setup**
4. Set contact email to a real domain address, for example:
   - `editor@mvjmhs.com`
5. For journal-level email footer/signature:
   - **Settings → Website → Appearance**
   - **Settings → Workflow → Emails**

### 8.4 Recommended email addresses

| Purpose | Suggested address |
|---------|-------------------|
| System / all OJS mail | `info@mvjmhs.com` |
| Journal contact | `info@mvjmhs.com` |
| Site admin contact | `info@mvjmhs.com` |

Use `info@mvjmhs.com` for **all** of these in OJS after deployment:

- Site contact email
- Journal contact email
- SMTP sender address
- Email templates "From" address

---

## 9. Set Folder Permissions

In hosting File Manager or FTP:

| Path | Permission |
|------|------------|
| `public_html/cache/` | writable (`755` or `775`) |
| `public_html/public/` | writable (`755` or `775`) |
| `/home/youruser/ojs_files/` | writable (`755` or `775`) |

If uploads fail, ask hosting support to confirm write access for the web server user.

---

## 10. Final Live URLs

After deployment, use these URLs:

| Page | URL |
|------|-----|
| Main site | https://mvjmhs.com/ |
| Journal homepage | https://mvjmhs.com/index.php/mvjmhs |
| Admin login | https://mvjmhs.com/index.php/index/login |
| Register | https://mvjmhs.com/index.php/mvjmhs/user/register |
| Current issue | https://mvjmhs.com/index.php/mvjmhs/issue/current |

Default local admin credentials after import:

- Username: `admin`
- Password: `admin123`

Change this password immediately after going live.

---

## 11. Post-Deployment Checklist

After the site is online:

- [ ] Open https://mvjmhs.com/
- [ ] Confirm redirect to journal homepage works
- [ ] Confirm CSS/JS loads correctly
- [ ] Login as admin
- [ ] Change admin password
- [ ] Update site contact email to `@mvjmhs.com`
- [ ] Update journal contact email to `@mvjmhs.com`
- [ ] Test SMTP by sending a test email from OJS
- [ ] Test user registration email
- [ ] Test password reset email
- [ ] Create first issue/article if needed

---

## 12. Verify Journal Settings

Your imported journal should use:

- Journal name: **MVJMHS**
- Journal path: **mvjmhs**

If needed, verify in phpMyAdmin:

```sql
SELECT journal_id, path, enabled FROM journals;
SELECT setting_name, locale, setting_value
FROM journal_settings
WHERE journal_id = 1 AND setting_name = 'name';
```

Expected:

- `path = mvjmhs`
- `name = MVJMHS`

---

## 13. Test Email After Deployment

### Method 1: OJS workflow test

1. Register a test user with a real email address
2. Check whether registration/verification email arrives
3. Use **Lost Password** and confirm reset email arrives

### Method 2: create a test submission workflow

1. Submit a test manuscript
2. Trigger editor/reviewer notification
3. Confirm outgoing mail uses `@mvjmhs.com`

### If email does not work

Check:

1. SMTP username is the **full email address**
2. Correct port and encryption (`587 + TLS` or `465 + SSL`)
3. Mailbox password is correct
4. Hosting provider allows SMTP from PHP apps
5. SPF/DKIM records exist for `mvjmhs.com`

Ask hosting support for:

- SMTP hostname
- SMTP port
- Required encryption
- Whether outgoing SMTP is blocked on shared hosting

---

## 14. Common Problems and Fixes

### 500 Internal Server Error

- Check PHP version is 8.2+
- Check hosting error log
- Verify `config.inc.php` syntax
- Verify database credentials

### Page loads without design/CSS

- Enable default theme in database
- Clear `cache/` folder
- Confirm `plugins/themes/default/` exists on server

### Database connection error

- Confirm DB name, username, password
- Confirm user has privileges
- Confirm host is usually `localhost`

### Upload/file errors

- Check `files_dir` path
- Check folder permissions
- Confirm `ojs_files` exists outside `public_html`

### Redirect loop

- Enable SSL first
- Then set `force_ssl = On`

### Emails not sending

- Switch `[email] default` from `log` to `smtp`
- Verify mailbox login in hosting webmail first
- Use hosting-provided SMTP settings exactly

### Old localhost links appear

Update in `config.inc.php`:

```ini
base_url = "https://mvjmhs.com"
allowed_hosts = '["mvjmhs.com", "www.mvjmhs.com"]'
```

Then clear cache.

---

## 15. Backup Before Any Live Change

Always backup before editing production:

1. Download `config.inc.php`
2. Export database from phpMyAdmin
3. Download `ojs_files/`
4. Download `public/journals/` if present

---

## 16. Quick Deployment Steps (Short Version)

1. Export local DB to SQL file
2. Upload OJS files to `public_html`
3. Upload `C:\xampp_82\files\ojs` to `/home/youruser/ojs_files`
4. Create hosting database and import SQL
5. Edit `config.inc.php`:
   - `base_url = https://mvjmhs.com`
   - database credentials
   - `files_dir`
   - SMTP domain mail settings
6. Enable SSL for `mvjmhs.com`
7. Open https://mvjmhs.com/
8. Login and change admin password
9. Test domain email sending

---

## 17. Support Notes for Hosting Provider

If you need to contact hosting support, send this:

```text
Please confirm the server supports:
- PHP 8.2+
- mysqli, gd, intl, mbstring, xml, zip, curl, openssl, bcmath
- MySQL/MariaDB
- Let's Encrypt SSL
- SMTP for PHP applications

Domain: mvjmhs.com
Application: Open Journal Systems (OJS) 3.5.0-5
Document root: public_html
Private files directory: /home/username/ojs_files
```

---

## 18. Example Production Email Block

Use this as a ready template in `config.inc.php`:

```ini
[email]
default = smtp
smtp = On
smtp_server = mail.mvjmhs.com
smtp_port = 587
smtp_auth = tls
smtp_username = info@mvjmhs.com
smtp_password = YourMailboxPassword
allow_envelope_sender = On
default_envelope_sender = info@mvjmhs.com
force_default_envelope_sender = On
force_dmarc_compliant_from = On
dmarc_compliant_from_displayname = 'MVJMHS Journal'
```

---

## 19. Final Result

When deployment is complete, your live journal should open at:

**https://mvjmhs.com/index.php/mvjmhs**

And the root domain:

**https://mvjmhs.com/**

should redirect to the MVJMHS journal homepage.

---

## 20. Document Information

- Created for: MVJMHS OJS deployment
- Domain: mvjmhs.com
- Journal: MVJMHS
- Journal path: mvjmhs
- OJS version: 3.5.0-5
