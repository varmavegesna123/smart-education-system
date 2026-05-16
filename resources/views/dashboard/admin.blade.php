<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Administrator Portal') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-400">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                <span>System Online</span>
            </div>
        </div>
    </x-slot>

    <div x-data="{ activeTab: 'dashboard' }" class="space-y-6 pb-12">
        
        <!-- Tab Navigation -->
        <div class="flex p-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl w-fit">
            <button @click="activeTab = 'dashboard'" :class="activeTab === 'dashboard' ? 'bg-white/10 text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">Dashboard</button>
            <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-white/10 text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">Users</button>
            <button @click="activeTab = 'courses'" :class="activeTab === 'courses' ? 'bg-white/10 text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">Courses</button>
            <button @click="activeTab = 'remedial'" :class="activeTab === 'remedial' ? 'bg-white/10 text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">Remedial Tasks</button>
        </div>

        <!-- Session Messages -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        <!-- Dashboard Tab -->
        <div x-show="activeTab === 'dashboard'" class="space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="glass-card p-6 rounded-2xl flex items-center justify-between group hover:border-emerald-500/30 transition-all duration-300">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Students</p>
                        <h4 class="text-3xl font-bold text-white mt-1">{{ $stats['total_students'] }}</h4>
                    </div>
                    <div class="p-4 bg-blue-500/10 rounded-2xl text-blue-400 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-2xl flex items-center justify-between border-red-500/20 bg-red-500/5 group hover:border-red-500/50 transition-all duration-300">
                    <div>
                        <p class="text-xs font-semibold text-red-400 uppercase tracking-wider">Critical Risk</p>
                        <h4 class="text-3xl font-bold text-red-400 mt-1">{{ $stats['high_risk_students'] }}</h4>
                    </div>
                    <div class="p-4 bg-red-500/20 rounded-2xl text-red-400 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-2xl flex items-center justify-between group hover:border-emerald-500/30 transition-all duration-300">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Educators</p>
                        <h4 class="text-3xl font-bold text-white mt-1">{{ $stats['total_teachers'] }}</h4>
                    </div>
                    <div class="p-4 bg-emerald-500/10 rounded-2xl text-emerald-400 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-2xl flex items-center justify-between group hover:border-emerald-500/30 transition-all duration-300">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Courses</p>
                        <h4 class="text-3xl font-bold text-white mt-1">{{ $stats['total_classes'] }}</h4>
                    </div>
                    <div class="p-4 bg-purple-500/10 rounded-2xl text-purple-400 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Performance Chart -->
            <div class="glass-card p-8 rounded-3xl">
                <div class="flex justify-between items-center mb-8">
                    <h4 class="text-lg font-bold text-white">Institutional Growth</h4>
                    <select class="bg-white/5 border-white/10 text-gray-400 text-xs rounded-xl px-4 py-2 outline-none">
                        <option>Last 6 Months</option>
                        <option>Last Year</option>
                    </select>
                </div>
                <div class="h-[350px] w-full">
                    <canvas id="overviewChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Users Tab -->
        <div x-show="activeTab === 'users'" class="glass-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
                <h4 class="text-lg font-bold text-white">Registered Users</h4>
                <div class="flex space-x-2">
                    <input type="text" placeholder="Search users..." class="bg-white/5 border-white/10 text-white text-sm rounded-xl px-4 py-2 outline-none focus:border-emerald-500/50 w-64">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4 text-right">Join Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($users as $user)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-medium text-white">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="px-2 py-1 bg-white/5 border border-white/10 rounded-md text-[10px] uppercase font-bold text-emerald-400">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Courses Tab -->
        <div x-show="activeTab === 'courses'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Course Form -->
                <div class="glass-card p-6 rounded-3xl h-fit">
                    <h4 class="text-lg font-bold text-white mb-6">Create New Course</h4>
                    <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Course Name</label>
                            <input type="text" name="name" required class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Section</label>
                                <input type="text" name="section" required class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Teacher</label>
                                <select name="teacher_id" required class="w-full bg-[#1a1a1a] border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50"></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-emerald-500/20">Create Course</button>
                    </form>
                </div>

                <!-- Course List -->
                <div class="lg:col-span-2 glass-card rounded-3xl overflow-hidden h-fit">
                    <div class="p-6 border-b border-white/5">
                        <h4 class="text-lg font-bold text-white">Active Courses</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-300">
                            <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                                <tr>
                                    <th class="px-6 py-4">Course</th>
                                    <th class="px-6 py-4">Instructor</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($classRooms as $class)
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-white">{{ $class->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $class->section }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $class->teacher->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.courses.destroy', $class->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Archive this course?')" class="p-2 text-gray-500 hover:text-red-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remedial Tab -->
        <div x-show="activeTab === 'remedial'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Remedial Form -->
                <div class="glass-card p-6 rounded-3xl h-fit">
                    <h4 class="text-lg font-bold text-white mb-6">Assign Remedial Task</h4>
                    <form action="{{ route('admin.remedial-tasks.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Student</label>
                            <select name="student_id" required class="w-full bg-[#1a1a1a] border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->risk_level }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Subject</label>
                                <select name="subject_id" required class="w-full bg-[#1a1a1a] border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Assign Teacher</label>
                                <select name="teacher_id" required class="w-full bg-[#1a1a1a] border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Task Title</label>
                            <input type="text" name="title" required class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Due Date</label>
                            <input type="date" name="due_date" required class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Instructions</label>
                            <textarea name="description" rows="3" required class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50"></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-purple-500 hover:bg-purple-600 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-purple-500/20">Assign Task</button>
                    </form>
                </div>

                <!-- Remedial Task List -->
                <div class="lg:col-span-2 glass-card rounded-3xl overflow-hidden h-fit">
                    <div class="p-6 border-b border-white/5">
                        <h4 class="text-lg font-bold text-white">Active Remedial Tasks</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-300">
                            <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                                <tr>
                                    <th class="px-6 py-4">Student</th>
                                    <th class="px-6 py-4">Task</th>
                                    <th class="px-6 py-4">Subject</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($remedialTasks as $task)
                                <tr class="hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-white">{{ $task->student->user->name }}</div>
                                        <div class="text-[10px] uppercase font-bold text-red-400">{{ $task->student->risk_level }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">{{ $task->title }}</div>
                                        <div class="text-xs text-gray-500">Due: {{ $task->due_date->format('M d') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-white/5 border border-white/10 rounded text-[10px] text-purple-400">{{ $task->subject->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.remedial-tasks.destroy', $task->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('overviewChart').getContext('2d');
            
            let gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
            gradient1.addColorStop(0, 'rgba(0, 193, 106, 0.4)');
            gradient1.addColorStop(1, 'rgba(0, 193, 106, 0)');

            let gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
            gradient2.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
            gradient2.addColorStop(1, 'rgba(59, 130, 246, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Average Score',
                        data: [65, 72, 68, 85, 78, 92],
                        borderColor: '#00C16A',
                        backgroundColor: gradient1,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#00C16A'
                    }, {
                        label: 'Attendance %',
                        data: [88, 85, 92, 90, 95, 94],
                        borderColor: '#3b82f6',
                        backgroundColor: gradient2,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#3b82f6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 10, weight: 'bold' } } },
                        y: { beginAtZero: true, max: 100, grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false }, ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 10 } } }
                    },
                    plugins: { 
                        legend: { position: 'top', align: 'end', labels: { color: 'white', boxWidth: 10, usePointStyle: true, font: { size: 12, weight: 'bold' } } },
                        tooltip: { backgroundColor: '#1a1a1a', titleColor: '#fff', bodyColor: '#ccc', borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1, padding: 12, displayColors: false }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
