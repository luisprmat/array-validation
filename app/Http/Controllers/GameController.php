<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\User;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::with(['users'])->get();

        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');

        return view('games.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameRequest $request)
    {
        $game = Game::create(['name' => $request->input('name')]);
        $game->users()->sync($request->input('players'));

        return redirect()->route('games.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $users = User::pluck('name', 'id');
        $game->load(['users']);

        return view('games.edit', compact('game', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GameRequest $request, Game $game)
    {
        $game->update(['name' => $request->input('name')]);
        $game->users()->sync($request->input('players'));

        return redirect()->route('games.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->users()->sync([]);
        $game->delete();

        return redirect()->route('games.index');
    }
}