<?php

use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB as DB;
use Faker\Factory as Faker;
use App\User;
use App\Employee;
use App\Project;
use App\Campaign;
use App\Task;
use App\Subtask;
use App\Client;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $faker = Faker::create();
    factory(User::class, 2)->create()->each(function ($user) {
         $user->employees()->saveMany(factory(Employee::class, 2)->create(['tenant_id' => $user->id]));
         $user->clients()->saveMany(factory(Client::class,2)->create(['tenant_id' => $user->id]));
     });
    $tenants = User::all()->pluck('id')->toArray();
    $employees = Employee::all()->pluck('id')->toArray();
    $clients = Client::all()->pluck('id')->toArray();

    foreach($employees as $employee)
    {
        $employee = Employee::find($employee);
        $employee->projects()->saveMany(factory(Project::class,2)->create(['tenant_id'=> $faker->randomElement($tenants),'client_id' => $faker->randomElement($clients)]));
    }
    $projects = Project::all()->pluck('id')->toArray();
    foreach($projects as $project)
    {
        $project = Project::find($project);
        $project->campaigns()->saveMany(factory(Campaign::class, 2)->create());
    }
    $campaigns = Campaign::all()->pluck('id')->toArray();
    foreach($campaigns as $campaign)
    {
         $campaign = Campaign::find($campaign);
         $campaign->tasks()->saveMany(factory(Task::class, 2)->create());
    }
    $tasks = Task::all()->pluck('id')->toArray();
    foreach($tasks as $task)
    {
        $task = Task::find($task);
        $task->subtasks()->saveMany(factory(Subtask::class,2)->create(['task_id'=> $task->id]));
    }
    $subtasks = Subtask::all()->pluck('id')->toArray();
    foreach($subtasks as $subtask)
    {
        $subtask = Subtask::find($subtask);
        $subtask->employees()->sync([$faker->randomElement($employees) => ['project_id'=> $faker->randomElement($projects)]]);
    }
     
    }
}
