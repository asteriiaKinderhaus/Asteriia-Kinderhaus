<?php

namespace App\Http\Controllers\Facilitator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Facilitator;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $facilitator = Facilitator::with('schoolClasses')
            ->where('user_id', $user->id)
            ->first();

        return view(
            'facilitator.dashboard',
            compact('facilitator')
        );
    }

    public function profile()
    {
        $user = Auth::user();

        $facilitator = $user->facilitator;

        return view('facilitator.profile', compact(
            'user',
            'facilitator'
        ));
    }
}
