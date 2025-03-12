<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameWinnerRequest;
use App\Models\Game;

class GameWinnerController extends Controller
{
    public function edit(Game $game)
    {
        $game->load(['users']);

        $places = [];

        for ($i = 1; $i <= $game->users()->count(); $i++) {
            $places[$i] = __('Place :position', ['position' => $i]);
        }

        return view('games.winners', compact('game', 'places'));
    }

    public function update(StoreGameWinnerRequest $request, Game $game)
    {
        $game->load(['users']);

        foreach ($game->users as $user) {
            $game->users()->updateExistingPivot($user->id, [
                'place' => $request->input('players.'.$user->id),
            ]);
        }

        return redirect()->route('games.index');
    }
}
