<?php
/*
$Id: payer_plugin.php,v 1.1 2015/04/22 11:58:55 bihla Exp $
$Header: /usr/local/cvsroot/startpaket/API/PHP/payer_plugin.php,v 1.1 2015/04/22 11:58:55 bihla Exp $
$Log: payer_plugin.php,v $
Revision 1.1  2015/04/22 11:58:55  bihla
rebuild of startpaket - COMPLETELY NEW STRUCTURE

Revision 1.1  2015/04/22 11:16:23  bihla
sharing startpaketINIT for the first time

Revision 1.14  2015/03/26 16:59:01  bihla
small bug fixed

Revision 1.13  2014/10/03 14:14:17  bihla
adding woocommerce form fields

Revision 1.12  2014/06/25 13:31:26  bihla
must be correct URL

Revision 1.11  2013/04/25 19:40:47  bihla
the latest.

Revision 1.10  2013/01/03 13:22:33  bihla
Added errorhandling when getting challange.

Revision 1.9  2012/08/31 15:04:01  bihla
removed some spaces

Revision 1.8  2012/08/31 14:47:19  bihla
adjusted from postcode to zipcode

Revision 1.7  2012/08/31 14:10:40  bihla
always use https://secure.payer.se

Revision 1.6  2012/08/31 13:59:44  bihla
added "example" to payer_plugin
added fast_checkout.php

Revision 1.5  2012/08/01 15:01:09  admin
Bug 474 - Add quick checkout for osCommerce

Revision 1.4  2012/08/01 13:47:24  admin
Bug 473 - Quick checkout has to check if jQuery is loaded before load it

Revision 1.3  2012/05/21 08:46:08  amcco
Added support for IE

Revision 1.1  2012/05/15 08:52:03  bihla
added CVS header

*/ 

class payer_plugin {
	
	var $postapi;
	var $baseurl;

	function payer_plugin() {
		$this->postapi = new payread_post_api();
		$this->baseurl="https://secure.payer.se/PostAPI_V1/pages/helper";
//		$this->baseurl="http://vmware.payer.se:8080/PostAPI_V1/pages/helper";
	}
	
	function setBaseUrl($url){
		$this->baseurl=$url;
	}
	
	function getChallangeResponse($challange) {
		return md5($this->postapi->getKeyA()."$challange");
	}

