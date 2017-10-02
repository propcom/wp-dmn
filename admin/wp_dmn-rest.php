<?

  class DMNApi extends WP_REST_Controller {

    public $logged_in;

    public function __construct ( $logged_in ) {

      $this->logged_in = $logged_in;

    }

    public function register_routes() {

      $version = '1';
      $namespace = 'dmn/v' . $version;
      $base = 'widget';

      register_rest_route( $namespace, '/' . $base . '/(?P<id>[a-zA-Z|0-9]+)', [

        [
          'methods' => WP_REST_Server::READABLE,
          'callback' => [ $this, 'get_booking' ],
          'args' => [

            'id' => [

              'validate_callback' => function ( $param, $request, $key ) {

								return is_numeric( $param );

							}

            ]

          ],

        ],

      ] );

    }

    /**
     * Get the booking info from DMN
     */
    public function get_booking ( $request ) {

      if( $request ) {

        $dmn = Wordpress_DMN_Api::forge($request->get_param('id'));

        if($dmn->is_setup()) {

          $data = [

            'status' => 'success',
            'code' => 200,
            'data' => $dmn->submit()->get_raw_data(),

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
