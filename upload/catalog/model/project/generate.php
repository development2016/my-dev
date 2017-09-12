<?php
class ModelProjectGenerate extends Model {


	public function getMongo()
	{

		$cert = '/var/www/vhosts/asiaebuy.com/httpdocs/my-dev/compose.crt';

		$ctx = stream_context_create(array(
		    "ssl" => array(
		        "cafile"            => $cert,
		        "allow_self_signed" => false,
		        "verify_peer"       => true, 
		        "verify_peer_name"  => true,
		        "verify_expiry"     => true, 
		    ),
		));


		$dsn = 'mongodb://opencart:Amtujpino.leso@aws-ap-southeast-1-portal.2.dblayer.com:15429,aws-ap-southeast-1-portal.0.dblayer.com:15429/asiaebuy-my?ssl=true';

		$manager = new MongoDB\Driver\Manager($dsn,[],['context'=>$ctx]);  

		

		//$manager = new MongoDB\Driver\Manager("mongodb://fuad:Amtujpino.2@127.0.0.1:27017/asiaebuy-my");

		return $manager;
	}





	public function getQuotation() {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "generate_quotation_no  ORDER BY id DESC LIMIT 1");

		return $query->row;
	}

	public function addQuotation($key,$data) {

		if (isset($data['quotation_no'])) {
			$quotation_no = $data['quotation_no'];
		} else {
			$quotation_no = 0;
		}

		if (isset($data['enter_by'])) {
			$enter_by = $data['enter_by'];
		} else {
			$enter_by = 0;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "generate_quotation_no` SET `quotation_no` = '" . $quotation_no . "', `enter_by` = '" . $enter_by . "',`date_create` = NOW()");


	}









}
