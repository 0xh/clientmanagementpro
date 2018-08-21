<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use App\EligibilityChecker;
use Carbon\Carbon;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Client Management Pro',
        'product' => 'Client Management Pro',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'admin@clientmanagement.pro';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'admin@clientmanagement.pro'
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::useStripe()->noCardUpFront()->trialDays(10);
        Spark::afterLoginRedirectTo('/dashboard');
        Spark::freePlan()
        ->features([
            '3 Client Only'
        ]);
        Spark::plan('VIP', 'spark_test_2')
            ->price(30)
            ->features([
                'Unlimited Clients', 'Unlimited Campaigns', 'Unlimited Jobs', 'Unlimited Tasks', 'Unlimited File Storage'
            ]);
        Spark::collectBillingAddress();
        // Spark::checkPlanEligibilityUsing('EligibilityChecker@handle');
        Spark::createUsersWith(function ($request) {
            $user = Spark::user();
        
            $data = $request->all();
        
            $user->forceFill([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'last_read_announcements_at' => Carbon::now(),
                'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
            ])->save();
        
            return $user;
        });
    }
}
