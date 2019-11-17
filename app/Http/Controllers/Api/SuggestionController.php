<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Decision;
use App\Models\Suggestion;
use Carbon\Carbon;
class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Suggestion $suggestion)
    {
        $decision    = Decision::whereDate('created_at', Carbon::today())->count();
        $suggestions = [];
        if(!$decision){
            if(request()->display == 's'){
                $suggestions = $suggestion->with('resturant')->whereDate('created_at', Carbon::today())->groupBy('resturant_id')->selectRaw('count(*) as total, resturant_id')->get();
            }else{
                $suggestions = $suggestion->with('resturant')->with('user')->whereDate('created_at', Carbon::today())->latest()->paginate(15);
            }
        }
        
        return $this->successResponse('suggestions', $suggestions);
    }

    public function getTodaySuggestion(Suggestion $suggestion)
    {
        $suggestions = $suggestion->where('user_id', auth()->id())->whereDate('created_at', Carbon::today())->pluck('resturant_id');
        return $this->successResponse('suggestions', $suggestions);   
    }

    public function plusOne(Suggestion $suggestion)
    {
        $q = Suggestion::where('user_id', auth()->id())->whereDate('created_at', Carbon::today());

        if(!$q->where('resturant_id', $suggestion->resturant_id)->count()){

            if(Suggestion::where('user_id', auth()->id())->whereDate('created_at', Carbon::today())->count() >= 3){
                return $this->failResponse('suggestions', [], 'you reach the limit of suggestion.');   
            }else{
                $suggestion->user_id = auth()->id();
                $suggestion->id = null;
            }
            
        }else{
            return $this->failResponse('suggestions', [], 'you just suggested this resturant before.');
        }

        return $this->successResponse('suggestion', Suggestion::create($suggestion->toArray()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Suggestion $suggestions)
    {
        $data = $this->validate($request, [
            'notes'             => 'nullable|string|max:450',
            'resturant_id'      => 'required|integer'
        ]);
        $data['user_id'] = auth()->id();
        $q = $suggestions->where('user_id', auth()->id())->whereDate('created_at', Carbon::today());

        if(!$q->where('resturant_id', request()->resturant_id)->count()){

            if($suggestions->where('user_id', auth()->id())->whereDate('created_at', Carbon::today())->count() >= 3){
                return $this->failResponse('suggestions', [], 'you reach the limit of suggestion.');   
            }else{
                $suggestion = $suggestions->create($data);
            }
            
        }else{
            return $this->failResponse('suggestions', [], 'you just suggested this resturant before.');
        }
        
        return $this->successResponse('suggestions', $suggestion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Suggestion $suggestions)
    {
        return $this->successResponse('suggestions', $suggestions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Suggestion $suggestions)
    {
        $suggestion = $suggestions->findOrFail($id);
        if($suggestion->user_id == auth()->id()){
            $suggestion->delete();
            return $this->successResponse('items', [], 'Suggestion Deleted successfully');
        }else{
            return $this->failResponse('suggestions', [], 'you don\'t have permession to do this action.');
        }
        
    }
}
