<?php
class ControllerProjectPrint extends Controller {


	public function index() {


		$this->load->language('project/view');


		if (isset($this->request->post['config_name'])) {
			$data['config_name'] = $this->request->post['config_name'];
		} else {
			$data['config_name'] = $this->config->get('config_name');
		}
		if (isset($this->request->post['config_address'])) {
			$data['config_address'] = $this->request->post['config_address'];
		} else {
			$data['config_address'] = $this->config->get('config_address');
		}

		if (isset($this->request->post['config_email'])) {
			$data['config_email'] = $this->request->post['config_email'];
		} else {
			$data['config_email'] = $this->config->get('config_email');
		}

		if (isset($this->request->post['config_telephone'])) {
			$data['config_telephone'] = $this->request->post['config_telephone'];
		} else {
			$data['config_telephone'] = $this->config->get('config_telephone');
		}

		if (isset($this->request->post['config_fax'])) {
			$data['config_fax'] = $this->request->post['config_fax'];
		} else {
			$data['config_fax'] = $this->config->get('config_fax');
		}

		$this->load->language('checkout/checkout');

		$data['qt_title'] = $this->language->get('qt_title');
		// all normal data up
				$data['qt_date'] = $this->language->get('qt_date');
		$data['qt_no'] = $this->language->get('qt_no');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');


		$this->load->model('project/generate');

		

		if (isset($this->request->get['quotation'])) {
			$quotation = $this->request->get['quotation'];
		} else {
			$quotation = 0;
		}

		if (isset($this->request->get['belong'])) {
			$belong = $this->request->get['belong'];
		} else {
			$belong = 0;
		}

		$checkConn = $this->model_project_generate->getMongo();


		$filter = [
			'quotation_no' => $quotation,
			'enter_by' => $belong,
		];

		$options = [];

		$query = new MongoDB\Driver\Query($filter, $options);

		$test = $checkConn->executeQuery('asiaebuy-my.quotation', $query)->toArray();

		$dataArray = json_decode(json_encode($test),true);

		$data['all'] = $dataArray;



		$this->response->setOutput($this->load->view('project/print',$data));
	}




}