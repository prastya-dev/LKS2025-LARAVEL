<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Scores;
use App\Models\Game_versions;
use App\Http\Resources\GamesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAll(Request $req)
    {
        $page = (int) $req->query('page', 0);
        $size = max((int) $req->query('size', 10),1);
        $shortBy = in_array($req->query('sortBy'),['title', 'popular', 'uploaddate']) ? $req->query('sortBy') : 'title';
        $shortDir = $req->query('sortDir') === 'desc' ? 'desc' : 'asc';
        $games = Games::has('version');

        if ($shortBy === 'uploaddate') {
            $shortBy = 'created_at';
        }else if($shortBy === 'title'){
            $games->orderByRaw("CAST(SUBSTRING_INDEX(title, ' ',-1) AS UNSIGNED) {$shortDir}");
        }else if ($shortBy === 'popular') {
            $games = $games->withCount('score as user_count') // Menghitung jumlah user yang memberi nilai
                           ->orderBy('user_count', $shortDir); // Mengurutkan berdasarkan jumlah user_count
        }
        $game = $games->paginate($size);




        return response()->json([
            "page" =>$game->currentPage(),
            'size' => $game->perPage(),
            "totalElement" => $game->total(),
            "content" => GamesResource::collection($game->items()),
        ],200);
    }


    public function get($slug){
        $game = Games::where('slug', $slug)->first();
        return new GamesResource($game);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $req->validate([
            'title' => "required|unique:games,title|max:50|min:4",
            'description' => "required|max:5000" 
        ]);

        $slug = Str::slug($req->title);

        $game = Games::create([
            'title' => $req->title,
            'description' => $req->description,
            'slug' => $slug,
            'created_by' => $req->user()->id,
        ]);
        return response()->json(["message" => "success upload game","content" => new GamesResource($game)],200);
        
    }
    public function getScore($slug){
        $game = Games::where('slug', $slug)->first();
        if(!$game){return response()->json(["messages" => "game Not Found"],404);}
    
      $version = Game_versions::where('game_id', $game->id)->pluck('id');
      $score = Scores::whereIn('game_version_id', $version)->orderBy('score', 'desc')->get();
      $resp = $score->map(function($item){
        return [
        "score" => $item->score,
        "user" => $item->user->username
        ];
      });
      return response()->json([
      $resp
    ],200);
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Games $games)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Games $games)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Games $games)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Games $games)
    {
        //
    }
}
