<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Package;
use Illuminate\Http\Request;

class DishController extends Controller
{

    // Dish Methods
    public function dishList() {
        $dishes = Dish::all();

        return response()->json(['data' => $dishes], 200);
    }

    public function viewDish(Request $request, $id) {
        $dish = Dish::find($id);
    
        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }
    
        return response()->json(['data' => $dish], 200);
    }
    

    // Package Methods
    public function packageList() {
        $packages = Package::all();

        return response()->json(['data' => $packages], 200);
    }

    public function viewPackage(Request $request, $id) {
        $package = Package::find($id);
    
        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }
    
        return response()->json(['data' => $package], 200);
    }
}
