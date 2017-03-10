<?php
/*
  Plugin Name: Certificates Payments (by Robokassa)
  Description: Плагин для онлайн покупки и оплаты сертификатов через платежную систему Robokassa.
  Version: 1.0
  Author: L.Rusakova, D.Korepanova
  Author URI: http://www.promedia-perm.ru/
 */

add_action('init', 'certpay_init');
add_action('admin_menu', 'rk_control_menu');
add_action('admin_menu', 'certs_control_menu');
add_action('admin_init', 'certs_admin_init');

register_activation_hook(__FILE__, 'db_install');


/* functions of displaying invoices table */

function certs_control_menu() {
    add_options_page('Управление сертификатами', 'Сертификаты', 1, "cpt_config_cb", "cpt_config_cb");
}

function cpt_config_cb() {
    include(WP_PLUGIN_DIR . '/certificates-payments/controllers/index.php');
}

function certs_admin_init() {
    // JS
    wp_register_script('cpt-js', WP_PLUGIN_URL . '/certificates-payments/js/certificates-payments.js');
    wp_enqueue_script('cpt-js');
    wp_register_script('cpt-sort-js', WP_PLUGIN_URL . '/certificates-payments/js/jquery.tablesorter.js');
    wp_enqueue_script('cpt-sort-js');

    // CSS
    wp_register_style('cpt-styles', WP_PLUGIN_URL . '/certificates-payments/css/style.css');
    wp_enqueue_style('cpt-styles');
}

/* functions of creating Robokassa Settings page and saving them in DB */

function rk_control_menu() {
    add_options_page('Изменени настроек Робокассы', 'Настройки Робокассы', 'manage_options', 'rk_sc_config', 'rk_config_cb');
    add_action('admin_init', 'rk_register_settings');
}

function rk_register_settings() {
    register_setting('rk-settings-group', 'rk-settings-group');
    add_settings_section('rk-settings-group', __('Robokassa Settings', 'rk'), 'rk_section_text', 'rk_config');
    add_settings_field('rk_merchant', __('Merchant Login', 'rk'), 'rk_setting_string', 'rk_config', 'rk-settings-group', array('id' => 'merchant'));
    add_settings_field('rk_key1', __('Key #1', 'rk'), 'rk_setting_string', 'rk_config', 'rk-settings-group', array('id' => 'key1'));
    add_settings_field('rk_key2', __('Key #2', 'rk'), 'rk_setting_string', 'rk_config', 'rk-settings-group', array('id' => 'key2'));
    //add_settings_field('rk_success_url', __('Success url','rk'), 'rk_setting_string', 'rk_config', 'rk-settings-group',array('id'=>'success_url'));
    //add_settings_field('rk_fail_url', __('Fail url','rk'), 'rk_setting_string', 'rk_config', 'rk-settings-group',array('id'=>'fail_url'));
}

function rk_config_cb() {
    ?>
    <form action="options.php" method="post">
        <?php settings_fields('rk-settings-group'); ?>
        <?php do_settings_sections('rk_config'); ?>
        <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
    <?php
}

function rk_section_text() {
    echo '<p>' . __('Main settings of Robokassa Merchant.') . '</p>';
}

function rk_setting_string($id) {
    $options = get_option('rk-settings-group');
    $id = $id['id'];
    echo "<input id='rk_{$id}' name='rk-settings-group[rk_{$id}]' size='40' type='text' value='" . $options['rk_' . $id] . "' />";
}

function rk_setting_text($id) {
    $options = get_option('rk-settings-group');
    $id = $id['id'];
    echo "<textarea id='rk_{$id}' name='rk-settings-group[rk_{$id}]' cols='70' rows='10'>" . $options['rk_' . $id] . "</textarea>";
}

/* function of creating DB wp_invoices */

