<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\Roles;

// $roles = DB::table('roles')->get();
// print_r($roles);

Route::get('/', 'HomepageController@homepage');

Route::get('/home',[
	'uses' => 'HomepageController@homepage',
	'as' => 'home'
	]);

Route::post('/register', [
	'uses' => 'AccountController@register',
	'as' => 'companyregister'
]);

Route::get('/completeaccount', [
	'uses' => 'AccountController@completeaccount',
	'as' => 'companysetup'
]);

Route::post('/completeaccount', [
	'uses' => 'AccountController@completeaccountsave',
	'as' => 'companysetupsave'
]);

Route::get('{domain}/', [
	'uses' => 'HomepageController@signin',
	'as' => 'companysignin'
]);

Route::get('{domain}/signin', [
	'uses' => 'HomepageController@signin',
	'as' => 'companysignin'
]);

Route::post('{domain}/signin', [
	'uses' => 'HomepageController@signinRequest',
	'as' => 'companysignincheck'
]);

Route::get('{domain}/logout',[
	'uses' => 'HomepageController@signout',
	'as' => 'logout'
]);

// Route::get('/haha/haha', function(){
// 	$getroles = DB::table('roles')->get()->toArray();
// 	$getroles = json_decode(json_encode($getroles), True);
// 	$roles = [];

// 	foreach ($getroles as $role){
// 		$roles[] = $role['role_desc'];
// 	}
// 	echo "<pre>"; print_r($roles); echo "</pre>";
// });

/*$getroles = DB::table('roles')->get()->toArray();
$getroles = json_decode(json_encode($getroles), True);
$roles = [];

foreach ($getroles as $role){
	$roles[] = $role['role_desc'];
}*/



