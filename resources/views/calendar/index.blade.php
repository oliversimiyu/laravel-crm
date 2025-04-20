<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-gray-900 to-gray-800">
        <div class="w-full p-6 space-y-6">
            <!-- Calendar Header -->
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-white">Calendar & Tasks</h1>
                    <div class="flex space-x-2">
                        <button class="bg-blue-600/20 text-blue-400 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">Day</button>
                        <button class="bg-blue-600/20 text-blue-400 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">Week</button>
                        <button class="bg-blue-600/20 text-blue-400 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">Month</button>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button onclick="openTaskModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>New Task</span>
                    </button>
                    <button onclick="openAppointmentModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                        <i class="fas fa-calendar-plus"></i>
                        <span>New Appointment</span>
                    </button>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-4 mb-6">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="text-center text-gray-400 font-medium py-2">{{ $day }}</div>
                @endforeach
                @foreach($calendarDays as $date)
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-4 min-h-[120px] border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300 group">
                        <div class="text-sm text-gray-400 mb-2">{{ $date->format('j') }}</div>
                        @foreach($date->appointments as $appointment)
                            <div class="text-xs bg-blue-500/20 text-blue-400 p-1 rounded mb-1 truncate">
                                {{ $appointment->title }}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <!-- Tasks & Upcoming Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Task List -->
                <div class="lg:col-span-2 bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-tasks text-blue-400 mr-2"></i>
                            Tasks
                        </h2>
                        <div class="flex space-x-2">
                            <select class="bg-gray-700 text-gray-300 rounded-lg px-3 py-1 text-sm border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option>All Tasks</option>
                                <option>My Tasks</option>
                                <option>Assigned to Others</option>
                            </select>
                            <select class="bg-gray-700 text-gray-300 rounded-lg px-3 py-1 text-sm border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option>All Status</option>
                                <option>Pending</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @foreach($tasks as $task)
                            <div class="bg-gray-700/50 rounded-xl p-4 border border-gray-600/50 hover:border-blue-500/50 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" class="rounded bg-gray-600 border-gray-500 text-blue-500 focus:ring-blue-500">
                                        <span class="text-white">{{ $task->title }}</span>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $task->priority === 'high' ? 'bg-red-500/20 text-red-400' : ($task->priority === 'medium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <span class="text-gray-400">Due: {{ $task->due_date->format('M j, Y') }}</span>
                                        <img src="{{ $task->assigned_to->profile_photo_url }}" class="w-6 h-6 rounded-full" title="{{ $task->assigned_to->name }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-calendar text-blue-400 mr-2"></i>
                        Upcoming Events
                    </h2>
                    <div class="space-y-4">
                        @foreach($upcomingEvents as $event)
                            <div class="bg-gray-700/50 rounded-xl p-4 border border-gray-600/50 hover:border-blue-500/50 transition-all duration-300">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-500/20 rounded-lg p-2">
                                        <span class="text-blue-400 text-lg font-bold">{{ $event->start_time->format('d') }}</span>
                                        <span class="text-blue-400 text-xs block">{{ $event->start_time->format('M') }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-medium">{{ $event->title }}</h3>
                                        <p class="text-gray-400 text-sm">{{ $event->start_time->format('g:i A') }} - {{ $event->end_time->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div id="taskModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
                <h2 class="text-xl font-semibold text-white mb-4">New Task</h2>
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-400 mb-2">Title</label>
                            <input type="text" name="title" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-400 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-400 mb-2">Due Date</label>
                                <input type="date" name="due_date" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-400 mb-2">Priority</label>
                                <select name="priority" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-400 mb-2">Assign To</label>
                            <select name="assigned_to" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeTaskModal()" class="px-4 py-2 text-gray-400 hover:text-white transition-colors duration-200">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200">Create Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Appointment Modal -->
    <div id="appointmentModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
                <h2 class="text-xl font-semibold text-white mb-4">New Appointment</h2>
                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-400 mb-2">Title</label>
                            <input type="text" name="title" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-400 mb-2">Date</label>
                                <input type="date" name="date" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-400 mb-2">Time</label>
                                <input type="time" name="time" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-400 mb-2">Duration (minutes)</label>
                            <select name="duration" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="30">30 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="90">1.5 hours</option>
                                <option value="120">2 hours</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-400 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-400 mb-2">Participants</label>
                            <select name="participants[]" multiple class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeAppointmentModal()" class="px-4 py-2 text-gray-400 hover:text-white transition-colors duration-200">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200">Create Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openTaskModal() {
            document.getElementById('taskModal').classList.remove('hidden');
        }

        function closeTaskModal() {
            document.getElementById('taskModal').classList.add('hidden');
        }

        function openAppointmentModal() {
            document.getElementById('appointmentModal').classList.remove('hidden');
        }

        function closeAppointmentModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
