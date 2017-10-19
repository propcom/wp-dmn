<?

  /*
  * @class: Dates
  * @description: Returns dates and filters certain dates
  */

  class Dates {

    /*
    * @payload
    */
    private $payload;

    /*
    * @dates
    */
    private $dates;

    /*
    * @current_date
    */
    private $current_date;

    /*
    * @future
    */
    private $future;

    private function __construct ($payload = null, $future = null) {

      $this->payload = $payload;
      $this->future = $future;

      if($this->payload && isset($payload->validation->date)) {
        $this->dates = $payload->validation->date->suggestedValues;
      }

      $this->current_date = time();

    }

    /*
    * @get_dates
    */
    public function get_dates () {

      $dates_arr = [];

      if(empty($this->dates)) return null;

      foreach($this->dates as $date) {

        if($this->future) {

          if($this->is_future($date->date)) $dates_arr[] = [
            'date' => $date->date,
            'timestamp' => strtotime($date->date),
            'message' => $date->message
          ];

        } else {

          $dates_arr[] = [
            'date' => $date->date,
            'timestamp' => strtotime($date->date),
            'message' => $date->message
          ];

        }

      }

      return $dates_arr;

    }

    /*
    * @get_from_to
    */
    public function get_from_to ($start, $to) {

      $valid_dates = [];

      if(empty($this->dates)) return null;

      foreach($this->dates as $date) {

        if(strtotime($date->date) >= strtotime($start) && strtotime($date->date) <= strtotime($to)) {
          $valid_dates[] = [
            'date' => $date->date,
            'timestamp' => strtotime($date->date),
            'message' => $date->message
          ];
        }

      }

      return $valid_dates;

    }

    /*
    * @is_date_available
    */
    public function is_date_available ($chosen_date) {

      $date_available = false;

      if(empty($this->dates)) return null;

      foreach($this->dates as $date) {
        
        if(strtotime($date->date) == strtotime($chosen_date)) {
          $date_available = true;
          break;
        }

      }

      return $date_available;

    }

    /*
    * @is_future
    */
    private function is_future ($date_string) {

      if(strtotime($date_string) >= $this->current_date) {
        return true;
      }

      return false;

    }

    /*
    * @forge
    */
    public static function forge ($payload = null, $future = null) {
      return new static($payload, $future);
    }
  }

?>
