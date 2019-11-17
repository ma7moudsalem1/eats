<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $orders)
    {
        return $this->successResponse('orders', $orders->whereDate('created_at', Carbon::today())->latest()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Item $items)
    {
        $data = $this->validate($request, [
            'name'              => 'required|string|min:2|max:191',
            'details'           => 'required|string|max:450',
            'resturant_id'      => 'required|integer'
        ]);
        $item = $items->create($data);
        return $this->successResponse('items', $item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $orders,$id)
    {
        $order = $orders->findOrFail($id);
        $data = $this->validate($request, [
            'delivery_price'   => 'required|string|max:450',
            'status'           => 'required|boolean'
        ]);
        $order->update($data);
        return $this->successResponse('orders', $order);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $orders)
    {
        $orders->delete();
        return $this->successResponse('orders', [], 'order Deleted successfully');
    }
}
