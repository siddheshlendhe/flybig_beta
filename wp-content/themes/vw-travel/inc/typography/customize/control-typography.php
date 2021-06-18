<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class VW_Travel_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'vw-travel' ),
				'family'      => esc_html__( 'Font Family', 'vw-travel' ),
				'size'        => esc_html__( 'Font Size',   'vw-travel' ),
				'weight'      => esc_html__( 'Font Weight', 'vw-travel' ),
				'style'       => esc_html__( 'Font Style',  'vw-travel' ),
				'line_height' => esc_html__( 'Line Height', 'vw-travel' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'vw-travel' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'vw-travel-ctypo-customize-controls' );
		wp_enqueue_style(  'vw-travel-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'vw-travel' ),
        'Abril Fatface' => __( 'Abril Fatface', 'vw-travel' ),
        'Acme' => __( 'Acme', 'vw-travel' ),
        'Anton' => __( 'Anton', 'vw-travel' ),
        'Architects Daughter' => __( 'Architects Daughter', 'vw-travel' ),
        'Arimo' => __( 'Arimo', 'vw-travel' ),
        'Arsenal' => __( 'Arsenal', 'vw-travel' ),
        'Arvo' => __( 'Arvo', 'vw-travel' ),
        'Alegreya' => __( 'Alegreya', 'vw-travel' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'vw-travel' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'vw-travel' ),
        'Bangers' => __( 'Bangers', 'vw-travel' ),
        'Boogaloo' => __( 'Boogaloo', 'vw-travel' ),
        'Bad Script' => __( 'Bad Script', 'vw-travel' ),
        'Bitter' => __( 'Bitter', 'vw-travel' ),
        'Bree Serif' => __( 'Bree Serif', 'vw-travel' ),
        'BenchNine' => __( 'BenchNine', 'vw-travel' ),
        'Cabin' => __( 'Cabin', 'vw-travel' ),
        'Cardo' => __( 'Cardo', 'vw-travel' ),
        'Courgette' => __( 'Courgette', 'vw-travel' ),
        'Cherry Swash' => __( 'Cherry Swash', 'vw-travel' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'vw-travel' ),
        'Crimson Text' => __( 'Crimson Text', 'vw-travel' ),
        'Cuprum' => __( 'Cuprum', 'vw-travel' ),
        'Cookie' => __( 'Cookie', 'vw-travel' ),
        'Chewy' => __( 'Chewy', 'vw-travel' ),
        'Days One' => __( 'Days One', 'vw-travel' ),
        'Dosis' => __( 'Dosis', 'vw-travel' ),
        'Droid Sans' => __( 'Droid Sans', 'vw-travel' ),
        'Economica' => __( 'Economica', 'vw-travel' ),
        'Fredoka One' => __( 'Fredoka One', 'vw-travel' ),
        'Fjalla One' => __( 'Fjalla One', 'vw-travel' ),
        'Francois One' => __( 'Francois One', 'vw-travel' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'vw-travel' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'vw-travel' ),
        'Great Vibes' => __( 'Great Vibes', 'vw-travel' ),
        'Handlee' => __( 'Handlee', 'vw-travel' ),
        'Hammersmith One' => __( 'Hammersmith One', 'vw-travel' ),
        'Inconsolata' => __( 'Inconsolata', 'vw-travel' ),
        'Indie Flower' => __( 'Indie Flower', 'vw-travel' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'vw-travel' ),
        'Julius Sans One' => __( 'Julius Sans One', 'vw-travel' ),
        'Josefin Slab' => __( 'Josefin Slab', 'vw-travel' ),
        'Josefin Sans' => __( 'Josefin Sans', 'vw-travel' ),
        'Kanit' => __( 'Kanit', 'vw-travel' ),
        'Lobster' => __( 'Lobster', 'vw-travel' ),
        'Lato' => __( 'Lato', 'vw-travel' ),
        'Lora' => __( 'Lora', 'vw-travel' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'vw-travel' ),
        'Lobster Two' => __( 'Lobster Two', 'vw-travel' ),
        'Merriweather' => __( 'Merriweather', 'vw-travel' ),
        'Monda' => __( 'Monda', 'vw-travel' ),
        'Montserrat' => __( 'Montserrat', 'vw-travel' ),
        'Muli' => __( 'Muli', 'vw-travel' ),
        'Marck Script' => __( 'Marck Script', 'vw-travel' ),
        'Noto Serif' => __( 'Noto Serif', 'vw-travel' ),
        'Open Sans' => __( 'Open Sans', 'vw-travel' ),
        'Overpass' => __( 'Overpass', 'vw-travel' ),
        'Overpass Mono' => __( 'Overpass Mono', 'vw-travel' ),
        'Oxygen' => __( 'Oxygen', 'vw-travel' ),
        'Orbitron' => __( 'Orbitron', 'vw-travel' ),
        'Patua One' => __( 'Patua One', 'vw-travel' ),
        'Pacifico' => __( 'Pacifico', 'vw-travel' ),
        'Padauk' => __( 'Padauk', 'vw-travel' ),
        'Playball' => __( 'Playball', 'vw-travel' ),
        'Playfair Display' => __( 'Playfair Display', 'vw-travel' ),
        'PT Sans' => __( 'PT Sans', 'vw-travel' ),
        'Philosopher' => __( 'Philosopher', 'vw-travel' ),
        'Permanent Marker' => __( 'Permanent Marker', 'vw-travel' ),
        'Poiret One' => __( 'Poiret One', 'vw-travel' ),
        'Quicksand' => __( 'Quicksand', 'vw-travel' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'vw-travel' ),
        'Raleway' => __( 'Raleway', 'vw-travel' ),
        'Rubik' => __( 'Rubik', 'vw-travel' ),
        'Rokkitt' => __( 'Rokkitt', 'vw-travel' ),
        'Russo One' => __( 'Russo One', 'vw-travel' ),
        'Righteous' => __( 'Righteous', 'vw-travel' ),
        'Slabo' => __( 'Slabo', 'vw-travel' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'vw-travel' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'vw-travel'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'vw-travel' ),
        'Sacramento' => __( 'Sacramento', 'vw-travel' ),
        'Shrikhand' => __( 'Shrikhand', 'vw-travel' ),
        'Tangerine' => __( 'Tangerine', 'vw-travel' ),
        'Ubuntu' => __( 'Ubuntu', 'vw-travel' ),
        'VT323' => __( 'VT323', 'vw-travel' ),
        'Varela Round' => __( 'Varela Round', 'vw-travel' ),
        'Vampiro One' => __( 'Vampiro One', 'vw-travel' ),
        'Vollkorn' => __( 'Vollkorn', 'vw-travel' ),
        'Volkhov' => __( 'Volkhov', 'vw-travel' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'vw-travel' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'vw-travel' ),
			'100' => esc_html__( 'Thin',       'vw-travel' ),
			'300' => esc_html__( 'Light',      'vw-travel' ),
			'400' => esc_html__( 'Normal',     'vw-travel' ),
			'500' => esc_html__( 'Medium',     'vw-travel' ),
			'700' => esc_html__( 'Bold',       'vw-travel' ),
			'900' => esc_html__( 'Ultra Bold', 'vw-travel' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'' => esc_html__( 'No Fonts Style', 'vw-travel' ),
			'normal'  => esc_html__( 'Normal', 'vw-travel' ),
			'italic'  => esc_html__( 'Italic', 'vw-travel' ),
			'oblique' => esc_html__( 'Oblique', 'vw-travel' )
		);
	}
}
