<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class TeamMembersController extends Controller
{
    public function index()
    {
        $team  = Team::where('owner_id', auth()->user()->id)->first();
        $roles = Role::get(['id', 'title']);
        $users = User::where('team_id', $team->id)->get();

        return view('admin.team-members.index', compact('team', 'users', 'roles'));
    }

    public function invite(Request $request)
    {
        $request->validate(['email' => 'email']);
        $team    = Team::where('owner_id', auth()->user()->id)->first();
        $url     = URL::signedRoute('register', ['team' => $team->id]);
        $message = new \App\Notifications\TeamMemberInvite($url);
        Notification::route('mail', $request->input('email'))->notify($message);

        return redirect()->back()->with('message', 'Invite sent.');
    }
}
