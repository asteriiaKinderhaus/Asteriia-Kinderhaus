<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\http\Requests\Admin\MealRequest;
use App\Helpers\GenerateId;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meals = Meal::orderBy('order_no')->get();

        return view('admin.meal.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.meal.create');
    }

    public function store(MealRequest $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'order_no' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        Meal::create([
            'id' => GenerateId::make(Meal::class, 'MEA'),
            'name' => $request->name,
            'order_no' => $request->order_no,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.meals.index')
            ->with('success', 'Meal successfully added.');
    }
}
