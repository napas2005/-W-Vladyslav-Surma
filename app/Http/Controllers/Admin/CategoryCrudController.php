<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('категорію', 'категорії');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'title',
            'label' => 'Назва',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->whereTranslationLike('title', '%' . $searchTerm . '%');
            }
        ]);

        CRUD::addColumn([
            'name' => 'active',
            'label' => 'Видимість',
            'type' => 'editable-checkbox',
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);
        // $this->crud->setValidation(CategoryRequest::class);

        foreach (get_locales() as $locale) {

            CRUD::addField([
                'name' => 'title:' . $locale,
                'label' => 'Назва',
                'tab' => $locale,
            ]);

            CRUD::addField([
                'name' => 'slug:' . $locale,
                'attribute' => 'slug:' . $locale,
                'label' => 'SEF URL',
                'tab' => $locale,
            ]);

            CRUD::addField([
                'name' => 'description:' . $locale,
                'type' => 'summernote',
                'label' => 'Опис',
                'tab' => $locale,
            ]);
        }

        CRUD::addField([
            'name' => 'active',
            'label' => 'Видимість',
            'type' => 'checkbox',
            'tab' => 'Основне',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
