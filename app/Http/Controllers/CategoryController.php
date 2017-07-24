<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Response;
use File;

class CategoryController extends Controller {
	
	public function imageUpload() {
		return view('image-upload');
	}


    public function getAllCategory() {
    	//retrieve all categories from datbase
    	$categories = Category::all();
        foreach($categories as $category) 
            $category->name = ucwords($category->name);
    	
    	return Response::json(array(
    		'categories'=>$categories->toArray()),
    		200
    	);
    }

    public function getCategory(Request $request, $id) {
        //retrieve categoy based on id from database
    	$category = Category::find($id);

    	return Response::json(array(
    		'error'=>false,
    		'category'=>$category),
    		200
    	);
    }

    public function addCategory(Request $request) {
        //add new category to database
        $category = new Category();
        //add image to folder images
        $fileImage = $request->category_image;
        $imageName = time().'_'.$fileImage->getClientOriginalName();
        $fileImage->move(public_path('images/categories'), $imageName);
        //add category to database
        $category->name = strtolower($request->category_name);
        $category->category_img = $imageName;
        $category->save();

        return Response::json(array(
            'error'=>false,
            'message'=>"Kategori berhasil ditambahkan"),
            200
        );
    }

    public function updateCategory(Request $request, $id) {
        //update category based on id in database
        $category = Category::find($id);
        $oldImage = $category->category_img;
        //check image update or not
        $isChangeImage = $request->isChangeImage;
        if($isChangeImage) {
            //delete old image
            $pathFile = public_path('images/categories/') . $oldImage;
            File::delete($pathFile);
            //add image to folder images
            $fileImage = $request->category_image;
            $imageName = time().'_'.$fileImage->getClientOriginalName();        
            $fileImage->move(public_path('images/categories'), $imageName);
        } else {
            $imageName = $oldImage;
        }
        //add category to database
		$category->name = strtolower($request->category_name);
		$category->category_img = $imageName;
		$category->save();

		return Response::json(array(
    		'error'=>false,
    		'message'=>"Kategori berhasil diubah"),
    		200
    	);
	}

    public function deleteCategory($id) {
        //delete data of category from database
        $category = Category::find($id);
        $oldImage = $category->category_img;
        //delete image
        $pathFile = public_path('images/categories/') . $oldImage;
        File::delete($pathFile);
        $category->delete();

        return Response::json(array(
            'error'=>false,
            'message'=>"Kategori berhasil dihapus"),
            200
        );
    }
}
