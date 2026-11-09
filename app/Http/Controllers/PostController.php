<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => ['nullable', 'string', 'max:255'], 'category' => ['nullable', 'string', 'max:100']]);
        $posts = Post::query()
            ->where('is_published', true)
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->input('q').'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->input('category')))
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->orderByDesc('id')
            ->paginate(7)
            ->withQueryString();
        $categories = Post::query()->distinct()->orderBy('category')->pluck('category');

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        abort_unless($post->is_published, 404);
        $post->views += 1;
        $post->save();

        return view('posts.show', compact('post'));
    }
}
