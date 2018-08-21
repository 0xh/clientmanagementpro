<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Methods\NormalizerMethod;
use App\Traits\Methods\CampaignProgressMethod;

trait CampaignBuilder {

    use NormalizerMethod ,CampaignProgressMethod;
}