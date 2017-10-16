<?

  /*
  * @class: Times
  * @description: Returns times and filters certain times
  */

  class Times {

    /*
    * @payload
    */
    private $payload;

    /*
    * @times
    */
    private $times;

    /*
    * @current_time
    */
    private $current_time;

    /*
    * @future
    */
    private $future;

    /*
    * @user_actions
    */
    private $user_actions = [

      'accept' => 'Your booking will be accepted and automatically confirmed',
      'enquire' => 'Your booking will be processed as an enquiry, but you will need to wait for confirmation',
      'may_enquire' => 'Venue has no availability, but you may choose to submit an enquiry anyway',
      'reject' => 'Bookings cannot be taken at this present time, please try again soon'

    ];

    private function __construct ($payload = null, $future = null) {

      $this->payload = $payload;
      $this->future = $future;

      if($this->payload && isset($payload->validation->time)) {
        $this->times = $payload->validation->time->suggestedValues;
      }

      $this->current_time = time();

    }

    /*
    * @get_times
    */
    public function get_times () {

      $times_arr = [];

      if(empty($this->times)) return null;

      foreach($this->times as $time) {

        if($this->future) {

          if($this->is_future($time->time)) $times_arr[] = [
            'time' => $time->time,
            'timestamp' => strtotime($time->time),
            'action' => (isset($this->user_actions[$time->action]) ? $this->user_actions[$time->action] : $this->action),
            'message' => $time->message
          ];

        } else {

          $times_arr[] = [
            'time' => $time->time,
            'timestamp' => strtotime($time->time),
            'action' => (isset($this->user_actions[$time->action]) ? $this->user_actions[$time->action] : $this->action),
            'message' => $time->message
          ];

        }

      }

      return $times_arr;

    }

    /*
    * @get_from_to
    */
    public function get_from_to ($start, $to) {

      $valid_times = [];

      if(empty($this->times)) return null;

      foreach($this->times as $time) {

        if(strtotime($time->time) >= strtotime($start) && strtotime($time->time) <= strtotime($to)) {
          $valid_times[] = [
            'date' => $time->time,
            'timestamp' => strtotime($time->time),
            'message' => $time->message
          ];
        }

      }

      return $valid_times;

    }

    /*
    * @is_time_available
    */
    public function is_time_available ($chosen_time) {

      $time_available = false;

      if(empty($this->times)) return null;

      foreach($this->times as $time) {

        if(strtotime($time->time) == strtotime($chosen_time) && $time->valid) {
          $time_available = true;
          break;
        }

      }

      return $time_available;

    }

    /*
    * @is_future
    */
    private function is_future ($time_string) {

      if(strtotime($time_string) >= $this->current_time) {
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
