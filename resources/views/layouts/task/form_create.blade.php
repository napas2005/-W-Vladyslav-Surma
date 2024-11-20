@extends('common.home')

@section('content')
    <form class="max-w-sm mx-auto" method="POST"
        action="{{ route('task.store', ['slug' => $category_slug]) }}">
        @csrf

        {{-- Поле "Заголовок" --}}
        <div class="mb-5">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('task/form.title') }}
            </label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                class="bg-gray-50 border @error('title') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="{{ __('task/form.title_placeholder') }}">

            @error('title')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                    <span class="font-medium">{{ __('task/form.error') }}</span> {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Поле "Опис" --}}
        <div class="mb-5">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('task/form.description') }}
            </label>
            <textarea id="description" name="description" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border @error('description') border-red-500 @else border-gray-300 @enderror focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="{{ __('task/form.description_placeholder') }}">{{ old('description') }}</textarea>

            @error('description')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                    <span class="font-medium">{{ __('task/form.error') }}</span> {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Поле "Пріоритет" --}}
        <div class="mb-5">
            <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('task/form.priority') }}
            </label>
            <select id="priority" name="priority_id"
                class="bg-gray-50 border @error('priority_id') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach ($priority as $p)
                    <option value="{{ $p->id }}" {{ old('priority_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->title }}
                    </option>
                @endforeach
            </select>

            @error('priority_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                    <span class="font-medium">{{ __('task/form.error') }}</span> {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Поле "Дата завершення" --}}
        <div class="relative max-w-sm">
            <label for="datepicker-autohide" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('task/form.date_due') }}
            </label>
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 mt-6 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
            </div>
            <input id="datepicker-autohide" datepicker datepicker-autohide datepicker-format="dd-mm-yyyy" type="text" name="due_date"
                value="{{ old('due_date') }}"
                class="bg-gray-50 border @error('due_date') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="{{ __('task/form.date_due_placeholder') }}">

            @error('due_date')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ __('task/form.error') }} {{ $message }}</p>
            @enderror
        </div>

        {{-- Кнопка --}}
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                {{ __('task/form.button') }}
            </button>
        </div>
    </form>
@endsection
