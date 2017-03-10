<?php
	/**
	 * Instantiate the certificates payments PHP5 class and call the do_action method
	 *
	 * @author Lyudmila Rusakova
	 *
	 **/
	 
	include(WP_PLUGIN_DIR.'/certificates-payments/inc/certificates-payments.class.php');
	$a = new WPCerts();
	$a->do_action();
?>