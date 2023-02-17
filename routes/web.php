<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/forgot', 'UserControl\AuthController@forgot')->name('forgot');
Route::post('/got_new_pass', 'UserControl\AuthController@got_new_pass')->name('auth.forgot');

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('home', 'HomeController@index')->name('home');
    Route::resource('account', 'UserControl\AccountController');
    Route::get('/logout', 'Auth\LoginController@logout', function () {
        return abort(404);
    });

    Route::group(['middleware' => ['role:Admin|User Manager|User Supervisor|User Staff|Security Senior Staff|Security Staff']], function() {
        Route::resource('helpdesk', 'Helpdesk\HelpdeskController')->except(['index']);
        Route::get('helpdesks/{category?}', ['as'=>'helpdesk.index','uses'=>'Helpdesk\HelpdeskController@index']);
        Route::get('helpdesk/download/{id}', ['as'=>'helpdesk.download','uses'=>'Helpdesk\HelpdeskController@download']);
        Route::get('helpdesk/file/export', ['as'=>'helpdesk.export','uses'=>'Helpdesk\HelpdeskController@export']);
		
		//	Authorization SAP
        Route::resource('sap/authorization', 'Helpdesk\SapAuthController');
        Route::get('sap/authorization/fico/{approval_id}/{helpdesk_id}/{status}', ['as'=>'authorization.fico','uses'=>'Helpdesk\SapAuthController@fico_approval']);
        Route::get('sap/authorization/bpo/{approval_id}/{helpdesk_id}/{status}', ['as'=>'authorization.bpo','uses'=>'Helpdesk\SapAuthController@bpo_approval']);
        Route::get('sap/authorization/it/{approval_id}/{helpdesk_id}/{status}', ['as'=>'authorization.it','uses'=>'Helpdesk\SapAuthController@it_approval']);
        Route::get('sap/authorization/proman/{approval_id}/{helpdesk_id}/{status}', ['as'=>'authorization.proman','uses'=>'Helpdesk\SapAuthController@proman_approval']);
        Route::get('sap/authorization/cancel/{type}/{approval_id}/{helpdesk_id}', ['as'=>'authorization.cancel','uses'=>'Helpdesk\SapAuthController@cancel_approval']);
		
		//	Config SAP
		Route::resource('sap/config', 'Helpdesk\SapConfigController');
		Route::get('sap/config/bpo/{approval_id}/{helpdesk_id}/{status}', ['as'=>'config.bpo','uses'=>'Helpdesk\SapConfigController@bpo_approval']);
        Route::get('sap/config/fico/{approval_id}/{helpdesk_id}/{status}', ['as'=>'config.fico','uses'=>'Helpdesk\SapConfigController@fico_approval']);
        Route::get('sap/config/proman/{approval_id}/{helpdesk_id}/{status}', ['as'=>'config.proman','uses'=>'Helpdesk\SapConfigController@proman_approval']);
        Route::get('sap/config/it/{approval_id}/{helpdesk_id}/{status}', ['as'=>'config.it','uses'=>'Helpdesk\SapConfigController@it_approval']);        
        Route::get('sap/config/cancel/{type}/{approval_id}/{helpdesk_id}', ['as'=>'config.cancel','uses'=>'Helpdesk\SapConfigController@cancel_approval']);
		
		//Request SAP ABAP
        Route::resource('sap/abap', 'Helpdesk\SapAbapController');
        Route::get('sap/abap/bpo/{approval_id}/{helpdesk_id}/{status}', ['as'=>'abap.bpo','uses'=>'Helpdesk\SapAbapController@bpo_approval']);
        Route::get('sap/abap/fico/{approval_id}/{helpdesk_id}/{status}', ['as'=>'abap.fico','uses'=>'Helpdesk\SapAbapController@fico_approval']);
        Route::get('sap/abap/proman/{approval_id}/{helpdesk_id}/{status}', ['as'=>'abap.proman','uses'=>'Helpdesk\SapAbapController@proman_approval']);
        Route::get('sap/abap/it/{approval_id}/{helpdesk_id}/{status}', ['as'=>'abap.it','uses'=>'Helpdesk\SapAbapController@it_approval']);        
        Route::get('sap/abap/cancel/{type}/{approval_id}/{helpdesk_id}', ['as'=>'abap.cancel','uses'=>'Helpdesk\SapAbapController@cancel_approval']);
		
		//Request Vendor SAP
        Route::resource('sap/vendor', 'Helpdesk\SapVendorController');
        Route::get('sap/vendor/bpo/{approval_id}/{helpdesk_id}/{status}', ['as'=>'vendor.bpo','uses'=>'Helpdesk\SapVendorController@bpo_approval']);
        Route::get('sap/vendor/fico/{approval_id}/{helpdesk_id}/{status}', ['as'=>'vendor.fico','uses'=>'Helpdesk\SapVendorController@fico_approval']);
        Route::get('sap/vendor/proman/{approval_id}/{helpdesk_id}/{status}', ['as'=>'vendor.proman','uses'=>'Helpdesk\SapVendorController@proman_approval']);
        Route::get('sap/vendor/it/{approval_id}/{helpdesk_id}/{status}', ['as'=>'vendor.it','uses'=>'Helpdesk\SapVendorController@it_approval']);        
        Route::get('sap/vendor/cancel/{type}/{approval_id}/{helpdesk_id}', ['as'=>'vendor.cancel','uses'=>'Helpdesk\SapVendorController@cancel_approval']);
    });

    Route::group(['prefix' => 'edoc','middleware' => ['role:Admin|Admin E-Doc|User Manager|User Supervisor|User Staff']], function() {
        Route::resource('dashboard_edoc', 'Edoc\DashboardController');

        //edoc
        Route::resource('list', 'Edoc\EdocController')->except(['create']);
        Route::get('create/{id?}/{doc_type?}/{iso_type?}', ['as' => 'list.create', 'uses' => 'Edoc\EdocController@create']);
        
        //document
        Route::resource('document', 'Edoc\DocumentController');
        Route::get('document/download/{id}', ['as'=>'document.download','uses'=>'Edoc\DocumentController@download']);
        Route::get('document/status/{id}/{status}', ['as'=>'document.status','uses'=>'Edoc\DocumentController@status']);
        Route::post('document/update_file', ['as'=>'document.update_file','uses'=>'Edoc\DocumentController@update_file']);

        //form
        Route::resource('form', 'Edoc\FormController');
        Route::get('form/download/{id}', ['as'=>'form.download','uses'=>'Edoc\FormController@download']);
        Route::get('form/status/{id}/{status}', ['as'=>'form.status','uses'=>'Edoc\FormController@status']);
        Route::post('form/update_file', ['as'=>'form.update_file','uses'=>'Edoc\FormController@update_file']);

        //supporting
        Route::resource('supporting', 'Edoc\SupportingController');
        Route::get('supporting/download/{id}', ['as'=>'supporting.download','uses'=>'Edoc\SupportingController@download']);
        Route::get('supporting/status/{id}/{status}', ['as'=>'supporting.status','uses'=>'Edoc\SupportingController@status']);
        Route::post('supporting/update_file', ['as'=>'supporting.update_file','uses'=>'Edoc\SupportingController@update_file']);
    });

    Route::group(['prefix' => 'okm','middleware' => 'role:Admin|Admin OKM|User Manager|User Supervisor|User Staff|Security Senior Staff|Security Staff'], function(){
        //dashboard
        Route::resource('dashboard_okm','Elearning\DashboardController');
        
        //schedule 
        Route::resource('schedule','Elearning\ScheduleController')->except(['index','show']);
        Route::get('schedules/{category?}', ['as' => 'schedule.index', 'uses' => 'Elearning\ScheduleController@index']);
		Route::get('schedules/detail/{id}/{category?}', ['as' => 'schedule.show', 'uses' => 'Elearning\ScheduleController@show']);
        Route::post('schedule/add_participant/{id}', ['as'=>'schedule.add_participant','uses'=>'Elearning\ScheduleController@add_participant']);
		Route::get('schedule/export_schedule/{id}', ['as'=>'schedule.export_schedule','uses'=>'Elearning\ScheduleController@export_schedule']);
        Route::delete('schedule/remove_participant/{id}', ['as'=>'schedule.remove_participant','uses'=>'Elearning\ScheduleController@remove_participant']);
		
		//User result
        Route::get('user/answer/{schedule_id}/{nik}',['as'=>'user.answer.result', 'uses'=>'Elearning\ScheduleController@user_answers']);

        //exam 
        Route::resource('exam','Elearning\ExamController');
        Route::post('exam/score/{id}', ['as'=>'exam.score','uses'=>'Elearning\ExamController@score']);
        Route::get('exam/start/{id}-{lastpage?}', ['as'=>'exam.start','uses'=>'Elearning\ExamController@start']);
        Route::post('exam/store_answer/{schedule_id}-{question_id}-{answer_id}-{page_number}', ['as'=>'exam.store_answer', 'uses'=>'Elearning\ExamController@store_answer']);
        Route::get('exam/result/{schedule_id}', ['as'=>'exam.result', 'uses'=>'Elearning\ExamController@result']);

        //raport
        Route::resource('raport','Elearning\RaportController');
        Route::get('raport/by_user/{nik}', ['as'=>'raport.by_user','uses'=>'Elearning\RaportController@by_user']);
        Route::get('raport/detail/{nik}/{material_id}', ['as'=>'raport.detail','uses'=>'Elearning\RaportController@detail']);

        //Material
        Route::resource('material','Elearning\MaterialController');
        Route::post('material/store_content', ['as'=>'material.store_content','uses'=>'Elearning\MaterialController@store_content']);
        Route::post('material/update_content/{id}', ['as'=>'material.update_content','uses'=>'Elearning\MaterialController@update_content']);
        Route::delete('material/destroy_content/{id}', ['as'=>'material.destroy_content','uses'=>'Elearning\MaterialController@destroy_content']);
		Route::get('material/download/{id}', ['as'=>'material.download','uses'=>'Elearning\MaterialController@download']);

        //Question
        Route::resource('question','Elearning\QuestionController');
        Route::post('question/store_content', ['as'=>'question.store_content','uses'=>'Elearning\QuestionController@store_content']);
        Route::post('question/update_content/{id}', ['as'=>'question.update_content','uses'=>'Elearning\QuestionController@update_content']);
        Route::get('question/edit_content/{id}', ['as'=>'question.edit_content','uses'=>'Elearning\QuestionController@edit_content']);
        Route::delete('question/destroy_content/{id}', ['as'=>'question.destroy_content','uses'=>'Elearning\QuestionController@destroy_content']);
		Route::post('question/import_content/{id}', ['as'=>'question.import_content','uses'=>'Elearning\QuestionController@import_content']);
		
    });

    Route::group(['middleware' => ['role:Admin']], function() {
        Route::group(['prefix' => 'uac'], function () {
            Route::get('users/reset/{id}',['as'=>'users.reset','uses'=>'UserControl\UserController@reset']);
            Route::get('users/change_status/{id}/{status}',['as'=>'users.change_status','uses'=>'UserControl\UserController@change_status']);
			Route::get('users/export_user', ['as'=>'users.export_user','uses'=>'UserControl\UserController@export_user']);
            Route::resource('users','UserControl\UserController');
            Route::resource('roles','UserControl\RoleController');
            Route::resource('permissions','UserControl\PermissionController');
        });
		
		Route::resource('sap_users','Sap\SapUserController')->except('destroy');
        Route::put('sap_users/{id}/delete','Sap\SapUserController@delete')->name('sap_users.delete');

        Route::resource('sap_bpo','Sap\SapBPOController');
        Route::put('sap_bpo/{id}/delete','Sap\SapBPOController@delete')->name('sap_bpo.delete');

        Route::resource('sap_fico','Sap\SapFICOHeadController');

        Route::resource('sap_it','Sap\SapITController');
        Route::put('sap_it/{id}/delete', 'Sap\SapITController@delete')->name('sap_it.delete');

        Route::resource('sap_pro_manag','Sap\SapProjectManagerController');

        Route::group(['prefix' => 'asset'], function () {
            Route::resource('type','Asset\MasterTypeController');
        });
   });
	Route::group(['prefix'=>'general','middleware' => ['role:Admin|User Supervisor|User Staff']],function(){
            Route::resource('phonebook', 'PhoneBook\PhonebookController')->except('destroy');
            Route::post('phonebook/deleted/{id}', 'PhoneBook\PhonebookController@softdeleted');
			Route::get('phonebook/getdata/json','PhoneBook\PhonebookController@GetDataTable')->name('phonebook.getdata');
    });
	 
	 /*  -----   -----   Delivery Note   -----   -----   */
    Route::group(['prefix'=>'delivery', 'middleware'=>['role:Admin|Admin Delivery|Security Senior Staff|Security Staff|User Staff|User Supervisor']],function(){
        Route::get('index', 'Delivery\DeliveryController@index')->name('DN.index');
        Route::get('create', 'Delivery\DeliveryController@create')->name('DN.Create');
        Route::post('store', 'Delivery\DeliveryController@store')->name('DN.Store');
        Route::get('edit/{id}', 'Delivery\DeliveryController@edit')->name('DN.Edit');
        Route::post('update/{id}', 'Delivery\DeliveryController@update')->name('DN.Update');
        Route::get('preview/{id}', 'Delivery\DeliveryController@preview')->name('DN.Preview');        
        Route::get('print/{id}', 'Delivery\DeliveryController@print')->name('DN.Print');			
        
        Route::post('confirm/print/{id}','Delivery\DeliveryController@confirm_print')->name('DN.Confirm');
        Route::get('export', 'Delivery\DeliveryController@export_excel')->name('DN.Export');
		
		/* ---	---	 ---	New Request From FI 	---	---	---
				---	---	---	Remarks with Invoice	---	---	--- */
		Route::post('remark/invoice/{id}', 'Delivery\DeliveryController@remarks_invoice')->name('DN.remarks');

    });
	
	 /*  --- --- --- dwiki add new fitur on 08/01/2021   --- --- --- */
    Route::group(['prefix'=>'hris', 'middleware'=>['role:Admin|Admin Hris|User Manager|User Supervisor|User Staff|Security Senior Staff|Security Staff']], function(){
        Route::get('dashbord', 'Hris\DashboardController@index')->name('hris.dashboard');
        
        Route::get('mealallowance/index', 'Hris\UangMakanController@index')->name('MealAllowance.index');
        Route::get('mealallowance/create', 'Hris\UangMakanController@create')->name('MealAllowance.create');
        Route::post('mealallowance/store', 'Hris\UangMakanController@store')->name('MealAllowance.store');
        Route::get('mealallowance/{id}/show', 'Hris\UangMakanController@show')->name('MealAllowance.show');
        Route::get('mealallowance/{id}/print', 'Hris\UangMakanController@print_mealallowance')->name('MealAllowance.print');
        Route::get('mealallowance/download/template', 'Hris\UangMakanController@download_template')->name('MealAllowance.download');
        Route::get('mealallowance/sendemail/{id}', 'Hris\UangMakanController@send_email')->name('MealAllowance.pushemail');
        Route::delete('mealallowance/{id}/delete', 'Hris\UangMakanController@delete')->name('MealAllowance.delete');

    });

});

//Route::get('/home', 'HomeController@index')->name('home');
