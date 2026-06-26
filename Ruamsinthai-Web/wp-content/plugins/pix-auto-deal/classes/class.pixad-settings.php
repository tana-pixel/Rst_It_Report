<?php
class PIXAD_Settings
{
	/**
	 * Update | Save | Create - update_option
	 * ======================================
	 * $table:
	 * WP_OPTIONS
	 * PIXAD_CURRENCIES
	 *
	 * @since 0.2
	 */
	public function update( $table, $key, $value, $post_id = false, $array = false ) {
		switch( $table ):
			
			/**
			 * Update single wp_options
			 * ========================
			 * @since 0.2
			 */
			case $table == 'WP_OPTIONS' && $array == false:
				 if( update_option( $key, $value ) )
					echo $this->success();
			break;
			
			/**
			 * Update array wp_options
			 * =======================
			 * @since 0.2
			 */
			case $table == 'WP_OPTIONS' && $array == true:
				foreach( $value as $arname => $aroption ) {
					update_option( $key, $arname, $aroption );
				}
				echo $this->success();
			break;
			
			/**
			 * Update _jp_autos_currencies
			 * ==========================
			 * @since 0.4
			 */
			case $table == 'PIXAD_CURRENCIES':
				 if( update_option( $key, $value ) )
					echo $this->success();
			break;
		
		endswitch;
	}
	/**
	 * Delete Settings From Database
	 *
	 * $table:
	 * WP_OPTIONS
	 * WP_POSTMETA
	 *
	 * @since 1.0
	 */
	public function delete( $table, $key, $post_id = false, $user_id = false, $meta_key = false, $meta_value = false ) {
		switch( $table ):
			
			/**
			 * Delete from WP_OPTIONS
			 * ======================
			 * @since 1.0
			 */
			case $table == 'WP_OPTIONS':
				 if( delete_option( $key ) )
					echo $this->success();
			break;
		
		endswitch;
	}
	/**
	 * Get option from database
	 *
	 * WP_OPTIONS
	 * WP_POSTMETA
	 *
	 * @since 1.0
	 * @return string || array
	 */
	public function getSettings( $table, $key, $unserialize = false, $user_id = false ) {
		$settings = false; // default settings status, once settings is updated return true
		
		switch( $table ):
		
			case $table == 'WP_OPTIONS' && $unserialize == false:
				 
				 if( get_option( $key ) )
					 $settings = get_option( $key );
				 
			break;
			
			case $table == 'WP_OPTIONS' && $unserialize == true:
			
				 if( get_option( $key ) )
					 $settings = unserialize( get_option( $key ) );
					
			break;
		
		endswitch;

		return $settings;
	}

   public static function getAllSettings( ) {
	    $settings = array(
            "auto-make" => __("Auto Make",'pixad'),
            "auto-model" => __("Auto Model",'pixad'),
            "auto-version" => __("Auto Version",'pixad'),
            "auto-year" => __("Year",'pixad'),
            "auto-mileage" => __("Mileage",'pixad'),
            "auto-fuel" => __("Fuel",'pixad'),
            "auto-engine" => __("Engine",'pixad'),
            "auto-horsepower" => __("Horsepower",'pixad'),
            "auto-transmission" => __("Transmission",'pixad'),
            "auto-drive" => __("Drive",'pixad'),
            "auto-doors" => __("Doors",'pixad'),
            "auto-seats" => __("Seats",'pixad'),
            "auto-color" => __("Color",'pixad'),
            "auto-color-int" => __("Interior Color",'pixad'),
            "auto-condition" => __("Condition",'pixad'),
            "auto-purpose" => __("Purpose",'pixad'),
            "auto-vin" => __("VIN",'pixad'),
            "auto-price" => __("Price",'pixad'),
            "auto-sale-price" => __("Sale Price",'pixad'),
            "auto-stock-status" => __("Stock Status",'pixad'),
            "auto-price-type" => __("Price Type",'pixad'),
            "auto-warranty" => __("Warranty",'pixad'),
            "auto-currency" => __("Currency",'pixad'),
            "first-name" => __("Seller First Name",'pixad'),
            "last-name" => __("Seller Last Name",'pixad'),
            "seller-company" => __("Seller Company",'pixad'),
            "seller-email" => __("Seller Email",'pixad'),
            "seller-phone" => __("Seller Phone",'pixad'),
            "seller-country" => __("Seller Country",'pixad'),
            "seller-state" => __("Seller State",'pixad'),
            "seller-town" => __("Seller Town",'pixad'),
            "seller-location" => __("Seller Location",'pixad'),
            "seller-location-lat" => __("Seller Location Latitude",'pixad'),
            "seller-location-long" => __("Seller Location Longitude",'pixad'),
            "auto-date" => __("Updated Date",'pixad'),
        );

        return $settings;
    }

	/**
	 * If operation successful, show message
	 *
	 * @since 1.0
	 */
	public function success( $type = null ) {
		if( $type == 'update' ) {
			$message = 'Settings updated!';
		} else {
			$message = 'Settings saved!';
		}
		return	'
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong>'. __( $message, 'pixad' ) .'</strong></p>
			</div>
			<meta http-equiv="refresh" content="0" url="'.$_SERVER['PHP_SELF'].'">
				';
	}
	/**
	 * If operation failed, show message
	 *
	 * @since 1.0
	 */
	public function failed() {
		return	'
			<div id="setting-error-settings_updated" class="error settings-error">
				<p><strong>'. __( 'Operation failed.', 'pixad' ) .'</strong></p>
			</div>
			<meta http-equiv="refresh" content="0" url="'.$_SERVER['PHP_SELF'].'">
				';
	}
}
?>