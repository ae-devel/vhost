<?php

	class CommonFunctions {
		
		public static function displayError( $ErrorMessage ) {
			echo '<div style="width: 100%; height: 500px; padding: 20px; background: #000; color: #FFF; border-top: 3px solid yellow; position:fixed; left: 0; bottom: 0; z-index: 9999; overflow-y: scroll;">' . $ErrorMessage . '</div>';
			die();
		}
		
	}
