<?php
 
namespace App\Http\Controllers;
 
use App\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redis;
 
class CarController extends Controller{

	public function createCar(Request $request){
 
    	$car = Car::create($request->all());
 
    	return response()->json($car);
 
	}
 
	public function updateCar(Request $request, $id){

    	$car  = Car::find($id);
    	$car->make = $request->input('make');
    	$car->model = $request->input('model');
    	$car->year = $request->input('year');
    	$car->save();
 
    	return response()->json($car);
	}  

	public function deleteCar($id){
    	$car  = Car::find($id);
    	$car->delete();
 
    	return response()->json('Removed successfully.');
	}

	public function index(){
        $ObjRedis = new Redis();
        echo typeOf($ObjRedis);
        var_dump($ObjRedis);
        echo $ObjRedis->connect();
    	$cars  = Car::all();
 
    	return response()->json($cars);
 
	}
}
?>
