# NumberBarn Blog — WordPress Theme

## Installation

1. Copy the entire `wordpress/` folder into your WordPress install as:
   ```
   wp-content/themes/numberbarn/
   ```
2. Go to **Appearance → Themes** in your WP admin and activate **NumberBarn Blog**.
3. Done — all existing posts will appear automatically with the new design.

---

## Theme File Map

| File | Purpose |
|---|---|
| `style.css` | Theme declaration + all CSS |
| `functions.php` | Theme setup, enqueue, customizer, helpers |
| `header.php` | Top bar + sticky nav |
| `footer.php` | CTA banner + footer |
| `index.php` | Blog homepage (hero, grid, authors section) |
| `single.php` | Single post (article + TOC sidebar + related) |
| `author.php` | Author profile + stats + post grid |
| `archive.php` | Category / tag archive |
| `search.php` | Search results |
| `page.php` | Static pages |
| `sidebar.php` | Blog / archive sidebar |
| `sidebar-article.php` | Article TOC + related sidebar |

---

## Customizer Settings (Appearance → Customize)

| Setting | Description |
|---|---|
| **Top Bar** | Text, link text, and link URL |
| **Nav CTA Button** | Button label and destination URL |
| **Homepage Hero** | Tag label (e.g. "Featured") |
| **CTA Banner** | Headline, subtext, button text and URL |
| **Footer** | Brand description paragraph |

---

## Author Custom Fields

Each author can set their own fields at **Users → Edit Profile → NumberBarn Author Info**:

- **Author Role / Title** — shown under their name (e.g. "Journalist & Copywriter")
- **Twitter / X URL** — shown on author page and article byline
- **LinkedIn URL** — shown on author page and article byline

---

## Recommended Plugins

| Plugin | Purpose |
|---|---|
| [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) | SEO meta, sitemaps |
| [Mailchimp for WP](https://wordpress.org/plugins/mailchimp-for-wp/) | Newsletter signup in sidebar |
| [Post Views Counter](https://wordpress.org/plugins/post-views-counter/) | Powers "Popular Posts" widget with real view counts |
| [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) | Page caching for performance |
| [Smush](https://wordpress.org/plugins/wp-smushit/) | Image optimization |

---

## Navigation Menu

1. Go to **Appearance → Menus**
2. Create a new menu and assign it to **Primary Navigation**
3. Add your categories + the "Get a Number" link (mark it as `nav-cta` in CSS Classes)

---

## Widget Areas

Three widget areas are registered. Go to **Appearance → Widgets** to customize:

- **Blog Sidebar** — shown on homepage and archives
- **Article Sidebar** — shown on single posts (override TOC + newsletter defaults)
- **Author Sidebar** — shown on author pages

---

## Category Color Mapping

Categories are auto-colored by slug. To match the design, name your categories:

| Category Name | Slug | Color |
|---|---|---|
| General | `general` | Blue |
| Ask the Pig | `ask-the-pig` | Pink |
| By the Numbers | `by-the-numbers` | Indigo |
| Featured Customers | `featured-customers` | Green |
| Toll-Free | `toll-free` | Amber |
| VoIP & Tech | `voip-tech` | Purple |
| Business | `business` | Blue |
| Guides | `guides` | Indigo |
| News | `news` | Pink |
