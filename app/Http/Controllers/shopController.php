<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class shopController extends Controller
{
    public function index(Request $request , $categorySlug = null , $subCategorySlug = null){
        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];
       
        $categories = Category::orderBy('name','ASC')->with('sub_category')->where('status',1)->get();
        $brands = Brand::orderBy('name','ASC')->where('status',1)->get();
        $products = Product::where('status',1);

        // apply filters here

        if (!empty($categorySlug)){
            $category = Category::where('slug',$categorySlug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;
        }

        if (!empty($subCategorySlug)){
            $subCategory = SubCategory::where('slug',$subCategorySlug)->first();
            $products = $products->where('sub_category_id',$subCategory->id);
            $subCategorySelected = $subCategory->id;
        }

        if (!empty($request->get('brand'))){
            $brandsArray = explode(',',$request->get('brand'));
            $products = $products->whereIn('brand_id',$brandsArray);
        }

        if ($request->get('price_max') != '' && $request->get('price_min') != ''){
            if ($request->get('price_max') == 2000){
                $products = $products->whereBetween('price',[intval($request->get('price_min')),2000]);
            }

            $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);

        }

        if(!empty($request->get('search'))){
            $products = $products->where('title','like','%'.$request->get('search').'%');

        }

        if ($request->get('sort') != ''){
            if ($request->get('sort') == 'latest'){
                $products = $products->orderBy('id','DESC');
            } elseif($request->get('sort') == 'price_asc'){
                $products = $products->orderBy('price','ASC');
            } else{
                $products = $products->orderBy('price','DESC');
            }
        } else{
            $products = $products->orderBy('id','DESC');
        }
        $products = $products->paginate(6);
        
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['priceMax'] = (intval($request->get('price_max')) == 0) ? 2000 : $request->get('price_max');
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');
        
        

        return view('front.shop', $data);
    }

    public function product($slug){
        // echo $slug;
        $product = Product::where('slug',$slug)
                   ->withCount('product_ratings')
                   ->withSum('product_ratings','rating')
                   ->with(['product_images','product_ratings'])->first();

        if ($product == null){
           abort(404);
        }

        // dd($product)

        $relatedProducts = [];
        // Fetch related products
        if($product->related_products != '') {
            $productArray = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->where('status',1)->get();
        }
         
        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;

        // Rating Calculation

        // "product_ratings_count" => 2
        // "product_ratings_sum_rating" => 8.0

        $avgRating = '0.00'; 
        $avgRatingPer = 0; 
        if($product->product_ratings_count > 0){
            $avgRating = number_format(($product->product_ratings_sum_rating/$product->product_ratings_count),2);
            $avgRatingPer = ($avgRating*100)/5;
        }

        $data['avgRating'] = $avgRating;
        $data['avgRatingPer'] = $avgRatingPer;


        return view('front.product',$data);
    }

    public function saveRating(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email',
            'comment' => 'required|min:10',
            'rating' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $count = ProductRating::where('email',$request->email)->where('product_id', $id)->count();
        if ($count > 0){
            session()->flash('error','You already rated this product');

            return response()->json([
                'status' => true,
            ]);
        }
        $productRating = new ProductRating;
        $productRating->product_id = $id;
        $productRating->username = $request->name;
        $productRating->email = $request->email;
        $productRating->comment = $request->comment;
        $productRating->rating = $request->rating;
        $productRating->status = 0;
        $productRating->save();

        session()->flash('success','Thanks for your rating.');

        return response()->json([
            'status' => true,
            'message' => 'Thanks for your rating.'
        ]);
    }
}
