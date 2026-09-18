<?php

namespace App\Http\Controllers\Facilitator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Facilitator;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $facilitator = Facilitator::with([
            'facilitatorStudents' => function ($query) {
                $query->whereDate('start_date', '<=', Carbon::today())
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                            ->orWhereDate('end_date', '>=', Carbon::today());
                    })
                    ->with('student');
            }
        ])
            ->where('user_id', $user->id)
            ->firstOrFail();

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
