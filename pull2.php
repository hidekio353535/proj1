<?php

define( 'LOGFILE', '/DIR' );
define( 'SECRET', '0000000000' );
define( 'PULL_CMD', 'git pull origin main' );

$post_data = file_get_contents( 'php://input' );
$signature = hash_hmac( 'sha1', $post_data, SECRET );

function log_msg( $message ) {
	file_put_contents( LOGFILE, $message . "\n", FILE_APPEND );
}

if ( empty( $_SERVER['HTTP_X_HUB_SIGNATURE'] ) ) {
	exit;
}

if ( ! hash_equals( 'sha1=' . $signature, $_SERVER['HTTP_X_HUB_SIGNATURE'] ) ) {
	exit;
}

// At this point, we've verified the signature from Github, so we can do things.
$date = date(' m/d/Y h:i:s a', time() );
log_msg( "Deploying at {$date}" );

$output_lines = array();
exec( PULL_CMD, $output_lines );

if ( ! empty( $output_lines ) ) {
	log_msg( implode( "\n", $output_lines ) );
}

exit;

