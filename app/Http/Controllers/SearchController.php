<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Interest;

class SearchController extends Controller
{
    public function filter(Request $request, User $user)
    {
        $temp = DB::table('users')->join('usersInterests', 'users.id', '=', 'usersInterests.userid')->leftJoin('interests', 'interests.id', '=', 'usersInterests.interestid')->get();
        if ($request->sport != 'Any') {
            $filters = $temp->where('interestid', $request->sport);
            if ($request->level != 'Any') {
                $filters = $temp->where('interestid', $request->sport)
                                ->where('level', $request->level);
            }
        }

        $users = User::all();
        $interests = Interest::all();
        return view('users.show', compact('users', 'interests', 'filters'));
    }
}
