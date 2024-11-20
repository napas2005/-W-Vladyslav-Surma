@foreach ($tasks as $task)
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="w-4 p-4">
            <div class="flex items-center">
                <input id="checkbox-task-{{ $task->id }}" type="checkbox" data-task_id="{{ $task->id }}"
                    class="w-4 h-4 task-checkbox text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    {{ $task->is_completed ? 'checked' : '' }}>
                <label for="checkbox-task-{{ $task->id }}" class="sr-only">checkbox</label>
            </div>
        </td>
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ Str::limit($task->title, 15, '...') }}
        </th>
        <td class="px-6 py-4" style="background:{{ $task->priority->color }};">
            {{ $task->priority->title }}
        </td>
        <td class="px-6 py-4">
            {{ Str::limit($task->description, 25, '...') }}
        </td>
        <td class="px-6 py-4">
            {{ $task->due_date }}
        </td>
        <td class="px-6 py-4">
            <a href="{{ route('task.edit', ['slug' => $task->slug]) }}"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </td>
    </tr>
@endforeach
