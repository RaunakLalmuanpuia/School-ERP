<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import QuasarLayout from '@/Layouts/QuasarLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <QuasarLayout title="Dashboard">
        <Head title="Welcome" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </QuasarLayout>
</template>
