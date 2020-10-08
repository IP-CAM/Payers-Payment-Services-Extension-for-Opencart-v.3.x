<?php
// Heading
$_['heading_title']      = 'Payer Installment';

// Text
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified the account details!';
$_['text_edit']          = 'Edit Payer Installment';
$_['text_development']   = '<span style="color: green;">Ready</span>';
$_['text_payer_enter']	 = '<a onclick="window.open(\'http://payer.se\');"><img src="view/image/payment/payer.png" alt="Payer" title="Payer" /><br/></a>';

// Entry
$_['entry_status']       = 'Status:';
$_['entry_geo_zone']     = 'Geo Zone:';
$_['entry_order_status'] = 'Order Status:';
$_['entry_mid']          = 'Agent ID:';
$_['entry_key']          = 'Key A:';
$_['entry_keyb']         = 'Key B:';
$_['entry_sort_order']   = 'Sort Order:';
$_['entry_test']   	 = 'Test Mode:';
$_['entry_debug']   	 = 'Debug Mode:';


// Help
$_['help_mid']           = '(use "*" for live or "TESTINSTALLATION" for testmode)';
$_['help_key']           = '(use "*" for live or "j3qh0b3B22sIyWulCZKeFJvIMx9mylLId2Qd4JEUAWtYJOacDKg9kCGWZE0oQKWUCDXwcshCfArOerQI2XGcpdYfIXtoyg02JWnLfuekVvZ1NGyFt5HJ8vOGj9VIeUzO" for testmode)';
$_['help_keyb']          = '(use "*" for live or "mzuP5yWQWzesjrRlfQToHSf1B2xjNseZRyFLWrsIRw12NIcTpW9XFdN76afIsjyaI4Muk543qTT5sWNHJLueP8aK8gjqqHrYB5jLYcEfWn0eaNMJo7O55PF3VOicmA2N" for testmode)';
$_['help_ajax']          = 'Ajax Pre-Confirm will set the order to "pending" before sending to the gateway. This is only needed if there are server communication problems with the gateway and orders are being lost. By pre-confirming the order, the order starts in a pending state, then upon gateway return, the order is updated. (Recommended: DISABLED)';
$_['help_test']          = 'Test mode is used to make test transactions';
$_['help_debug']         = 'Debug mode is used when there are payment or order update issues to help track down where the problem is. This usually includes saving logs or sending emails to the store email with extra information. (Recommended: DISABLED)';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify this payment module!';
$_['error_mid']          = 'Agent ID Required!';
$_['error_key']          = 'Key A Required!';
$_['error_keyb']         = 'Key B Required!';
?>