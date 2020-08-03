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

// Route to test Affectiva
//Route::view('/test-webcam', 'test-webcam')->name('webcam');

$base = env('APP_DIR') ? '/' . env('APP_DIR') : '';

Route::get('/set-language/{language}', 'LanguageController@setLanguage')
    ->name('language.set');

Route::view('/', 'landing')->name('landing');
Route::redirect('/landing', $base . '/');

Route::name('system.')
    ->middleware('auth')
    ->middleware('verified')
    ->prefix('system')
    ->group(function () use ($base) {
        Route::get('/', 'ProjectController@getDashboard')->name('home');
        Route::redirect('/home', $base . '/system');

        Route::post('/project/rename', 'ProjectController@renameProject')->name('rename-project')
            ->middleware('permissions.project:modify,project_rename_id');
        Route::post('/video/rename', 'VideoController@renameVideo')->name('rename-video')
            ->middleware('permissions.video:modify,video_rename_id');
        Route::put('/video/report/set', 'VideoController@setReport')->name('video.report.set')
            ->middleware('permissions.video:modify,video_id');
        Route::post('/project/delete', 'ProjectController@deleteProject')->name('delete-project')
            ->middleware('permissions.project:admin,project_delete_id');
        Route::post('/video/delete', 'VideoController@deleteVideo')->name('delete-video')
            ->middleware('permissions.video:remove,video_delete_id');
        Route::post('/project/move', 'ProjectController@moveProject')->name('move-project')
            ->middleware('permissions.project:admin,project_selected_id');
        Route::post('/video/move', 'VideoController@moveVideo')->name('move-video')
            ->middleware('permissions.video:admin,video_selected_id');

        Route::post('/user/check-password', 'UserController@checkUserPassword')->name('user.password.check');
        Route::view('/profile', 'profile')->name('profile');
        Route::post('/profile/edit', 'UserController@editProfile')->name('edit-profile');

        Route::prefix('/project/{id}/report')
            ->middleware('permissions.project:read')
            ->group(function () {
                Route::get('/', 'ProjectController@getProjectReport')->name('report-project');
                Route::get('/download/html', 'ReportController@downloadProjectHTML')->name('layout-file-project');

                Route::name('project.download-')
                    ->prefix('/download')
                    ->group(function () {
                        Route::get('/pdf', 'ReportController@downloadProjectPDF')->name('pdf');
                        Route::get('/json', 'ReportController@downloadProjectJSON')->name('json');
                        Route::get('/powerpoint', 'ReportController@downloadProjectPPTX')->name('pptx');
                        Route::get('/excel', 'ReportController@downloadProjectExcel')->name('excel');
                    });
            });

        Route::prefix('/video/{id}')
            ->middleware('permissions.video:read')
            ->group(function () {
                Route::get('/', 'VideoController@getVideoReport')->name('report-video');
                Route::put('/edit/duration', 'VideoController@resetInterval')->name('edit-video-duration');
                Route::get('/download/html', 'ReportController@downloadVideoHTML')->name('layout-file');

                Route::name('download-')
                    ->prefix('/download')
                    ->group(function () {
                        Route::get('/pdf', 'ReportController@downloadVideoPDF')->name('pdf');
                        Route::get('/json', 'ReportController@downloadVideoJSON')->name('json');
                        Route::get('/powerpoint', 'ReportController@downloadVideoPPTX')->name('pptx');
                        Route::get('/excel', 'ReportController@downloadVideoExcel')->name('excel');
                    });
            });

        Route::post('/video/upload', 'VideoController@uploadVideo')->name('videoUpload')
            ->middleware('permissions.project:add,project_id');
        Route::post('/video/realtime-upload', 'VideoController@realtimeUpload')->name('realtimeUpload')
            ->middleware('permissions.project:add,project_id');
        Route::post('/project/new', 'ProjectController@createProject')->name('newProject')
            ->middleware('permissions.project:add,father_id');
        Route::put('/video/report/set', 'VideoController@setReport')->name('video.report.set')
            ->middleware('permissions.video:modify,video_id');

        Route::get('/project/{id}', 'ProjectController@getProjectDetails')->name('project-details')
            ->middleware('permissions.project:read');
        Route::prefix('/project/{id}/share')
            ->name('permissions.')
            ->middleware('permissions.project:admin')
            ->group(function () {
                Route::get('/', 'PermissionsController@getProjectPermissions')
                    ->name('index');
                Route::delete('/delete/{user_id}', 'PermissionsController@deletePermission')
                    ->name('delete');

                Route::put('/add', 'PermissionsController@addPermission')
                    ->name('add');

                Route::any('/edit', 'PermissionsController@editPermission')
                    ->name('edit');
            });
    });

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('landing');
})->name('logout');

Auth::routes(['verify' => true]);

Route::redirect('/home', $base . '/system');