	function getFastCheckoutScript($ecommerce) {
		$line = "";
		$html = "";
		$jseffects_start = "";
		$jseffects_end = "";
		$website=$this->postapi->get_agentid();
		$fp = fopen($this->baseurl."/getChallange.jsp?website=$website", "r");
		if ($fp!=null){
			while (!feof($fp)) {
				$line.=fgets($fp, 4096);
			}
			$obj=json_decode($line);
			$challange=$obj->auth->challange;
			$hash = $this->getChallangeResponse($challange);
		} else {
			$hash = "failed";
		}
		$jsinit = "payerjs_fqcout.payerjs_init();";
		
			if ($ecommerce == 'example') {
			$js_inputs = "
			jQuery('input[name=\"firstname\"]').val(c.consumer.firstname);
			jQuery('input[name=\"lastname\"]').val(c.consumer.lastname);
			jQuery('input[name=\"streetaddress\"]').val(c.consumer.address);
			jQuery('input[name=\"zipcode\"]').val(c.consumer.zipcode);
			jQuery('input[name=\"city\"]').val(c.consumer.city);
			jQuery('select[name=\"country\"]').val('SE');
			";
			$html = "<script type=\"text/javascript\">";
		}
			if ($ecommerce == 'woocommerce') {
			$js_inputs = "
			jQuery('input[name=\"ship_to_different_address\"]').val(0);
			jQuery('input[name=\"billing_first_name\"]').val(c.consumer.firstname);
			jQuery('input[name=\"billing_last_name\"]').val(c.consumer.lastname);
			jQuery('input[name=\"billing_address_1\"]').val(c.consumer.address);
			jQuery('input[name=\"billing_address_2\"]').val('');
			jQuery('input[name=\"billing_postcode\"]').val(c.consumer.zipcode);
			jQuery('input[name=\"billing_city\"]').val(c.consumer.city);
			jQuery('input[name=\"billing_country\"]').val('SE');
			";
			$html = "<script type=\"text/javascript\">";
		}
		if ($ecommerce == 'opencart') {
			$js_inputs = "
			jQuery('input[name=\"firstname\"]').val(c.consumer.firstname);
			jQuery('input[name=\"lastname\"]').val(c.consumer.lastname);
			jQuery('input[name=\"address_1\"]').val(c.consumer.address);
			jQuery('input[name=\"postcode\"]').val(c.consumer.zipcode);
			jQuery('input[name=\"city\"]').val(c.consumer.city);
			jQuery('select[name=\"country_id\"]').val('203');			
			jQuery('#payment-address select[name=\'zone_id\']').load('index.php?route=checkout/address/zone&country_id=203');
			";			
			$jseffects_start = "
			// jseffects_start - start
			jQuery('#payer_btn_pin').attr('disabled', true);
			jQuery('#payer_btn_pin').after('<span class=wait>&nbsp;<img src=catalog/view/theme/default/image/loading.gif alt=\"Wait...\" /></span>');		
			// jseffects_start - end
			";
			$jseffects_end .= "
			// jseffects_end - start
			jQuery('.wait').remove();
			// jseffects_end - end
			";
			$html = "<script type=\"text/javascript\">";
		}
		if ($ecommerce == 'magento') {
			$js_inputs = "
			jQuery('input[name=\"billing[firstname]\"]').val(c.consumer.firstname);
			jQuery('input[name=\"billing[lastname]\"]').val(c.consumer.lastname);
			jQuery('input[name=\"billing[street]\"]').val(c.consumer.address);
			jQuery('input[name=\"billing[postcode]\"]').val(c.consumer.zipcode);
			jQuery('input[name=\"billing[city]\"]').val(c.consumer.city);
			jQuery('select[name=\"billing[country_id]\"]').val('SE');
			";
			$html = "<script type=\"text/javascript\">";
		}
		if ($ecommerce == 'oscommerce') {
			$js_inputs = "
			jQuery('input[name=\"firstname\"]').val(c.consumer.firstname);
			jQuery('input[name=\"lastname\"]').val(c.consumer.lastname);
			jQuery('input[name=\"street_address\"]').val(c.consumer.address);
			jQuery('input[name=\"postcode\"]').val(c.consumer.zipcode);
			jQuery('input[name=\"city\"]').val(c.consumer.city);
			jQuery('input[name=\"state\"]').val(c.consumer.city);
			jQuery('select[name=\"country\"]').val('203');
			payer_inp_pin = jQuery('#payer_inp_pin').val();
			payer_inp_pin = payer_inp_pin.substr(payer_inp_pin.length-2,1);
			if(0==payer_inp_pin%2){
				jQuery('input[name=\"gender\"][value=\"f\"]').attr('checked','checked');
			}
			else {
				jQuery('input[name=\"gender\"][value=\"m\"]').attr('checked','checked');
			}
			";
			$html = "<script type=\"text/javascript\">";
		}
		
		$jseffects_end .= "
			// jseffects_end - start
			jQuery('#payer_btn_pin').fadeTo('fast', 1);
			if (c.consumer.firstname == '') {
				jQuery('#payer_inp_pin').effect('highlight', {color: '#ff6666'}, 1000);
				jQuery('#payer_inp_pin').css({'border': '1px solid #ff6666'});
				return false;
			}
			// jseffects_end - end
		";
		
		$html .= "
		window.onload = function(){
		if(typeof jQuery == 'undefined'){
			document.write('<script src=\"http://code.jquery.com/jquery-latest.min.js\"><\/script>'); 
			document.write('<script src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js\"><\/script>'); 
		}
		jQuery.support.cors = true;	
		jQuery(document).ready(function() {
			payerjs_fqcout = {
				payerjs_init: function () {
					jQuery('#payer_btn_pin').bind('click', function () {
						$jseffects_start
						jQuery('#payer_btn_pin').fadeTo('slow', 0.5);
						setTimeout(function() {payerjs_fqcout.payerjs_dojsoncall();}, 2500);
					});
				},
				payerjs_dojsoncall: function () {
					if ('XDomainRequest' in window && window.XDomainRequest !== null) {		  
						// Use Microsoft XDR
						var xdr = new XDomainRequest();
						xdr.open('get','$this->baseurl/getAddress.jsp?orgnr=' + jQuery('#payer_inp_pin').val() + '&website=$website&hash=$hash');
						xdr.onload = function() {
							c = jQuery.parseJSON(xdr.responseText);
							$jseffects_end
							// js_inputs - start
							$js_inputs
							// js_inputs - end
						}
						xdr.send();
					} else {
						jQuery.getJSON('$this->baseurl/getAddress.jsp?orgnr=' + jQuery('#payer_inp_pin').val() + '&website=$website&hash=$hash', function(c) { 
							$jseffects_end
							// js_inputs - start
							$js_inputs
							// js_inputs - end
						});
					}
				}
			}
			$jsinit
		});
	}
</script>\n";

		return $html;
	}	
}
?>