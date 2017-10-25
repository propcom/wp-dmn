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
