<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePlanRequest;
use App\Http\Requests\Admin\UpdatePlanRequest;
use App\Http\Resources\PlansResource;
use App\Models\Plan;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PlansController extends Controller
{

    use HttpResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plans = QueryBuilder::for(Plan::class)
            ->defaultSorts('-created_at')
            ->allowedSorts(['name_ar', 'name_en', 'price'])
            ->allowedFilters(['name_ar', 'name_en'])
            ->paginate()
            ->appends($request->query());

        return $this->respond(['plans' => PlansResource::collection($plans)->response()->getData(true)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePlanRequest $request)
    {
        $plan = Plan::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'description' => $request->description,
            'price' => $request->price
        ]);

        $plan->permissions()->attach($request->permissions);

        return $this->responseCreated(new PlansResource($plan), 'Plan Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return $this->respond(new PlansResource($plan));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'price' => $request->price
        ]);

        $plan->permissions()->sync($request->permissions);

        return $this->responseCreated(new PlansResource($plan), __('lang.create')  );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->permissions()->detach($plan->permissions->pluck('id'));
        $plan->delete();
        return $this->responseOk('Plan Deleted Successfully');
    }
}
