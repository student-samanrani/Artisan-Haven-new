<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductImageController extends Controller
{
    public function update(Request $request){

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;
        $productImage->image  = $imageName;
        $productImage->save();

          //large image
          $destPath = public_path().'/uploads/product/large/'.$imageName;
          $manager = new ImageManager(new Driver());
          $image = $manager->read($sourcePath);
          $image = $image->scaleDown(1400);
          $image->save($destPath); 

          //small image
          $destPath = public_path().'/uploads/product/small/'.$imageName;
          $manager = new ImageManager(new Driver());
          $image = $manager->read($sourcePath);
          $image = $image->cover(300, 300);
          $image->save($destPath); 

          return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'ImagePath' => asset('uploads/product/small/'.$productImage->image),
            'message' => 'Image Saved successfully'
        ]);

    }
    public function destroy(Request $request){
        $productImage = ProductImage::find($request->id);

        if(empty($productImage)){
            return response()->json([
                'status' => false,
                'message' => 'Image No Found'
            ]);
        }
        // delete images from folder
        File::delete(public_path().'/uploads/product/large/'.$productImage->image);
        File::delete(public_path().'/uploads/product/small/'.$productImage->image);
        
        $productImage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully '
        ]);
     }
}
