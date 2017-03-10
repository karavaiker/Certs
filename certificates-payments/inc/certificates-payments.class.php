<?php

/**
 * Certificates Payments
 *
 * Admin class for displaying and editing certificates invoices
 *
 * @author Lyudmila Rusakova
 */
Class WPCerts {

  /**
   * db class variable
   *
   * @var object
   */
  protected $db;

  /**
   * data class variable
   *
   * @var array
   */
  protected $data;

  /**
   * Instantiate the class vars on construct
   *
   */
  public function __construct() {
    global $wpdb;

    $this->db = & $wpdb;
    $this->data = array();
  }

  /**
   * If an action is set using $_GET action it else default it
   *
   * @return void
   */
  public function do_action() {

    if (!isset($_POST['cpt_hidden'])) {
      $this->index();
    } else {
      $this->save_status();
    }
  }

  /**
   * Display the index (list) view
   *
   * @return view template
   */
  public function index() {
    $out = '
			<form name="post" action="' . $_SERVER['REQUEST_URI'] . '" method="post" id="post-status">
				<div class="wrap">
					<div id="icon-edit" class="icon32"></div>
					<h2>Списки сертификатов</h2>
					<div class="status-names">Статусы сертификатов:</div>
					<ul class="status-names-list">
						<li><span>init</span> - сертификат находится в оплате</li>
						<li><span>paid</span> - сертификат оплачен</li>
						<li><span>nopaid</span> - сертификат не оплачен</li>
						<li><span>closed</span> - сертификат использован</li>
					</ul>
				</div>
				<br /><br />
				<div class="tab active" id="tb_tab1"><a onclick="switch_tables(1);">Актуальные</a></div>
				<div class="tab" id="tb_tab2"><a onclick="switch_tables(2);">Закрытые</a></div>
				<div class="tab" id="tb_tab3"><a onclick="switch_tables(3);">Остальные</a></div>';


    $this->data['actual_certs'] = $this->db->get_results("SELECT * FROM {$this->db->prefix}invoices WHERE invoice_status = 'paid' ");
	$out .= '<div id="tbl1"><table class="widefat certs-table" id="actual-certs-table" style="width: 99%;">';
	$out .= $this->show_certs($this->data['actual_certs']);
	$out .= '</div>';
			
	$this->data['closed_certs'] = $this->db->get_results("SELECT * FROM {$this->db->prefix}invoices WHERE invoice_status = 'closed' ");
	$out .= '<div id="tbl2"><table class="widefat certs-table" id="closed-certs-table" style="width: 99%;">';
	$out .=	$this->show_certs($this->data['closed_certs']);
	$out .= '</div>';
			
	$this->data['nopaid_certs'] = $this->db->get_results("SELECT * FROM {$this->db->prefix}invoices WHERE invoice_status != 'paid' AND invoice_status != 'closed' ");
	$out .= '<div id="tbl3"><table class="widefat certs-table" id="nopaid-certs-table" style="width: 99%;">';
	$out .=	$this->show_certs($this->data['nopaid_certs']);
	$out .= '</div>';

    $out .= ' 
				<input type="hidden" name="cpt_hidden" value="Y">
				<input name="save" type="submit" class="save-button" id="save-status" value="Обновить">
			</form>';

    echo $out;
  }

public function showModalAboutCert($cert){
    $out='<div id="modalCert-'.$cert->invoice_id.'" style="display:none;margin: auto;">';

    $out .='<h2>Наименование: ' . $cert->cert_name . '</h2>
             <table>
                <tr>
                    <td>Номер заказа:</td>
                    <td>' . $cert->invoice_id . '</td>
                </tr>
                <tr>
                    <td>Код сертификата:</td>
                    <td>'.$cert->invoice_key.'</td>
                </tr>
                <tr>
                    <td>Email покупателя:</td>
                    <td>'.$cert->buyer_email.'</td>
                </tr>
                <tr>
                    <td>Дата заказа:</td>
                    <td>' . $cert->invoice_date . '</td>
                </tr>
                <tr>
                    <td>Статус заказа:</td>
                    <td>' . trim($cert->invoice_status) . '</td>
                </tr>
                <tr>
                    <td>Стоимость сертификата:</td>
                    <td><b>' . number_format($cert->cert_price, 0, ',', ' ') . ' руб</b></td>
                </tr> 
             </table>';
    if (trim($cert->invoice_status) == paid ){
        $out .='
            <table style="margin-top:40px;">
                <tr>
                    <td><input id="mail-for-cert-'.$cert->invoice_key.'" value="'.$cert->buyer_email.'" placeholder="Введите email"><a class="button button-danger" onclick="send_cert_email($(\'#mail-for-cert-'.$cert->invoice_key.'\').val())" target="_blank">Отправить Сертификат еще раз</a></td>
                    <td><a class="button button-primary" href="http://fly.perm.ru/print-certificate?key='.$cert->invoice_key.'" target="_blank">Ссылка на Сертификат</a></td>
                </tr>
             </table>
        ';
    }
    $out.='</div>';
    $out.='<a href="#TB_inline?width=400&height=300&inlineId=modalCert-'.$cert->invoice_id.'" class="button button-primary thickbox" title="Подробности сертификата">Подробнее</a>';
    return $out;
}
  /**
   * Display the table of invoices
   *
   * @return view template
   */
  public function show_certs($certs) {

    $out = '
<thead>
	<tr>
		<th width="10%">№ заказа</th>								
		<th width="30%">Название сертификата</th>								
		<th width="20%">Email покупателя</th>
		<th width="10%">Цена сертификата</th>
		<th width="10%">Дата заказа</th>
		<th width="10%">Статус заказа</th>
		<th width="10%">Подробнее</th>
	</tr>
</thead>			
<tbody>';

    $i = 0;
    foreach ($certs as $cert) {
      $i++;
      $alternate = (($i % 2) == 0) ? '' : ' alternate';
	  
	  if (isset($cert->buyer_phone) && !empty($cert->buyer_phone)) {
		$cert->buyer_info = $cert->buyer_fio . '<br>Телефон: ' . $cert->buyer_phone;
	  } else {
		$cert->buyer_info = $cert->buyer_fio;
	  }

      $out .= '<tr class="active' . $alternate . '">
		<td>' . $cert->invoice_id . '</td>												
		<td>' . $cert->cert_name . '</td>										
		<td>' . $cert->buyer_email . '</td>
		<td>' . number_format($cert->cert_price, 0, ',', ' ') . ' руб</td>
		<td>' . $cert->invoice_date . '</td>
		<td class="status-name">' . trim($cert->invoice_status) . '<input name="status_' . $cert->invoice_id . '" type="text" class="status" value="' . trim($cert->invoice_status) . '" /></td>
		<td cert-key="'.$cert->invoice_key.'">'.$this->showModalAboutCert($cert).'</td>
	</tr>';
    }

    $out .= '</tbody></table><script>function send_cert_email(mail) {
        $.ajax({
          url: "http://fly.perm.ru/resent-email",
          data: {
            to: mail,
            key: "'.$cert->invoice_key.'",
            summ: "'.$cert->cert_price.'",
            cert_name: "'.$cert->cert_name.'",
            inv_id: "'.$cert->invoice_id.'"
          }
        }).done(function(xhr){alert(xhr);})
  
}</script>';
    return $out;
  }



  /**
   * Save changed status of invoices
   *
   * @return view template
   */
  public function save_status() {

    // We have $_POST data so it's a postback, set the internal data var to the $_POST vars
    $this->status = $_POST;

    foreach ($this->status as $key => $status) {
      $inv_id = trim(str_replace('_', '', strstr($key, '_')));
      $inv_status = trim($status);

      // Update the status in database
      global $wpdb;
      $table_name = $wpdb->prefix . "invoices";

      $wpdb->query("UPDATE $table_name SET invoice_status = '$inv_status' WHERE invoice_id = '$inv_id' ");
    }

    $this->index();
  }

}

// END Class
?>