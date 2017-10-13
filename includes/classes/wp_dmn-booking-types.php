<?

  /*
  * @class: Action_Handler
  * @description: Checks the submission action
  */

  class Booking_Types {

    /*
    * @payload
    */
    private $payload;

    /*
    * @error
    */
    private $error;

    /*
    * @types
    */
    private $types;

    /*
    * @rules
    */
    private $rules;

    private function __construct ($payload = null, $rules = null) {

      $this->payload = $payload;
      $this->rules = $rules;

      if($this->payload && isset($this->payload->validation->type->errors)) {
        $this->error = $this->payload->validation->type->errors;
      }

      if($this->payload && isset($this->payload->validation->type)) {
        $this->types = $this->payload->validation->type->suggestedValues;
      }

    }

    /*
    * @get_all_types
    */
    public function get_all_types () {

      $type_arr = [];

      if(empty($this->types)) return null;

      foreach($this->types as $type) {

        $booking_type_id = $type->value->id;
        $booking_type_name = $type->value->name;

        if(!is_null($this->rules)) {

          if(isset($this->rules['guestlist']) && $type->value->guestlist != $this->rules['guestlist']) continue;
          if(isset($this->rules['privateHire']) && $type->value->privateHire != $this->rules['privateHire']) continue;

          $type_arr[] = [
            'id' => $booking_type_id,
            'name' => $booking_type_name
          ];

        } else {

          $type_arr[] = [
            'id' => $booking_type_id,
            'name' => $booking_type_name
          ];

        }

      }

      return $type_arr;

    }

    /*
    * @get_error
    */
    public function get_error () {

      if(empty($this->error)) return null;

      return [
        'code' => $this->error[0]->code,
        'message' => $this->error[0]->message
      ];

    }

    /*
    * @forge
    */
    public static function forge ($payload = null, $rules = null) {
      return new static($payload, $rules);
    }
  }

?>
