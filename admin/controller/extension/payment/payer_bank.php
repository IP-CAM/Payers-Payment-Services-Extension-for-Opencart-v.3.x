<?php

class ControllerExtensionPaymentPayerbank extends Controller {

	private $error = array();
	private $pname = 'payer_bank';

	public function index() {
		$this->load->language("extension/payment/$this->pname");

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment_' . $this->pname, $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
		}
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_mid'] = $this->language->get('entry_mid');
		$data['entry_key'] = $this->language->get('entry_key');
		$data['entry_keyb'] = $this->language->get('entry_keyb');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_ajax'] = $this->language->get('entry_ajax');
		$data['entry_debug'] = $this->language->get('entry_debug');

		$data['help_mid'] = $this->language->get('help_mid');
		$data['help_key'] = $this->language->get('help_key');
		$data['help_keyb'] = $this->language->get('help_keyb');
		$data['help_test'] = $this->language->get('help_test');
		$data['help_debug'] = $this->language->get('help_debug');

		$data['tab_general'] = $this->language->get('tab_general');

		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['mid'])) {
			$data['error_mid'] = $this->error['mid'];
		} else {
			$data['error_mid'] = '';
		}

		if (isset($this->error['key'])) {
			$data['error_key'] = $this->error['key'];
		} else {
			$data['error_key'] = '';
		}

		if (isset($this->error['keyb'])) {
			$data['error_keyb'] = $this->error['keyb'];
		} else {
			$data['error_keyb'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'user_token=' . $this->session->data['user_token'], true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link("extension/payment/$this->pname", 'user_token=' . $this->session->data['user_token'], true),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link("extension/payment/$this->pname", 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link("extension/payment", 'user_token=' . $this->session->data['user_token'], true);

		foreach (array("status", "geo_zone_id", "order_status_id") as $name) {
			$key = $this->pname . "_" . $name;
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} else {
				$data[$key] = $this->config->get($key);
			}
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$settings = $this->model_setting_setting->getSetting('payment_' . $this->pname);

		foreach ($settings as $key => $value) {
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} else {
				$data[$key] = $value;
			}
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->id = 'content';
		$this->template = "extension/payment/" . $this->pname;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['fooer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/' . $this->pname, $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', "extension/payment/" . $this->pname)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payment_' . $this->pname . '_mid']) {
			$this->error['mid'] = $this->language->get('error_mid');
		}

		if (!$this->request->post['payment_' . $this->pname . '_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}

		if (!$this->request->post['payment_' . $this->pname . '_keyb']) {
			$this->error['keyb'] = $this->language->get('error_keyb');
		}

		return !$this->error;
	}

}

?>