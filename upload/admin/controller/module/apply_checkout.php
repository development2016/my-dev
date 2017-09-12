<?php
class ControllerModuleApplyCheckout extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/apply_checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('apply_checkout', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_status'] = $this->language->get('entry_status');
        $data['text_apply_checkout'] = $this->language->get('text_apply_checkout');
        $data['text_apply_coupon'] = $this->language->get('text_apply_coupon');
        $data['text_apply_voucher'] = $this->language->get('text_apply_voucher');
        $data['text_apply_reward'] = $this->language->get('text_apply_reward');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

        $data['entry_apply_coupon'] = $this->language->get('entry_apply_coupon');
        $data['entry_apply_voucher'] = $this->language->get('entry_apply_voucher');
        $data['entry_apply_reward'] = $this->language->get('entry_apply_reward');
		$data['entry_status'] = $this->language->get('entry_status');

        $data['help_apply_coupon'] = $this->language->get('help_apply_coupon');
        $data['help_apply_voucher'] = $this->language->get('help_apply_voucher');
        $data['help_apply_reward'] = $this->language->get('help_apply_reward');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/apply_checkout', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/apply_checkout', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['apply_checkout_status'])) {
			$data['apply_checkout_status'] = $this->request->post['apply_checkout_status'];
		} else {
			$data['apply_checkout_status'] = $this->config->get('apply_checkout_status');
		}

		if (isset($this->request->post['apply_checkout_coupon'])) {
			$data['apply_checkout_coupon'] = $this->request->post['apply_checkout_coupon'];
		} else {
			$data['apply_checkout_coupon'] = $this->config->get('apply_checkout_coupon');
		}

		if (isset($this->request->post['apply_checkout_voucher'])) {
			$data['apply_checkout_voucher'] = $this->request->post['apply_checkout_voucher'];
		} else {
			$data['apply_checkout_voucher'] = $this->config->get('apply_checkout_voucher');
		}

		if (isset($this->request->post['apply_checkout_reward'])) {
			$data['apply_checkout_reward'] = $this->request->post['apply_checkout_reward'];
		} else {
			$data['apply_checkout_reward'] = $this->config->get('apply_checkout_reward');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/apply_checkout.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/apply_checkout')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}