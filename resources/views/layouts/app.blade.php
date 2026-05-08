<!DOCTYPE html>
<html>
<head>
    <title>TaskFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow p-4 flex justify-between">
    <h1 class="font-bold">TaskFlow</h1>
    <a href="/tasks" class="text-blue-500">Mes tâches</a>
</nav>

<div class="p-6">
    @yield('content')
</div>

</body>
</html>