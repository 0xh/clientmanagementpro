<?php

namespace App;

use Laravel\Spark\Contracts\Interactions\CheckPlanEligibility as Contract;

class EligibilityChecker implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function handle($user, $plan)
    {
        if($plan->name === 'pro' && count($user->projects) > 3){
            return false;
        }
    }
}
