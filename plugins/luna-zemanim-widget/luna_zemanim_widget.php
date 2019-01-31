<?php
/**
* Plugin Name: Daily Zemanim
 * Plugin URI: https://lunacodesdesign.com/
 * Description: Displays Zemannim (times) according to Sepharadic tradition.
 *   Uses the DB-IP API and the Google Maps API for geographic information.
 *   Uses the Sun-Calc Library (https://github.com/mourner/suncalc) for sunrise/sunset information.
 * Version: 1.3.0
 * Author: Luna Lunapiena
 * Author URI: https://lunacodesdesign.com/
 * License: GPL3+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: luna_zemanim_widget_domain
 * Change Record:
 * ***********************************
 * 2018- - initial creation
 *
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation,version 3
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   For details about the GNU General Public License, see <http://www.gnu.org/licenses/>.
 *   For details about this program, see the readme file.
*/

/**
 * Issues:
 * ***********************************
 * getGeoDetails: var state needs For Loop, instead of just being set to null
 * improve code logic with promises?
 * MAJOR: I NEED TO ADD DATE AND TIME CALCULATIONS FOR SATURDAY!!!
*/

class Luna_Zemanim_Widget extends WP_Widget {

  /**
   * Register widget with WordPress
   */
  public function __construct() {
    parent::__construct(
      'luna_zemanim_widget', // Base ID
      __('Daily Zemannim', 'luna_zemanim_widget_domain'), // Name
      array( 'description' => __( "Displays Zemannim (times) according to Sepharadic tradition", 'luna_zemanim_widget_domain' ),  ) //Args
    );

  add_action( 'widgets_init', function() {register_widget( 'Luna_Zemanim_Widget' ); } );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget Arguments.
   * @param array $instance Saved values from database   */
  public function widget( $args, $instance ) {
    wp_enqueue_script( 'suncalc-master', plugins_url( '/suncalc-master/suncalc.js?ver=4.9.4', __FILE__ ) );
    wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyAmCeKW07UlPDH_eQarF4y9vWJ6cwHePp4' );


    $title = apply_filters( 'widget_title', $instance['title'] );

    echo $args['before_widget'];
    if ( ! empty( $title ) ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }

/**
 * Generates the Hebrew Date from a passed in date object
 * @param  object $date the date
 * @return string       The Hebrew rendition of the date.
 */
function generateHebrewDate($date) {
  $month = idate("m", $date);
  $day = idate("j", $date);
  $year = idate("Y", $date);
  $jdate = gregoriantojd($month, $day, $year);
  $jd2 = jdtojewish($jdate, true, CAL_JEWISH_ADD_GERESHAYIM);

  $hebDateStr = mb_convert_encoding("$jd2", "utf-8", "ISO-8859-8");
  return $hebDateStr;
}

/**
 * Generates English and Hebrew dates for current day and upcoming Shabbath
 * @since 1.2.0
 *
 * @return array Contains English and Hebrew dates the current day and upcoming Shabbath
 */
function generateDates() {
  $today = date("F, j, Y");
  $todayInt = strtotime("now");
  $dayOfWeek = date("N");
  if ($dayOfWeek == 5) {
        $friday = strtotime("now");
  } elseif ($dayOfWeek == 6) {
    $friday = strtotime("yesterday");
  } else {
    $friday = strtotime("next friday");
  }

  $todayStr = $today;
  $shabbatISO = date(DATE_ISO8601, $friday);    $todayHebStr = generateHebrewDate($todayInt);
  $shabbatStr = date("F, j, Y", $friday);
  $shabbatHebStr = generateHebrewDate($friday);
  $dates = [$todayStr, $todayHebStr, $shabbatStr, $shabbatHebStr, $shabbatISO];
  return $dates;
}
$dates = generateDates();

/**
 * Pre-generates html structure for front-end display, prior to
 * any other code being run
 * @since 1.0.0
 */
function outputZemanim($dates) {
  $today = $dates[0];
  $todayHeb = $dates[1];
  $shabbat = $dates[2];
  $shabbatHeb = $dates[3];
  ?>

    <div id="zemanim_container">
        <div id="zemanim_display">
            <span id="zemanim_date">Times for <?php echo($today) ?><br></span>
            <span id="zemanim_city"></span>
            <span id="zemanim_hebrew"><?php echo($todayHeb) ?><br></span>
            <span id="zemanim_shema">Latest Shema: <br></span>
            <span id="zemanim_minha">Earliest Minḥa:  <br></span>
            <span id="zemanim_peleg">Peleḡ haMinḥa:  <br></span>
            <span id="zemanim_sunset">Sunset: <br></span>
        </div>
    </div>
    <br><br>
    <h6 class="widget_title">Shabbat Zemannim</h6>
    <div id="shabbat_zemanim_container">
        <div id="shabbat_zemanim_display">
            <span id="shabbat_zemanim_date">Shabbat Times for <?php echo($shabbat) ?><br></span>
            <span id="shabbat_zemanim_city"></span>
            <span id="shabbat_zemanim_hebrew"><?php echo($shabbatHeb); ?><br>
            </span>
            <span id="shabbat_zemanim_candles">Sunset: <br></span>
            <span id="shabbat_zemanim_sunset">Sunset: <br></span>
            <span id="shabbat_zemanim_habdala">Haḇdala: </span>
        </div>
    </div>

<?php
}
outputZemanim($dates);
?>

<script type="text/javascript" defer>
var zemanim = document.getElementById("zemanim_container");
var z_city = document.getElementById("zemanim_city");
var z_shema = document.getElementById("zemanim_shema");
var z_minha = document.getElementById("zemanim_minha");
var z_peleg = document.getElementById("zemanim_peleg");
var z_sunset = document.getElementById("zemanim_sunset");
var shabbat_zemanim = document.getElementById("shabbat_zemanim_container");
var sz_city = document.getElementById("shabbat_zemanim_city");
var sz_candles =document.getElementById("shabbat_zemanim_candles");
var sz_sunset = document.getElementById("shabbat_zemanim_sunset");
var sz_habdala = document.getElementById("shabbat_zemanim_habdala");

/**
 * Requests location permission from user for HTML5 Geolocation API,
 * and routes it to the relevant function.
 * @return {(number|Array)} [lat, long] coordinates
 */
function getLocation() {
  var options = {
    enableHighAccuracy: true,
    maximumAge: 0
  };

  function error(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
  zemanim.innerHtml = "Please enable location services to display the most up-to-date Zemanim";
        getAddrDetailsByIp();
  }

  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(getLatLngByGeo, error, options);
    }
}

/**
 * getLatLngByGeo - separate [lat, long] into lat & long vars, pass to Google Maps API via getGeoDetails
 * @since  1.0.0
 * @param  {number|Array} position [lat, long]
 * @return {[type]}          [description]
 */
function getLatLngByGeo(position) {
  var pos = position;
  var lat = pos.coords.latitude;
  var long = pos.coords.longitude;

  getGeoDetails(lat, long);
}

/**
 * Parses JSON object from DB-IP API, and passes
 * formatted `urlStr` to getLatLongByAddr()
 * @since  1.0.0
 */
function getAddrDetailsByIp() {
  let urlStr = 'https://api.db-ip.com/v2/free/self';
  fetch(urlStr)
    .then(function(response) {
      return response.json();
    })
    .then(function(res) {
      let ip = res["ipAddress"];
      let apiKey = 'AIzaSyDFrCM7Ao83pwu_avw-53o7cV0Ym7eLqpc';
      let city = res["city"];
      let state = res["stateProv"];
      let stateAbbr = abbrRegion(state, 'abbr');
      // console.log(stateAbbr);
      let country = res["countryCode"];
      // If we have something in State Abbr
      state = "Test" + stateAbbr;
      // console.log(state);
      if (stateAbbr) {
      //   // Replace the long state name w/ the abbreviation
        // console.log("Pre:" + state);
        state = stateAbbr;
        // console.log("Post: " + state);
      }
      let address = city + "+" + state + "&components=" + country;
      let urlBase = 'https://maps.googleapis.com/maps/api/geocode/json?';
      let url = urlBase + "&address=" + address + "&key=" + apiKey;
      // use regEx to replace all spaces with plus signs
      let urlStr = url.replace(/\s+/g, "+");
      getLatLongByAddr(urlStr);
    });
}

/**
 * Takes a string of the user's state and returns the two letter abbreviation
 * @param  {[type]} input [description]
 * @param  {[type]} to    [description]
 * @return {[type]}       [description]
 */
function abbrRegion(input, to) {
    var states = [
        ['Alabama', 'AL'],
        ['Alaska', 'AK'],
        ['American Samoa', 'AS'],
        ['Arizona', 'AZ'],
        ['Arkansas', 'AR'],
        ['Armed Forces Americas', 'AA'],
        ['Armed Forces Europe', 'AE'],
        ['Armed Forces Pacific', 'AP'],
        ['California', 'CA'],
        ['Colorado', 'CO'],
        ['Connecticut', 'CT'],
        ['Delaware', 'DE'],
        ['District Of Columbia', 'DC'],
        ['Florida', 'FL'],
        ['Georgia', 'GA'],
        ['Guam', 'GU'],
        ['Hawaii', 'HI'],
        ['Idaho', 'ID'],
        ['Illinois', 'IL'],
        ['Indiana', 'IN'],
        ['Iowa', 'IA'],
        ['Kansas', 'KS'],
        ['Kentucky', 'KY'],
        ['Louisiana', 'LA'],
        ['Maine', 'ME'],
        ['Marshall Islands', 'MH'],
        ['Maryland', 'MD'],
        ['Massachusetts', 'MA'],
        ['Michigan', 'MI'],
        ['Minnesota', 'MN'],
        ['Mississippi', 'MS'],
        ['Missouri', 'MO'],
        ['Montana', 'MT'],
        ['Nebraska', 'NE'],
        ['Nevada', 'NV'],
        ['New Hampshire', 'NH'],
        ['New Jersey', 'NJ'],
        ['New Mexico', 'NM'],
        ['New York', 'NY'],
        ['North Carolina', 'NC'],
        ['North Dakota', 'ND'],
        ['Northern Mariana Islands', 'NP'],
        ['Ohio', 'OH'],
        ['Oklahoma', 'OK'],
        ['Oregon', 'OR'],
        ['Pennsylvania', 'PA'],
        ['Puerto Rico', 'PR'],
        ['Rhode Island', 'RI'],
        ['South Carolina', 'SC'],
        ['South Dakota', 'SD'],
        ['Tennessee', 'TN'],
        ['Texas', 'TX'],
        ['US Virgin Islands', 'VI'],
        ['Utah', 'UT'],
        ['Vermont', 'VT'],
        ['Virginia', 'VA'],
        ['Washington', 'WA'],
        ['West Virginia', 'WV'],
        ['Wisconsin', 'WI'],
        ['Wyoming', 'WY'],
    ];

    // So happy that Canada and the US have distinct abbreviations
    var provinces = [
        ['Alberta', 'AB'],
        ['British Columbia', 'BC'],
        ['Manitoba', 'MB'],
        ['New Brunswick', 'NB'],
        ['Newfoundland', 'NF'],
        ['Northwest Territory', 'NT'],
        ['Nova Scotia', 'NS'],
        ['Nunavut', 'NU'],
        ['Ontario', 'ON'],
        ['Prince Edward Island', 'PE'],
        ['Quebec', 'QC'],
        ['Saskatchewan', 'SK'],
        ['Yukon', 'YT'],
    ];

    var regions = states.concat(provinces);

    var i; // Reusable loop variable
    if (to == 'abbr') {
        input = input.replace(/\w\S*/g, function (txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); });
        for (i = 0; i < regions.length; i++) {
            if (regions[i][0] == input) {
                // console.log(regions[i][1])
                return (regions[i][1]);
            }
        }
    } else if (to == 'name') {
        input = input.toUpperCase();
        for (i = 0; i < regions.length; i++) {
            if (regions[i][1] == input) {
                return (regions[i][0]);
            }
        }
    }
}

/**
 * Extracts lat & long from passed urlStr, and
 * sends to Google Maps Geocoding API via getGeoDetails
 * @param  {string} urlStr [formatted string to plug into Google Maps API]
 * @since  1.0.0
 */
function getLatLongByAddr(urlStr) {
  let url = urlStr;
  fetch(url)
    .then((response) => {
      return response.json();
    })
    .then((res) => {
      let data = new Array(res.results[0]);
      let lat = data[0].geometry.location.lat;
      let long = data[0].geometry.location.lng;
      getGeoDetails(lat, long);
    });
}

/**
 * Feeds lat & long coords into Google Maps API to obtain city and state info and
 * pass to generateTimes()
 *
 * @param  {[float]} lat_crd  [user's lattitude]
 * @param  {[float]} long_crd [user's longitude]
 * @return {[string]} cityStr [user's City, State]
 */
function getGeoDetails(lat_crd, long_crd) {
  let lat = lat_crd;
  let long = long_crd;
  var point = new google.maps.LatLng(lat, long);        new google.maps.Geocoder().geocode({'latLng': point}, function (res, status) {

    if (res[0]) {
      for (var i = 0; i < res.length; i++) {
        if (res[i].types[0] === "locality") {
          var city = res[i].address_components[0].short_name;
        } // end if loop 2

        if (res[i].types[0] === "administrative_area_level_1") {
          var state = res[i].address_components[0].short_name;
        } // end if loop 2
      } // end for loop
    } // end if loop 1

    if (state == null) {
      var cityStr = city;
    } else {
      var cityStr =  city + ", " + state;
    }

    timesHelper(lat, long, cityStr);
  });
}

/**
 * Removes leading 0 from 2-digit month or date numbers and returns to generateTimeStrings
 * @param  {int} x Numerical time passed from generateTimeStrings()
 * @return {int}   1-digit version of int `x` that was passed in
 */
function formatTime(x) {
  var reformattedTime = x.toString();
  reformattedTime = ("0" + x).slice(-2);
  return reformattedTime;
}

/**
 * Splits time object into year, month, day, hour, min, sec and returns buildTimeStr
 * @param  {int} timeObj Value passed in from generateTimes() after formatting from formatTime()
 * @return {string}   Time String in Y-M-D-H-M
 */
function generateSunStrings(timeObj) {
  var year = timeObj.getFullYear();
  var month = formatTime(timeObj.getMonth() + 1);
  var day = formatTime(timeObj.getDate());
  var hour = formatTime(timeObj.getHours());
  var min = formatTime(timeObj.getMinutes());
  var sec = formatTime(timeObj.getSeconds());
  var buildTimeStr = year + "-" + month + "-" + day + " " + hour + ":" + min;
  return buildTimeStr;
}

/**
 * Helper function for generateTimeStrings
 * @param  {object} timeObj Time oject used to build a date string
 * @see generateTimeStrings()
 * @return {string}   The Date in a string
 */
function generateDateString(timeObj) {
  var monthInt = timeObj.getMonth();
  var monthList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var month = monthList[monthInt];
  var day = formatTime(timeObj.getDate());
  var year = timeObj.getFullYear();
  var buildDateStr = '<span id="zemanin_date">' + "Times for " + month + " " + day + ", " + year + '</span>';
  return buildDateStr;
}

function timesHelper(lat, long, city) {
  var cityStr = city;
  var todayTimesObj = SunCalc.getTimes(new Date(), lat, long);
  var shabbatFeed = '<?php echo("$dates[4]"); ?>';
  var shabbatHelperStr = shabbatFeed.substr(0, 19);
  var shabbatHelper = new Date(shabbatHelperStr);
  var shabbatTimesObj = SunCalc.getTimes(new Date(shabbatHelperStr), lat, long);
  var todayTimes = calculateTimes(todayTimesObj, false);
  var shabbatTimes = calculateTimes(shabbatTimesObj, true);
  var todayStrSet = generateTimeStrings(todayTimes, false);
  var shabbatStrSet = generateTimeStrings(shabbatTimes, true);

  displayTimes(todayStrSet, cityStr);
  displayShabbatTimes(shabbatStrSet, cityStr);
}

/**
 * Splits time object into year, month, day, hour, min, sec and returns buildTimeStr
 * @param  {int} timeObj Value passed in from generateTimes() after formatting from formatTime()
 * @return {string}   Time String in Y-M-D-H-M
 */
function generateTimeStrings(timeSet, shabbat) {
  var sunrise = timeSet[0];
  var sunset = timeSet[1];
  var offSet = timeSet[2];
  var sunsetDateTimeInt = timeSet[3];

  var latestShemaStr = '<span id="zemanim_shema">Latest Shema: </span>' + calculateLatestShema(sunrise, sunset, offSet);
  var earliestMinhaStr = '<span id="zemanim_minha">Earliest Minḥa: </span>' + calculateEarliestMinha(sunrise, sunset, offSet);
  var pelegHaMinhaStr = '<span id="zemanim_peleg">Peleḡ HaMinḥa: </span>' + calculatePelegHaMinha(sunrise, sunset, offSet);
  var sunsetStr = '<span id="zemanim_sunset">Sunset: </span>' + unixTimestampToDate(sunsetDateTimeInt + offSet);

  if (shabbat) {
    var candleLighting = timeSet[4];
    var habdala = timeSet[5];
    var candleLightingStr = '<span id="zemanim_habdala">Candle Lighting (18 min): </span>' + unixTimestampToDate(candleLighting + offSet);
    var habdalaStr = '<span id="zemanim_habdala">Haḇdala (20 min): </span>' + unixTimestampToDate(habdala + offSet);
    var shabbatSet = [sunsetStr, candleLightingStr, habdalaStr];

    return shabbatSet;
  } else {
    var todaySet = [latestShemaStr, earliestMinhaStr, pelegHaMinhaStr, sunsetStr];

    return todaySet;
  }

}

/**
 * [calculateTimes description]
 * @param  {array} timeObj  Contains soon-to-be manupulated time data
 * @param  {boolean} shabbat Determines whether we are calculate times for Shabbath or weekday
 * @return {array}         An array of time value integers
 */
function calculateTimes(timeObj, shabbat) {
  var times = timeObj;
  var sunriseObj = times.sunrise;
  var offSet = sunriseObj.getTimezoneOffset() / 60;
  var offSetSec = offSet * 3600;
  var sunriseStr = generateSunStrings(sunriseObj);
  var sunsetObj = times.sunset;
  var sunsetStr = generateSunStrings(sunsetObj);

  var SunriseDateTimeInt = parseFloat((new Date(sunriseStr).getTime() / 1000) - offSetSec);
  var sunsetDateTimeInt = parseFloat((new Date(sunsetStr).getTime() / 1000) - offSetSec);
  var sunriseSec = SunriseDateTimeInt - offSet;
  var sunsetSec = sunsetDateTimeInt - offSet;

  if (shabbat) {
    var candleLightingOffset = 1080;
    var habdalaOffSet = 1200;
    var candleLightingSec = sunsetDateTimeInt - candleLightingOffset;
    var habdalaSec = sunsetDateTimeInt + habdalaOffSet;

    var timeSet = [sunriseSec, sunsetSec, offSetSec, sunsetDateTimeInt, candleLightingSec, habdalaSec];
  } else {
    var timeSet = [sunriseSec, sunsetSec, offSetSec, sunsetDateTimeInt];
  }

  return timeSet;
}

/**
 * [unixTimestampToDate description]
 * @param  {int} timestamp UTC Timestamp
 * @return {string}           Time in H:M:S
 * @since  1.0.0
 */
function unixTimestampToDate(timestamp) {
  var date = new Date(timestamp * 1000);
  var hours = date.getHours();
  var ampm = "AM";
  var minutes = "0" + date.getMinutes();

  if (hours > 12) {
    hours -= 12;
    ampm = "PM";
  }
  else if (hours === 0) {
    hours = 12;
  }
  var formattedTime = hours + ':' + minutes.substr(-2);
  return formattedTime + " " + ampm;
}

/**
 * Calculates the latest halakhic time to say the Shema Yisrael prayer
 * @param  {int} sunriseSec The time of sunrise, in seconds
 * @param  {int} sunsetSec  Time of sunset, in seconds
 * @param  {int} offSetSec  Offset for Time Zone and DST
 * @return {string}            Formatted string in H:M:S
 * @see unixTimestampToDate
 * @since  1.0.0
 */
function calculateLatestShema(sunriseSec, sunsetSec, offSetSec) {
  var halakhicHour = Math.abs((sunsetSec - sunriseSec) / 12);
  var shemaInSeconds = sunriseSec + (halakhicHour * 3) + offSetSec;
  var latestShema = unixTimestampToDate(shemaInSeconds);

  return latestShema;
}

/**
 * Calculates the earliest halakhic time to pray Minḥa
 * @param  {int} sunriseSec The time of sunrise, in seconds
 * @param  {int} sunsetSec  Time of sunset, in seconds
 * @param  {int} offSetSec  Offset for Time Zone and DST
 * @return {string}            Formatted string in H:M:S
 * @see unixTimestampToDate
 */
function calculateEarliestMinha(sunriseSec, sunsetSec, offSetSec) {
  var halakhicHour = (sunsetSec - sunriseSec) / 12;
  var minhaInSeconds = sunriseSec + (halakhicHour * 6.5) + offSetSec;
  var earliestMinha = unixTimestampToDate(minhaInSeconds);

  return earliestMinha;
}

/**
 * Calculates the latest halakhic time to pray Minḥa
 * @param  {int} sunriseSec The time of sunrise, in seconds
 * @param  {int} sunsetSec  Time of sunset, in seconds
 * @param  {int} offSetSec  Offset for Time Zone and DST
 * @return {string}            Formatted string in H:M:S
 * @see unixTimestampToDate
 */
function calculatePelegHaMinha(sunriseSec, sunsetSec, offSetSec) {
  var halakhicHour = (sunsetSec - sunriseSec) / 12;
  var minhaInSeconds = sunsetSec - (halakhicHour * 1.25) + offSetSec;
  var pelegHaMinha = unixTimestampToDate(minhaInSeconds);

  return pelegHaMinha;
}

/**
 * Receives time and location info from generateTimes() and
 * writes innerHtml for front-end display, via jQuery
 * @param  {string} date   Today's Date
 * @param  {string} city   User's City
 * @param  {string} shema  Lastest time to pray Shema
 * @param  {string} minha  Earliest time to pray Minḥa
 * @param  {string} peleg  Latest time to pray Minḥa
 * @param  {string} sunset Time of Sunset
 * @since  1.0.0
 */
function displayTimes(timeSet, city) {
  var city = city;
  var shema = timeSet[0];
  var minha = timeSet[1];
  var peleg = timeSet[2];
  var sunset = timeSet[3];

  // z_date.innerHTML = date + "<br>";
  z_city.innerHTML = city + "<br>";
  z_shema.innerHTML = shema + "<br>";
  z_minha.innerHTML = minha + "<br>";
  z_peleg.innerHTML = peleg + "<br>";
  z_sunset.innerHTML = sunset + "<br>";
}

/**
 * Generates HTML output for display of Shabbath Times
 * @since  1.2.0
 *
 * @param  {array} timeSet an array containing
 * sunset, candle lighting, and habdala information
 * @param  {string} city    Name of the user's city
 * @return {[type]}         [description]
 */
function displayShabbatTimes(timeSet, city) {
  var city = city;
  var sunset = timeSet[0];
  var candleLighting = timeSet[1];
  var habdala = timeSet[2];

  sz_city.innerHTML = city + "<br>";
  sz_sunset.innerHTML = sunset + "<br>";
  sz_candles.innerHTML = candleLighting + "<br>";
  sz_habdala.innerHTML = habdala;

}


  // Make sure we're ready to run our script!
  jQuery(document).ready(function($) {
    getLocation();
  });

</script>

<?php

  echo $args['after_widget'];

} // public function widget ends here

/**
 * Back-end widget form.
 *
 * @see WP_Widget::form()
 *
 * @param array $instance Previously saved values from database.
 */
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'New title', 'luna_zemanim_widget_domain' );
    }

  // Widget admin form
?>
  <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
  </p>
<?php
}

/**
 * Sanitize widget form values as they are saved.
 *
 * @see WP_Widget::update()
 *
 * @param array $new instance Values just sent to be saved from database.
 *
 * @return array Updated safe values to be saved.
 */
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

return $instance;
}

} // class Luna_Zemanim_Widget

$lunacodes_widget = new Luna_Zemanim_Widget();
