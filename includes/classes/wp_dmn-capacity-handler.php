<?

  /*
  * @class: Capacity_Handler
  * @description: Checks the capacity of number people allowed
  */

  class Capacity_Handler {

    /*
    * @payload
    */
    private $payload;

    /*
    * @max_num
    */
    private $max_num;

    /*
    * @min_num
    */
    private $min_num;

    private function __construct ($payload = null) {

      $this->payload = $payload;

      if($this->payload && isset($payload->validation->num_people)) {
        $this->min_num = $payload->validation->num_people->rules->min;
        $this->max_num = $payload->validation->num_people->rules->max;
      }

    }

    /*
    * @exceeds_limit
    */
    public function exceeds_limit ($amount = 1) {
      return ($amount > $this->max_num);
    }

    /*
    * @matched_minimum
    */
    public function matched_minimum ($amount = 1) {
      return ($amount > $this->min_num);
    }

    /*
    * @get_limit
    */
    public function get_limit () {
      return $this->max_num;
    }

    /*
    * @get_minimum
    */
    public function get_minimum () {
      return $this->min_num;
    }

    /*
    * @forge
    */
    public static function forge ($payload = null) {
      return new static($payload);
    }
  }

?>
