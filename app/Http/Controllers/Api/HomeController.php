<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Resturant;
use App\Models\Item;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numbers = [
            'users'      => User::count(),
            'resturants' => Resturant::where('status', 1)->count(),
            'items'      => Item::count(),
            'orders'     => Order::count()
        ];
        $data = [
            'numbers' => $numbers
        ];
        return $this->successResponse('home', $data);
    }
}
