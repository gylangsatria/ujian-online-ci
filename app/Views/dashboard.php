<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ujian Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <span class="font-bold text-lg">Ujian Online</span>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600"><?= esc($user_name) ?> (<?= esc($group_name) ?>)</span>
                <a href="<?= base_url('logout') ?>" class="text-sm text-red-600 hover:underline">Logout</a>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-2">Selamat datang, <?= esc($user_name) ?>!</p>
    </main>
</body>
</html>