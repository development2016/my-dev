<?php
class ControllerShippingBSkynetGeoWeight extends Controller {
	private $error = array();
	private $_ext_name = 'b_skynet_geo_weight';
	private $_ext_title = 'Combo Pack F3 - Courier Service (Weight Based)';
	private $_dev_name = 'Afendio';
	private $_dev_email = 'opencartmy@gmail.com';
	private $_ext_version = '1.2';

	public function index() {
		$this->load->language('shipping/' . $this->_ext_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$data['ext_name'] = $this->_ext_name;
		$data['ext_title'] = $this->_ext_title;
		$data['dev_name'] = $this->_dev_name;
		$data['dev_email'] = $this->_dev_email;
		$data['ext_version'] = $this->_ext_version;

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('b_skynet_geo_weight', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['heading_titlepage'] = $this->language->get('heading_titlepage');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_rate'] = $this->language->get('entry_rate');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_rate'] = $this->language->get('help_rate');
		$data['help_shipdisplayoption'] = $this->language->get('help_shipdisplayoption');
		$data['help_min_weight'] = $this->language->get('help_min_weight');
		$data['help_max_weight'] = $this->language->get('help_max_weight');
		$data['help_hand'] = $this->language->get('help_hand');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		
		$data['entry_min_weight'] = $this->language->get('entry_min_weight');
		$data['entry_max_weight'] = $this->language->get('entry_max_weight');
		$data['entry_hand'] = $this->language->get('entry_hand');		
		$data['entry_shipdisplayoption'] = $this->language->get('entry_shipdisplayoption');
		$data['entry_logo_only'] = $this->language->get('entry_logo_only');
		$data['entry_text_only'] = $this->language->get('entry_text_only');
		$data['entry_logoandtext'] = $this->language->get('entry_logoandtext');
		$data['entry_shipdisplay'] = $this->language->get('entry_shipdisplay');
		$data['icon_shipping_1'] = $this->language->get('icon_shipping_1');
		$data['icon_shipping_2'] = $this->language->get('icon_shipping_2');
		$data['icon_shipping_3'] = $this->language->get('icon_shipping_3');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_titlepage'),
			'href' => $this->url->link('shipping/b_skynet_geo_weight', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('shipping/b_skynet_geo_weight', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();

		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate');
			}
			
			if (isset($this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'])) {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'] = $this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'];
			} else {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'] = $this->config->get('b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_min');
			}	
			
			if (isset($this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'])) {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'] = $this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'];
			} else {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'] = $this->config->get('b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_max');
			}
			
			if (isset($this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'])) {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'] = $this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'];
			} else {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'] = $this->config->get('b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand');
			}

			if (isset($this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$data['b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('b_skynet_geo_weight_' . $geo_zone['geo_zone_id'] . '_status');
			}
		}

		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['b_skynet_geo_weight_tax_class_id'])) {
			$data['b_skynet_geo_weight_tax_class_id'] = $this->request->post['b_skynet_geo_weight_tax_class_id'];
		} else {
			$data['b_skynet_geo_weight_tax_class_id'] = $this->config->get('b_skynet_geo_weight_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['b_skynet_geo_weight_status'])) {
			$data['b_skynet_geo_weight_status'] = $this->request->post['b_skynet_geo_weight_status'];
		} else {
			$data['b_skynet_geo_weight_status'] = $this->config->get('b_skynet_geo_weight_status');
		}

		if (isset($this->request->post['b_skynet_geo_weight_sort_order'])) {
			$data['b_skynet_geo_weight_sort_order'] = $this->request->post['b_skynet_geo_weight_sort_order'];
		} else {
			$data['b_skynet_geo_weight_sort_order'] = $this->config->get('b_skynet_geo_weight_sort_order');
		}
		
		if (isset($this->request->post['b_skynet_geo_weight_shipdisplayoption'])) {
			$data['b_skynet_geo_weight_shipdisplayoption'] = $this->request->post['b_skynet_geo_weight_shipdisplayoption'];
		} else {
			$data['b_skynet_geo_weight_shipdisplayoption'] = $this->config->get('b_skynet_geo_weight_shipdisplayoption'); 
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/b_skynet_geo_weight', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/b_skynet_geo_weight')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}