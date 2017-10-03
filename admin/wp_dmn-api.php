<?

  /*
  * @class: Wordpress_DMN_Api
  * @description: DMN api class for returning json data from DMN api
  */

  class Wordpress_DMN_Api {

    /*
    * @api_url
    */
    private $api_url = 'https://api.designmynight.com/v4/';

    /*
    * @method
    */
    private $api_method = 'POST';

    /*
    * @headers
    */
    private $api_headers = [];

    /*
    * @wp_args
    */
    private $wp_args = [];

    /*
    * @venue_id
    */
    private $venue_id;

    /*
    * @api_ready
    */
    private $api_ready = false;

    /*
    * @endpoints
    */
    private $endpoints = [];

    /*
    * @post_fields
    */
    private $post_fields = null;

    /*
    * @response_headers
    */
    private $response_headers = [];

    /*
    * @api_data
    */
    private $api_data = null;

    protected function __construct ($venue_id = null) {

      $this->wp_args = [
        'method' => $this->api_method,
        'timeout' => 30,
        'sslverify' => false
      ];

      $this->venue_id = $venue_id;

      try {

        if(!$this->is_options_valid()) {

          $this->report_error('DMN Settings are not setup correctly, so we have disabled widget on FE');

        } else {

          $this->setup_headers();
          $this->api_ready = true;

        }

      } catch (Wordpress_DMN_Api_Exception $ex) {}

    }

    /*
    * @get_availability_url
    */
    public function get_availability_url () {
      return $this->endpoints['availability'];
    }

    /*
    * @setup_headers
    */
    private function setup_headers () {

      if(!$this->is_options_valid()) {
        $this->report_error('DMN Settings are not setup correctly, this means your widget will not render on FE');
      }

      $this->api_headers = [
        'Content-Type' => 'application/json',
        'Authorization' => get_option ('prop_dmn')['uid'].':'.get_option ('prop_dmn')['api_key']
      ];

      $this->endpoints['availability'] = $this->api_url . '/bookings';
      if($this->venue_id) {
        $this->endpoints['availability'] = $this->api_url . '/venues/' . $this->venue_id . '/booking-availability';
      }

      $this->wp_args['headers'] = $this->api_headers;

    }

    /*
    * @fields
    */
    public function fields ($arr = []) {

      if(!empty($arr)) {
        $this->post_fields = $arr;
      }

      return $this;

    }

    /*
    * @submit
    */
    public function submit () {

      try {

        if(($url = $this->endpoints['availability'])) {

          $api_repsonse = $this->post_data($url);

          if(isset($api_repsonse['response']) && isset($api_repsonse['body'])) {

            $this->api_data['code'] = $api_repsonse['response']['code'];
            $this->api_data['message'] = $api_repsonse['response']['message'];
            $this->api_data['data'] = $api_repsonse['body'];

            $this->response_headers = $api_repsonse['headers'];

          }

        }

      } catch (Wordpress_DMN_Api_Exception $ex) {
        echo $ex->getMessage();
      }

      return $this;

    }

    /*
    * @post_data
    */
    private function post_data ($url) {

      $return = null;

      if($url && isset($this->wp_args['headers'])) {

        if($this->post_fields) {
          $this->wp_args['body'] = json_encode($this->post_fields);
        }

        $response = wp_remote_post($url, $this->wp_args);

        if(!is_wp_error($response)) {

          $return = $response;

        } else {
          throw new Wordpress_DMN_Api_Exception('Error Occurred: ' . $response->get_error_message());
        }

      }

      return $return;

    }

    /*
    * @get_rate_limits
    */
    public function get_rate_limits () {
      // get api rate limits
    }

    /*
    * @report_error
    */
    private function report_error ($err) {

      $this->log_error($err);

      if(is_array($err) || is_object($err)) {
        throw new Wordpress_DMN_Api_Exception(print_r($err, true));
      } else {
        throw new Wordpress_DMN_Api_Exception($err);
      }

    }

    /*
    * @log_error
    */
    private function log_error ($err = null) {

      if(defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {

        if(is_array($err) || is_object($err)) {
          error_log( 'DMN_Api Error: ' . print_r($err, true) );
        } else {
          error_log( 'DMN_Api Error: ' . $err );
        }

      }

    }

    /*
    * @get_data
    */
    public function get_raw_data () {
      return $this->api_repsonse['data'];
    }

    /*
    * @is_options_valid
    */
    private function is_options_valid () {

      if( !get_option ('prop_dmn')['api_key'] ) return false;
      if( !get_option ('prop_dmn')['uid'] ) return false;

      return true;
    }

    /*
    * @is_setup
    */
    public function is_setup () {
      return $this->api_ready;
    }

    /*
    * @forge
    * @params - Venue Id
    */
    public static function forge ($venue_id = null) {
      return new static($venue_id);
    }

  }

?>
