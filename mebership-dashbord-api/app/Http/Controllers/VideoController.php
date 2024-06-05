<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Display a listing of the videos.
     */
    public function index()
    {
        $user = Auth::user();
        // Obtener videos del usuario autenticado
        $userVideos = Video::where('user_id', $user->id);

        // Obtener videos de los grupos a los que pertenece el usuario
        $groupVideos = Video::whereHas('group', function ($query) use ($user) {
            $query->where('owner_id', $user->id)
                  ->orWhereHas('users', function ($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
        });

        // Combinar ambas consultas
        $videos = $userVideos->union($groupVideos)->get();
        
        return response()->json($videos);
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'group_id' => 'nullable|exists:groups,id',
            'is_private' => 'boolean',
        ]);

        $video = Video::create([
            'title' => $validated['title'],
            'url' => $validated['url'],
            'group_id' => $validated['group_id'] ?? null,
            'user_id' => Auth::id(),
            'is_private' => $validated['is_private'] ?? false,
        ]);

        return response()->json($video, 201);
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video)
    {
        if ($video->is_private && $video->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($video->group_id && !$video->group->users->contains(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($video);
    }

    /**
     * Update the specified video in storage.
     */
    public function update(Request $request, Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'url',
            'group_id' => 'nullable|exists:groups,id',
            'is_private' => 'boolean',
        ]);

        $video->update($validated);

        return response()->json($video);
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $video->delete();

        return response()->json(null, 204);
    }
}
