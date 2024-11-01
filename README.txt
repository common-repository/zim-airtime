=== Zim Airtime ===
Contributors: techzim
Donate link: https://www.techzim.co.zw/
Tags: e-commerce
Requires at least: 3.0.1
Tested up to: 5.7
Requires PHP: 5.6
Stable tag: 2.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Extra income stream for Zimbabwean online publishers. An easy way for them to sell airtime

== Description ==

Zim Airtime is a plugin that gives Zimbabwean online publishers a secondary revenue stream. The plugin allows visitors to such websites to buy prepaid airtime and internet subscriptions for their mobile networks. The publisher earns a commission for airtime sales that originate from their website. 

The publisher will contact Techzim to be on-boarded as a vendor so that they may begin to sell airtime on their website. Essentially, the plugin displays a form for website visitors who wish to buy airtime to fill in. The information gathered by this form is sent to [techzim market airtime system](https://europe-west2-techzim-airtime-system.cloudfunctions.net/create_order) where the buying request is processed. The customer will be sent a message on their mobile phone to confirm the transaction. Once that happens, the customer will receive the airtime and the publisher from which the sale originated will be credited with their commission.

[Techzim Market](https://techzim.market/)
[Privacy Policy](https://www.iubenda.com/privacy-policy/25401067)

== Installation ==
There are a few options for installing and setting up this plugin.

= UPLOAD MANUALLY =

1. Download and unzip the plugin
1. Upload the ‘techzim-airtime’ folder into the ‘/wp-content/plugins/’ directory
1. Go to the Plugins admin page and activate the plugin

= INSTALL VIA ADMIN AREA = 

1. In the admin area go to Plugins > Add New and search for “Zim Airtime”
1. Click install and then click activate

== USAGE ==

* Once installed you can direct customers to yourdomain/airtime so they can buy airtime.
* In the admin area go to Settings > Zim Airtime
* Enter you Vendor Name. If you're currently not a vendor, contact us on marketplace@techzim.co.zw for registration.
* Tick the box next to "Airtime Buying Below Post" if you'd also want readers to be able to buy airtime at the end of a post
* Save the settings

You're done!

**NB:** A valid Vendor Name should be entered for you to earn commission.

== Frequently Asked Questions ==

= Where do I get my Vendor name? =

Contact us on marketplace@techzim.co.zw to be registered as a Vendor.

== Screenshots ==

1. This is the airtime page
2. This is the airtime buying form below a post
3. This is the settings page

== Changelog ==
= 2.4.0 =
* UPDATED: styles to use Tailwind CSS.

= 2.3.2 =
* UPDATED: AMP custom CSS.

= 2.3.1 =
* FIXED: airtime order received page four-o-four.

= 2.3.0 =
* ADDED: airtime order received page notice from Techzim Airtime System.
* ADDED: airtime buying form shortcode.

= 2.2.5 =
* ADDED: notice on airtime order received page to inform customers.

= 2.2.4 =
* FIXED: airtime form not being displayed on airtime page for some websites.

= 2.2.3 =
* FIXED: diaspora page being output on local airtime page

= 2.2.2 =
* FIXED: ZWL airtime amount not being calculated immediately after entering US airtime amount.

= 2.2.0 =
* ADDED: ability to pay for airtime using international payment methods. 

= 2.1.6 =
* FIXED: update js file.

= 2.1.5 =
* UPDATED: add NetOne pinful recharges.

= 2.1.4 =
* UPDATED: Add js resource.

= 2.1.3 =
* UPDATED: Rename js file name.

= 2.1.2 =
* FIXED: Using test API endpoint to create orders instead of the live API endpoint.

= 2.1.1 =
* UPDATED: direct customer support traffic to the live chat.

= 2.1.0 =
* ADDED: customer support live chat.

= 2.0.2 =
* UPDATED: customer support number.

= 2.0.1 =
*FIXED: lowercase order ID on query page making it hard for support to quickly find the order on new system.

= 2.0.0 =
* UPDATED: plugin to send transactions to a new system that has better performance and scalability.

= 1.0.2 =
* FIXED: Airtime buying form being added to WordPress REST API results.

= 1.0.1 =
* FIXED: WooCommerce cart form hidden by CSS for non airtime products.

= 1.0 =
* Initial release.

== Upgrade Notice ==
= 2.4.0 =
* As a vendor you should upgrade to this version so that customers get a better looking form.

= 2.3.2 =
* As a vendor you should upgrade to this version so that the latest styles are used for AMP pages.

= 2.3.1 =
* As a vendor you should upgrade to this version so that the order received page doesn't show a four-o-four error.

= 2.3.0 =
* As a vendor you should upgrade to this version so you can sell anywhere on your pages using a shortcode and so you can get notices updated automatically.

= 2.2.5 =
* As a vendor you should upgrade to this version so that customers are informed about EcoCash PIN prompt challenges.

= 2.2.4 =
* As a vendor you should upgrade to this version so that the buying form is displayed on the airtime page.

= 2.2.3 =
* As a vendor, this update is optional as the new features are still under trial.

= 2.2.2 =
* As a vendor, this update is optional as the new features are still under trial.

= 2.2.0 =
* As a vendor, this update is optional as the new features are still under trial.

= 2.1.6 =
* As a vendor you should upgrade to this version to continue buying airtime properly.

= 2.1.5 =
* As a vendor you should upgrade to this version to continue buying airtime properly.

= 2.1.4 =
* As a vendor you should upgrade to this version to continue buying airtime properly.

= 2.1.3 =
* As a vendor you should upgrade to this version to continue making sales and earning commission.

= 2.1.2 =
* As a vendor you should upgrade to this version to continue making sales and earning commission.

= 2.1.1 =
* As a vendor you should upgrade to this version so that customers can get support assistance quickly via the live chat option.

= 2.1.0 =
* As a vendor you should upgrade to this version so that customers can get support assistance via live chat.

= 2.0.2 =
* As a vendor you should upgrade to this version so that customers can get support assistance on the new support number.

= 2.0.1 =
* As a vendor you should upgrade to this version so that customers can get support assistance quickly. 

= 2.0.0 =
* As a vendor you should upgrade to this version to continue making sales and earning commission.

= 1.0.2 =
* If your site's content is pulled by third parties using the WordPress REST API then you'll need to upgrade to this version so that the API results don't include the airtime buying form.

= 1.0.1 =
* As a WooCommerce user you'll want to upgrade to this version so that the cart form on your products will be visible.

= 1.0 =
* Initial release.
