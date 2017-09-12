<?php
class ModelShippingAPoslajuGeoWeight extends Model {
	public function getQuote($address) {
		$this->load->language('shipping/a_poslaju_geo_weight');

		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		foreach ($query->rows as $result) {
			if ($this->config->get('a_poslaju_geo_weight_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}
			
			$min_weight = $this->config->get('a_poslaju_geo_weight_' . $result['geo_zone_id'] . '_min');
		    $max_weight = $this->config->get('a_poslaju_geo_weight_' . $result['geo_zone_id'] . '_max');
		    
		    if (($this->cart->getWeight() < $min_weight) || ($this->cart->getWeight() > $max_weight)) {
                $status = false;
             }

			if ($status) {
				$cost = '';
				$weight = $this->cart->getWeight();
				
				$fuel = $this->config->get('a_poslaju_geo_weight_' . $result['geo_zone_id'] . '_fuel');
				$hand = $this->config->get('a_poslaju_geo_weight_' . $result['geo_zone_id'] . '_hand');
				$gst = $this->config->get('a_poslaju_geo_weight_' . $result['geo_zone_id'] . '_gst');
				
				$rates = explode(',', $this->config->get('a_poslaju_geo_weight_' . $result['geo_zone_id'] . '_rate'));
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}

				if ((string)$cost != '') {
				 
				$p1 = round($fuel/100, 2)*$cost;
				$p2 = round($hand/100, 2)*$cost;
				$costhp = $p1 + $p2 + $cost;
				$p3 = round($gst/100, 2)*$costhp;
				$costnew = $cost + $p1 + $p2 + $p3;
				  
				    if ($this->config->get('a_poslaju_geo_weight_shipdisplayoption') =='1') { 
					    $quote_data['a_poslaju_geo_weight_' . $result['geo_zone_id']] = array(
						'code'         => 'a_poslaju_geo_weight.a_poslaju_geo_weight_' . $result['geo_zone_id'],
						'keycode'      => '1',
						'title'        => $this->language->get('text_title') . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
						'icon_shipping'=> $this->language->get('icon_shipping_1'),
						'cost'         => $costnew,
						'tax_class_id' => $this->config->get('a_poslaju_geo_weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($costnew, $this->config->get('a_poslaju_geo_weight_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					    );
					    
					} elseif ($this->config->get('a_poslaju_geo_weight_shipdisplayoption') =='2') {
					    $quote_data['a_poslaju_geo_weight_' . $result['geo_zone_id']] = array(
						'code'         => 'a_poslaju_geo_weight.a_poslaju_geo_weight_' . $result['geo_zone_id'],
						'keycode'      => '1',
						'title'        => $this->language->get('text_title') . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
						'icon_shipping'=> $this->language->get('icon_shipping_2'),
						'cost'         => $costnew,
						'tax_class_id' => $this->config->get('a_poslaju_geo_weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($costnew, $this->config->get('a_poslaju_geo_weight_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					    );
					 
					} else {
					    $quote_data['a_poslaju_geo_weight_' . $result['geo_zone_id']] = array(
						'code'         => 'a_poslaju_geo_weight.a_poslaju_geo_weight_' . $result['geo_zone_id'],
						'keycode'      => '1',
						'title'        => $this->language->get('text_title') . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
						'icon_shipping'=> $this->language->get('icon_shipping_3'),
						'cost'         => $costnew,
						'tax_class_id' => $this->config->get('a_poslaju_geo_weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($costnew, $this->config->get('a_poslaju_geo_weight_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					    );
					 	
				 }
			   }
			}
		}

		$method_data = array();

		if ($quote_data) {
			$method_data = array(
				'code'       => 'a_poslaju_geo_weight',
				'title'      => '',
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('a_poslaju_geo_weight_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}