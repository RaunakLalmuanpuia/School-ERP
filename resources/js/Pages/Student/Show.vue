<template>
    <QuasarLayout>
        <Head title="Student" />
        <div class="bg-gray-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Student Details -->
                    <div class="p-6 flex items-center">
                        <div class="mr-4">
                            <!-- Student Photo -->
                            <img :src="'/storage/' + student_detail.photo" :alt="$page.props.auth.user.name" class="w-32 h-32 rounded-full">
                        </div>
                        <div class="px-10">
                            <h2 class="text-2xl font-bold text-gray-800">Basic Info</h2>
                            
                            <p class="text-gray-600 text-sm mb-2">Email: {{ student_detail.user.name }}</p>
                            <p class="text-gray-600 text-sm mb-2">Email: {{ student_detail.user.email }}</p>
                            <p class="text-gray-600 text-sm mb-2">Class: {{ student_detail.class.description }}</p>
                            <p class="text-gray-600 text-sm">Admission Number: {{ student_detail.admission_no }}</p>
                        </div>
                        
                        <div class="px-5">
                            <h2 class="text-2xl font-bold text-gray-800">Personal Details</h2>
                            <p class="text-gray-600 text-sm mb-2">Father Name: {{ student_detail.father_name }}</p>
                            <p class="text-gray-600 text-sm mb-2">Mother Name: {{ student_detail.mother_name }}</p>
                            <p class="text-gray-600 text-sm">Address: {{ student_detail.address }}</p>
                            <p class="text-gray-600 text-sm">Phone: {{ student_detail.phone_no }}</p>
                        </div>
                    </div>
                    <!-- Subject Details -->
                    <div class="border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 px-6 py-4 bg-gray-100">Subject Details</h3>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <template v-if="student_subjects.length > 0">
                                <q-card v-for="subject in student_subjects" :key="subject.id" class="border-gray-300">
                                    <q-card-section>
                                        <h4 class="text-xl font-semibold text-gray-800">{{ subject.name }}</h4>
                                        <p class="text-gray-600">{{ subject.subject_code }}</p>
                                        <p class="text-gray-600">{{ subject.teacher.user.name }}</p>
                                    </q-card-section>
                                </q-card>
                            </template>
                            <template v-else>
                                <p class="text-gray-600">No subjects assigned.</p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </QuasarLayout>
</template>
  
<script setup>
import { Head } from '@inertiajs/vue3';
import QuasarLayout from "@/Layouts/QuasarLayout.vue";

    const props = defineProps({
        student_detail: Object,
        student_subjects: Array,
    });
</script>
  