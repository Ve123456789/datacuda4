<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\View\Factory;
use App\Services\PlanService as Service;
use Illuminate\Routing\Redirector;

use App\Http\Requests\PlanRequestPost;
use App\Http\Requests\PlanRequestGet;
use App\Http\Requests\PlanRequestPut;

class PlanController extends Controller
{

    private $service;

    public function __construct (Service $service) {
        $this->service = $service;
    }

    public function index (Request $request, Factory $view) {
        return $view->make('admin/subscription-plans/index', ['list' => $this->service->paginate($request)]);
    }

    public function create (Request $request, Factory $view) {
        return $view->make('admin/subscription-plans/create', ['plans' => $this->service->pluck()]);
    }

    public function store (PlanRequestPost $request, Redirector $redirector) {
        $this->service->create($request);
        return $redirector->to('admin/subscription-plans')->with('success', 'Subscription Plan Successfully created!');
    }

    public function view (PlanRequestGet $request, Factory $view) {
        return $view->make('admin/subscription-plans/view', ['data' => $this->service->get($request), 'plans' => $this->service->pluck()]);
    }

    public function update (PlanRequestPut $request, Redirector $redirector) {
        $this->service->update($request);
        return $redirector->to('admin/subscription-plans')->with('success', 'Subscription Plan Successfully updated!');
    }

    public function getActive (Request $request) {
        return $this->service->getActive($request);
    }
}
