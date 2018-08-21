<?php
  // Profile Routes
  Route::get('/profile', 'Profile')->name('employee.profile');
  Route::put('/profile', 'UpdateProfile')->name('employee.profile.update');
  Route::put('/profile/upload', 'UploadAvatar')->name('employee.profile.upload');
  Route::get('/password', 'Password')->name('employee.password');
  Route::put('/password', 'ChangePassword')->name('employee.password.change');
  // Authentication Routes
  Route::get('/login', 'Auth\LoginController@showLoginForm')->name('employee.login');
  Route::post('/login', 'Auth\LoginController@login')->name('employee.login.submit');
  Route::get('/logout', 'Auth\LoginController@logout')->name('employee.logout');
  // Password reset Routes
  Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('employee.password.email');
  Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('employee.password.request');
  Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('employee.password.new_password');
  Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('employee.password.reset');
  // Admin Dashboard Route

  Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'DashboardController@index')->name('employee.dashboard');
      Route::post('/clients/create', 'Project\CreateProject')->name('employee.projects.create');
      Route::get('/clients/{projectID}', 'Project\ShowProject')->name('employee.projects.view');
      Route::post('/clients/{projectID}/progress', 'Project\CampaignsProgress')->name('employee.projects.progress');
      
      Route::get('/jobs/{task}', 'Task\ShowTask')->name('employee.tasks.view');
      Route::get('/tasks/{subtask}', 'Subtask\ViewSubtask')->name('employee.subtask.show');
      Route::get('/jobs/{task}/tasks', 'Subtask\ShowSubtask')->name('employee.subtasks.index');
      Route::put('/jobs/{task}/tasks/{subtask}/toggle', 'Subtask\ToggleSubtask')->name('employee.subtasks.toggle');

      Route::get('/jobs/{task}/comments', 'Comment\ShowComment')->name('employee.comments.show');
      Route::post('/jobs/{task}/comments/add/{comment?}','Comment\AddComment')->name('employee.comments.add');
      Route::put('/jobs/{task}/comments/edit/{comment}', 'Comment\EditComment')->name('employee.comments.edit');
      Route::delete('/jobs/{task}/comments/delete/{comment}', 'Comment\DeleteComment')->name('employee.comments.delete');
  });

Route::get('/files/show/{projectID}', 'File\ShowProjectFiles')->name('employee.files.show');



