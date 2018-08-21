<?php
  // Update Profile
  Route::get('/profile', 'Profile')->name('client.profile');
  Route::put('/profile', 'UpdateProfile')->name('client.profile.update');
  Route::put('/profile/upload', 'UploadAvatar')->name('client.profile.upload');
  Route::get('/password', 'Password')->name('client.password');
  Route::put('/password', 'ChangePassword')->name('client.password.change');
  // Authentication Routes
  Route::get('/login', 'Auth\LoginController@showLoginForm')->name('client.login');
  Route::post('/login', 'Auth\LoginController@login')->name('client.login.submit');
  Route::get('/logout', 'Auth\LoginController@logout')->name('client.logout');
  // Password reset Routes
  Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('client.password.email');
  Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('client.password.request');
  Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('client.password.new_password');
  Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('client.password.reset');
  // Admin Dashboard Route
  Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'DashboardController@index')->name('client.dashboard');
      Route::get('/clients/{projectID}', 'Project\ShowProject')->name('client.projects.view');
      Route::post('/clients/{projectID}/progress', 'Project\CampaignsProgress')->name('client.projects.progress');

      Route::get('/jobs/{task}', 'Task\ShowTask')->name('client.tasks.view');
      Route::get('/tasks/{subtask}', 'Subtask\ViewSubtask')->name('client.subtask.show');
      Route::get('/jobs/{task}/tasks', 'Subtask\ShowSubtask')->name('client.subtasks.index');

      Route::get('/jobs/{task}/comments', 'Comment\ShowComment')->name('client.comments.show');
      Route::post('/jobs/{task}/comments/add/{comment?}','Comment\AddComment')->name('client.comments.add');
      Route::put('/jobs/{task}/comments/edit/{comment}', 'Comment\EditComment')->name('client.comments.edit');
      Route::delete('/jobs/{task}/comments/delete/{comment}', 'Comment\DeleteComment')->name('client.comments.delete');
  });
Route::get('/files/show/{projectID}', 'File\ShowProjectFiles')->name('client.files.show');



