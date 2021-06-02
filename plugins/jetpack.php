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

		if ( 'submit' === $field['type'] ) {
			$form[] = '<!-- wp:jetpack/button ' . json_encode( array( "element" => "button", "text" => $field['label'] ) ) . '/-->';
			continue;
		}

		if ( 'text' === $field['type'] && 'email' === $field['format'] ) {
			$form[] = '<!-- wp:jetpack/email ' . json_encode( $options ) . '/-->';
			continue;
		}

		if ( 'text' === $field['type'] && 'date' === $field['format'] ) {
			$form[] = '<!-- wp:jetpack/date ' . json_encode( $options ) . '/-->';
			continue;
		}

		if ( 'text' === $field['type'] && 0 === stripos( trim( $field['label'] ), 'name' ) ) {
			$form[] = '<!-- wp:jetpack/name ' . json_encode( $options ) . '/-->';
			continue;
		}

		if ( 'select' === $field['type'] ) {
			$options['options'] = $field['options'];
			$form[] = '<!-- wp:jetpack/select ' . json_encode( $options ) . '/-->';
			continue;
		}

	}



	return '<!-- wp:jetpack/contact-form {"to":' . $data['email'] . ',"subject":"Contact"} -->' . implode( PHP_EOL, $form ) . '<!-- /wp:jetpack/contact-form -->';

}, 10, 3 );


// <!-- wp:jetpack/contact-form {"subject":"subject ","to":"email"} -->
// <!-- wp:jetpack/field-name {"required":true} /-->

// <!-- wp:jetpack/field-email {"required":true} /-->

// <!-- wp:jetpack/field-date /-->

// <!-- wp:jetpack/field-select {"options":["test1","test2"]} /-->

// <!-- wp:jetpack/field-textarea /-->

// <!-- wp:jetpack/button {"element":"button","text":"Kontakt"} /-->
// <!-- /wp:jetpack/contact-form -->
