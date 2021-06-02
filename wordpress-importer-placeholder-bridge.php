<?php
/*
 * Plugin Name: WordPress Importer Placeholder Bridge
 * Version: 0.1
 *
 * Description: Here we collect some
 *
 */

foreach ( get_option( 'active_plugins' ) as $plugin_file ) {
	if ( 'contact-form-7/wp-contact-form-7.php' === $plugin_file ) {
		include __DIR__ . '/plugins/contact-form-7.php';
	}
	if ( 'jetpack/jetpack.php' === $plugin_file ) {
		include __DIR__ . '/plugins/jetpack.php';
	}
}