function db_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
  invoice_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,  
  cert_name varchar(64) CHARACTER SET utf8 NOT NULL,  
  buyer_email varchar(64) CHARACTER SET utf8 NOT NULL,  
  cert_price int(11) NOT NULL,
  invoice_status varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT 'nopaid'
  invoice_date datetime NOT NULL,  
  invoice_key varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  UNIQUE KEY invoice_id (invoice_id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

/* function of adding certificates data to DB wp_invoices */

function db_install_data($cert_name, $cert_price,$email, $post_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";
    $time = current_time('mysql');
    $rows_affected = $wpdb->insert($table_name, array('cert_name' => $cert_name, 'cert_price' => $cert_price, 'cert_id'=>$post_id, 'buyer_email' => $email, 'invoice_date' => $time));
    return $time;
}

/* function of getting id of current invoice */

function get_invoice_id($time) {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $id = $wpdb->get_results("SELECT invoice_id FROM $table_name WHERE invoice_date = '$time'");

    return $id[0]->invoice_id;
}

/* function of getting id of invoice */

function get_invoice_id_by_key($inv_key) {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $id = $wpdb->get_results("SELECT invoice_id FROM $table_name WHERE invoice_key = '$inv_key'");

    return $id[0]->invoice_id;
}

/* function of getting status of current invoice */

function get_invoice_status($inv_key) {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $status = $wpdb->get_results("SELECT invoice_status FROM $table_name WHERE invoice_key = '$inv_key'");

    return $status[0]->invoice_status;
}

function get_cert_name($inv_id){
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $status = $wpdb->get_results("SELECT cert_name FROM $table_name WHERE invoice_id = '$inv_id'");

    return $status[0]->invoice_status;
}

/* function of getting price of current certificate */

function get_cert_price($cert_id, $fly_length) {
    global $wpdb;
    $table_name = $wpdb->prefix . "postmeta";

    $price = $wpdb->get_results("SELECT meta_value FROM $table_name WHERE post_id = '$cert_id' AND meta_key = '$fly_length'");

    return $price[0]->meta_value;
}


function redirect_to_cert_page($inv_id,$status){
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";
    $cert_id = $wpdb->get_results("SELECT cert_id FROM $table_name WHERE invoice_id = '$inv_id'");
    print_r( $cert_id[0]->cert_id );
    $url_page = get_permalink($cert_id[0]->cert_id).'?'.$status;
    wp_redirect($url_page);
    exit();
};


function get_buyer_email($inv_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $email = $wpdb->get_results("SELECT buyer_email FROM $table_name WHERE invoice_id = '$inv_id'");

    return $email[0]->buyer_email;
}

/* function of saving current invoice key */

function save_inv_key($inv_id, $key) {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $wpdb->query("UPDATE $table_name SET invoice_key = '$key' WHERE invoice_id = '$inv_id' ");
}

/* function of updating current invoice status */

function update_inv_status($inv_id, $status) {
    global $wpdb;
    $table_name = $wpdb->prefix . "invoices";

    $wpdb->query("UPDATE $table_name SET invoice_status = '$status' WHERE invoice_id = '$inv_id' ");
}

/* function of initializing certificates payment */

function init_buy($options) {
    $error = 0;
    foreach ($_POST as $field) {
        if (empty($field))
            $error = 1;
    }

    if ($error == 0) {
			/* initializing certificate properties */
			$cert_name = $_POST['cert_name'];
            $cert_price = $_POST['cert_price'];
            $email = $_POST['email'];
            $post_id = $_POST['post_id'];

			if (true ) {
				/* saving certificates data in DB */
				$invoice_time = db_install_data($cert_name, $cert_price,$email,$post_id);
				/* getting id of current invoice */
				$invoice_id = get_invoice_id($invoice_time);
				/* forming Robokassa url to payment */
				// merchant registration data
				$mrh_login = $options['rk_merchant'];      // login here
				$mrh_pass1 = $options['rk_key1'];   // merchant pass1 here               
				// order properties
				$inv_id = $invoice_id;        // invoice number 
				$inv_desc = $cert_name;   // invoice desc
				$out_summ = $cert_price;   // invoice summ

				// build CRC value
				$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
				// build URL
				$url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&" .
						"OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&Email=$email";

                //echo $url;
                wp_redirect($url);
				exit();
			} else {
				wp_redirect('404');
				exit();
			}

    } else {
        wp_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }
}

/* function of processing ResultURL */

function init_result($options) {
    // merchant registration data
    $mrh_pass2 = $options['rk_key2'];   // merchant pass2 here    
    // HTTP parameters
    $out_summ = $_REQUEST["OutSum"];
    $inv_id = intval($_REQUEST["InvId"]);
    $crc = $_REQUEST["SignatureValue"];

    // HTTP parameters: $out_summ, $inv_id, $crc
    $crc = strtoupper($crc);   // force uppercase

    /* building own CRC */
    $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));

    if (strtoupper($my_crc) != strtoupper($crc)) {
        echo "bad sign\n";
        exit();
    }

    /* printing OK signature */
    echo "OK$inv_id\n";

    /* changing invoice status to paid */
    $status = 'paid';
    update_inv_status($inv_id, $status);


    /* getting email of buyer */
    $to_email = get_buyer_email($inv_id);

	/* getting certificate name */
    $cert_name = get_cert_name($inv_id);

    /* building and saving invoice key */
    $key = md5("$inv_id:$to_email");
    save_inv_key($inv_id, $key);
    send_email($to_email,$inv_id,$out_summ,$cert_name,$key);
    exit();
}

