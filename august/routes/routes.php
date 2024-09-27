<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

App::setLocale('vi');

Route::middleware(['web'])->group(function () {
    Route::get('/august/login', 'Package\August\Http\Controllers\AblockAuthController@login')->name('login');
    Route::post('/august/login-store', 'Package\August\Http\Controllers\AblockAuthController@store')->name('august.auth.store');
    
    Route::middleware(['auth'])->group(function () {
        $namespace = 'Package\August\Http\Controllers';
        Route::namespace($namespace)->group(function() {
            // Route::get('/tasks', 'TaskController@index');

            // ablock
            Route::get('/august/ablock', 'AblockController@index')->name('august.ablock.index');

            Route::post('/august/ablock/get-fields', 'AblockController@getFields')->name('august.ablock.getfields');

            Route::get('/august/ablock/0', 'AblockController@add')->name('august.ablock.add');
            Route::get('/august/ablock/{field_id}', 'AblockController@edit')->name('august.ablock.edit');
            Route::get('/august/ablock/coppy/{field_id}', 'AblockController@coppy')->name('august.ablock.coppy');
            Route::post('/august/ablock/store', 'AblockController@store')->name('august.ablock.store');
            Route::get('/august/ablock/delete/{field_id}', 'AblockController@delete')->name('august.ablock.delete');
            Route::get('/august/convert-to-ablock', 'AblockController@listTableDB')->name('august.ablock.list-table-db');
            Route::get('/august/convert-to-ablock/{table_name}', 'AblockController@convertToAblock')->name('august.ablock.convert-to-ablock');

            // user field
            Route::get('/august/ablock/{id_block}/field', 'AblockUserFieldController@index')->name('august.userfield.index');
            Route::get('/august/ablock/{id_block}/field/0', 'AblockUserFieldController@add')->name('august.userfield.add');
            Route::get('/august/ablock/{id_block}/field/{id_userfield}', 'AblockUserFieldController@edit')->name('august.userfield.edit');
            Route::get('/august/ablock/{id_block}/field/{id_userfield}/copy', 'AblockUserFieldController@copy')->name('august.userfield.copy');
            Route::post('/august/ablock/{id_block}/field/store', 'AblockUserFieldController@store')->name('august.userfield.store');
            Route::get('/august/ablock/{id_block}/field/{id_userfield}/delete', 'AblockUserFieldController@delete')->name('august.userfield.delete');

            // user field type
            Route::get('/august/ablock/field/type/0','AblockUserFieldTypeController@add')->name('august.userfieldtype.add');
            Route::get('/august/ablock/field/type','AblockUserFieldTypeController@index')->name('august.userfieldtype.index');
            Route::post('/august/ablock/field/type/store','AblockUserFieldTypeController@store')->name('august.userfieldtype.store');
            Route::get('/august/ablock/field/type/{id_fieldtype}','AblockUserFieldTypeController@edit')->name('august.userfieldtype.edit');
            Route::get('/august/ablock/field/type/{id_fieldtype}/copy','AblockUserFieldTypeController@copy')->name('august.userfieldtype.copy');
            Route::get('/august/ablock/field/type/{id_fieldtype}/delete','AblockUserFieldTypeController@delete')->name('august.userfieldtype.delete');

            // elements
            Route::post('/august/lists/store', 'ListsController@store')->name('august.lists.store');
            Route::post('/august/lists/view-mode', 'ListsController@viewMode')->name('august.lists.view_mode');
            
            Route::any('/august/lists/{id_block}', 'ListsController@index')->name('august.lists.index');

            Route::any('/august/lists/{id_block}/import-excel', 'ListsController@importExcel')->name('august.lists.importexcel');
            Route::any('/august/lists/{id_block}/export-excel', 'ListsController@exportExcel')->name('august.lists.exportexcel');

            Route::get('/august/lists/{id_block}/element/0', 'ListsController@add')->name('august.lists.add');
            Route::post('august/lists/get/element', 'ListsController@getElementsLinkTo')->name('august.lists.get.elementlinkto');
            Route::get('/august/lists/{id_block}/element/{id_element}', 'ListsController@edit')->name('august.lists.edit');
            Route::get('/august/lists/{id_block}/element/{id_element}/copy', 'ListsController@copy')->name('august.lists.copy');
            Route::get('/august/lists/{id_block}/element/{id_element}/preview', 'ListsController@preview')->name('august.lists.preview');
            
            Route::get('/august/lists/{id_block}/element/{id_element}/delete', 'ListsController@delete')->name('august.lists.delete');

            // menu
            Route::get('/august/menu', 'AblockMenuController@index')->name('august.menu.index');
            Route::get('/august/menu/0', 'AblockMenuController@add')->name('august.menu.add');
            Route::get('/august/menu/{id_menu}', 'AblockMenuController@edit')->name('august.menu.edit');
            Route::get('/august/menu/{id_menu}/copy', 'AblockMenuController@copy')->name('august.menu.copy');
            Route::post('/august/menu/store', 'AblockMenuController@store')->name('august.menu.store');
            Route::get('/august/menu/{id_menu}/delete', 'AblockMenuController@delete')->name('august.menu.delete');

            // menu group
            Route::get('/august/menugroup/0', 'AblockMenuController@addMenuGroup')->name('august.menugroup.add');
            Route::post('/august/menugroup/store', 'AblockMenuController@storeMenuGroup')->name('august.menugroup.store');


            // Lang
            Route::get('/august/lang', 'AExtendblockLangController@index')->name('august.lang.index');
            Route::get('/august/lang/0', 'AExtendblockLangController@add')->name('august.lang.add');
            Route::get('/august/lang/{id_lang}', 'AExtendblockLangController@edit')->name('august.lang.edit');
            Route::get('/august/lang/{id_lang}/copy', 'AExtendblockLangController@copy')->name('august.lang.copy');
            Route::post('/august/lang/store', 'AExtendblockLangController@store')->name('august.lang.store');
            Route::get('/august/lang/{id_lang}/delete', 'AExtendblockLangController@delete')->name('august.lang.delete');

            //Users
            Route::post('/august/users/search', 'AExtendblockUserController@searchUsers')->name('august.search.users');

            Route::middleware(['checkUserRole'])->group(function() {
                Route::any('/august/users', 'AExtendblockUserController@index')->name('august.users.index');
                Route::get('/august/users/0', 'AExtendblockUserController@add')->name('august.users.add');
                Route::get('/august/users/{id_user}', 'AExtendblockUserController@edit')->name('august.users.edit');
                Route::get('/august/users/{id_user}/preview', 'AExtendblockUserController@preview')->name('august.users.preview');
                Route::get('/august/users/{id_user}/copy', 'AExtendblockUserController@copy')->name('august.users.copy');
                Route::post('/august/users/store', 'AExtendblockUserController@store')->name('august.users.store');
                Route::get('/august/users/{id_user}/delete', 'AExtendblockUserController@delete')->name('august.users.delete');
            });

            //User Role
            Route::any('/august/user-role', 'AExtendblockUserRoleController@index')->name('august.user.role.index');
            Route::get('/august/user-role/0', 'AExtendblockUserRoleController@add')->name('august.user.role.add');
            Route::get('/august/user-role/{id_role}', 'AExtendblockUserRoleController@edit')->name('august.user.role.edit');
            Route::get('/august/user-role/{id_role}/copy', 'AExtendblockUserRoleController@copy')->name('august.user.role.copy');
            Route::post('/august/user-role/store', 'AExtendblockUserRoleController@store')->name('august.user.role.store');
            Route::get('/august/user-role/{id_role}/delete', 'AExtendblockUserRoleController@delete')->name('august.user.role.delete');

            //File
            Route::any('/august/file', 'AExtendblockFileController@index')->name('august.file.index');
            Route::get('/august/file/0', 'AExtendblockFileController@add')->name('august.file.add');
            Route::get('/august/file/{id_file}', 'AExtendblockFileController@edit')->name('august.file.edit');
            Route::post('/august/file/store', 'AExtendblockFileController@store')->name('august.file.store');
            Route::get('/august/file/{id_file}/delete', 'AExtendblockFileController@delete')->name('august.file.delete');
            Route::post('/august/file/field/delete/', 'AExtendblockFileController@deleteImageField')->name('august.file.field.delete');

            // speed
            Route::get('/august/speed', 'AblockSpeedController@index')->name('august.speed.index');

            // chat
            Route::get('/august/chat', 'AblockChatController@index')->name('august.chat.index');

            // site setting
            Route::get('/august/setting', 'AblockSettingController@index')->name('august.setting.index');
            Route::post('/august/setting-store', 'AblockSettingController@store')->name('august.setting.store');
        });
    });
});
?>