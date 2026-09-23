# Bootstrap Mega Starter

Bootstrap Mega Starter is a reusable classic WordPress starter theme built on Bootstrap 5 with its main feature integrated directly into **Appearance → Menus**: a responsive mega menu without a page builder or separate mega-menu plugin.

## Version

**1.0.0 — stable release**

## Main features

- Bootstrap 5.3.6 bundled locally; no frontend CDN dependency.
- Native **Appearance → Menus** mega-menu checkbox on top-level items.
- Automatic mega-menu columns based on available width and menu groups/items.
- First-level children can act as column headings; grandchildren appear beneath them.
- Optional mega-menu featured image with left, right, top or bottom placement.
- Desktop mega menus and normal dropdowns both use Bootstrap's native **click** behavior.
- Outside click and Escape close desktop dropdowns consistently.
- Right-side mobile offcanvas navigation.
- Mobile nested navigation uses clear **+ / −** expand/collapse controls.
- Mobile offcanvas respects the WordPress admin toolbar while developers are logged in.
- Custom logo, menus, widgets, comments, pagination, archives, search and 404 templates.
- Gutenberg wide/full alignment, editor styles and responsive embeds.
- Accessibility basics including skip link, focus states, ARIA state updates and reduced-motion support.
- Customizer starter options.
- WooCommerce support with optional Account and Cart header actions.
- GPL-2.0-or-later theme license; bundled Bootstrap retains its MIT license.

## Mega menu setup

1. Go to **Appearance → Menus**.
2. Add items to the Primary Menu.
3. Open a top-level menu item and enable **Mega Menu**.
4. Optionally choose a featured image and its position.
5. Save the menu.

The theme calculates the desktop grid automatically. On mobile, mega menus become normal nested accordion navigation so the same menu remains usable on small screens.

## Developer customization rules

This starter deliberately separates the **menu engine** from the **project styling layer**. When using the theme as a base for a client/project, avoid editing the core files below unless you are intentionally maintaining or extending Bootstrap Mega Starter itself.

### Core files — do not modify for normal project styling

- `inc/class-bs5-mega-navwalker.php` — core Bootstrap/mega-menu HTML walker.
- `inc/menu-fields.php` — Appearance → Menus mega-menu fields, media controls and saving logic.
- `assets/js/mega-menu.js` — core desktop dropdown, automatic column fitting, mobile accordion/offcanvas and accessibility behavior.
- The **BMS CORE: MEGA MENU / MOBILE NAV** sections in `assets/css/theme.css` — structural mega-menu/offcanvas CSS.
- Everything under `assets/vendor/bootstrap/` — third-party Bootstrap distribution files. **Never edit vendor files directly.**

Editing these files can break menu markup, Bootstrap dropdown behavior, mobile +/− controls, outside-click closing, automatic columns or future updates.

### Where developers should put project CSS

Use `style.css` for project-specific CSS overrides. A clearly marked **PROJECT CUSTOM CSS** section is included at the bottom of that file. For a reusable parent-theme installation, a child theme is even better because updates to Bootstrap Mega Starter can then be applied without overwriting project work.

Do not edit `bootstrap.min.css`. Override Bootstrap variables/classes from project CSS instead.

### Where developers should put project JavaScript

Do **not** add project code inside `assets/js/mega-menu.js`. Create a separate file such as:

`assets/js/project.js`

and enqueue it from `functions.php` (or preferably from a child theme). This keeps the navigation engine isolated and makes debugging/upgrades much safer.

### PHP customization

Normal template files such as `header.php`, `footer.php`, `page.php`, `single.php`, archive templates and template parts are intended to be adapted for a project. If changing navigation markup, preserve the walker classes/data attributes expected by `mega-menu.js` and `theme.css`.

## Theme structure

```text
bootstrap-mega-starter/
├── assets/
│   ├── css/
│   │   ├── editor-style.css
│   │   └── theme.css
│   ├── js/
│   │   ├── admin-menu.js
│   │   └── mega-menu.js
│   └── vendor/
│       └── bootstrap/
│           ├── css/
│           │   └── bootstrap.min.css
│           ├── js/
│           │   └── bootstrap.bundle.min.js
│           └── LICENSE
├── inc/
│   ├── class-bs5-mega-navwalker.php
│   ├── customizer.php
│   ├── extras.php
│   ├── menu-fields.php
│   ├── template-tags.php
│   └── woocommerce.php
├── languages/
├── template-parts/
│   ├── content-none.php
│   ├── content-page.php
│   ├── content-search.php
│   └── content.php
├── .gitignore
├── 404.php
├── archive.php
├── attachment.php
├── author.php
├── category.php
├── comments.php
├── date.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── search.php
├── searchform.php
├── sidebar.php
├── single.php
├── tag.php
├── style.css
├── screenshot.png
├── readme.txt
├── LICENSE
├── CHANGELOG.md
├── CONTRIBUTING.md
└── README.md
```

This tree reflects the complete **v1.0.0** release structure. Keep the core paths stable in future compatible releases, especially the mega-menu/navwalker files documented above, so child themes and project customizations can rely on them.

## WooCommerce

When WooCommerce is active, the theme enables standard WooCommerce theme/gallery support. Account and Cart header icons can be independently enabled or disabled from the Customizer. They are not output when WooCommerce is inactive.

## Development notes

Run development with `WP_DEBUG` enabled. When changing navigation code, test desktop click/open/outside-click/Escape behavior, mobile +/− accordions, nested children, long menus, admin toolbar clearance, all mega-menu image positions, resize behavior and keyboard navigation.

## Licensing

Bootstrap Mega Starter is licensed under **GNU GPL v2 or later**. See `LICENSE`.

Bootstrap 5.3.6 is bundled under the **MIT License**. See `assets/vendor/bootstrap/LICENSE`.
