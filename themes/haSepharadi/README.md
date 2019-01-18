# haSepharadi

This project stores my development work on the [haSepharadi](https://hasepharadi.com) website. Currently this involves a [theme rewrite](themes/haSepharadi) (shifting from the CityNews theme to the Genesis Framework), a [Zemannim plugin](plugins/luna-zemanim-widget), and an [Affiliate Links plugin](plugins/luna-affiliates-widget).

Frameworks, Libraries, and APIs used:
* [Genesis Framework](https://www.studiopress.com/features/)
* [HTML5 Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
* [Google Maps Geocoding API](https://developers.google.com/maps/documentation/geocoding/intro)
* [SunCalc Library](https://github.com/mourner/suncalc)

This project consists of the haSepharadi theme
## Changelog

See Git commit history and previous style.css files, for present.

## Issues

### Image Loading - Homepage
* Image loading time on Homepage (due to unnecessarily large image files)

### Fonts Loading
* Clean up fonts loading - remove unnecessary fonts in fonts.scss
    * Need to experiment with this first, to find out what's impacting what

### Comments System
* wpDiscuz needs further styling and social media integration

### Events Calendar
* Need solution for importing facebook events and displaying on an event calendar

### Author Bios
* Author bios need css styling

### Nav Menus
* Desktop menu is a bit glitchy in its hover behavior (further complicated by menu depth)

### Content & Styling
* Need to make some adjustments to individual posts, in order to ditch Visual Composer, upon switching to the rewritten theme
* General Note: May need to adjust padding in .entry-content, for responsiveness
* Eliminate the Read More link that's appear at the bottom of full-length single posts

### Refactor
* index.php - what purpose is it serving
* custom-functions.php
    4.6 - Next & Prev Posts Link - look for a more organic code solution
