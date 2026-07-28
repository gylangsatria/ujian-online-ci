<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800"><?= $title ?></h2>
    </div>

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

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="users-table">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $i = 1; foreach ($users as $u) : ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $i++ ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $u->first_name ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $u->last_name ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $u->username ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $u->email ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?= $u->group_name ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php if ($u->active) : ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            <?php else : ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?= base_url('users/edit/' . $u->id) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fa fa-edit"></i></a>
                            <?php if ($u->id != $user->id) : ?>
                                <?php if ($u->active) : ?>
                                    <a href="<?= base_url('users/deactivate/' . $u->id) ?>" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Deactivate"><i class="fa fa-power-off"></i></a>
                                <?php else : ?>
                                    <a href="<?= base_url('users/activate/' . $u->id) ?>" class="text-green-600 hover:text-green-900 mr-3" title="Activate"><i class="fa fa-check"></i></a>
                                <?php endif; ?>
                                <a href="<?= base_url('users/delete/' . $u->id) ?>" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900"><i class="fa fa-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#users-table').DataTable();
    });
</script>
<?= $this->endSection() ?>