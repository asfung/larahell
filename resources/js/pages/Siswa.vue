<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, router } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Siswa', href: '/siswa' },
];

defineProps<{
    siswa: Array<any>;
}>();

const form = useForm({
    nisn: '',
    nama: '',
    tempat_lahir: '',
    tanggal_lahir: '',
    alamat: '',
    telepon: '',
});

const search = ref('');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref<number | null>(null);

const openCreateModal = () => {
    form.reset();
    isEditing.value = false;
    showModal.value = true;
};

const openEditModal = (s: any) => {
    form.nisn = s.nisn;
    form.nama = s.nama;
    form.tempat_lahir = s.tempat_lahir;
    form.tanggal_lahir = s.tanggal_lahir;
    form.alamat = s.alamat;
    form.telepon = s.telepon;
    editingId.value = s.id;
    isEditing.value = true;
    showModal.value = true;
};

const save = () => {
    if (isEditing.value && editingId.value !== null) {
        form.put(route('siswa.update', editingId.value), {
            onSuccess: () => {
                form.reset();
                showModal.value = false;
            },
        });
    } else {
        form.post(route('siswa.store'), {
            onSuccess: () => {
                form.reset();
                showModal.value = false;
            },
        });
    }
};

const destroy = (id: number) => {
    if (confirm('Are you sure?')) {
        router.delete(route('siswa.destroy', id));
    }
};

const searchSiswa = () => {
    router.get(route('siswa.index'), { search: search.value }, { preserveState: true });
};

const handleDownloadPdf = () => {
    const link = document.createElement('a');
    link.href = route('siswa.report');
    link.setAttribute('download', 'laporan.pdf');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

const handleKeydown = (e: KeyboardEvent) => {
    if (e.key === 'Escape') {
        showModal.value = false;
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
    <Head title="Siswa" />
        <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 flex flex-col gap-4">
            <h2>Data Siswa</h2>
            <div class="flex gap-4">
                <button @click="handleDownloadPdf" class="btn text-red-500 p-2 hover:ring-2 active:bg-red-500/50 hover:ring-red-500 hover:rounded-sm hover:cursor-pointer">Download PDF</button>
                <button @click="openCreateModal" class="btn bg-blue-500 text-white p-2 rounded-sm hover:cursor-pointer hover:bg-blue-800">Tambah Siswa</button>
            </div>

            <input v-model="search" @input="searchSiswa" placeholder="Cari siswa..." class="border p-2 rounded" />

            <table class="w-full border mt-4">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="s in siswa" :key="s.id">
                        <td>{{ s.nisn }}</td>
                        <td>{{ s.nama }}</td>
                        <td>{{ s.tempat_lahir }}</td>
                        <td>{{ s.tanggal_lahir }}</td>
                        <td>{{ s.alamat }}</td>
                        <td>{{ s.telepon }}</td>
                        <td>
                            <button @click="openEditModal(s)" class="text-blue-500 hover:cursor-pointer">Edit</button>
                            <button @click="destroy(s.id)" class="text-red-500 ml-2 hover:cursor-pointer">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            v-if="showModal"
            class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md flex items-center justify-center"
            @click.self="showModal = false"
            >
            <!-- class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" -->
            <div
                class="bg-white dark:bg-gray-800 text-black dark:text-white p-6 rounded-lg w-full max-w-lg shadow-lg"
                >
                <h3 class="text-lg font-bold mb-4">
                    {{ isEditing ? 'Edit Siswa' : 'Tambah Siswa' }}
                </h3>
                <form @submit.prevent="save" class="space-y-3">
                    <input
                    v-model="form.nisn"
                    placeholder="NISN"
                    class="w-full border p-2 rounded bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                    <input
                    v-model="form.nama"
                    placeholder="Nama"
                    class="w-full border p-2 rounded bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                    <input
                    v-model="form.tempat_lahir"
                    placeholder="Tempat Lahir"
                    class="w-full border p-2 rounded bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                    <input
                    v-model="form.tanggal_lahir"
                    type="date"
                    class="w-full border p-2 rounded bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                    <textarea
                        v-model="form.alamat"
                        placeholder="Alamat"
                        class="w-full border p-2 rounded bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        ></textarea>
                    <input
                    v-model="form.telepon"
                    placeholder="Telepon"
                    class="w-full border p-2 rounded bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />

                    <div class="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            @click="showModal = false"
                            class="bg-gray-200 dark:bg-gray-600 px-4 py-2 rounded text-black dark:text-white hover:cursor-pointer"
                            >
                            Batal
                        </button>
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded hover:cursor-pointer"
                                >
                                {{ isEditing ? 'Ubah' : 'Tambah' }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
        </AppLayout>
</template>
