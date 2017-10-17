<?

  /*
  * @class: WP_DMN
  * @description: Front end class used to communicate to api
  */

  class WP_DMN {

    /*
    * @dmn_api
    */
    private $dmn_api;

    /*
    * @dmn_post_fields
    */
    private $dmn_post_fields;

    /*
    * @booking_type_rules
    */
    private $booking_type_rules;

    private function __construct () {
      $this->dmn_api = Wordpress_DMN_Api::forge();

      $this->dmn_post_fields = [];
      $this->booking_type_rules = null;
    }

    /*
    * @add_field
    */
    public function add_field ($field_name, $field_value) {
      $this->dmn_post_fields[$field_name] = $field_value;
      return $this;
    }

    /*
    * @is_ready
    */
    public function is_ready () {
      return $this->dmn_api->is_setup();
    }

    /*
    * @add_rules
    */
    public function add_rules ($rules) {
      $this->booking_type_rules = $rules;
      return $this;
    }

    /*
    * @request
    */
    public function request () {
      $limit = $this->dmn_api->fields($this->dmn_post_fields)->submit()->get_rate_limits();

      // give your app a break
      if($limit->remaining == 1) {
        return null;
      }

      return $this;
    }

    /*
    * @as_array
    */
    public function as_array () {
      return [
        'acceptance' => $this->get_acceptance(),
        'booking_types' => $this->get_booking_types()
      ];
    }

    /*
    * @get_acceptance
    */
    public function get_acceptance () {
      return $this->dmn_api->booking()->get_action(true);
    }

    /*
    * @get_booking_types
    */
    public function get_booking_types () {
      return $this->dmn_api->booking()->get_booking_types($this->booking_type_rules);
    }

    /*
    * @get_capacity
    */
    public function get_capacity ($amount = 1) {
      return $this->dmn_api->booking()->get_capacity($amount);
    }

    /*
    * @dates
    */
    public function dates ($future = null) {
      return $this->dmn_api->booking()->dates($future);
    }

    /*
    * @times
    */
    public function times ($future = null) {
      return $this->dmn_api->booking()->times($future);
    }

    /*
    * @duration
    */
    public function duration () {
      return $this->dmn_api->booking()->duration();
    }

    /*
    * @get_booking_details
    */
    public function get_booking_details () {
      return $this->dmn_api->booking()->booking_details();
    }

    /*
    * @submit_booking
    */
    public function submit_booking () {
      return $this->dmn_api->booking()->submit_booking();
    }

    /*
    * @forge
    */
    public static function forge () {
      return new static();
    }
  }

?>
