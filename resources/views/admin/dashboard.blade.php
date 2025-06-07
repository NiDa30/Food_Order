<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white font-bold text-xl">Admin Panel</span>
            </div>
            <nav class="mt-6">
                <div id="userManagementLink" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 cursor-pointer transition-colors"
                     onclick="showSection('userManagement')">
                    <span class="mx-3">User Management</span>
                </div>
                <div id="foodManagementLink" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 cursor-pointer transition-colors"
                     onclick="showSection('foodManagement')">
                    <span class="mx-3">Food Management</span>
                </div>
            </nav>
            <div class="absolute bottom-0 w-64 bg-gray-800">
                <form action="{{ route('admin.logout') }}" method="POST" class="p-4">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-6">
                <!-- User Management Section -->
                <div id="userManagement" class="hidden">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">User Management</h2>
                        <button onclick="showUserModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Add New User
                        </button>
                    </div>                    <div class="bg-white rounded-lg shadow overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr>                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email_verified_at ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at ? date('m/d/Y', strtotime($user->created_at)) : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="editUser({{ json_encode($user) }})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                        <button onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Food Management Section -->
                <div id="foodManagement" class="hidden">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Food Management</h2>
                        <button onclick="showFoodModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Add New Food
                        </button>
                    </div>                    <div class="bg-white rounded-lg shadow overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($foods as $food)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $food->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $food->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($food->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ $food->image }}" alt="{{ $food->name }}" class="h-10 w-10 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="editFood({{ json_encode($food) }})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                        <button onclick="deleteFood({{ $food->id }})" class="text-red-600 hover:text-red-900">Delete</button>
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

    <!-- User Modal -->
    <div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">User Form</h3>
                <form id="userForm" class="space-y-4">
                    <input type="hidden" id="userId">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="userName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="userEmail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="userPassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="isAdmin" class="rounded border-gray-300 text-blue-600">
                        <label class="ml-2 block text-sm text-gray-900">Is Admin</label>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeUserModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Food Modal -->
    <div id="foodModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Food Form</h3>                <form id="foodForm" class="space-y-4">
                    <input type="hidden" id="foodId">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="foodName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="foodDescription" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" step="0.01" id="foodPrice" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image URL</label>
                        <input type="text" id="foodImage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="foodCategory" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Category</option>
                            <option value="main">Main Dish</option>
                            <option value="appetizer">Appetizer</option>
                            <option value="dessert">Dessert</option>
                            <option value="beverage">Beverage</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="isAvailable" class="rounded border-gray-300 text-blue-600">
                        <label class="ml-2 block text-sm text-gray-900">Is Available</label>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeFoodModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentSection = 'userManagement';

        function showSection(section) {
            // Hide all sections
            document.getElementById('userManagement').classList.add('hidden');
            document.getElementById('foodManagement').classList.add('hidden');
            
            // Remove active class from all links
            document.getElementById('userManagementLink').classList.remove('bg-gray-700');
            document.getElementById('foodManagementLink').classList.remove('bg-gray-700');
            
            // Show selected section and highlight link
            document.getElementById(section).classList.remove('hidden');
            document.getElementById(section + 'Link').classList.add('bg-gray-700');
            
            currentSection = section;
            
            // Load data for the section
            if (section === 'userManagement') {
                loadUsers();
            } else {
                loadFoods();
            }
        }

        // User Management
        function loadUsers() {
            fetch('/admin/users')
                .then(response => response.json())
                .then(users => {
                    const tbody = document.getElementById('userTableBody');
                    tbody.innerHTML = '';                    users.forEach(user => {
                        tbody.innerHTML += `                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">${user.id}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${user.name}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${user.email}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${user.email_verified_at || '-'}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${user.is_admin ? 'Yes' : 'No'}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${user.created_at ? new Date(user.created_at).toLocaleDateString() : '-'}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick="editUser(${JSON.stringify(user)})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                    <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                });
        }       function editUser(user) {
            showUserModal(user);
        }

        function showUserModal(user = null) {
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('userForm').reset();
            
            if (user) {
                document.getElementById('userId').value = user.id;
                document.getElementById('userName').value = user.name;
                document.getElementById('userEmail').value = user.email;
                document.getElementById('isAdmin').checked = user.is_admin;
            }
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        document.getElementById('userForm').onsubmit = function(e) {
            e.preventDefault();
            const userId = document.getElementById('userId').value;
            const data = {
                name: document.getElementById('userName').value,
                email: document.getElementById('userEmail').value,
                password: document.getElementById('userPassword').value,
                is_admin: document.getElementById('isAdmin').checked
            };

            const url = userId ? `/admin/users/${userId}` : '/admin/users';
            const method = userId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                closeUserModal();
                loadUsers();
            });
        };

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch(`/admin/users/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadUsers();
                });
            }
        }

        // Food Management
        function loadFoods() {
            fetch('/admin/foods')
                .then(response => response.json())
                .then(foods => {
                    const tbody = document.getElementById('foodTableBody');
                    tbody.innerHTML = '';                    foods.forEach(food => {
                        tbody.innerHTML += `
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">${food.id}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${food.name}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${food.description || '-'}</td>
                                <td class="px-6 py-4 whitespace-nowrap">$${Number(food.price).toFixed(2)}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="${food.image}" alt="${food.name}" class="h-10 w-10 object-cover rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">${food.category || '-'}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="${food.is_available ? 'text-green-600' : 'text-red-600'}">
                                        ${food.is_available ? 'Yes' : 'No'}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">${new Date(food.created_at).toLocaleDateString()}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick="editFood(${JSON.stringify(food)})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                    <button onclick="deleteFood(${food.id})" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                });
        }        function editFood(food) {
            showFoodModal(food);
        }

        function showFoodModal(food = null) {
            document.getElementById('foodModal').classList.remove('hidden');
            document.getElementById('foodForm').reset();
            if (food) {
                document.getElementById('foodId').value = food.id;
                document.getElementById('foodName').value = food.name;
                document.getElementById('foodDescription').value = food.description || '';
                document.getElementById('foodPrice').value = food.price;
                document.getElementById('foodImage').value = food.image || '';
                document.getElementById('foodCategory').value = food.category || '';
                document.getElementById('isAvailable').checked = food.is_available;
            }
        }

        function closeFoodModal() {
            document.getElementById('foodModal').classList.add('hidden');
        }

        document.getElementById('foodForm').onsubmit = function(e) {
            e.preventDefault();
            const foodId = document.getElementById('foodId').value;            const data = {
                name: document.getElementById('foodName').value,
                description: document.getElementById('foodDescription').value,
                price: document.getElementById('foodPrice').value,
                image: document.getElementById('foodImage').value,
                category: document.getElementById('foodCategory').value,
                is_available: document.getElementById('isAvailable').checked
            };

            const url = foodId ? `/admin/foods/${foodId}` : '/admin/foods';
            const method = foodId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                closeFoodModal();
                loadFoods();
            });
        };

        function deleteFood(id) {
            if (confirm('Are you sure you want to delete this food item?')) {
                fetch(`/admin/foods/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadFoods();
                });
            }
        }

        // Show initial section
        showSection('userManagement');
    </script>
</body>
</html>
