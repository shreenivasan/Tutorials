<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Faqs;
use Illuminate\Support\Facades\DB;
class FaqController extends Controller
{
   public function index()
   {
        $faqs = DB::table('ts_faqs')->paginate(20);
        return view('faqs.index',compact('faqs'));
   }
   
   public function create()
   {
      //
   }
   
   public function store()
   {
      //
   }

   public function show($id)
   {
      //
   }

   public function edit($id)
   {
      //
   }

   public function update($id)
   {
      //
   }
   public function destroy($id)
   {
      //
   }
}
