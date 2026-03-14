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
$route['register'] = 'Hub/register';
$route['login'] = 'Hub/login';
$route['hub/register'] = 'Hub/register';
$route['hub/login'] = 'Hub/login';
$route['hub/pending'] = 'Hub/pending';
$route['user/login'] = 'User/login';
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
 * Action Module (Phase 2)   /api/action/*
 * ========================================================= */
$route['api/action/device/register']        = 'api/Action/register_device';
$route['api/action/provider/ping']          = 'api/Action/provider_ping';
$route['api/action/provider/availability']  = 'api/Action/provider_availability';
$route['api/action/request/create']         = 'api/Action/request_create';
$route['api/action/request/status']         = 'api/Action/request_status';
$route['api/action/request/accept']         = 'api/Action/request_accept';
$route['api/action/request/reject']         = 'api/Action/request_reject';
$route['api/action/nearby_markers']         = 'api/Action/nearby_markers';
$route['api/action/request/complete']       = 'api/Action/request_complete';
$route['api/action/rating/add']             = 'api/Action/rating_add';
$route['api/action/rating/list']            = 'api/Action/rating_list';

/* =========================================================
 * Service Management (Phase 1)
 * ========================================================= */
$route['servicecategories']                 = 'Servicecategories/index';
$route['servicecategories/add']            = 'Servicecategories/add';
$route['servicecategories/add_sub']        = 'Servicecategories/add_sub';
$route['servicecategories/edit/(:num)']    = 'Servicecategories/edit/$1';
$route['servicecategories/delete']         = 'Servicecategories/delete';

$route['services']                         = 'Services/index';
$route['services/add']                    = 'Services/add';
$route['services/edit/(:num)']            = 'Services/edit/$1';
$route['services/delete']                 = 'Services/delete';
$route['services/status']                 = 'Services/status';
$route['services/bulk_commission']         = 'Services/bulk_commission';
$route['services/surge']                   = 'Services/surge';

$route['providers']                        = 'Providers/index';
$route['providers/active']                 = 'Providers/active';
$route['providers/view']                   = 'Providers/view';
$route['providers/approve']                = 'Providers/approve';
$route['providers/reject']                 = 'Providers/reject';
$route['providers/suspend']                = 'Providers/suspend';
$route['providers/monitoring']             = 'Providers/monitoring';
$route['providers/get_locations']          = 'Providers/get_locations';

$route['promos']                           = 'Promos/index';
$route['promos/add']                       = 'Promos/add';

$route['complaints']                       = 'Complaints/index';
$route['complaints/resolve']               = 'Complaints/resolve';

$route['service_reports/commissions']      = 'Service_reports/commissions';
$route['service_reports/performance']      = 'Service_reports/provider_performance';
$route['service_reports/categories']       = 'Service_reports/category_analysis';

/* =========================================================
 * Consumer Shop Portal   /shop/*
 * ========================================================= */
/* -- Consumer Shop Portal -- */
$route['shop']                         = 'Shop/index';
// ... (existing shop routes)
$route['shop/view/(:any)/(:num)']      = 'Shop/view/$1/$2';

/* =========================================================
 * Subscription & Commission Module
 * ========================================================= */
$route['subscriptions/admin']        = 'Subscriptions/index';
$route['subscriptions/approvals']    = 'Subscriptions/approvals';
$route['subscriptions/active_users'] = 'Subscriptions/active_users';
$route['subscriptions/commissions']  = 'Subscriptions/commissions';