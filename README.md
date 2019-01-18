# haSepharadi

This project stores my development work on the [haSepharadi](https://hasepharadi.com) website. Currently this involves a [theme rewrite](themes/haSepharadi) (shifting from the CityNews theme to the Genesis Framework), a [Zemannim plugin](plugins/luna-zemanim-widget), and an [Affiliate Links plugin](plugins/luna-affiliates-widget).

Frameworks, Libraries, and APIs used:
* [Genesis Framework](https://www.studiopress.com/features/)
* [HTML5 Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
* [Google Maps Geocoding API](https://developers.google.com/maps/documentation/geocoding/intro)
* [SunCalc Library](https://github.com/mourner/suncalc)

This project consists of the haSepharadi theme
## Changelog

### [1.1.61] - 2019-01-19
* Fix About Author appears at bottom of homepage
* Add Author Bios styling

## Issues

### Resources & Loading

#### Image Loading - Homepage
* Image loading time on Homepage (due to unnecessarily large image files)
    * Compress Images & Regenerate Thumbnails
    * Implement Upload Size Limit / Auto Compression / Scaling Reduction

#### Fonts Loading
* Clean up fonts loading - remove unnecessary fonts in fonts.scss
    * Need to experiment with this first, to find out what's impacting what

### Comments System
* wpDiscuz needs further styling and social media integration

### Events Calendar
* Need solution for importing facebook events and displaying on an event calendar

### Author Bios
* Author bios need css styling
* custom-functions.php - remove encapsulating `<div class="author-img>` tags

### Nav Menus
* Desktop menu is a bit glitchy in its hover behavior (further complicated by menu depth)
* Menu Depth 3 - Item 1 has border issue
    * Likely having another class' style applied to it inadvertently

### Content & Styling
* Need to make some adjustments to individual posts, in order to ditch Visual Composer, upon switching to the rewritten theme
* General Note: May need to adjust padding in .entry-content, for responsiveness
* Eliminate the Read More link that's appear at the bottom of full-length single posts

### Refactor
* custom-functions.php
    4.6 - Next & Prev Posts Link - look for a more organic code solution

### Author Bios - Footer
* Font is not rendering the same as City News Theme
    * See "Fonts Loading" above

### Code Cleanup

#### SCSS
* Improve SCSS organization
    * Reconsider locations and naming of Author Bio classes (so as to distinguish them from the Author's Box widget)
    * Section headings need to match and follow a consistent numbering theme.
        * Use same headings structure as custom-functions.php for each scss partial

#### PHP
* PHP Code needs DocBlocks
* Add in esc_url et al, where necessary

#### Media Queries
* Remove `#topbar` and any other id selectors

### Header Area
* Refine the look of header area for `max-width: 60em` and all descending screen sizes

### Topbar
* `#topbar` may have z-index issue on small mobile


## Future
* Rewrite with CSS Grid

[1.1.7]: https://github.com/lunacodes/hasepharadi/compare/master@%7B1day%7D...master
