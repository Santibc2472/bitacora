<?php
/**
 * @author: roboter
 * @date: 22.10.12
 * @time: 20:03
 *
 */

if ( ! defined( 'USER' ) ) {
	define( 'USER', 'User.svc/' );
}
if ( ! defined( 'USERGET' ) ) {
	define( 'USERGET', 'User.svc/get' );
}
if ( ! defined( 'PLACE' ) ) { // 'Place.svc/place' - for old version
	define( 'PLACE', 'Place.svc/' );
}
if ( ! defined( 'SERVICE' ) ) {
	define( 'SERVICE', 'Service.svc/' );
}
if ( ! defined( 'CATEGORY' ) ) {
	define( 'CATEGORY', 'Category.svc/' );
}
if ( ! defined( 'RESERVATION' ) ) {
	define ( 'RESERVATION', 'Reservation.svc/' );
}
if ( ! defined( 'EMAILCONTENT' ) ) {
	define( 'EMAILCONTENT', 'emailcontent.svc/' );
}
if ( ! defined( 'DATES' ) ) {
	define( 'DATES', 'Date.svc/' );
}
if ( ! defined('CUSTOMFIELDS')){
    define( 'CUSTOMFIELDS', 'CustomFields.svc/' );
}
if ( ! defined( 'POST' ) ) {
	define( 'POST', 'POST' );
}
if ( ! defined( 'GET' ) ) {
	define( 'GET', 'GET' );
}
if ( ! defined( 'PUT' ) ) {
	define( 'PUT', 'PUT' );
}
if ( ! defined( 'DELETE' ) ) {
	define( 'DELETE', 'DELETE' );
}
if ( ! defined( 'REMINDER' ) ) {
	define ( 'REMINDER', 'Reminder.svc/' );
}
if ( ! defined( 'REDI_SUCCESS' ) ) {
	define( 'REDI_SUCCESS', 'SUCCESS' );
}
if ( ! defined( 'REDI_RESTAURANT_API' ) ) {
	define( 'REDI_RESTAURANT_API', 'http://api.reservationdiary.eu/service/' );
}

if ( ! defined( 'CUSTOM_FIELDS' ) ) {
	define( 'CUSTOM_FIELDS', 11 );
}

if ( ! defined( 'WAITLIST' ) ) {
    define( 'WAITLIST', 'WaitList.svc/' );
}

