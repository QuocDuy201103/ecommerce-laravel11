<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);


        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateBrandThumbnailsImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been added succesfuly!');
    }
    // public function brand_store(Request $request)
    // {
    //     // Sửa quy tắc xác thực
    //     $request->validate([
    //         'name' => 'required',
    //         'image' => 'image|mimes:png,jpg,jpeg|max:2048',
    //     ]);

    //     $brand = new Brand();
    //     $brand->name = $request->name;
    //     $brand->slug = Str::slug($request->name);

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $file_extension = $image->extension();
    //         $file_name = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file_extension;

    //         if ($this->GenerateBrandThumbnailsImage($image, $file_name)) {
    //             $brand->image = $file_name;
    //         } else {
    //             // Xử lý lỗi khi lưu hình ảnh
    //             return redirect()->back()->with('error', 'Failed to upload brand image.');
    //         }
    //     }
    //     $brand->save();
    //     return redirect()->route('admin.brands')->with('status', 'Brand has been added successfully');
    // }

    public function GenerateBrandThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path(('uploads/brands'));
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constrain) {
            $constrain->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
    
    

    // public function GenerateBrandThumbnailsImage($image, $imageName)
    // {
    //     try {
    //         $destinationPath = public_path('uploads/brands');

    //         if (!File::exists($destinationPath)) {
    //             File::makeDirectory($destinationPath, 0755, true);
    //         }
    //         $img = Image::make($image->getRealPath());
    //         $img->fit(124, 124, function ($constraint) {
    //             $constraint->upsize();
    //         }, 'center');
    //         $img->save($destinationPath . '/' . $imageName);

    //         return true;
    //     } catch (\Exception $e) {
    //         \Log::error('Error generating brand thumbnail: ' . $e->getMessage());
    //         return false;
    //     }
    // }
}
