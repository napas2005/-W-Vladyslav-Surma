{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="lar la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Categories" icon="las la-stream" :link="backpack_url('category')" />
<x-backpack::menu-item title="Priorities" icon="las la-list-ol" :link="backpack_url('priority')" />
<x-backpack::menu-item title="Tasks" icon="las la-tasks" :link="backpack_url('task')" />
<x-backpack::menu-item title="Task financials" icon="las la-coins" :link="backpack_url('task-financial')" />
