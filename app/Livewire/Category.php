<?php

namespace App\Livewire;

use App\Handlers\CategoryHandler;
use App\Models\Category as ModelsCategory;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination, WithFileUploads;

    protected $categoryHandler;

    public function mount()
    {
        $this->categoryHandler = new CategoryHandler();
    }

    public $name, $description, $category_id;
    public $updateCategories, $updateName, $updateDescription, $updateCategory_id;
    public $updateCategory = false;
    public $createCategory = false;
    public $deleteCategory = false;
    public $deleteCategories;
    public $deleteCategoryName;
    public $search;
    public $photo;
    public $updatePhoto;



    protected $listeners = [
        'deleteCategory' => 'categoryDelete',
        'cancel'
    ];

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
    ];



    public function openCreateModal()
    {
        $this->createCategory = true;
    }

    public function openUpdateModal($id)
    {
        $updateCategories = ModelsCategory::findOrFail($id);
        $this->updateName = $updateCategories->name;
        $this->updateDescription = $updateCategories->description;
        $this->updatePhoto = $updateCategories->image ?? null;
        $this->updateCategory_id = $updateCategories->id  ;
        $this->updateCategory = true;
    }

    public function openDeleteModal($id)
    {
        $this->deleteCategories = ModelsCategory::findOrFail($id);
        $this->deleteCategoryName = $this->deleteCategories->name;
        $this->deleteCategory = true;
    }

    public function categotyModalClose()
    {
        $this->createCategory = false;
    }

    public function updateyModalClose()
    {
        $this->updateCategory = false;
    }

    public function deleteModalClose()
    {
        $this->deleteCategory = false;
    }

    public static $layout = 'layouts.app';

    public function render()
    {
        if (!$this->categoryHandler) {
            $this->categoryHandler = new CategoryHandler();
        }
        if ($this->search && !$this->categoryHandler->categorySearch($this->search)) {
            $categories = [];
        } else {
            $categories = $this->categoryHandler->categorySearch($this->search);
        }
        // dump($categories);
        return view('livewire.category', ['categories' => $categories]);
    }

    public function searchCategory(){

        if (!$this->categoryHandler) {
            $this->categoryHandler = new CategoryHandler();
        }
        try {
            $this->categoryHandler->categorySearch($this->search);
        } catch (\Exception $e) {
            Session::flash('error', 'Something goes wrong while search category!!');
        }


    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->photo = '';
    }

    public function create()
    {
        $this->validate();

        if (!$this->categoryHandler) {
            $this->categoryHandler = new CategoryHandler();
        }

        try {
            $this->categoryHandler->createCategory($this->name, $this->description, $this->photo);
            $this->resetFields();
            $this->categotyModalClose();
        } catch (\Exception $e) {
            Session::flash('error', 'Something goes wrong while creating category!!');
            $this->resetFields();
            $this->categotyModalClose();
        }
    }

    public function categoryUpdate()
    {
        $this->validate([
            'updateName' => 'required',
            'updateDescription' => 'required',
            'updatePhoto' => 'required',
        ]);

        if (!$this->categoryHandler) {
            $this->categoryHandler = new CategoryHandler();
        }

        try {
            $this->categoryHandler->updateCategory($this->updateCategory_id, $this->updateName, $this->updateDescription, $this->updatePhoto);
            $this->updateyModalClose();
        } catch (\Exception $e) {
            Session::flash('error', 'Something goes wrong while updating category!!');
            $this->updateyModalClose();
        }
    }

    public function categoryDelete()
    {
        try {
            if (!$this->categoryHandler) {
                $this->categoryHandler = new CategoryHandler();
            }

            $this->categoryHandler->deleteCategory($this->deleteCategories->id);
            $this->deleteModalClose();
        } catch (\Exception $e) {
            Session::flash('error', 'Something goes wrong while deleting category!!');
            $this->deleteModalClose();
        }
    }
}
