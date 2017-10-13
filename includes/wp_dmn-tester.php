<?

  /*
  * Class Name: DMN_Api_Tester
  * Description: Used to test and make sure that DMN is still live
  */

  class DMN_Api_Tester {

    public function test () {

      $dmn_api = Wordpress_DMN_Api::forge();

      // check options are set
      if($dmn_api->is_setup()) {
        $api_rates = $dmn_api->submit()->get_rate_limits();

        echo sprintf('<div class="notice notice-warning is-dismissible"><p>You have %s api requests left on this App, this will reset back to %s on %s at %s</p></div>', $api_rates->remaining, $api_rates->limit, $api_rates->reset_date, $api_rates->reset_time);

      } else {
        echo sprintf('<div class="notice notice-error is-dismissible"><p>%s</p></div>', 'Settings are not setup, please do correct this and try again');
      }

    }

    public static function forge () {
      return new static();
    }

  }

?>
