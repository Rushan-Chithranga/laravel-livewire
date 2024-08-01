<?php

namespace App\Handlers;

use App\Mail\CategoryEmail;
use App\Models\Category as ModelsCategory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryHandler
{
    public static function categorySearch($search)
    {
        return ModelsCategory::query()
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(8);

    }
    public static function createCategory($name, $description,$photo)
    {
        $diskName = env('FILESYSTEM_DISK');

        if ($photo) {
            $image = Storage::disk($diskName)->put('upload',$photo);
        }

        $data = [
            'name' => $name,
            'description' => $description,
            'image' => $image
        ];

        Mail::to(auth()->user()->email)->send(new CategoryEmail([
            'name' => auth()->user()->name,
            'catrgoryName' => $name,
            'description' => $description,
            'image' => $image
        ]));
        ModelsCategory::create($data);
        Session::flash('success', 'Category Created Successfully!!');
    }

    public static function updateCategory($id, $name, $description,$photo)
    {
        $diskName = env('FILESYSTEM_DISK');

        if ($photo) {
            $image = Storage::disk($diskName)->put('upload',$photo);
        }

        $category = ModelsCategory::findOrFail($id);

        $category->fill([
            'name' => $name,
            'description' => $description,
            'image' => $image
        ])->save();

        Session::flash('success', 'Category Updated Successfully!!');
    }

    public static function deleteCategory($id)
    {
        $diskName = env('FILESYSTEM_DISK');

        $category = ModelsCategory::findOrFail($id);

        if ($category->image) {
            $fullImagePath = env('APP_URL')."/storage/".$category->image;
            // dd($fullImagePath);
            Storage::disk($diskName)->delete($fullImagePath);
        }

        $category->delete();
        Session::flash('success', 'Category Deleted Successfully!!');
        return redirect(request()->header('Referer'));

    }
}
