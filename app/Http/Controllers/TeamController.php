<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $positions = [
            'Goalkeeper' => 'Goalkeeper',
            'Defender' => 'Defender',
            'Midfielder' => 'Midfielder',
            'Forward' => 'Forward',
            'Coach' => 'Coach',
            'Assistant Coach' => 'Assistant Coach',
            'Physiotherapist' => 'Physiotherapist',
            'Doctor' => 'Doctor',
            'Manager' => 'Manager',
            'President' => 'President',
        ];

        return view('teams.create', compact('users', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $team = Team::create(['name' => $request->input('name')]);

        $team->users()->sync(
            collect($request->input('players'))
                ->mapWithKeys(function ($item) {
                    return [$item['id'] => ['position' => $item['position']]];
                })
        );

        return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $users = User::pluck('name', 'id');
        $team->load(['users']);
        $positions = [
            'Goalkeeper' => 'Goalkeeper',
            'Defender' => 'Defender',
            'Midfielder' => 'Midfielder',
            'Forward' => 'Forward',
            'Coach' => 'Coach',
            'Assistant Coach' => 'Assistant Coach',
            'Physiotherapist' => 'Physiotherapist',
            'Doctor' => 'Doctor',
            'Manager' => 'Manager',
            'President' => 'President',
        ];

        return view('teams.edit', compact('team', 'users', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTeamRequest $request, Team $team)
    {
        $team->update(['name' => $request->input('name')]);

        $team->users()->sync(
            collect($request->input('players'))
                ->mapWithKeys(function ($item) {
                    return [$item['id'] => ['position' => $item['position']]];
                })
        );

        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->users()->sync([]);
        $team->delete();

        return redirect()->route('teams.index');
    }
}
