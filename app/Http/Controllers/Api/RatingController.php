<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\Anime;
use App\Models\Dorama;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    /* ================ Anime ================ */
    public function addForAnime(RatingRequest $request, $id): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $anime->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['assessment' => $request->validated('assessment')]
        );

        return response()->noContent();
    }

    public function removeForAnime($id): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $anime->ratings()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->noContent();
    }

    /* ================ Dorama ================ */
    public function addForDorama(RatingRequest $request, $id): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $dorama->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['assessment' => $request->validated('assessment')]
        );

        return response()->noContent();
    }

    public function removeForDorama($id): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $dorama->ratings()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->noContent();
    }
}
