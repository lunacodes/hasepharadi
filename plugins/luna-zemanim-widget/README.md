# Daily Zemannim Plugin

A widget that calculates and displays prayer times, dates of fasts and holidays, and the weekly torah portion, according to halakha (Jewish Law). This plugin is a rewrite and extension of the [Daily Zman Widget](https://wordpress.org/plugins/daily-zman-widget/) by [Adato Systems](http://www.adatosystems.com/)

The plugin works by pulling the user's location, either by the HTML5 Geolocation API or by inputting the user's IP (retrieved from browser headers) into the DB-IP - IP Geolocation API. From there it extracts the user's longitude and latitude, and feeds that into the Google Maps Geocoding API, to obtain the user's city, state, and country.

Once this is done, it checks for Daylight Saving Times, and then uses a Javascript time object, with a UTC offset to caclulate the UTC time. The UTC time is then fed into the SunCalc library, which returns the times for sunrise and sunset, and then performs the relevant calculations, in order to generate the halakhic times.

Version 1.1

## Requirements
* [HTML5 Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
* [Google Maps Geocoding API](https://developers.google.com/maps/documentation/geocoding/intro)
* [SunCalc Library](https://github.com/mourner/suncalc)
* [jQuery](https://jquery.com/)
* [DB-IP - IP Geolocation API](https://db-ip.com/api/)

## Issues & Future Features
* getGeoDetails: var state - immediately precedes if (state == null) - needs for loop, instead of just being set to null,
* Incorporate Promises more?
* Incorporate new Hebcal SSL API
* Add back-end/admin options, for choosing transliteration and which times to display, back in
* Cleanup unused code
