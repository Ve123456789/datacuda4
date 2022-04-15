<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;
use Auth;
use App\Models\User;

class SubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function create()
    {
    	$user = User::where('id', Auth::user()->id)->first();
    	//Cancel subscription after paid period ends
    	$user->subscription('main')->cancel();
    	//Cancel subscription direct
    	//$user->subscription('main')->cancelNow();
		if ($user->subscription('main')->cancelled()) {
		    //if the user was once an active subscriber, but has cancelled their subscription
		    $user_plan =  'was once a member';
		}
    	if ($user->subscribed('main')) {
			if ($user->subscription('main')->onTrial()) {
                $user_plan = 'on trial';
			}
			if ($user->subscribedToPlan('2', 'main')) {
                $user_plan = 'You have monthly plan';
			}
			if ($user->subscription('main')->onGracePeriod()) {
                $user_plan = 'On grace period';
			}
		} else {
			$user->newSubscription('main', '2')->create();
            $user_plan = 'New User Plan Created';
		}

        return response()->json(['status' => 200,'message'=> 'Success','user_plans' => $user_plan]);


    }


    public function myCards() {
    	$user = User::where('id', Auth::user()->id)->first();
    	$cards = $user->cards();

    	foreach ($cards as $id => $card) {
    		$user_cards[] =  $card->brand.' '.$card->exp_month.' '.$card->exp_year.' '.$card->last4;
    	}

        return response()->json(['status' => 200,'message'=> 'Success','user_cards' => $user_cards]);
    }

    public function storeCard(Request $request) {
    	$user = User::where('id', Auth::user()->id)->first();
        $stripeCardToken = $this->createStripeCardToken($request);
        
        if ($stripeCardToken == false) {
            return response()->json(['status' => 204,'message'=> 'Invalid Card Details']);
        }
    	$user->updateCard($stripeCardToken->id);
        return response()->json(['status' => 200,'message'=> 'Card successfully added']);
    }

    protected function createStripeCardToken($request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $eCard = null;

        try {
            // Create Stripe CardToken
            $stripeCardToken = $stripeCardToken = \Stripe\Token::create(array(
                "card" => array(
                    "number" => $request->number,
                    "exp_month" => $request->exp_month,
                    "exp_year" => $request->exp_year,
                    "cvc" => $request->cvc,
                )
            ));

        } catch (\Stripe\Error\RateLimit $eCard) {
            $message = 'Too many requests made to the API too quickly';
        } catch (\Stripe\Error\InvalidRequest $eCard) {
            $message = 'Too many requests made to the API too quickly';
        } catch (\Stripe\Error\Authentication $eCard) {
            $message = 'Authentication with Stripe\'s API failed';
        } catch (\Stripe\Error\ApiConnection $eCard) {
            $message = 'Network communication with Stripe failed';
        } catch (\Stripe\Error\Base $eCard) {
            $message = 'Payplan Not created';
        } catch (Exception $eCard) {
            $message = 'Please contact the support team';
        }

        if ($eCard) {
            return false;
        } else {
            return $stripeCardToken;
        }
    }    

    public function getCurrentSubscriptionPlan (Request $request) {
        $plan = $request->user()->subscriptions()->latest()->select(['plan_id', 'created_at', 'amount', 'expire_at', 'status'])->with(['plan' => function ($plan) {
            return $plan->select(['id', 'name']);
        }])->first();

        return response()->json(['status' => 200, 'message'=> 'Subscription information found', 'data' => $plan]);
    }

    public function cancelSubscription (Request $request) {
        $userData = Auth::user();
        $plan = $request->user()->subscriptions()->where('status', true)->where('user_id',$userData->id)->latest()->first();

        if (!$plan) {
            return response()->json(['status' => 208, 'message'=> 'You have already cancelled your subscription plan.', 'data' => []]);
        }

        $plan->update(['status' => false]);
        return response()->json(['status' => 200, 'message'=> 'Subscription plan has been cancelled.', 'data' => []]);
    }
}
