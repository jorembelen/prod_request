<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use App\ProductCategory;
use App\ProductCatalog;
use App\ProductOrder;
use Hash;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getUsers() {
        return User::with('role')->get();
    }

    public function addUser(Request $request) {
        $try = User::where('email', $request->email)->first();

        if(!$try) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->role == 3 || $request->role == 6) {
                $user->email_verified_at = Carbon::now()->toDateTimeString();
            }
            $user->password = Hash::make('password');
            $user->save();

            $urole = new UserRole;
            $urole->user_id = $user->id;
            $urole->role_id = $request->role;
            $urole->save();

            return 'Success';
        } else {
            return 'Email already exist. Try new email.';
        }
    }

    public function updateUser(Request $request) {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $urole = UserRole::where('user_id', $request->id)->first();
        $urole->role_id = $request->role;
        $urole->save();

        return 'Success';
    }

    public function removeUser(Request $request) {
        $user = User::find($request->id);
        $user->delete();

        $urole = UserRole::where('user_id', $request->id)->delete();

        return 'Success';
    }

    public function getCategories() {
        return ProductCategory::all();
    }

    public function addCategory(Request $request) {
        $category = new ProductCategory;
        $category->name = $request->category;
        $category->save();

        return 'Success';
    }

    public function updateCategory(Request $request) {
        $category = ProductCategory::find($request->id);
        $category->name = $request->category;
        $category->save();

        return 'Success';
    }

    public function removeCategory(Request $request) {
        $category = ProductCategory::find($request->id);
        $category->delete();

        return 'Success';
    }

    public function getCatalogs() {
        return ProductCatalog::with('category')->get();
    }

    public function addCatalog(Request $request) {

        $catalog = ProductCatalog::create([
            'pgd_sku' => $request['pgdsku'],
            'name' => $request['name'],
            'category_id' => $request['category_id'],
            'description' => $request['description'],
        ]);

        if($catalog) {
            if($request->hasFile('images')){
                
                foreach ($request->file('images') as $photo) {
                    $filename = $photo->store('/public/catalogs/'.$catalog->id.'');
                    $productImage = ProductCatalog::where('id', $catalog->id)->first();
                    $productImage->image = $filename;
                    $productImage->update();
                }

            } else {
               return 'Add product failed!';
            }
        }

        return 'Success';
    }

    public function updateCatalog(Request $request) {
        $catalog = ProductCatalog::find($request->id);
        $catalog->name = $request->category;
        $catalog->save();

        return 'Success';
    }

    public function removeCatalog(Request $request) {
        $catalog = ProductCatalog::find($request->id);
        $catalog->delete();

        return 'Success';
    }


    public function getProducts() {
        return ProductOrder::with('catalog')->get();
    }

    public function addProduct(Request $request) {

        $catalog = ProductOrder::create([
            'pgd_sku' => $request['pgdsku'],
            'name' => $request['name'],
            'category_id' => $request['category_id'],
            'description' => $request['description'],
        ]);

        if($catalog) {
            if($request->hasFile('images')){
                
                foreach ($request->file('images') as $photo) {
                    $filename = $photo->store('/public/catalogs/'.$catalog->id.'');
                    $productImage = ProductOrder::where('id', $catalog->id)->first();
                    $productImage->image = $filename;
                    $productImage->update();
                }

            } else {
               return 'Add product failed!';
            }
        }

        return 'Success';
    }

    public function updateProduct(Request $request) {
        $catalog = ProductOrder::find($request->id);
        $catalog->name = $request->category;
        $catalog->save();

        return 'Success';
    }

    public function removeProduct(Request $request) {
        $catalog = ProductOrder::find($request->id);
        $catalog->delete();

        return 'Success';
    }
}
