# Payer OpenCart Module 3.0

This is the payment module to get started with Payers payment services in OpenCart.

For more information about our payment services, please visit [www.payer.se](http://www.payer.se).

## Requirements

  * [OpenCart](http://www.opencart.com): Version 3.0
  * [Payer Credentials](https://payer.se) - Missing credentials? Contact the [Customer Service](mailto:kundtjanst@payer.se).

## Installation

  1. Place the `admin`, `catalog` and `images` folders in the root of your OpenCart installation.
  2. Configure your Payer Credentials. See the `Configuration` section below for more details.
  3. From the OpenCart administration page, go to `Extensions`and then `Payment`.
  4. Install and configure the module.

## Configuration

Each module has to be configured correctly with your unique Payer Credentials before it can be used in production. The credentials corresponds to the following parameters:

  * `AGENT ID`
  * `KEY 1`
  * `KEY 2`

The key values can be found under the `Settings/Account` section in [Payer Administration](https://secure.payer.se/adminweb/inloggning/inloggning.php).

Setup the module by replacing the placeholders in the `PayReadConf.php` file with these values. The configuration file can be found in the `catalog/controller/payment/payerapi` folder in the root of the directory. And that's it!

## Support

For questions regarding your payment module integration, please contact the Payer [Technican Support](mailto:teknik@payer.se). 

For questions regarding the 3.0 migration please open an issue or contact [Henric Johansson](mailto:henric@vallagruppen.com).