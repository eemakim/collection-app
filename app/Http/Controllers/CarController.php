<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function all()
    {
        return Car::all();
    }
    public function getSingle(int $id)
    {
        return Car::find($id);
    }


}
