# TrustNinja — Marketing Site

Marketing and landing page site for TrustNinja, built on [Tina4PHP](https://tina4.com).

---

## Prerequisites

- PHP (check your hosting environment for compatibility)
- Composer
- Apache with `mod_rewrite` enabled
- A [Mandrill](https://mandrillapp.com) (Mailchimp Transactional) account
- A [Google reCAPTCHA v3](https://www.google.com/recaptcha) site + secret key pair

---

## Installation

**1. Clone the repo**
```bash
git clone https://github.com/CodeInfinity-Pty-Ltd/trustninja-website.git
cd trustninja-website
```

**2. Install dependencies**
```bash
composer install
```

**3. Set up environment variables**

Copy the example env file and fill in your values:
```bash
cp .env.example .env
```

| Variable | Description |
|---|---|
| `MANDRILL_API_KEY` | Mandrill API key for sending transactional emails |
| `RECAPTCHA_V3_SITE_KEY` | Google reCAPTCHA v3 public key (used in templates) |
| `RECAPTCHA_V3_SECRET_KEY` | Google reCAPTCHA v3 secret key (server-side validation) |
| `CONTACT_US_EMAIL` | Email address that contact form submissions are sent to |

---

## Running Locally

Tina4 includes a built-in development server. From the project root:

```bash
php index.php
```

This starts a local server at `http://localhost:7145` by default.

> **Note:** The `.htaccess` includes an automatic HTTPS redirect which will cause issues locally. Comment out these three lines in `.htaccess` while developing:
> ```apache
> # RewriteCond %{HTTPS} !=on
> # RewriteCond %{REQUEST_URI} !^/.well-known/.*$ [NC]
> # RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,NE]
> ```

---

## SCSS

Tina4 compiles SCSS automatically. Edit files in `scss/partials/` — `site.scss` is the manifest that imports all partials. The compiled output lands in `public/css/default.css`.

> **Do not edit `public/css/default.css` directly** — it is overwritten on every SCSS change.

The partial structure is:

| Partial | Purpose |
|---|---|
| `_variables.scss` | Colour tokens, font vars |
| `_base.scss` | Body, resets, global defaults |
| `_utilities.scss` | Shared utility classes |
| `_buttons.scss` | Bootstrap button variants |
| `_trustpilot.scss` | Trustpilot widget |
| `_header.scss` | Header, nav, logo slider |
| `_footer.scss` | Footer, gradient background |
| `_hero.scss` | Hero sections |
| `_home.scss` | Homepage sections |
| `_agency.scss` | Agency pricing page |
| `_review-management.scss` | Review management page |
| `_legal.scss` | Legal pages and contact |
| `_errors.scss` | 403/404 error pages |

---

## Project Structure

```
├── api/                  # API endpoints (email sending)
├── app/helper/           # PHP helper classes (Email, Captcha)
├── public/
│   ├── css/              # Compiled CSS (do not edit directly)
│   ├── images/           # Static images
│   ├── js/               # JavaScript files
│   └── videos/           # Video assets
├── routes/               # Tina4 route definitions
├── scss/
│   ├── site.scss         # SCSS manifest (imports all partials)
│   └── partials/         # Individual SCSS partials
└── templates/
    ├── components/       # Reusable Twig components (header, footer etc)
    ├── email/            # Email templates
    └── screens/          # Page templates
```

---

## Deployment

The site requires Apache with `mod_rewrite` enabled. Ensure your vhost points to the project root and that `.htaccess` overrides are allowed (`AllowOverride All`).

The HTTPS redirect in `.htaccess` is active by default — ensure your server has a valid SSL certificate before going live.

---

## Contributing

1. Create a feature branch off `main`
2. Make your changes
3. Submit a pull request with a clear description of what changed and why
