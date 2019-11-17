<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Decision;
use App\Models\Order;
use Carbon\Carbon;
class DecisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Decision $decisions)
    {
        return $this->successResponse('decisions', $decisions->with('resturant')->whereDate('created_at', Carbon::today())->latest()->paginate(15));
    }


    public function makeDecision(Request $request)
    {
        $this->validate($request, [
            'resturants'      => 'required|array'
        ]);
        foreach($request->resturants as $resturant){
            Decision::create(['resturant_id' => $resturant]);
        }
        return $this->successResponse('decisions', []);
    }

    public function isDecisionMade(Decision $decisions)
    {
        $decision = $decisions->whereDate('created_at', Carbon::today())->count();
        return $this->successResponse('decisions', ['made' => $decision]);
    }

    public function makeOrder()
    {
        $orders = Order::whereDate('created_at', Carbon::today())->count();
        if(!$orders){
            $decisions = Decision::with('resturant')->whereDate('created_at', Carbon::today())->get();
            if($decisions){
                foreach($decisions as $decision){
                    $delv = @$decision->resturant->delivery_price ? @$decision->resturant->delivery_price : 1;
                    Order::create(['decision_id' => $decision->id, 'delivery_price' => $delv]);
                    $decision->update(['status' => 1]);
                }
            }
        }
        return $this->successResponse('decisions', []);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Decision $decisions)
    {
        $decisions->delete();
        return $this->successResponse('decisions', [], 'Decision Deleted Successfully');
    }
}
