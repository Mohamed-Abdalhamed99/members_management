<?php

namespace App\Http\Controllers\CentralApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePlanRequest;
use App\Http\Requests\Admin\UpdatePlanRequest;
use App\Http\Requests\UpdatePlanFeatureRequest;
use App\Http\Resources\PlansResource;
use App\Models\Plan;
use App\Models\PlansFeature;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    use HttpResponse;

    /**
    * Display a listing of the resource.
    * @return Renderable
    */
    public function index() {
        $plans = QueryBuilder::for ( Plan::class )
        ->defaultSort( '-created_at' )
        ->allowedSorts( [ 'name' ,'annually_price' ,'monthly_price' ] )
        ->allowedFilters( [ 'name' ,'annually_price' ,'monthly_price' ] )
        ->paginate( \request()->pages ?? 25 )
        ->appends( request()->query() );

        return $this->respond( PlansResource::collection( $plans )->response()->getData( true ) );
    }

    /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Renderable
    */
    public function store( CreatePlanRequest $request ) {
        $plan = Plan::create([
            'name' => $request->name,
            'annually_price' => $request->annually_price,
            'monthly_price' => $request->monthly_price
        ]);;

        $plan_features = [];
        foreach($request->features as $feature){
            $plan_feature = new PlansFeature();
            $plan_feature->feature = $feature;
            array_push($plan_features , $plan_feature);
        }
        $plan->features()->saveMany($plan_features);
        return $this->responseOk('تم إضافة الخطة بنجاح');
    }

    /**
    * Show the specified resource.
    * @param int $id
    * @return Renderable
    */
    public function show( Plan $plan ) {
        $data = new PlansResource( $plan );
        return $this->respond( $data );
    }

    /**
    * Update the specified resource in storage.
    * @param Request $request
    * @param int $id
    * @return Renderable
    */
    public function update( UpdatePlanRequest $request,  Plan $plan ) {
        $plan->update([
            'name' => $request->name,
            'annually_price' => $request->annually_price,
            'monthly_price' => $request->monthly_price
        ]);

        // add new features if exists
        if($request->features != null){
            $plan_features = [];
            foreach($request->features as $feature){
                $plan_feature = new PlansFeature();
                $plan_feature->feature = $feature;
                array_push($plan_features , $plan_feature);
            }
            $plan->features()->saveMany($plan_features);
        }
        return $this->responseOk('تم التعديل بنجاح');
    }

    /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Renderable
    */
    public function destroy( Plan $plan ) {
        $plan->delete();
        return $this->responseOk( 'تم الحذف بنجاح' );
    }

    /**
     * delete specific plan feature
     *
     * @param PlansFeature $plan_feature
     * @return json
     */
    public function deletePlanFeature(PlansFeature $plans_feature)
    {
        $plans_feature -> delete();
        return $this->responseOk( 'تم الحذف بنجاح' );
    }

    /**
     * delete specific plan feature
     *
     * @param PlansFeature $plan_feature
     * @param UpdatePlanFeatureRequest $request
     * @return json
     */
    public function updatePlanFeature(PlansFeature $plans_feature , UpdatePlanFeatureRequest $request)
    {
        $plans_feature->update(['feature' => $request->feature]);
        return $this->responseOk('تم التعديل بنجاح');
    }
}
