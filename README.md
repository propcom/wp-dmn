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

**Get a list of dates**
```PHP
if($dmn_api->is_ready()) {
  // get all dates for current month
  $dates = $dmn_api->request()->dates()->get_dates();

  // get all dates from the current date to end of current month
  $dates = $dmn_api->request()->dates(true)->get_dates();
}
```

## API Docs

You have access to some useful functions, here are just a few...

`get_acceptance()` - Each request returns a set of actions, meaning it tells the user what will happen once they submit there details.

`dates()` - Returns an instance of the Dates class, giving you access to the below functions:

  - `get_dates()` returns all dates available for the current month.
  - `get_from_to()` filters out dates between 2 dates.
  - `is_date_available()` returns a boolean based on of the given date is available or not.
