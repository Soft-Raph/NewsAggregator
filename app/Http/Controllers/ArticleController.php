<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\FetchArticlesResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $validate = [
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'date' => 'nullable|date',
        ];

        $validator = Validator::make($request->all(), $validate);

        if ($validator->fails()) {
            return ResponseHelper::error(
                422,
                $validator->messages()->first()
            );
        }
        $query = Article::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('date')) {
            $query->whereDate('published_at', $request->date);
        }

        return ResponseHelper::success(FetchArticlesResource::collection($query->paginate(10)), 'Article fetched successfully');
    }
}
