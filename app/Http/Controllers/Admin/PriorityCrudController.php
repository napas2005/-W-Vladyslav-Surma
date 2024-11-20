<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PriorityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PriorityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PriorityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Priority::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/priority');
        CRUD::setEntityNameStrings('Пріорітет', 'Пріорітети');
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
            'name' => 'color',
            'label' => 'Колір',
            'type' => 'color'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PriorityRequest::class);

        foreach (get_locales() as $locale) {

            CRUD::addField([
                'name' => 'title:' . $locale,
                'label' => 'Назва',
                'tab' => $locale,
            ]);
        }

        CRUD::addField([
            'name' => 'color',
            'label' => 'Колір',
            'type' => 'color',
            'tab' => 'Основне',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