if ( ! class_exists( 'ReDi' ) ) {
	class Redi {
		private $ApiKey;

        public function __construct( $ApiKey ) {
            $this->ApiKey = $ApiKey;
        }
		public function Redi( $ApiKey ) {
			$this->ApiKey = $ApiKey;
		}

		public function deleteCustomField( $lang, $placeID, $customFieldID ) {
			return $this->request( REDI_RESTAURANT_API . CUSTOMFIELDS . $lang . '/' . $this->ApiKey . '/place/' . $placeID . '/customfield/' . $customFieldID, DELETE );
		}

		public function updateCustomField( $lang, $placeID, $customFieldID, $params ) {
			return $this->request( REDI_RESTAURANT_API . CUSTOMFIELDS .'/v1/'. $lang . '/' . $this->ApiKey . '/place/' . $placeID . '/customfield/' . $customFieldID, PUT,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function saveCustomField( $lang, $placeID, $params ) {
			return $this->request( REDI_RESTAURANT_API . CUSTOMFIELDS .'/v1/'. $lang . '/' . $this->ApiKey . '/place/' . $placeID, POST,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function getCustomField( $lang, $placeID ) {
			return $this->request( REDI_RESTAURANT_API . CUSTOMFIELDS . $lang . '/' . $this->ApiKey . '/place/' . $placeID, GET );
		}

		public function getBlockingDates( $lang, $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . DATES  . $lang . '/'.$this->ApiKey.'/'. $categoryID, GET,  self::strParams( $params ) );
		}

		public function getReservationUrl( $lang ) {
			return '//wp.reservationdiary.eu/' . $lang . '/' . $this->ApiKey . '/Reservation/Index';
		}

		public function getEmailContent( $reservationID, $type, $params ) {
			return $this->request( REDI_RESTAURANT_API . EMAILCONTENT . $this->ApiKey . '/' . $reservationID . '/ClientReservation' . $type,
				GET, self::strParams( $params ) );
		}

		public function cancelReservationByClient( $params ) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION .'/v1/'. $this->ApiKey . '/cancelByClient', DELETE,
				self::strParams( $params ) );
		}

		public function cancelReservation( $params ) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $this->ApiKey . '/cancelByProvider', DELETE,
				self::strParams( $params ) );
		}

		public function findReservation($lang, $reservationID) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $lang . '/' . $this->ApiKey . '/getReservation/' . $reservationID, GET);
	    }

		public function createReservation( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $this->ApiKey . '/' . $categoryID, POST,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function updateReservation($reservationID, $lang, $currentTime, $dontNotifyClient, $params)
		{
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $this->ApiKey . '/update/' . $reservationID . 
				'?Lang=' . $lang . '&CurrentTime=' . $currentTime . '&DontNotifyClient=' . $dontNotifyClient, PUT,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function addWaitList($placeID, $params, $currentTime, $lang){
            return $this->request( REDI_RESTAURANT_API . WAITLIST . $lang .'/v1/' . $this->ApiKey . '/place/' . $placeID . '?currentTime='. $currentTime, POST, json_encode( self::unescape_array( $params ) ) );
		}
		
		public function addReminder( $placeID, $lang, $params ) {
			return $this->request( REDI_RESTAURANT_API . REMINDER . $lang . '/' . $this->ApiKey . '/place/' . $placeID, POST,
				json_encode( self::unescape_array( $params ) ) );
		}

		/**
		 * @param $categoryID
		 * @param $params array
		 * <pre>
		 * StartTime -
		 * EndTime
		 * Quantity
		 * Alternatives
		 * </pre>
		 *
		 * @return array
		 */
		public function query( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $this->ApiKey . '/' . $categoryID . '/Person',
				GET, self::strParams( $params ) );
		}

		public function createCategory( $placeID, $params ) {
			return $this->request( REDI_RESTAURANT_API . CATEGORY . $this->ApiKey . '/' . $placeID, POST,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function getServices( $categoryID ) {
			return $this->request( REDI_RESTAURANT_API . SERVICE . $this->ApiKey . '/' . $categoryID . '/Person', GET );
		}

		public function deleteServices( $categoryID, $quantity ) {
			return $this->request( REDI_RESTAURANT_API . SERVICE . $this->ApiKey . '/' . $categoryID . '/person/delete?quantity=' . $quantity,
				DELETE );
		}

		public function setServiceTime( $categoryID, $timeSet ) {
			return $this->request( REDI_RESTAURANT_API . CATEGORY . $this->ApiKey . '/' . $categoryID . '/time',
				PUT,
				json_encode( self::unescape_array( array( 'timeSet' => $timeSet ) ) ) );
		}

		public function getServiceTime( $categoryID ) {
			return $this->request( REDI_RESTAURANT_API . CATEGORY . $this->ApiKey . '/' . $categoryID . '/time', GET );
		}

		public function createService( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . SERVICE . $this->ApiKey . '/' . $categoryID, POST,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function userGetError() {
			return $this->request( REDI_RESTAURANT_API . USERGET );
		}

		public function createUser( $params ) {
			return $this->request( REDI_RESTAURANT_API . USER, POST, json_encode( self::unescape_array( $params ) ) );
		}

		public function setPlace( $placeID, $params ) {
			return $this->request( REDI_RESTAURANT_API . PLACE . $this->ApiKey . '/' . $placeID, PUT,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function createPlace( $params ) {
			return $this->request( REDI_RESTAURANT_API . PLACE . $this->ApiKey, POST,
				json_encode( self::unescape_array( $params ) ) );
		}

		public function shiftsStartTime( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . CATEGORY . $this->ApiKey . '/' . $categoryID . '/shiftsStartTime',
				GET, self::strParams( $params ) );
		}

		public function availabilityByDay( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $this->ApiKey . '/' . $categoryID . '/availabilityByDay/Person',
				GET, self::strParams( $params ) );
		}

		public function availabilityByShifts( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $this->ApiKey . '/' . $categoryID . '/availabilityByShifts/Person',
				GET, self::strParams( $params ) );
		}

		public function getCustomDurationAvailability( $categoryID, $params) {
			return $this->request( REDI_RESTAURANT_API . RESERVATION . $this->ApiKey . '/' . $categoryID . '/guestsByStayDuration',
				GET, self::strParams( $params ) );
		}

		public function getPlace( $placeID ) {
			return $this->request( REDI_RESTAURANT_API . PLACE . $this->ApiKey . '/' . $placeID, GET );
		}

		public function getPlaceCategories( $placeID ) {
			return $this->request( REDI_RESTAURANT_API . PLACE . $this->ApiKey . '/' . $placeID . '/categories', GET );
		}

		public function getPlaces() {
			return $this->request( REDI_RESTAURANT_API . PLACE . $this->ApiKey, GET );
		}

		public function setApiKey( $ApiKey ) {
			$this->ApiKey = $ApiKey;
		}

		public static function strParams( $params ) {
			$url_param = '';
			$first     = 0;

			if ( is_array( $params ) ) {
				foreach ( $params as $param_name => $param_value ) {
					$url_param .= ( ( $first ++ == 0 ) ? '?' : '&' ) . $param_name . '=' . $param_value;
				}
			}

			return $url_param;
		}

		private static function unescape_array( $array ) {
			$unescaped_array = array();
			foreach ( $array as $key => $val ) {
				if ( is_array( $val ) ) {
					$unescaped_array[ $key ] = self::unescape_array( $val );
				} else {
					$unescaped_array[ $key ] = stripslashes( $val );
				}
			}

			return $unescaped_array;
		}

		private function request( $url, $method = GET, $params_string = null ) {
			$request = new WP_Http;
			$curTime = microtime( true );
			$req     = array(
				'method'  => $method,
				'body'    => (($method === GET || $method === DELETE ) ? null : $params_string),
				'headers' => array(
					'Content-Type'   => 'application/json; charset=utf-8',
					'Content-Length' => ($method === GET || $method === DELETE ) ? 0 : strlen( $params_string )
				)
			);
			$output  = $request->request(
				$url . ( ( $method === GET || $method === DELETE ) ? $params_string : '' ), $req );
			if ( is_wp_error( $output ) ) {
				return array(
					'request_time' => round( microtime( true ) - $curTime, 3 ) * 1000,
					'Error'        => __( 'Online reservation service is not available at this time. Try again later or contact us <a href="mailto:info@reservationdiary.eu;'.get_bloginfo('admin_email').'?subject=Reservation form is not working&body='.get_bloginfo().'">directly</a>',
						'redi-restaurant-reservation' ),
					'Wp-Error'     => $output->errors
				);
			}

			if ( $output['response']['code'] != 200 && $output['response']['code'] != 400 ) {
				return array(
					'response_code' => $output['response']['code'],
					'Error'         => __( 'Online reservation service is not available at this time. Try again later or contact us <a href="mailto:info@reservationdiary.eu;'.get_bloginfo('admin_email').'?subject=Reservation form is not working&body='.get_bloginfo().'">directly</a>',
						'redi-restaurant-reservation' )
				);
			}
			$output = $output['body'];

			// convert response
			$output = (array) json_decode( $output );

			return $output;
		}
	}
}




