<?php

namespace App\Http\Controllers\Admin\Blogs;

use App\Repositories\Blogs\BlogsRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Blogs\BlogsStoreRequest;
use App\Http\Requests\Admin\Blogs\BlogsUpdateRequest;
use App\Http\Resources\Admin\Blogs\BlogsResource;

class BlogsController extends BaseController
{
    public function __construct(BlogsRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Blogs',
            fileFields: ['img']
        );

        $this->storeRequestClass = BlogsStoreRequest::class;
        $this->updateRequestClass = BlogsUpdateRequest::class;
        $this->resourceClass = BlogsResource::class;
    }
}
