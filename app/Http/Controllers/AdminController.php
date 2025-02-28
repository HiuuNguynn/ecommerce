<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    // Hiển thị trang admin chính
    public function index() {
        return view('admin.index');
    }

    // Lấy danh sách thương hiệu (brands) và phân trang
    public function brands() 
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10); // Sửa 'paninate' thành 'paginate'
        return view('admin.brands', compact('brands'));
    }

    public function add_brand() 
    {
        return view('admin.brand-add');
    }


    public function brand_store(Request $request) {
        $request -> validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->GenerateBrandThumbailsImage($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand has been added succesfully!');

    }
    public function brand_edit($id) {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);
    
        $brand = Brand::find($request->id);
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found.');
        }
    
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
    
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
                File::delete(public_path('uploads/brands/' . $brand->image));
            }
    
            $image = $request->file('image');
            $file_extention = $image->getClientOriginalExtension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
    
            $this->GenerateBrandThumbailsImage($image, $file_name);
    
            $brand->image = $file_name;
        }
    
        $brand->save();
    
        return redirect()->route('admin.brands')->with('status', 'Brand has been updated successfully!');
    }
    
    public function GenerateBrandThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image-> path()); 
        $img->cover(124,124,"top");
        $img->resize(124,124,function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);

    }
}
