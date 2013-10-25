<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "members";
$route['404_override'] = '';

#DASHBOARD

$route['members/dashboards'] 	= 'dashboards/members/index';
$route['members/dashboards/(:num)'] 	= 'dashboards/members/index/$1';

$route['members/dashboards/search'] 	= 'dashboards/members/search';
$route['members/dashboards/search/(:num)'] 	= 'dashboards/members/search/$1';

$route['members/add-user'] 		= 'dashboards/members/userManagement/add';
$route['members/edit-user/(:num)'] 	= 'dashboards/members/userManagement/edit/$1';

$route['members/view-user/(:num)'] 	= 'dashboards/members/viewUserDetails/$1';
$route['members/view-user-delete/(:num)'] 	= 'dashboards/members/viewUserDetailsDeleteView/$1';

$route['members/delete-user'] 	= 'dashboards/members/deleteUser';
$route['members/check-permission/(.*)/(:num)'] 	= 'dashboards/members/checkPermission/$1/$2';

$route['logout']				= 'members/logout';


/* End of file routes.php */
/* Location: ./application/config/routes.php */