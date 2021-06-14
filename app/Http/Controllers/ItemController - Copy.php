<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{

    public function itemView()
    {
    	$panddingItem = Item::where('status',0)->orderBy('order')->get();
    	$completeItem = Item::where('status',1)->orderBy('order')->get();

    	return view('dragAndDroppable',compact('panddingItem','completeItem'));
    }

    public function updateItems(Request $request)
    {
    	$input = $request->all();

    	foreach ($input['panddingArr'] as $key => $value) {
    		$key = $key+1;
    		Item::where('id',$value)->update(['status'=>0,'order'=>$key]);
    	}

    	foreach ($input['completeArr'] as $key => $value) {
    		$key = $key+1;
    		Item::where('id',$value)->update(['status'=>1,'order'=>$key]);
    	}

    	return response()->json(['status'=>'success']);
    }

}