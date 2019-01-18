<a id="hasepharadi"></a>
# haSepharadi

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

<a id="plugins-and-widgets"></a>
### Plugins and Widgets

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

<a id="header--nav-menus"></a>
### Header & Nav Menus

<a id="header-area"></a>
#### Header Area
* Refine the look of header area for `max-width: 60em` and all descending screen sizes

<a id="nav-menus"></a>
#### Nav Menus
* Desktop menu is a bit glitchy in its hover behavior (further complicated by menu depth)
* Menu Depth 3 - Item 1 has border issue
    * Likely having another class' style applied to it inadvertently

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

<a id="code-cleanup"></a>
### Code Cleanup

<a id="scss"></a>
#### SCSS
* Improve SCSS organization
    * Reconsider locations and naming of Author Bio classes (so as to distinguish them from the Author's Box widget)
    * Section headings need to match and follow a consistent numbering theme.
        * Use same headings structure as custom-functions.php for each scss partial

<a id="php"></a>
#### PHP
* PHP Code needs DocBlocks
* Add in esc_url et al, where necessary

<a id="media-queries"></a>
#### Media Queries
* Remove `#topbar` and any other id selectors

#### CSS Grid
* Rewrite with CSS Grid

[1.1.61]: https://github.com/lunacodes/hasepharadi/compare/master@%7B1day%7D...master
