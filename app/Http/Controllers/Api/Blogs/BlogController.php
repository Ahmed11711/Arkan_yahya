<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Blogs\BlogsResource;
use App\Repositories\Blogs\BlogsRepositoryInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected BlogsRepositoryInterface $blogsRepo) {}

    public function index()
    {
        $blogs = $this->blogsRepo->getLatesByCount(5);
        return $this->successResponse(
            BlogsResource::collection($blogs),
            "Latest blogs retrieved successfully."
        );
    }

     public function all()
    {
        $blogs = $this->blogsRepo->all();
        return $this->successResponse(
            BlogsResource::collection($blogs),
            "Latest blogs retrieved successfully."
        );
    }
}
