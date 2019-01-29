<a id="hasepharadi"></a>
# haSepharadi
<!-- MarkdownTOC -->

* [Changelog](#changelog)
    * [\[1.1.71\] - 2019-01-19](#1171---2019-01-19)
    * [\[1.1.61\] - 2019-01-19](#1161---2019-01-19)
* [Issues](#issues)
    * [Resources & Loading](#resources--loading)
        * [Image Loading - Homepage](#image-loading---homepage)
        * [Fonts Loading](#fonts-loading)
    * [Accessibility](#accessibility)
        * [FontAwesome](#fontawesome)
    * [Plugins and Widgets](#plugins-and-widgets)
        * [Remove Unnecessary Plugins](#remove-unnecessary-plugins)
            * [Visual Composer](#visual-composer)
        * [wpDiscuz](#wpdiscuz)
        * [Events Calendar](#events-calendar)
    * [Header & Nav Menus](#header--nav-menus)
        * [Nav Menus](#nav-menus)
    * [Content & Styling](#content--styling)
        * [Author Page](#author-page)
        * [Category Pages](#category-pages)
        * [Post Meta](#post-meta)
    * [Code Cleanup](#code-cleanup)
        * [SCSS](#scss)
            * [Improve SCSS organization](#improve-scss-organization)
            * [FontAwesome](#fontawesome-1)
        * [PHP](#php)
        * [Media Queries](#media-queries)
        * [CSS Grid](#css-grid)
* [Other](#other)

<!-- /MarkdownTOC -->

This project stores my development work on the [haSepharadi](https://hasepharadi.com) website. Currently this involves a [theme rewrite](themes/haSepharadi) (shifting from the CityNews theme to the Genesis Framework), a [Zemannim plugin](plugins/luna-zemanim-widget), and an [Affiliate Links plugin](plugins/luna-affiliates-widget).

Frameworks, Libraries, and APIs used:
* [Genesis Framework](https://www.studiopress.com/features/)
* [HTML5 Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
* [Google Maps Geocoding API](https://developers.google.com/maps/documentation/geocoding/intro)
* [SunCalc Library](https://github.com/mourner/suncalc)

This project consists of the haSepharadi theme
<a id="changelog"></a>
## Changelog

<a id="1171---2019-01-19"></a>
### [1.1.71] - 2019-01-19
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
### [1.1.61] - 2019-01-19
* Fixed About Author appears at bottom of homepage
* Added Author Bios styling

<a id="issues"></a>
## Issues

<a id="resources--loading"></a>
### Resources & Loading

<a id="image-loading---homepage"></a>
#### Image Loading - Homepage
* Image loading time on Homepage (due to unnecessarily large image files)
    * Compress Images & Regenerate Thumbnails
    * Implement Upload Size Limit / Auto Compression / Scaling Reduction

<a id="fonts-loading"></a>
#### Fonts Loading
* Clean up fonts loading - remove unnecessary fonts in fonts.scss
    * Need to experiment with this first, to find out what's impacting what

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
* The followings posts currently rely on VC shortcode:
    * About
    * Lebanon
    * Others?
* **Adjust code in individual posts, in order to ditch Visual Composer**
    * Option 1: add new front-end and editor.css styles
    * Option 2: Replace with Beaver Builder
* Replace the shortcodes either with the [[div] shortcode plugin](https://wordpress.org/plugins/div-shortcode/) or with [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/)

<a id="wpdiscuz"></a>
#### wpDiscuz
* wpDiscuz needs further styling and social media integration
* Are there better options?

<a id="events-calendar"></a>
#### Events Calendar
* Need solution for importing facebook events and displaying on an event calendar

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

<a id="post-meta"></a>
#### Post Meta
* Post Meta on Home and Archive pages should probably be bigger by 1-2px

<a id="code-cleanup"></a>
### Code Cleanup

Items marked in bold are high priority
<a id="scss"></a>
#### SCSS

<a id="improve-scss-organization"></a>
##### Improve SCSS organization
* Use more specific partials and separate out concerns:
    * Author Bios (Footer) vs Author's (Box Widget)
    * Separate individualcustom widgets out from `_custom.scss`
    * Consider doing away with `custom.scss`, or at the very least exporting most of the code in it
        * Be clear on what its purpose is in the overall structure
* Section headings need to match and follow a consistent numbering theme.
    * Use same headings structure as custom-functions.php for each scss partial
* Improve Variables Usage by incorporating broader variables, ex: `category--color`
    * Replace `$orange variables` et al with `$link--font-color-hover: $orange` et al

<a id="fontawesome-1"></a>
##### FontAwesome
* Extract specifically needed FA styles, instead of loading the whole stylesheet?


<a id="php"></a>
#### PHP
* **PHP Code needs DocBlocks**
* **Add in esc_url et al, where necessary**
* Social sharing buttons - extract social btns from single.php and move to custom-functions.php

<a id="media-queries"></a>
#### Media Queries
* Replace `#topbar` and other id selectors wherever possible

<a id="css-grid"></a>
#### CSS Grid
* Rewrite with CSS Grid

<a id="other"></a>
## Other
* Add earlier version history to Changelog
* Update the separate repo for the Zemannim plugin

[1.1.7]: https://github.com/lunacodes/hasepharadi/compare/master@%7B1day%7D...master
[1.1.61]: https://github.com/lunacodes/hasepharadi/compare/master@%7B1day%7D...master

