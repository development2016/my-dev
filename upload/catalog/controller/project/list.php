<?php
class ControllerProjectList extends Controller {

	public function index() {


		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('project/list', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('project/list');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_quotation'),
			'href' => $this->url->link('project/quotation', '', true)
		);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		$this->response->setOutput($this->load->view('project/mongo',$data));

		if (isset($this->request->get['belong'])) {
			$belong = $this->request->get['belong'];
		} else {
			$belong = 0;
		}


		$this->load->model('project/generate');

		$checkConn = $this->model_project_generate->getMongo();

		$filter = [
			'enter_by' => $belong,
		];

		$options = [];

		$query = new MongoDB\Driver\Query($filter, $options);

		$test = $checkConn->executeQuery('asiaebuy-my.quotation', $query)->toArray();

		$dataArray = json_decode(json_encode($test),true);

		$data['all'] = $dataArray;

			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$data['base'] = $this->config->get('config_ssl');
			} else {
				$data['base'] = $this->config->get('config_url');
			}


		$this->response->setOutput($this->load->view('project/list',$data));





	}
}
