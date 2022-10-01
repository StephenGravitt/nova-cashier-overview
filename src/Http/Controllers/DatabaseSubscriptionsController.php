<?php

namespace LimeDeck\NovaCashierOverview\Http\Controllers;

use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use App\Models\Billing\Subscription as SubscriptionModel;


class DatabaseSubscriptionsController extends Controller
{
    /**
     * @param $billableId
     * @return array
     */
    public function show($billableId)
    {
        
        $subscription = SubscriptionModel::find($billableId);

        if (! $subscription) {
            return [
                'subscription' => null,
            ];
        }

        return [
            'subscription' => $this->formatSubscription($subscription),
        ];
    }

    /**
     * @param  \Laravel\Cashier\Subscription  $subscription
     * @return array
     */
    protected function formatSubscription(Subscription $subscription)
    {
        return array_merge($subscription->toArray(), [
            'plan'            => $subscription->stripe_price,
            'ended'           => $subscription->ended(),
            'canceled'        => $subscription->canceled(),
            'active'          => $subscription->active(),
            'on_trial'        => $subscription->onTrial(),
            'on_grace_period' => $subscription->onGracePeriod(),
        ]);
    }
}
