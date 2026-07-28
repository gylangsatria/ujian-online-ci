<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6"><?= $title ?></h2>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= session()->getFlashdata('message') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Change Password</h3>
        <form action="<?= base_url('settings/update_password') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="old_password">
                    Old Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="old_password" name="old_password" type="password" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">
                    New Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="new_password" name="new_password" type="password" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                    Confirm New Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="confirm_password" name="confirm_password" type="password" required>
            </div>

            <div class="flex items-center justify-end">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>