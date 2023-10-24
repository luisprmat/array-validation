<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::with('users')->get();

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        DB::transaction(function () use ($request) {
            $team = Team::create($request->validated());

            $playersArray = [];
            foreach ($request->input('players') as $player) {
                $playersArray[$player['id']] = ['position' => $player['position']];
            }
            $team->users()->attach($playersArray);
        });

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
        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTeamRequest $request, Team $team)
    {
        DB::transaction(function () use ($team, $request) {
            $team->update($request->validated());

            $playersArray = [];
            foreach ($request->input('players') as $player) {
                $playersArray[$player['id']] = ['position' => $player['position']];
            }
            $team->users()->sync($playersArray);
        });

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
