<?php

	class CommonFunctions {
		
		public static function displayError( $ErrorMessage ) {
			echo '<div style="width: 100%; height: 500px; padding: 20px; background: #000; color: #FFF; border-top: 3px solid yellow; position:fixed; left: 0; bottom: 0; z-index: 9999; overflow-y: scroll;">' . $ErrorMessage . '</div>';
			die();
		}
		
		
		public static function showErrorPage( $ErrorMessage = '' ) {
			
			include_once PATH_CONTROLLERS_DIR . '/ErrorController.php';
			
			die();
		}
		
		
		public static function getUserBrowser() {
				if ( !isset($_SERVER[ 'HTTP_USER_AGENT' ]) or  !($agent = $_SERVER[ 'HTTP_USER_AGENT' ])) {
						return null;
				}
				preg_match(
						"/(MSIE|Trident|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/",
						$agent,
						$browser_info);
				if (empty($browser_info)) {
						return null;
				}
				list(,$browser,$version) = $browser_info;
				$info['browser'] = $browser;
				$info['version'] = $version;
				if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) {
						$info['browser'] = 'Opera';
						$info['version'] = $opera[1];
				} elseif ($browser === 'MSIE') {
						preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie);
						if ($ie) {
								$info['browser'] = $ie[1] . ' based on IE';
						} else {
								$info['browser'] = 'IE';
						}
				} elseif ($browser === 'Trident') { // IE 11+
						$info['browser'] = 'IE';
						preg_match("/rv:([0-9.]+)/i", $agent, $ie);
						$info['version'] = $ie[1];
				} elseif ($browser === 'Firefox') {
						preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff);
						if ($ff) {
								$info['browser'] = $ff[1];
								$info['version'] = $ff[2];
						}
				} elseif ($browser === 'Opera' && $version === '9.80') {
						$info['browser'] = 'Opera';
						$info['version'] = substr($agent, -5);
				} elseif ($browser === 'Version') {
						$info['browser'] = 'Safari';
				} elseif (!$browser && strpos($agent, 'Gecko')) {
						$info['browser'] = 'Browser based on Gecko';
						$info['version'] = null;
				}
				return $info;
		}
		
		
		public static function getJsonType() {
		    $userBrowser = self::getUserBrowser();
		    if ($userBrowser !== null && isset($userBrowser['browser'])) {
			    if ($userBrowser['browser'] === 'IE') {
				    return 'text/x-json';
			    }
			    if (($userBrowser['browser'] === 'Opera') && ($userBrowser['version'] < '12.02')) {
				    return 'text/plain';
			    }
		    }
		    return 'application/json';
	    }
		
		
		public static function submitJsonResponse( $Data ) {
		    header( 'Content-Type: ' . self::getJsonType() . '; charset=utf-8' );
			echo json_encode( $Data, JSON_UNESCAPED_UNICODE );
	    }
		
	}
