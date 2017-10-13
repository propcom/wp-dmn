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
