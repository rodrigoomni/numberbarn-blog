# WordPress Implementation Notes

## Theme structure (to be scaffolded after HTML designs are approved)

```
wordpress-theme/
├── style.css          — Theme declaration
├── functions.php      — Enqueue styles/scripts, register menus, widget areas, post types
├── index.php          → maps to index.html design
├── single.php         → maps to post.html design
├── author.php         → maps to author.html design
├── header.php         — Shared nav + topbar partial
├── footer.php         — Shared footer partial
├── sidebar.php        — Sidebar widgets partial
├── archive.php        — Category / tag archive (reuses index card grid)
├── search.php         — Search results page
└── page.php           — Generic static page
```

## WordPress-specific considerations
- Post thumbnails: register_theme_support('post-thumbnails')
- Custom fields (ACF or native): read_time, hero_label, author_role, author_social
- Category color mapping: store as term meta or use CSS data attributes
- Newsletter widget: integrate with Mailchimp / ConvertKit via shortcode or plugin
- Author bio: uses WP user description field + custom social fields
- Related posts: WP_Query by category, exclude current post
- Pagination: replace "Load More" button with WP AJAX pagination or native wp_pagenavi