Route::group(['middleware' => 'web'], function () {	
	$roles = ['Superadmin', 'Loan Officer', 'Bookkeeper', 'Credit Officer', 'Audit Officer'];
	
	Route::get('{domain}/{user_id}',[
		'uses' => 'MainController@dashboard',
		'as' => 'dashboard',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/members/add',[
		'uses' => 'MemberController@addmember',
		'as' => 'addmember',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::post('{domain}/{user_id}/members/add', [
		'uses' => 'MemberController@addmembersave',
		'as' => 'addmembersave',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/members/overview',[
		'uses' => 'MemberController@getallmembers',
		'as' => 'viewallmembers',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}',[
		'uses' => 'MemberController@memberloanbook',
		'as' => 'viewmemberloanbook',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'LoanController@getUserLoanDetails',
		'as' => 'getuserloandetails',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'EqualAmortizationCalculator@equalAmortizationNoAjax',
		'as' => 'equalamortizationnoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'EqualPrincipalCalculator@equalPrincipalNoAjax',
		'as' => 'equalprincipalnoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'FlatRateCalculationController@flatRateNoAjax',
		'as' => 'flatratenoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/apply/{member_id}',[
		'uses' => 'LoanController@applyloan',
		'as' => 'applyloan',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::post('{domain}/{user_id}/apply/{member_id}',[
		'uses' => 'LoanController@saveapplyloan',
		'as' => 'saveapplication',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/members/{member_id}',[
		'uses' => 'MemberController@getmemberprofile',
		'as' => 'getmemberprofile',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::post('{domain}/{user_id}/members/update',[
		'uses' => 'MemberController@updatemembersave',
		'as' => 'updatemembersave',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loans/create',[
		'uses' => 'LoanController@createloan',
		'as' => 'addnewloan',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::post('{domain}/{user_id}/loans/create',[
		'uses' => 'LoanController@saveloan',
		'as' => 'savenewloan',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loans/overview',[
		'uses' => 'LoanController@getallloans',
		'as' => 'viewallloans',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/apply/{member_id}/getLoanDetails/{loan_id}',[
		'uses' => 'LoanController@getLoanDetailsAjax',
		'as' => 'getloandetails',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/apply/{member_id}/flatrate/{loan_id}',[
		'uses' => 'FlatRateCalculationController@flatRate',
		'as' => 'flatrate',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/apply/{member_id}/equalAmort/{loan_id}',[
		'uses' => 'EqualAmortizationCalculator@equalAmortization',
		'as' => 'equalamortization',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/apply/{member_id}/equalPrincipal/{loan_id}',[
		'uses' => 'EqualPrincipalCalculator@equalPrincipal',
		'as' => 'equalprincipal',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}/flatrate',[
		'uses' => 'FlatRateCalculationController@flatRate',
		'as' => 'sched_flatrate',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}/equalAmort',[
		'uses' => 'EqualAmortizationCalculator@equalAmortization',
		'as' => 'sched_equalamortization',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/loanbook/{member_id}/equalPrincipal',[
		'uses' => 'EqualPrincipalCalculator@equalPrincipal',
		'as' => 'sched_equalamortization',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/memberoverview/{member_id}/flatrate',[
		'uses' => 'FlatRateCalculationController@flatRate',
		'as' => 'sched_flatrate',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/memberoverview/{member_id}/equalAmort',[
		'uses' => 'EqualAmortizationCalculator@equalAmortization',
		'as' => 'sched_equalamortization',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/memberoverview/{member_id}/equalPrincipal',[
		'uses' => 'EqualPrincipalCalculator@equalPrincipal',
		'as' => 'sched_equalamortization',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	/*Route::post('{domain}/{user_id}/apply/{member_id}/calculate',[
		'uses' => 'LoanController@calculateSample',
		'as' => 'calculatesample',
		'middleware' => 'roles',
        'roles' => $roles
	]);*/

	Route::get('{domain}/{user_id}/apply/{member_id}/comaker',[
		'uses' => 'LoanController@applynew_comakers',
		'as' => 'applynew_comakers',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::post('{domain}/{user_id}/apply/{member_id}/forapproval',[
		'uses' => 'LoanController@applynewloan',
		'as' => 'applynewloan',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests',[
		'uses' => 'LoanController@loanrequests',
		'as' => 'loanrequests',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/action/{member_id}',[
		'uses' => 'LoanController@loanrequestaction',
		'as' => 'loanrequestaction',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/memberoverview/{member_id}',[
		'uses' => 'LoanController@getmemberoverview',
		'as' => 'loanrequests_overview',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/memberoverview/{member_id}/loandetails/{loan_user_id}',[
		'uses' => 'LoanController@getUserLoanDetails',
		'as' => 'loanrequests_overview_details',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/savesched/{member_id}/{loan_user_id}',[
		'uses' => 'LoanController@saveSchedule',
		'as' => 'saveschedule',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/savesched/flatrate/{member_id}/{loan_user_id}',[
		'uses' => 'FlatRateCalculationController@savesched',
		'as' => 'saveflatrateschedule',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/savesched/equalamortization/{member_id}/{loan_user_id}',[
		'uses' => 'EqualAmortizationCalculator@savesched',
		'as' => 'saveequalamortizationsched',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/requests/savesched/equalprincipal/{member_id}/{loan_user_id}',[
		'uses' => 'EqualPrincipalCalculator@savesched',
		'as' => 'saveequalprincipalsched',
		'middleware' => 'roles',
        'roles' => $roles
	]);


	Route::get('{domain}/{user_id}/roles/roleoverview',[
		'uses' => 'RoleController@getRoles',
		'as' => 'roleoverview',
		'middleware' => 'roles',
        'roles' => $roles
		]);

	Route::post('{domain}/{user_id}/roles/promote',[
		'uses' => 'RoleController@saveNewRoles',
		'as' => 'savenewrole',
		'middleware' => 'roles',
        'roles' => $roles
		]);

	Route::get('{domain}/{user_id}/payments',[
		'uses' => 'PaymentsController@paymentform',
		'as' => 'paymentform',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans',[
		'uses' => 'PaymentsController@loanpaymentform',
		'as' => 'loanpaymentform',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans/{member_id}',[
		'uses' => 'PaymentsController@memberloanpaymentform',
		'as' => 'memberloanpaymentform',
		'middleware' => 'roles',
        'roles' => $roles
	]);

/*	Route::get('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'PaymentsController@memberloanpaymentformschedule',
		'as' => 'memberloanpaymentformschedule',
		'middleware' => 'roles',
        'roles' => $roles
	]);*/

	Route::post('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'PaymentsController@memberloanpaymentformschedule',
		'as' => 'memberloanpaymentformschedule',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/searchMember',[
		'uses' => 'PaymentsController@pay_searchmember',
		'as' => 'searchmember',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::post('{domain}/{user_id}/payments',[
		'uses' => 'PaymentsController@savepaymentform',
		'as' => 'savepaymentform',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::post('{domain}/{user_id}/payments/searchLoan',[
		'uses' => 'PaymentsController@searchLoan',
		'as' => 'makepaymentformsearchloan',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}',[
		'uses' => 'PaymentsController@memberloanbook',
		'as' => 'paymentsviewmemberloanbook',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}/{loan_user_id}',[
		'uses' => 'PaymentsController@paymemberloan',
		'as' => 'pay_viewmemberloans',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'EqualAmortizationCalculator@equalAmortizationNoAjax',
		'as' => 'equalamortizationnoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'EqualPrincipalCalculator@equalPrincipalNoAjax',
		'as' => 'equalprincipalnoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'FlatRateCalculationController@flatRateNoAjax',
		'as' => 'flatratenoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'EqualAmortizationCalculator@payequalAmortizationNoAjax',
		'as' => 'payequalamortizationnoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'EqualPrincipalCalculator@payequalPrincipalNoAjax',
		'as' => 'payequalprincipalnoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loans/{member_id}/schedule/{loan_user_id}',[
		'uses' => 'FlatRateCalculationController@payflatRateNoAjax',
		'as' => 'payflatratenoajax',
		'middleware' => 'roles',
        'roles' => $roles
	]);

/*	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}/{loan_user_id}/payschedule',[
		'uses' => 'PaymentsController@pay_getmemberloan',
		'as' => 'paymentsviewmemberloans',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}/{loan_user_id}/countpayment',[
		'uses' => 'PaymentsController@countpayments',
		'as' => 'countpayments',
		'middleware' => 'roles',
        'roles' => $roles
	]);


	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}/{loan_user_id}/payschedule/flatrate',[
		'uses' => 'FlatRateCalculationController@flatRate',
		'as' => 'sched_flatrate',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}/{loan_user_id}/payschedule/equalAmort',[
		'uses' => 'EqualAmortizationCalculator@equalAmortization',
		'as' => 'sched_equalamortization',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}/{loan_user_id}/payschedule/equalPrincipal',[
		'uses' => 'EqualPrincipalCalculator@equalPrincipal',
		'as' => 'sched_equalamortization',
		'middleware' => 'roles',
        'roles' => $roles
	]);*/

	Route::get('{domain}/{user_id}/payments/loanbook/{member_id}/{loan_user_id}/makePayment',[
		'uses' => 'PaymentsController@savepayment',
		'as' => 'paymentsviewmemberloans',
		'middleware' => 'roles',
        'roles' => $roles
	]);

	Route::get('{domain}/{user_id}/company',[
		'uses' => 'CompanyController@companySettings',
		'as' => 'companysettings',
		'middleware' => 'roles',
        'roles' => $roles
		]);

	Route::post('{domain}/{user_id}/company',[
		'uses' => 'CompanyController@updateCompanySettings',
		'as' => 'updatecompany',
		'middleware' => 'roles',
        'roles' => $roles
		]);

});
