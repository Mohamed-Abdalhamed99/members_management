<?php

namespace Modules\Product\Http\Controllers;

use App\Models\Course;
use App\Models\Media;
use App\Models\Product;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Transformers\CoursesResource;
use Modules\Product\Http\Requests\CreateProductsRequest;
use Modules\Product\Http\Requests\UpdateProductsRequest;
use Modules\Product\Transformers\ProductsResource;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{

    use HttpResponse;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $products = QueryBuilder::for(Product::class)
            ->defaultSort('-created_at')
            ->allowedSorts(['name', 'description', 'price', 'created_at'])
            ->allowedFilters(['name', 'description', 'price', 'created_at'])
            ->paginate(\request()->pages ?? 10)
            ->appends(request()->query());

        return $this->respond(ProductsResource::collection($products)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateProductsRequest $request)
    {
        $product = Product::create($request->validated());
        $this->storeProductFilesAndImages($request->file()['product_files'], $request->file()['product_images'], $product);
        return $this->responseCreated(new ProductsResource($product), 'تم إضافة المنتج جديد');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Product $product)
    {
        return new ProductsResource($product);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateProductsRequest $request, Product $product)
    {
        // update data
        $product->update($request->validated());

        // upload new files and images if exists
        $this->storeProductFilesAndImages(isset($request->file()['product_files']) ? $request->file()['product_files'] : [], (isset($request->file()['product_images'])) ? $request->file()['product_images'] : [], $product);

        return $this->responseCreated(new ProductsResource($product), 'تم تعديل المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->responseOk('تم حذف المنتج بنجاح');
    }

    /**
     * store product files and images
     *
     * @return void
     */
    public function storeProductFilesAndImages($product_files, $product_images, $product): void
    {
        $product_files_keys = [];
        $product_images_keys = [];

        if (count($product_files) > 0) {
            // set product_files_keys array key names : [product_files[0] , product_files[1] , ...]
            for ($i = 0; $i < count($product_files); $i++) {
                array_push($product_files_keys, "product_files[$i]");
            }

            // add product_files media
            $product->addMultipleMediaFromRequest($product_files_keys)
                ->each(function ($product) {
                    $product->toMediaCollection('product_files');
                });
        }

        if (count($product_images) > 0) {
            // set product_images_keys array key names : [product_images[0] , product_images[1] , ...]
            for ($i = 0; $i < count($product_images); $i++) {
                array_push($product_images_keys, "product_images[$i]");
            }

            // add product_images media
            $product->addMultipleMediaFromRequest($product_images_keys)
                ->each(function ($product) {
                    $product->toMediaCollection('product_images');
                });
        }
    }

    /**
     * delete media
     *
     * @return json
     */
    public function deleteProductMedia(Media $media)
    {
        // dd( $media);
        $media->delete();
        return $this->responseOk('تم حذف الملف بنجاح');
    }
}