function send_email($to_email,$inv_id,$out_summ,$cert_name,$key){
    /* setting mail headers and filter */
    $headers = 'From: Парапланерная школа Вектор <info@fly.perm.ru>' . "\r\n";
    add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));

    /* sending thank mail for purchasing to buyer */
    $mail_body = '
		<div style="font-size:13px;color:rgb(85,85,85);font-family:verdana;line-height:18.65625px;background-image:url(\'http://fly.perm.ru/pics/bg/bg_top_thank.png\'); width:590px; min-height:75px;background-repeat:no-repeat no-repeat">
		  <div style="padding-top:30px;padding-left:50px;padding-right:50px">
			<a href="http://fly.perm.ru" target="_blank">
			  <img src="http://fly.perm.ru/pics/bg/logo.png" alt=\'Парапланерная школа "Вектор"\' style="border-style:none">
			</a>
		  </div>
		</div>
		<div style="font-size:13px;color:rgb(85,85,85);font-family:verdana;line-height:18.65625px;background-image:url(\'http://fly.perm.ru/pics/bg/bg_thank.png\');width:590px;background-repeat:no-repeat repeat">
		  <div style="padding-left:50px;padding-right:50px;padding-bottom:1px">
			<div style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(237,237,237)"><br></div>
			<div style="margin:20px 0px;font-size:30px">Спасибо!</div>
			<div style="margin-bottom:30px">
			  <div>Вы сделали покупку у продавца <strong>Парапланерная школа "Вектор"</strong><br> на сайте <a href="http://fly.perm.ru">fly.perm.ru</a>.</div><br>
			  <div style="margin-bottom:20px">
				<strong>Номер заказа:</strong>&nbsp;' . $inv_id . '<br>
				<strong>Дата заказа:</strong>&nbsp;' . date('d.m.Y') . '
			  </div>
			</div>
			<div>
			  <table style="width:490px;margin:5px 0px">
				<tbody>
				  <tr>
					<td style="font-weight:bold;font-size:12px">Название</td>
					<td width="70" style="text-align:right;font-weight:bold;font-size:12px">Цена</td>
				  </tr>
				</tbody>
			  </table>
			  <div style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(237,237,237)"><br></div>
			  <table style="width:490px;margin:5px 0px">
				<tbody>
				  <tr>
					<td style="font-size:12px">' . $cert_name . '</td>
					<td style="text-align:right;font-size:12px">' . $out_summ . '&nbsp;руб.</td>
				  </tr>
				</tbody>
			  </table>
			  <div style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(237,237,237)"><br></div>
			  <table style="width:490px;margin:5px 0px">
				<tbody>
				  <tr>
					<td width="150" style="text-align:right;font-size:12px">Налог: 0,00&nbsp;руб.</td>
				  </tr>
				  <tr>
					<td width="150" style="text-align:right;font-size:12px">Итого: ' . $out_summ . '&nbsp;руб.</td>
				  </tr>
				</tbody>
			  </table>
			  <div style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(237,237,237)"><br></div>
			  <table style="width:490px;margin:5px 0px">
				<tbody>
				  <tr>
					<td style="font-weight:bold;font-size:12px">Способ оплаты:</td>
					<td>
					  <table style="margin-left:auto">
						<tbody>
						  <tr>
							<td>
							  <img src="http://fly.perm.ru/pics/robokassa_logo.gif" alt="Robokassa" style="border-style:none;margin-right:5px;width:157px;">
							</td>
							<td style="font-size:12px"></td>
						  </tr>
						</tbody>
					  </table>
					</td>
				  </tr>
				</tbody>
			  </table>
			</div>
			<div style="margin:20px 0px">Есть вопросы? Обратитесь к продавцу&nbsp;
			  <a href="http://fly.perm.ru" target="_blank">Парапланерная школа "Вектор"</a>.
			</div>
			<div><br></div>
		  </div>
		</div>
		<div style="background-image:url(\'http://fly.perm.ru/pics/bg/bg_bot_thank.png\'); width:590px; min-height:130px;background-repeat:no-repeat no-repeat"></div>
	';

    wp_mail($to_email, 'Спасибо за покупку!', $mail_body, $headers);

    /* sending mail with certificate link to buyer */
    wp_mail($to_email, 'Сертификат на полет в парапланерной школе "Вектор"', 'Вы можете скачать Ваш сертификат по <a href="http://fly.perm.ru/print-certificate?key=' . $key . '">ссылке</a>', $headers);
}


