<?php
add_filter( 'wp_import_object_placeholder', function( $placeholder, $type, $data ) {
	if (
		'http://wordpress.org/export/objects/contact-form/1.0/' !== $type
		|| ! isset( $data['fields'] )
	) {
		return $placeholder;
	}

	// Create a contact form from the data:
	$form = array();
	foreach ( $data['fields'] as $field ) {
		$options = array();
		$options['label'] = $field['label'];
		if ( isset( $field['required'] ) && ( 'true' === $field['required'] || 'false' !== $field['required'] ) ) {
			$options['required'] = true;
		}

		if ( 'submit' === $field['type'] ) {
			$form[] = '<!-- wp:jetpack/button ' . json_encode( array( "element" => "button", "text" => $field['label'] ) ) . ' /-->';
			continue;
		}

		if ( 'text' === $field['type'] && 'email' === $field['format'] ) {
			$form[] = '<!-- wp:jetpack/field-email ' . json_encode( $options ) . ' /-->';
			continue;
		}

		if ( 'text' === $field['type'] && 'date' === $field['format'] ) {
			$form[] = '<!-- wp:jetpack/field-date ' . json_encode( $options ) . ' /-->';
			continue;
		}

		if ( 'text' === $field['type'] && 0 === stripos( trim( $field['label'] ), 'name' ) ) {
			$form[] = '<!-- wp:jetpack/field-name ' . json_encode( $options ) . ' /-->';
			continue;
		}

		if ( 'select' === $field['type'] ) {
			$options['options'] = array_column( $field['options'], 'value' );
			$form[] = '<!-- wp:jetpack/field-select ' . json_encode( $options ) . ' /-->';
			continue;
		}

		if ( 'textarea' === $field['type'] ) {
			$form[] = '<!-- wp:jetpack/field-textarea ' . json_encode( $options ) . ' /-->';
			continue;
		}

	}



	echo '<!-- wp:jetpack/contact-form {"to":"' . $data['email'] . '","subject":"Contact"} -->' . implode( PHP_EOL, $form ) . '<!-- /wp:jetpack/contact-form -->';
	return '<!-- wp:jetpack/contact-form {"to":"' . $data['email'] . '","subject":"Contact"} -->' . implode( PHP_EOL, $form ) . '<!-- /wp:jetpack/contact-form -->';

}, 10, 3 );


// <!-- wp:jetpack/contact-form {"subject":"subject ","to":"email"} -->
// <!-- wp:jetpack/field-name {"required":true} /-->

// <!-- wp:jetpack/field-email {"required":true} /-->

// <!-- wp:jetpack/field-date /-->

// <!-- wp:jetpack/field-select {"options":["test1","test2"]} /-->

// <!-- wp:jetpack/field-textarea /-->

// <!-- wp:jetpack/button {"element":"button","text":"Kontakt"} /-->
// <!-- /wp:jetpack/contact-form -->
