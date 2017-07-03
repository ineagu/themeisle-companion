<?php
/**
 * The Helper Class for content rendering.
 *
 * @link       https://themeisle.com
 * @since      1.0.0
 *
 * @package    Orbit_Fox
 * @subpackage Orbit_Fox/app/helpers
 */

/**
 * The class that contains utility methods to render partials, views or elements.
 *
 * @package    Orbit_Fox
 * @subpackage Orbit_Fox/app/helpers
 * @author     Themeisle <friends@themeisle.com>
 */
class Orbit_Fox_Render_Helper {

	/**
	 * Get a partial template and return the output.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @param   string $name The name of the partial w/o '-tpl.php'.
	 * @param   array  $args Optional. An associative array with name and value to be
	 *                                 passed to the partial.
	 * @return string
	 */
	public function get_partial( $name = '', $args = array() ) {
		ob_start();
		$file = OBX_PATH . '/core/app/views/partials/' . $name . '-tpl.php';
		if ( ! empty( $args ) ) {
			foreach ( $args as $obfx_rh_name => $obfx_rh_value ) {
				$$obfx_rh_name = $obfx_rh_value;
			}
		}
		if ( file_exists( $file ) ) {
			include $file;
		}
		return ob_get_clean();
	}

	/**
	 * Get a view template and return the output.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @param   string $name The name of the partial w/o '-page.php'.
	 * @param   array  $args Optional. An associative array with name and value to be
	 *                                 passed to the view.
	 * @return string
	 */
	public function get_view( $name = '', $args = array() ) {
		ob_start();
		$file = OBX_PATH . '/core/app/views/' . $name . '-page.php';
		if ( ! empty( $args ) ) {
			foreach ( $args as $obfx_rh_name => $obfx_rh_value ) {
				$$obfx_rh_name = $obfx_rh_value;
			}
		}
		if ( file_exists( $file ) ) {
			include $file;
		}
		return ob_get_clean();
	}

	/**
	 * Merges specific defaults with general ones.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @param   array $option  The specific defaults array.
	 * @return array
	 */
	private function sanitize_option( $option ) {
		$general_defaults = array(
			'id' => null,
			'class' => null,
			'name' => null,
			'label' => 'Module Text Label',
			'description' => 'Module Text Description ...',
			'type' => null,
			'value' => '',
			'default' => '',
			'placeholder' => 'Add some text',
			'disabled' => false,
			'options' => array(),
		);

		return wp_parse_args( $option, $general_defaults );
	}

	/**
	 * Render an input text field.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @param   array $option The option from the module.
	 * @return mixed
	 */
	private function field_text( $option = array() ) {
		$value = $option['default'];
		if ( isset( $option['value'] ) && $option['value'] != '' ) {
			$value = $option['value'];
		}
		$field = '
        <div class="form-group">
            <label class="form-label" for="' . $option['id'] . '">' . $option['label'] . '</label>
            <input class="form-input" type="text" id="' . $option['id'] . '" class="' . $option['class'] . '" name="' . $option['name'] . '" placeholder="' . $option['placeholder'] . '" value="' . $value . '">
        </div>
        ';

		return $field;
	}

	/**
	 * Method to render option to a field.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @param   array $option The option from the module.
	 * @return mixed
	 */
	public function render_option( $option = array() ) {
		$option = $this->sanitize_option( $option );
	    switch ( $option['type'] ) {
			case 'text':
				return $this->field_text( $option );
				break;
			default:
				return __( 'No option found for provided type', 'obfx' );
				break;
		}
	}


}
