<?

  /*
  * @class: Action_Handler
  * @description: Checks the submission action
  */

  class Action_Handler {

    /*
    * @payload
    */
    private $payload;

    /*
    * @action
    */
    private $action;

    /*
    * @actions
    */
    private $actions = [

      'accept:success' => 'Bookings will be accepted and automatically confirmed',
      'enquire:warning' => 'Bookings will be processed as an enquiry, but customer will have to wait for confirmation',
      'may_enquire:warning' => 'Venue has not availability, but the customer may choose to submit an enquiry anyway',
      'reject:error' => 'Bookings cannot be accommodated, your customers will not be able to make any bookings'

    ];

    /*
    * @actions
    */
    private $user_actions = [

      'accept:success' => 'Your booking will be accepted and automatically confirmed',
      'enquire:warning' => 'Your booking will be processed as an enquiry, but you will need to wait for confirmation',
      'may_enquire:warning' => 'Venue has no availability, but you may choose to submit an enquiry anyway',
      'reject:error' => 'Bookings cannot be taken at this present time, please try again soon'

    ];

    private function __construct ($payload = null) {

      $this->payload = $payload;
      $this->action = 'reject';

      if($this->payload && isset($this->payload->action)) {
        $this->action = $this->payload->action;
      }

    }

    /*
    * @get_filtered_action
    */
    public function get_filtered_action ($user = false) {

      $filtered = null;
      $possible_actions = ($user ? $this->user_actions : $this->actions);

      foreach($possible_actions as $key => $an_action) {

        $type = explode(':', $key)[0];
        $notice_type = explode(':', $key)[1];

        if($type == $this->action) {
          $filtered = [
            'notice' => $notice_type,
            'message' => $an_action
          ];
        }

      }

      return $filtered;

    }

    /*
    * @forge
    */
    public static function forge ($payload = null) {
      return new static($payload);
    }
  }

?>
