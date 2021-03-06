<a id="hasepharadi"></a>
# haSepharadi
<!-- MarkdownTOC -->

* [Changelog](#changelog)
    * [\[1.7.1\] - 2019-01-30](#171---2019-01-30)
    * [\[1.6.0\] - 2019-01-18](#160---2019-01-18)
* [Known Issues](#known-issues)
    * [Resources & Loading](#resources--loading)
        * [Image Loading - Homepage](#image-loading---homepage)
        * [Fonts](#fonts)
    * [Accessibility](#accessibility)
        * [FontAwesome](#fontawesome)
    * [Plugins and Widgets](#plugins-and-widgets)
        * [Remove Unnecessary Plugins](#remove-unnecessary-plugins)
            * [Visual Composer](#visual-composer)
        * [wpDiscuz](#wpdiscuz)
        * [Events Calendar](#events-calendar)
        * [Add Site Link to Copied Text](#add-site-link-to-copied-text)
        * [Mailchimp - Subscribe](#mailchimp---subscribe)
    * [Header & Nav Menus](#header--nav-menus)
        * [Nav Menus](#nav-menus)
    * [Content & Styling](#content--styling)
        * [Author Page](#author-page)
        * [Category Pages](#category-pages)
    * [Code Cleanup](#code-cleanup)
        * [SCSS](#scss)
            * [Improve SCSS organization](#improve-scss-organization)
        * [PHP & JS](#php--js)
        * [CSS Grid](#css-grid)
* [Other](#other)

<!-- /MarkdownTOC -->

This project stores my development work on the [haSepharadi](https://hasepharadi.com) website. Currently this involves the [haSepharadi theme](themes/haSepharadi) (built on the Genesis Framework), a [Zemannim plugin](plugins/luna-zemanim-widget), and an [Affiliate Links plugin](plugins/luna-affiliates-widget).

Frameworks, Libraries, and APIs used:
* [Genesis Framework](https://www.studiopress.com/features/)
* [HTML5 Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
* [Google Maps Geocoding API](https://developers.google.com/maps/documentation/geocoding/intro)
* [SunCalc Library](https://github.com/mourner/suncalc)

This project consists of the haSepharadi theme
<a id="changelog"></a>
## Changelog

<a id="1171---2019-01-19"></a>
<!-- ### [1.1.71] - 2019-01-19 -->

<a id="171---2019-01-30"></a>
### [1.7.1] - 2019-01-30
* Added and improved responsive styles for:
    * Category Template
    * Footer Widgets
* Fixed topbar styles issue and conflicts
* Switched to Font Awesome 5.6.3
* Cleaned up many site issues
* Improved Topbar nav functionality and styling.
    `min-width: 961` Menu now appears at top-right of screen, instead of Hamburger Menu.
* Vastly improved site loading time
* Next and Prev Post Links now display post titles

<a id="1161---2019-01-19"></a>
<!-- ### [1.1.61] - 2019-01-19 -->
<a id="160---2019-01-18"></a>
### [1.6.0] - 2019-01-18
* Fixed About Author appears at bottom of homepage
* Added Author Bios styling

<a id="known-issues"></a>
## Known Issues

<a id="resources--loading"></a>
### Resources & Loading

<a id="image-loading---homepage"></a>
#### Image Loading - Homepage
* Image loading time on Homepage (due to unnecessarily large image files)
    * Compress Images & Regenerate Thumbnails
    * Implement Upload Size Limit / Auto Compression / Scaling Reduction

<a id="fonts"></a>
#### Fonts
* ~Clean up fonts loading - remove unnecessary fonts in fonts.scss~
    * ~Need to experiment with this first, to find out what's impacting what~
* What's a good (and user-friendly) way to get Google Fonts into Editor?
* Font Awesome
    * Font Awesome flagging false 404s - likely due to minification:
        * https://hasepharadi.com/wp-content/themes/haseph/fonts/fontawesome-pro-5.6.3-web/webfonts/fa-brands-400.ttf
        * https://hasepharadi.com/wp-content/themes/haseph/fonts/fontawesome-pro-5.6.3-web/webfonts/fa-brands-400.woff
        * https://hasepharadi.com/wp-content/themes/haseph/fonts/fontawesome-pro-5.6.3-web/webfonts/fa-brands-400.woff2
    * Extract specifically needed FA styles, instead of loading the whole stylesheet


<a id="accessibility"></a>
### Accessibility

<a id="fontawesome"></a>
#### FontAwesome
* **Implement [Font Awesome Aria Accessibility Roles](https://fontawesome.com/v4.7.0/examples/#accessible)**

<a id="plugins-and-widgets"></a>
### Plugins and Widgets

<a id="remove-unnecessary-plugins"></a>
#### Remove Unnecessary Plugins

<a id="visual-composer"></a>
##### Visual Composer
* Finish recoding Lebanon page, so I can remove Visual Composer

<a id="wpdiscuz"></a>
#### wpDiscuz
* ~wpDiscuz needs further styling and social media integration~
* ~Are there better options?~

<a id="events-calendar"></a>
#### Events Calendar
* Working on a fully automated way to import events from fb pages

<a id="add-site-link-to-copied-text"></a>
#### Add Site Link to Copied Text
* Find a more elegant way to implement this, wrt UI/UX
    * How does the Forward's script work??

<a id="mailchimp---subscribe"></a>
#### Mailchimp - Subscribe
* can mc-validate.js be loaded locally instead?

<a id="header--nav-menus"></a>
### Header & Nav Menus

<a id="nav-menus"></a>
#### Nav Menus
* Desktop menu hover behavior is glitchy
    * Implement [pushy.js](https://github.com/christophery/pushy) menu instead?
    * Other possible solution: see [here](https://gist.github.com/GaryJones/1707986) for possible solution.
        * Parameters and definitions for `superfish.js`:
            * [Superfish site](https://superfish.joelbirch.co/options/)
            * [Dev Docs - jQuery .animate()](https://devdocs.io/jquery/animate)
* `min-width: 961` should .shrinked menu display sub-menu on hover?

<a id="content--styling"></a>
### Content & Styling

<a id="author-page"></a>
#### Author Page
* Needs light styling

<a id="category-pages"></a>
#### Category Pages
* Does `full-width` template actually make sense here?
* Page Title is appearing at the bottom of the page, after The Loop has finished

<a id="code-cleanup"></a>
### Code Cleanup

Items marked in bold are high priority
<a id="scss"></a>
#### SCSS

<a id="improve-scss-organization"></a>
##### Improve SCSS organization
* Section headings need to match and follow a consistent numbering theme.
    * Use same headings structure as custom-functions.php for each scss partial
* Improve Variables Usage by incorporating broader variables, ex: `category--color`
    * Replace `$orange variables` et al with `$link--font-color-hover: $orange` et al

<a id="php--js"></a>
#### PHP & JS
* Many functions still need DocBlocks
* Add in esc_url et al, where necessary

<a id="css-grid"></a>
#### CSS Grid
* Rewrite with CSS Grid

<a id="other"></a>
## Other
* Add earlier version history to Changelog

[1.7.1]: https://github.com/lunacodes/hasepharadi/commit/804479078b534a6a182d7cdc7d036fe0c5183b17
[1.6.0]: https://github.com/lunacodes/hasepharadi/commit/0751be9b5b4830b117c04d0ca80109e0fd83cba5

