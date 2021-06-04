<?php
add_filter( 'wp_import_object_placeholder', function( $placeholder, $type, $data ) {
	if (
		'contact-form' !== $type
		|| ! isset( $data['fields'] )
	) {
		return $placeholder;
	}

	// Create a contact form from the data:
	$form = array();
	foreach ( $data['fields'] as $field ) {
		if ( 'submit' === $field['type'] ) {
			$form[] = '[submit "' . esc_html( $field['label'] ) . '"]';
			continue;
		}
		$entry = '<label>' . esc_html( $field['label'] ) . PHP_EOL;
		$entry .= '[' . $field['type'];
		if ( 'true' === $field['required'] || 'false' !== $field['required'] ) {
			$entry .= '*';
		}
		$entry .= ' ' . sanitize_title( $field['label'] );
		$form[] = $entry . ']</label>';
	}


	$contact_form = wpcf7_save_contact_form( array(
		'form' => implode( PHP_EOL, $form ),
		'mail' => array(
			'recipient' => $data['email']
		),
	) );
	$contact_form_id = $contact_form->id;

	return '<!-- wp:contact-form-7/contact-form-selector {"id":' . $contact_form_id . ',"title":"Contact"} -->
<div class="wp-block-contact-form-7-contact-form-selector">[contact-form-7 id="' . $contact_form_id . '" title="Contact"]</div>
<!-- /wp:contact-form-7/contact-form-selector -->';

}, 10, 3 );

