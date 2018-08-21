<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show')->name('frontend');
Route::post('/clone/{projectID}', 'Project\CloneProject')->name('clone');
Route::post('/projects/{projectID}/toggleClonable', 'Project\ToggleClonable')->name('toggle-clonable');
Route::get('/templates', 'Template\ViewTemplates')->name('tenant.template.index');
Route::post('/templates', 'Project\GetClonableTemplates')->name('clonable-templates');
Route::get('/templates/{projectID}', 'Project\ShowTemplate')->name('show-template');
Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'HomeController@show')->name('dashboard');
      Route::post('/clients/create', 'Project\CreateProject')->name('tenant.projects.create');
      Route::post('/clients/{projectID}/edit', 'Project\EditProject')->name('tenant.projects.edit');
      Route::post('/clients/{projectID}/delete', 'Project\DeleteProject')->name('tenant.projects.delete');
      Route::get('/clients/{projectID}', 'Project\ShowProject')->name('tenant.projects.view');
      
      Route::post('/clients/{projectID}/campaigns/create', 'Campaign\CreateCampaign')->name('tenant.campaigns.create');
      Route::post('/campaigns/{campaign}/edit', 'Campaign\EditCampaign')->name('tenant.campaigns.edit');
      Route::post('/campaigns/{campaign}/reorder', 'Campaign\ReOrderCampaign')->name('tenant.campaigns.reorder');
      Route::post('/campaigns/{campaign}/delete', 'Campaign\DeleteCampaign')->name('tenant.campaigns.delete');
      Route::post('/clients/{projectID}/progress', 'Project\CampaignsProgress')->name('tenant.projects.progress');
      
      Route::get('/jobs/{task}', 'Task\ShowTask')->name('tenant.tasks.view');
      Route::post('/campaigns/{campaign}/jobs/create', 'Task\CreateTask')->name('tenant.tasks.create');
      Route::put('/jobs/{task}/edit', 'Task\EditTask')->name('tenant.tasks.edit');
      Route::put('/jobs/{task}/edit/description', 'Task\EditDescription')->name('tenant.tasks.edit.description');
      Route::delete('/jobs/{task}/delete', 'Task\DeleteTask')->name('tenant.tasks.delete');

      Route::get('/jobs/{task}/tasks', 'Subtask\ShowSubtask')->name('tenant.subtasks.index');
      Route::get('/tasks/{subtask}', 'Subtask\ViewSubtask')->name('tenants.subtask.show');
      Route::post('/jobs/{task}/tasks/add','Subtask\CreateSubtask')->name('tenant.subtasks.create');
      Route::put('/ratings/{subtask}','Subtask\UpdateRatings')->name('tenant.subtasks.ratings');
      Route::put('/jobs/{task}/tasks/{subtask}/toggle', 'Subtask\ToggleSubtask')->name('tenant.subtasks.toggle');
      Route::delete('/jobs/{task}/tasks/{subtask}/delete', 'Subtask\DeleteSubtask')->name('tenant.subtasks.delete');
      Route::put('/jobs/{task}/tasks/{subtask}/edit', 'Subtask\EditSubtask')->name('tenant.subtasks.edit');
      Route::put('/tasks/{subtask}/update', 'Subtask\UpdateSubtask')->name('tenant.subtasks.update');
      Route::get('/jobs/{task}/comments', 'Comment\ShowComment')->name('tenant.comments.show');
      Route::post('/jobs/{task}/comments/add/{comment?}','Comment\AddComment')->name('tenant.comments.add');
      Route::put('/jobs/{task}/comments/edit/{comment}', 'Comment\EditComment')->name('tenant.comments.edit');
      Route::delete('/jobs/{task}/comments/delete/{comment}', 'Comment\DeleteComment')->name('tenant.comments.delete');
  });

  Route::group(['prefix' => '/users'], function () {
      Route::get('/teammates', 'User\ShowEmployee')->name('tenant.employees.index');
      Route::post('/teammates', 'User\AddEmployee')->name('tenant.employees.add');
      Route::put('/teammates/{employee}/edit', 'User\EditEmployee')->name('tenant.employees.edit');
      Route::delete('/teammates/{employee}/delete', 'User\DeleteEmployee')->name('tenant.employees.edit');
      Route::delete('/teammates/{employee}/clients/{projectID}/subtasks/{subtask}/detach', 'User\UnassignedSubtask')->name('tenant.employees.unassigned_subtask');
      Route::delete('/teammates/{employee}/clients/{projectID}/detach', 'User\RemoveAllSubtasks')->name('tenant.employees.remove_all_subtasks');

      Route::get('/clients', 'User\ShowClient')->name('tenant.clients.index');
      Route::post('/clients', 'User\AddClient')->name('tenant.clients.add');
      Route::put('/clients/{client}/edit', 'User\EditClient')->name('tenant.clients.edit');
      Route::delete('/clients/{client}/delete', 'User\DeleteClient')->name('tenant.clients.delete');
      
      Route::get('/', 'User\ShowTenant')->name('tenant.manage.index');
      Route::post('/add', 'User\AddTenant')->name('tenant.manage.add');
      Route::put('/downgrade/{user}', 'User\DowngradeTenant')->name('tenant.manage.downgrade');
      Route::put('/upgrade/{user}', 'User\UpgradeTenant')->name('tenant.manage.upgrade');
      Route::delete('/delete/{user}', 'User\DeleteTenant')->name('tenant.manage.delete');
    });
Route::get('/files', 'File\Index')->name('tenant.files.index');
Route::post('/files/upload/{projectID}', 'File\UploadController@multiple_upload')->name('tenant.file.uploader');
Route::put('/files/edit/{fileID}', 'File\EditFile')->name('tenant.file.edit');
Route::delete('/files/delete/{fileID}', 'File\DeleteFile')->name('tenant.file.delete');
Route::get('/files/show/{projectID}', 'File\ShowProjectFiles')->name('tenant.files.show');
Route::get('/jobs/{task}/employee/{employee}/subtasks', 'Subtask\EmployeeTask')->name('task_employee_subtasks');
Route::get('/jobs/{task}/employee/{employee}/unassignsubtask/{subtask}', 'Subtask\EmployeeUnassignSubtask')->name('task_employee_unassign_subtasks');
Route::post('/jobs/{task}/employee/{employee}/unassignsubtask/all', 'Subtask\EmployeeUnassignAllSubtask')->name('task_employee_unassign_subtasks_all');
Route::post('/files/upload/jobs/{task}', 'File\TaskImageUploader@upload')->name('tenant.file.task');