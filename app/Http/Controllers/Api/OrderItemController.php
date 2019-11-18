<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\ItemSize;
use Carbon\Carbon;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderItem $OrderItem)
    {
        return $this->successResponse('orders', $OrderItem->with('item')->where('user_id', auth()->id())->where('order_id', request()->order)->latest()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, OrderItem $OrderItem)
    {
        $data = $this->validate($request, [
            'item_id'           => 'required|integer',
            'size_id'           => 'required|integer',
            'qty'               => 'required|integer',
            'order_id'          => 'required|integer',
        ]);
        $size = ItemSize::findOrFail($data['size_id']);
        $data['size_name'] = $size->name;
        $data['item_price'] = $size->item_price;
        unset($data['size_id']);
        $data['user_id'] = auth()->id();
        $item = $OrderItem->create($data);
        return $this->successResponse('orders', $item);
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

    public function getItems(Request $request)
    {
        $order = Order::findOrFail($request->order);
        $items = Item::where('resturant_id', @$order->resturant->id)->with('sizes')->get();
        return $this->successResponse('items', $items);
    }

    public function getTotal(Request $request)
    {
        $order = Order::findOrFail($request->order);
        $orderItems = OrderItem::where('order_id', $order->id)->groupBy('user_id')->selectRaw('count(*) as total, user_id')->get()->count();
        $items = OrderItem::where('user_id', auth()->id())->where('order_id', $order->id)->get();
        if(!$items){
            return $this->successResponse('items', 0);
        }
        $total = 0;
        foreach($items as $item){
            $total += ($item->item_price * $item->qty);
        }
        $total += ($order->delivery_price / $orderItems);
        return $this->successResponse('items', $total);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        if($orderItem->user_id != auth()->id()){
            return;
        }
        $orderItem->delete();
        return $this->successResponse('orders', [], 'order Deleted successfully');
    }
}
