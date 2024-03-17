<template>
    <QuasarLayout>
      <Head title="Subjects"/>
        <div
            v-if="$page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
            role="alert">
            <span class="font-medium">
                {{ $page.props.flash.message }}
            </span>
        </div>
        <main class="container w-full p-4 mx-auto">
            <div
                class="p-4 border border-gray-200 rounded-md shadow-sm dark:border-gray-800 dark:text-gray-300"
            >
                <div
                    class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3"
                >
                    <div
                        v-for="subjects in  subjects.data"
                        :key="subjects.id"
                    >
                        <div class="p-4 mb-4 border border-gray-300 rounded-md">
                            <Link
                                v-if="subjects.id"
                                :href="route('teacher.viewSubject', subjects)"
                            >
                                <div class="flex flex-col items-start gap-2">
                                    
                                    <span class="font-bold">{{
                                        subjects.name
                                    }}</span>
                                    <span>{{ subjects.subject_code}}</span>
                                    <span>{{ subjects.grade.description}}</span>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <div class="flex gap-1">
                    <Link
                        v-for="(link, index) in subjects.links"
                        :key="index"
                        class="px-4 py-2 rounded-md"
                        :href="link.url || ''"
                        :class="{
                            'bg-indigo-500 dark:bg-indigo-800 text-gray-300':
                                link.active,
                        }"
                        v-html="link.label"
                    />
                </div>
            </div>
        </main>
        
    </QuasarLayout>
</template>

<script setup>
import QuasarLayout from "@/Layouts/QuasarLayout.vue";
import {useForm, router, Link, Head} from "@inertiajs/vue3";
import { useQuasar } from "quasar";
import {ref} from 'vue';
const $q = useQuasar();


const props = defineProps({
    subjects: Object,
});

</script>