function resent_email(){
    $to_email = $_REQUEST['to'];
    $key = $_REQUEST['key'];
    $out = 'ОШИБКА! Сообщение не было отправлено!';
    if (isset($to_email,$key)){
        $headers = 'From: Парапланерная школа Вектор <info@fly.perm.ru>' . "\r\n";
        wp_mail($to_email, 'Сертификат на полет в парапланерной школе "Вектор"', 'Вы можете скачать Ваш сертификат по <a href="http://fly.perm.ru/print-certificate?key=' . $key . '">ссылке</a>', $headers);
        $out = 'Сообщение успешно отправлено на '.$to_email;
    }
    echo $out;
    exit();
}

/* function of processing SuccessURL */

function init_success() {
    $inv_id = intval($_REQUEST["InvId"]);
    redirect_to_cert_page($inv_id,"success");
    exit();
}

/* function of processing FailURL */

function init_fail() {
    // get invoice id from robokassa request
    $inv_id = intval($_REQUEST["InvId"]);
    // changing invoice status to nopaid
    $status = 'nopaid';
    update_inv_status($inv_id, $status);
    redirect_to_cert_page($inv_id, "fail");
    exit();
}

/* function of certificate printing */

function print_certificate() {
    $inv_key = $_GET['key'];

    /* getting status of current invoice */
    $inv_status = get_invoice_status($inv_key);

    if ($inv_status == "paid") {
        include( get_query_template('print-certificate') );
        exit();
    } else {
        wp_redirect('404');
        exit();
    }
}

/* function of certificate closing */

function close_certificate() {
    $inv_key = $_GET['key'];
	$action = $_GET['action'];

	if (isset($inv_key) && ($action == 'close')) {
		/* getting status of current invoice */
		$inv_status = get_invoice_status($inv_key);

		if ($inv_status == "paid") {
			wp_redirect($_SERVER['HTTP_HOST'] . '/zakrytie-sertifikata?key=' . $inv_key);
			exit();
		} elseif ($inv_status == "closed") {
			wp_redirect($_SERVER['HTTP_HOST'] . '/zakrytie-sertifikata?closed');
			exit();
		} else {
			wp_redirect($_SERVER['HTTP_HOST'] . '/zakrytie-sertifikata?other');
			exit();
		}
	} else {
		wp_redirect('404');
		exit();
	}
}

/* function of password checking */

function check_password() {
	$post_data = $_POST;
	$referer_url = wp_get_referer();
	$id_referer_page = url_to_postid($referer_url);
	$page_data = get_post_custom($id_referer_page);
	$password = $page_data['password'][0];
	
	if (isset($post_data['post_password']) && isset($post_data['key']) && isset($password)) {
		if ($post_data['post_password'] == $password) {
			$inv_status = get_invoice_status($post_data['key']);
				if ($inv_status == "paid") {
					$inv_id = get_invoice_id_by_key($post_data['key']);
					update_inv_status($inv_id, 'closed');
					wp_redirect($_SERVER['HTTP_HOST'] . '/zakrytie-sertifikata?paid');
					exit();
				} else {
					wp_redirect('404');
					exit();
				}
		} else {
			wp_safe_redirect($referer_url);
			exit();
		}
	} else {
		wp_redirect('404');
		exit();
	}
}

/* function of certificates payment processing */



function certpay_init() {
    $options = get_option('rk-settings-group');

    if (strpos($_SERVER["REQUEST_URI"], '/buy') !== false) {
        init_buy($options);
    } elseif (strpos($_SERVER["REQUEST_URI"], '/payment_result') !== false) {
        init_result($options);
    } elseif (strpos($_SERVER["REQUEST_URI"], '/success') !== false) {
        init_success();
    } elseif (strpos($_SERVER["REQUEST_URI"], '/fail') !== false) {
        init_fail();
    } elseif (strpos($_SERVER["REQUEST_URI"], '/print-certificate') !== false) {
        print_certificate();
	} elseif (strpos($_SERVER["REQUEST_URI"], '/close-certificate') !== false) {
        close_certificate();
	} elseif (strpos($_SERVER["REQUEST_URI"], '/check-password') !== false) {
        check_password();
	} elseif (strpos($_SERVER["REQUEST_URI"], '/resent-email') !== false) {
        resent_email();
    }
}
?>