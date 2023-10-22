<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $positions = $this->getPositions();

        return view('teams.create', compact('users', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        DB::transaction(function () use ($request) {
            $team = Team::create($request->validated());
            $team->users()->attach(
                collect($request->input('players'))
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => ['position' => $item['position']]];
                    })
            );
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
        $users = User::pluck('name', 'id');
        $positions = $this->getPositions();

        return view('teams.edit', compact('team', 'users', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTeamRequest $request, Team $team)
    {
        DB::transaction(function () use ($team, $request) {
            $team->update($request->validated());
            $team->users()->sync(
                collect($request->input('players'))
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => ['position' => $item['position']]];
                    })
            );
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

    private function getPositions(): array
    {
        return [
            'goalkeeper' => __('positions.goalkeeper'),
            'defender' => __('positions.defender'),
            'midfielder' => __('positions.midfielder'),
            'forward' => __('positions.forward'),
            'coach' => __('positions.coach'),
            'assistant_coach' => __('positions.assistant_coach'),
            'physiotherapist' => __('positions.physiotherapist'),
            'doctor' => __('positions.doctor'),
            'manager' => __('positions.manager'),
            'president' => __('positions.president'),
        ];
    }
}
