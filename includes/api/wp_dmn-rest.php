<?

  class DMNApi extends WP_REST_Controller {

    public $logged_in;

    public function __construct ( $logged_in ) {

      $this->logged_in = $logged_in;

    }

    public function register_routes() {

      $version = '1';
      $namespace = 'dmn/v' . $version;
      $base = 'bookings';

      register_rest_route( $namespace, '/'.$base, [
        [
          'methods' => WP_REST_Server::READABLE,
          'callback' => [ $this, 'get_booking_types' ],
        ],
      ] );

      register_rest_route( $namespace, '/booking', [
        [
          'methods' => WP_REST_Server::CREATABLE,
          'callback' => [ $this, 'query_bookings' ],
        ],
      ] );

    }

    /**
     * Get list booking types from DMN
     */
    public function get_booking_types ( $request ) {

      if( $request ) {

        $responseData = [];
        $dmn = WP_DMN::forge( (isset($request->get_query_params()['venue']) ? $request->get_query_params()['venue'] : null) );

        if($dmn->is_ready()) {

          $data = [

            'status' => 'success',
            'code' => 200,
            'data' => $dmn->request()->get_booking_types(),

          ];

        } else {

          $data = [

            'status' => 'error',
            'code' => 403,
            'message' => 'Permission forbidden, user has not setup there security deets',

          ];

        }

      } else {

        $data = [

          'status' => 'error',
          'code' => 403,
          'message' => 'Permission forbidden',

        ];

      }

      return new WP_REST_Response( $data, 200 );

    }

    /**
     * Query DMN Api for bookings
     */
    public function query_bookings ( $request ) {

      if( $request ) {

        $responseData = [];
        $responseDataKey = 'data';

        $dmn = WP_DMN::forge( (isset($request->get_json_params()['venue']) ? $request->get_json_params()['venue'] : null) );

        // check body params - Add needed fields
        if(isset($request->get_json_params()['type'])) {
          $dmn->add_field('type', $request->get_json_params()['type']);
        }

        if(isset($request->get_json_params()['num_people'])) {
          $dmn->add_field('num_people', $request->get_json_params()['num_people']);
        }

        if(isset($request->get_json_params()['date'])) {
          $dmn->add_field('date', $request->get_json_params()['date']);
        }

        if(isset($request->get_json_params()['time'])) {
          $dmn->add_field('time', $request->get_json_params()['time']);
        }

        if(isset($request->get_json_params()['duration'])) {
          $dmn->add_field('duration', $request->get_json_params()['duration']);
        }

        // make the request
        $dmn->request();

        // check body params - To return the needed data
        if(isset($request->get_json_params()['type'])) {
          $responseData['types'] = $dmn->get_booking_types();
        }

        if(isset($request->get_json_params()['num_people'])) {
          $responseData['num_people'] = $dmn->get_capacity($request->get_json_params()['num_people']);
        }

        if(isset($request->get_json_params()['date'])) {
          $dates = $dmn->dates();
          $responseData['dates'] = [
            'list' => $dates->get_dates(),
            'available' => $dates->is_date_available($request->get_json_params()['date'])
          ];
        }

        if(isset($request->get_json_params()['time'])) {
          $times = $dmn->times();
          $responseData['times'] = [
            'list' => $times->get_times(),
            'available' => $times->is_time_available($request->get_json_params()['time'])
          ];
        }

        if(isset($request->get_json_params()['duration'])) {
          $duration = $dmn->duration();
          $responseData['duration'] = [
            'list' => $duration->get_times(),
            'available' => $duration->is_duration_available($request->get_json_params()['duration'])
          ];
        }

        // return submited deets so far
        if(isset($request->get_query_params()['details'])) {
          $responseData['details'] = $dmn->get_booking_details();
        }

        if(isset($request->get_query_params()['submit'])) {
          $responseData = $dmn->submit_booking();
          $responseDataKey = 'next';
        }

        if($dmn->is_ready()) {

          $data = [

            'status' => 'success',
            'code' => 200,
            $responseDataKey => $responseData,

          ];

        } else {

          $data = [

            'status' => 'error',
            'code' => 403,
            'message' => 'Permission forbidden, user has not setup there security deets',

          ];

        }

      } else {

        $data = [

          'status' => 'error',
          'code' => 403,
          'message' => 'Permission forbidden',

        ];

      }

      return new WP_REST_Response( $data, 200 );

    }

  }

  add_action( 'rest_api_init', function () {

    $logged_in = is_user_logged_in();

    $dmn = new DMNApi( $logged_in );
    $dmn->register_routes();

  } );

?>
