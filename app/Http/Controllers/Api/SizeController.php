<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItemSize;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemSize $items)
    {
        return $this->successResponse('items', $items->where('item_id', request()->it)->latest()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ItemSize $items)
    {
        $data = $this->validate($request, [
            'name'              => 'required|string|min:2|max:191',
            'item_price'        => 'required',
            'item_id'           => 'required',
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
    public function update(Request $request, ItemSize $items,$id)
    {
        $item = $items->findOrFail($id);
        $data = $this->validate($request, [
            'name'              => 'required|string|min:2|max:191',
            'item_price'        => 'required',
            'item_id'           => 'required',
        ]);
        $item->update($data);
        return $this->successResponse('items', $item);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ItemSize $items)
    {
        $item = $items->findOrFail($id);
        $item->delete();
        return $this->successResponse('items', [], 'item Deleted successfully');
    }
}
