<a id="hasepharadi"></a>
# haSepharadi
<!-- MarkdownTOC -->

* [Changelog](#changelog)
    * [\[1.1.61\] - 2019-01-19](#1161---2019-01-19)
* [Issues](#issues)
    * [Resources & Loading](#resources--loading)
        * [Image Loading - Homepage](#image-loading---homepage)
        * [Fonts Loading](#fonts-loading)
        * [FontAwesome](#fontawesome)
    * [Accessibility](#accessibility)
    * [Plugins and Widgets](#plugins-and-widgets)
        * [Cleanup](#cleanup)
        * [wpDiscuz](#wpdiscuz)
        * [Events Calendar](#events-calendar)
        * [Author Bios - Footer](#author-bios---footer)
        * [Footer Widgets](#footer-widgets)
    * [Header & Nav Menus](#header--nav-menus)
        * [Header Area](#header-area)
        * [Nav Menus](#nav-menus)
        * [Topbar](#topbar)
    * [Content & Styling](#content--styling)
        * [Author Page](#author-page)
        * [Category Pages](#category-pages)
        * [Post Meta](#post-meta)
    * [Code Cleanup](#code-cleanup)
        * [SCSS](#scss)
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

<a id="1161---2019-01-19"></a>
### [1.1.61] - 2019-01-19
* Fix About Author appears at bottom of homepage
* Add Author Bios styling

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

<a id="fontawesome"></a>
#### FontAwesome
* Implement [FA Aria Accessibility Roles](https://fontawesome.com/v4.7.0/examples/#accessible) - exremely important
* ~why am I only using FA 4.6.7 and not FA-5??~
    * ~See if/which icons it affects~
* One of the plugins or icons somewhere uses Dashicons, iirc. Can I replace this with FA?
* Extract specifically needed FA styles, instead of loading the whole stylesheet
    * Do this in SCSS

<a id="accessibility"></a>
### Accessibility
* `min-width: 961px` Nav Submenus not accessible via Tabbing

<a id="plugins-and-widgets"></a>
### Plugins and Widgets

<a id="cleanup"></a>
#### Cleanup
* Remove Unnecessary Plugins
    * Visual Composer
        * Need to get rid of code on About page
        * Possibly others as well

<a id="wpdiscuz"></a>
#### wpDiscuz
* wpDiscuz needs further styling and social media integration

<a id="events-calendar"></a>
#### Events Calendar
* Need solution for importing facebook events and displaying on an event calendar

<a id="author-bios---footer"></a>
#### Author Bios - Footer
* custom-functions.php - consider remove encapsulating `<div class="author-img>` tags
* Font is not rendering the same as City News Theme
    * See "Fonts Loading" above

<a id="footer-widgets"></a>
#### Footer Widgets
* need styling for `max-width: 960` and below

<a id="header--nav-menus"></a>
### Header & Nav Menus

<a id="header-area"></a>
#### Header Area
* Refine the look of header area for `max-width: 60em` and all descending screen sizes

<a id="nav-menus"></a>
#### Nav Menus
* Desktop menu is a bit glitchy in its hover behavior (further complicated by menu depth)
    * See [here](https://gist.github.com/GaryJones/1707986) for solution.
    * Parameters and meanings are here:
        * [Superfish site](https://superfish.joelbirch.co/options/)
        * [Dev Docs - jQuery .animate()](https://devdocs.io/jquery/animate)
* ~Menu Depth 3 - Item 1 has border issue~
    * ~Likely having another class' style applied to it inadvertently~

<a id="topbar"></a>
#### Topbar
* `#topbar` may have z-index issue on small mobile

<a id="content--styling"></a>
### Content & Styling
* Adjust code in individual posts, in order to ditch Visual Composer
    * This may involve adding some new front-end and editor.css styles
* Eliminate Read More links at the bottom of single posts
* custom-functions.php
    4.6 - Next & Prev Posts Link - look for a more organic code solution

<a id="author-page"></a>
#### Author Page
* Sidebar is currently falling below content area
    * Is it using a full-width layout by accident??

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
* Improve SCSS organization
    * Use more specific partials and separate out concerns:
        * Author Bios (Footer) vs Author's (Box Widget)
        * Separate individualcustom widgets out from `_custom.scss`
        * Consider doing away with `custom.scss`, or at the very least exporting most of the code in it
            * Be clear on what its purpose is in the overall structure
    * Section headings need to match and follow a consistent numbering theme.
        * Use same headings structure as custom-functions.php for each scss partial
    * Improve Variables Usage by incorporating broader variables, ex: `category--color`
        * Replace `$orange variables` et al with `$link--font-color-hover: $orange` et al


<a id="php"></a>
#### PHP
* **PHP Code needs DocBlocks**
* **Add in esc_url et al, where necessary**
* Social sharing buttons - extract social btns from single.php and move to custom-functions.php

<a id="media-queries"></a>

<a id="media-queries"></a>
#### Media Queries
* Remove `#topbar` and any other id selectors

<a id="css-grid"></a>
#### CSS Grid
* Rewrite with CSS Grid

<a id="other"></a>
## Other
* Add earlier version history to Changelog
* Update the separate repo for the Zemannim plugin

[1.1.61]: https://github.com/lunacodes/hasepharadi/compare/master@%7B1day%7D...master

