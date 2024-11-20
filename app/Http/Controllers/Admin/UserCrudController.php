<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('користувача', 'користувачі');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'name',
            'label' => "Ім'я",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->whereTranslationLike('name', '%' . $searchTerm . '%');
            }
        ]);

        CRUD::addColumn([
            'name' => 'email',
            'label'=> "Email",
            'type' => 'email',
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::addField([
            'name' => 'name',
            'label'=> "Ім'я",
            'tab'  => 'Основне'
        ]);

        CRUD::addField([
            'name' => 'email',
            'label'=> "Email",
            'type' => 'email',
            'tab'  => 'Основне'
        ]);

        CRUD::addField([
            'name'  => 'password',
            'label' => 'Пароль',
            'type'  => 'password',
            'tab'   => 'Основне'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
