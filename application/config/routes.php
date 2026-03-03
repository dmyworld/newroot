<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* ------ Dashboard ------ */
$route['dashboard'] = 'OwnerDashboard';
$route['dashboard/(:any)'] = 'OwnerDashboard/$1';

/* ------ Sample Data Seeder ------ */
$route['sample_data']           = 'Sample_data/index';
$route['sample_data/install']   = 'Sample_data/install';
$route['sample_data/reset']     = 'Sample_data/reset';

/* ------ Stock Transfer ------ */
$route['stock_transfer'] = 'stock_transfer/index';
$route['stock_transfer/search_product'] = 'stock_transfer/search_product';
$route['stock_transfer/process_transfer'] = 'stock_transfer/process_transfer';

/* =========================================================
 * REST API Routes   /api/{controller}/{method}
 * ========================================================= */

/* -- Auth -- */
$route['api/auth/login']           = 'api/Auth/login';
$route['api/auth/register']        = 'api/Auth/register';
$route['api/auth/me']              = 'api/Auth/me';
$route['api/auth/update']          = 'api/Auth/update';

/* -- Timber Marketplace -- */
$route['api/timber/listings']      = 'api/Timber/listings';
$route['api/timber/lot']           = 'api/Timber/lot';
$route['api/timber/add_listing']   = 'api/Timber/add_listing';
$route['api/timber/bid']           = 'api/Timber/bid';
$route['api/timber/buy_now']       = 'api/Timber/buy_now';
$route['api/timber/my_listings']   = 'api/Timber/my_listings';
$route['api/timber/my_bids']       = 'api/Timber/my_bids';
$route['api/inventory/branch']     = 'api/Timber/branch_stock';

/* -- Calculator -- */
$route['api/calculator/log_volume']     = 'api/Calculator/log_volume';
$route['api/calculator/sawn_volume']    = 'api/Calculator/sawn_volume';
$route['api/calculator/wastage']        = 'api/Calculator/wastage';
$route['api/calculator/price_estimate'] = 'api/Calculator/price_estimate';
$route['api/calculator/history']        = 'api/Calculator/history';

/* -- Dashboard (real-time stats, charts) -- */
$route['api/dashboard/stats']      = 'api/Dashboard/stats';
$route['api/dashboard/charts']     = 'api/Dashboard/charts';

/* -- Audit Trail -- */
$route['api/audit/logs']           = 'api/Dashboard/audit_logs';
$route['api/audit/summary']        = 'api/Dashboard/audit_summary';

/* -- Market Trends -- */
$route['api/market/trends']         = 'api/Dashboard/trends';
$route['api/market/species_prices'] = 'api/Dashboard/species_prices';
$route['api/market/record_price']   = 'api/Dashboard/record_price';

/* -- Workers -- */
$route['api/workers/list']         = 'api/Dashboard/workers';

/* =========================================================
 * Consumer Shop Portal   /shop/*
 * ========================================================= */
$route['shop']                         = 'Shop/index';
$route['shop/calculator']              = 'Shop/calculator';
$route['shop/request_quote']           = 'Shop/request_quote';
$route['shop/submit_quote']            = 'Shop/submit_quote';
$route['shop/my_orders']               = 'Shop/my_orders';
$route['shop/admin_orders']            = 'Shop/admin_orders';
$route['shop/update_order_status']     = 'Shop/update_order_status';
$route['shop/manage_bids']             = 'Shop/manage_bids';
$route['shop/my_deals']               = 'Shop/my_deals';
$route['shop/place_bid']              = 'Shop/place_bid';
$route['shop/buy_now']                = 'Shop/buy_now';
$route['shop/finalize_deal']          = 'Shop/finalize_deal';
$route['shop/approve_request_buy']    = 'Shop/approve_request_buy';
$route['shop/update_bid_status']      = 'Shop/update_bid_status';
$route['shop/record_measurements']    = 'Shop/record_measurements';
$route['shop/set_agreement']          = 'Shop/set_agreement';
$route['shop/track']                   = 'Shop/track';
$route['shop/track/(:any)']            = 'Shop/track/$1';
$route['shop/checkout/(:any)/(:any)']  = 'Shop/checkout/$1/$2';
$route['shop/view/(:any)/(:num)']      = 'Shop/view/$1/$2';