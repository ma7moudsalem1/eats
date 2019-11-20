<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resturant;

class ResturantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Resturant $resturants)
    {
        return $this->successResponse('resturants', $resturants->latest()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resturant $resturants)
    {
        $data = $this->validate($request, [
            'name'              => 'required|string|min:2|max:191',
            'delivery_price'    => 'required|numeric',
            'details'           => 'nullable|string|max:450',
            'menu'              => 'nullable',
            'status'            => 'required|boolean'
        ]);
        $resturant = $resturants->create($data);
        return $this->successResponse('resturants', $resturant);
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
    public function update(Request $request, Resturant $resturants,$id)
    {
        $resturant = $resturants->findOrFail($id);
        $data      = $this->validate($request, [
            'name'              => 'required|string|min:2|max:191',
            'delivery_price'    => 'required|numeric',
            'details'           => 'nullable|string|max:450',
            'menu'              => 'nullable',
            'status'            => 'required|boolean'
        ]);
        $resturant->update($data);
        return $this->successResponse('resturants', $resturant);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Resturant $resturants)
    {
        $resturant = $resturants->findOrFail($id);
        $resturant->delete();
        return $this->successResponse('resturants', [], 'resturant Deleted successfully');
    }

    public function getResturants(Resturant $resturants)
    {
        $resturants = $resturants->whereStatus(1)->pluck('name', 'id');
        return $this->successResponse('resturants', $resturants);
    }
}
