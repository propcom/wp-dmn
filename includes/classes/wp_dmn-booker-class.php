<?

  /*
  * @class: Booking_Class
  * @description: Booking Class to construct the returned data
  */

  class Booking_Class {

    /*
    * @var data
    */
    protected $data;

    /*
    * @var bookings
    */
    private $bookings;

    /*
    * @var availability
    */
    private $availability;

    public function __construct ($data = null) {

      $this->data = $data;

      if($this->data && isset($data->payload->validation)) {
        $this->availability = $data->payload;
      }

    }

    /*
    * @get_action
    */
    public function get_action ($user = false) {

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      return Action_Handler::forge($this->availability)->get_filtered_action($user);
    }

    /*
    * @get_booking_types
    */
    public function get_booking_types ($rules = null) {

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      return Booking_Types::forge($this->availability, $rules)->get_all_types();
    }

    /*
    * @get_capacity
    */
    public function get_capacity ($amount = 1) {

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      $capacity = Capacity_Handler::forge($this->availability);

      return [
        'reached' => $capacity->exceeds_limit($amount),
        'max_capacity' => $capacity->get_limit(),
        'min_capacity' => $capacity->get_minimum()
      ];
    }

    /*
    * @dates
    */
    public function dates ($future = null) {

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      return Dates::forge($this->availability, $future);

    }

    /*
    * @times
    */
    public function times ($future = null) {

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      return Times::forge($this->availability, $future);

    }

    /*
    * @duration
    */
    public function duration () {

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      return Duration_Times::forge($this->availability);

    }

    /*
    * @booking_details
    */
    public function booking_details () {

      $details = [];

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      if(isset($this->availability->bookingDetails)) {

        foreach($this->availability->bookingDetails as $key => $detail) {
          if($key != 'venue_id' && $key != 'venue_group') $details[$key] = $detail;
        }

      }

      return $details;

    }

    /*
    * @submit_booking
    */
    public function submit_booking () {

      if(!$this->availability || $this->is_api_error()) {
        return null;
      }

      if(isset($this->availability->next) && isset($this->availability->next->web)) {
        return $this->availability->next->web;
      }

      return null;

    }

    /*
    * @is_api_error
    */
    private function is_api_error () {

      if($this->data && $this->data->status >= 400) {
        return true;
      }

      return false;

    }
  }

?>
