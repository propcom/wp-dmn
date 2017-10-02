<?

  /*
  * Class Name: DMN_Api_Tester
  * Description: Used to test and make sure that DMN is still live
  */

  class DMN_Api_Tester {

    public function test () {

      // check options are set

      if(!$this->is_options_valid()) {
        echo sprintf('<div class="notice notice-error is-dismissible"><p>%s</p></div>', 'Settings are not setup, please do this and try again');
      }

    }

    private function is_options_valid () {

      if( !get_option ('prop_dmn')['api_key'] ) return false;
      if( !get_option ('prop_dmn')['uid'] ) return false;

      return true;
    }

    public static function forge () {
      return new static();
    }

  }

?>
