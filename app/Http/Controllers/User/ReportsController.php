<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Category;
use App\Models\Wilaya;
use App\Models\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class ReportsController extends Controller
{
    public function getData(){
        return [Reports::with(['category', 'wilaya'])->get()];
    }
    public function index()
    {
        return view('app');
    }

    public function store(Request $request){
        $attributes = request()->validate([
            'title' => 'required|max:255',
            'category' => 'required|integer',
            'wilaya' => 'required|integer',
            'address' => 'required|string',
            'body' => 'required',
            'image' => 'file',
            'video' => 'file'
          ]);
          if(request('image')){

            $attributes['image'] = request('image')->store('covers');
          } else {
            $attributes['image'] = null;
        }
          
        $report = Reports::create([
            'user_id' => auth()->id(),
            'title' => $attributes['title'],
            'body' => $attributes['body'],
            'address' => $attributes['address'],
            'image' => $attributes['image'],
            'status' => 0
        ]);
  
        
           
  
        $report->category()->attach($attributes['category']);
        $report->wilaya()->attach($attributes['wilaya']);
        return auth()->user()->reports;
        }
}
