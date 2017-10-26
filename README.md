# DMN Plugin

Design My Night Plugin for wordpress

```Version 1.0```

## Front End API Documentation

Check that the plugin options have been setup correctly, by using the `is_ready()` function.
```PHP
$dmn_api = WP_DMN::forge();

if($dmn_api->is_ready()) {
  // Ok we are ready to use our functions
}
```

After our `is_ready()` check we can retreive a list booking types, such as Private Dining and Private Events etc...
```PHP
if($dmn_api->is_ready()) {
  // get all booking types
  $booking_types = $dmn_api->request()->get_booking_types();
}
```
Our `request()` function is required before any resource functions are called, as this function is responsible for calling the API and returning our resource data.

The `request()` function will return null if the plugin detects that the API needs a breather, this allows you to check instead of having your form break

**Add Fields in our requests**

Apart from booking types and dates, our other resource types such as time, duration etc require certain fields to be present in our requests. For example to pull through times, we can do the below:
```PHP
if($dmn_api->is_ready()) {
  // add fields needed
  // [type-id] one of our booking types
  // [num-people] number of people in our party
  // [date] date we want to book for
  $dmn_api->add_field('type', '[type-id]')->add_field('num_people', '[num-people]')->add_field('date', '[date]')->request();

  // now we can request times
}
```
If the above fields were not present, then when we try and retrieve our times, `null` would return.

**Get a list of dates**
```PHP
if($dmn_api->is_ready() && $dmn_api->request()) {
  // get all dates for current month
  $dates = $dmn_api->dates()->get_dates();

  // get all dates from the current date to end of current month
  $dates = $dmn_api->dates(true)->get_dates();
}
```

**Get a list of times**

Date field is required in request so as to return a list of times.
```PHP
if($dmn_api->is_ready() && $dmn_api->request()) {
  // get all times for current date
  $times = $dmn_api->times()->get_times();

  // get all times from the current time to midnight
  $times = $dmn_api->times(true)->get_times();
}
```

**Get a lits of duration times**

Time field is required in request so as to return a list of duration times.
```PHP
if($dmn_api->is_ready() && $dmn_api->request()) {
  // get all duration times for chosen time
  $duration_times = $dmn_api->duration()->get_times();
}
```

**Get our booking details**

DMN API kindly tracks our details we have posted in our request so far.
```PHP
if($dmn_api->is_ready() && $dmn_api->request()) {
  // get our booking details
  $deets = $dmn_api->get_booking_details();
}
```

**Submit Our Booking**

Once we have given DMN enough booking information, the api will return a web link to proceed with final booking.
```PHP
if($dmn_api->is_ready() && $dmn_api->request()) {
  // imagine we have added needed fields above
  $web_link = $dmn_api->submit_booking();
}
```
Returns `null` if not enough inforamtion has been given to generate this link

## API Docs

You have access to some useful functions, here are just a few...

`get_acceptance()` - Each request returns a set of actions, meaning it tells the user what will happen once they submit there details.

`dates()` - Returns an instance of the Dates class, giving you access to the below functions:

  - `get_dates()` returns all dates available for the current month.
  - `get_from_to($from, $to)` filters out dates between 2 dates.
  - `is_date_available($date)` returns a boolean based on of the given date is available or not.
