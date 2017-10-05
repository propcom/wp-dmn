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

      if($this->data && isset($data->payload->bookings)) {
        $this->bookings = $data->payload->bookings;
      }

      if($this->data && isset($data->payload->validation)) {
        $this->availability = $data->payload;
      }

    }

    /*
    * @get_venues
    */
    public function get_venues () {

      if(!$this->bookings) {
        return null;
      }

    }

    /*
    * @get_availability
    */
    public function get_availability () {

      if(!$this->availability) {
        return null;
      }

    }
  }

?>
