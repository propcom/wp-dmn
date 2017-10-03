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

      } else {
        echo sprintf('<div class="notice notice-error is-dismissible"><p>%s</p></div>', 'Settings are not setup, please do this and try again');
      }

    }

    public static function forge () {
      return new static();
    }

  }

?>
