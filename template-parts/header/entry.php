<?php
$type = Edumall_Global::instance()->get_header_type();

if ( 'none' === $type ) {
	return;
}

if ( ! edumall_has_elementor_template( 'header' ) ) {
	edumall_load_template( 'header/header', $type );
}
