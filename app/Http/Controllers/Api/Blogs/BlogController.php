<?php

namespace App\Http\Controllers\Api\Blogs;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Blogs\BlogsResource;
use App\Http\Resources\Admin\Blogs\BlogsWebResource;
use App\Repositories\Blogs\BlogsRepositoryInterface;

class BlogController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected BlogsRepositoryInterface $blogsRepo) {}

    public function index()
    {
        $blogs = $this->blogsRepo->getLatesByCount(1);
        return $this->successResponse(
            BlogsWebResource::collection($blogs),
            "Latest blogs retrieved successfully."
        );
    }

     public function all()
    {
        $blogs = $this->blogsRepo->all();
        return $this->successResponse(
            BlogsWebResource::collection($blogs),
            "Latest blogs retrieved successfully."
        );
    }

   public function show($id)
{
    $blog = $this->blogsRepo->find($id);

    if (!$blog) {
        return $this->errorResponse("Blog not found", 404);
    }

    return $this->successResponse(
        new BlogsWebResource($blog),
        "Blog retrieved successfully."
    );
}
}
