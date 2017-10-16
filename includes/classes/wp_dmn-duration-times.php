<?

  /*
  * @class: Duration Times
  * @description: Returns duration times and filters certain times
  */

  class Duration_Times {

    /*
    * @payload
    */
    private $payload;

    /*
    * @times
    */
    private $times;

    private function __construct ($payload = null, $future = null) {

      $this->payload = $payload;

      if($this->payload && isset($payload->validation->time)) {
        $this->times = $payload->validation->duration->suggestedValues;
      }

    }

    /*
    * @get_times
    */
    public function get_times () {

      $times_arr = [];

      if(empty($this->times)) return null;

      foreach($this->times as $time) {

        $times_arr[] = [
          'duration' => $time->label,
          'endTime' => (isset($time->endTime) ? $time->endTime : null)
        ];

      }

      return $times_arr;

    }

    /*
    * @is_duration_available
    */
    public function is_duration_available ($duration) {

      $duration_available = false;

      if(empty($this->times)) return null;

      foreach($this->times as $time) {

        if($duration == $time->value) {
          $duration_available = true;
          break;
        }

      }

      return $duration_available;

    }

    /*
    * @forge
    */
    public static function forge ($payload = null) {
      return new static($payload);
    }
  }

?>
