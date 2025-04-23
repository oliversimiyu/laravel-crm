<div wire:poll="{{ $pollingInterval }}ms" class="py-8">
    {{-- Success is as dangerous as failure. --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Tasks</h1>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Create Task
            </a>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                    <input type="text" wire:model.debounce.300ms="search" id="search" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Search tasks...">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                    <select wire:model="status" id="status" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="not_started">Not Started</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-300 mb-1">Priority</label>
                    <select wire:model="priority" id="priority" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-300 mb-1">Due Date</label>
                    <select wire:model="due_date" id="due_date" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="tomorrow">Tomorrow</option>
                        <option value="this_week">This Week</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Related To
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Due Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Priority
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $task->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                @if($task->taskable)
                                    @if($task->taskable_type == 'App\\Models\\Customer')
                                        <span class="text-blue-400">Customer:</span> {{ $task->taskable->first_name }} {{ $task->taskable->last_name }}
                                    @elseif($task->taskable_type == 'App\\Models\\Invoice')
                                        <span class="text-green-400">Invoice:</span> {{ $task->taskable->invoice_number }}
                                    @elseif($task->taskable_type == 'App\\Models\\Quote')
                                        <span class="text-yellow-400">Quote:</span> {{ $task->taskable->quote_number }}
                                    @else
                                        {{ class_basename($task->taskable_type) }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($task->priority == 'low') bg-blue-600 text-blue-100
                                    @elseif($task->priority == 'medium') bg-yellow-600 text-yellow-100
                                    @elseif($task->priority == 'high') bg-red-600 text-red-100
                                    @endif">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($task->status == 'not_started') bg-gray-600 text-gray-100
                                    @elseif($task->status == 'in_progress') bg-blue-600 text-blue-100
                                    @elseif($task->status == 'completed') bg-green-600 text-green-100
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-blue-400 hover:text-blue-300">View</a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                No tasks found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="px-6 py-4 bg-gray-800">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
