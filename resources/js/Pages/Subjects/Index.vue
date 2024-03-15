<template>
    <QuasarLayout>
        <Head title="Subjects" />
        <div
            v-if="$page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
            role="alert">
            <span class="font-medium">
                {{ $page.props.flash.message }}
            </span>
        </div>
        <main class="container w-full p-4 mx-auto">
            <div class="flex mb-4">
            <!-- create a dialog -->
            <q-btn label="Create Subject" color="primary" @click="creatPrompt()" />
        </div>
            <div
                class="p-4 border border-gray-200 rounded-md shadow-sm dark:border-gray-800 dark:text-gray-300"
            >
                <div
                    class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3"
                >
                    <div
                        v-for="subject in subjects.data"
                        :key="subject.id"
                    >
                        <div class="p-4 mb-4 border border-gray-300 rounded-md">
                            <Link
                                v-if="subject.id"
                                :href="route('subject.show', subject.id)"
                            >
                                <div class="flex flex-col items-start gap-2">
                                    <span class="font-bold">{{
                                        subject.name
                                    }}</span>
                                    <span>{{ subject.subject_code}}</span>
                                    <span>{{ subject.class.description }}</span>
                                    <span>{{ subject.teacher.user.name }}</span>
                                    <span>{{ subject.teacher.user.email }}</span>
                                    
                                    <!-- <span class="font-bold">{{
                                        classe.employer_status
                                    }}</span>
                                    <span>{{ classe.movement }}</span>
                                    <span v-html="classe.employer_feedback"></span> -->
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
         <!-- Create Dialog -->
         <q-dialog v-model="prompt" persistent>
            <q-card style="min-width: 350px">
                <q-card-section>
                <div class="text-h6">Create subjects</div>
                </q-card-section>
                <q-input v-model="form.name" label="Subjet Name" />
                <div v-if="form.errors.name">{{ form.errors.name }}</div>

                <q-input v-model="form.subject_code" label="Subject code" />
                <div v-if="form.errors.subject_code">{{ form.errors.subject_code }}</div>

                <!-- <q-date  v-model="form.acadamic_year" label="Acadamic Year" />
                <div v-if="form.errors.acadamic_year">{{ form.errors.acadamic_year }}</div> -->
                
                <!-- <q-select
        v-model="form.teacher_id"
        label="Teacher"
        outlined
        dense
        :options="teacherOptions"
      /> -->
           
                
      <q-select
        v-model="form.teacher_id"
        label="Teacher"
        outlined
        dense
        :options="teacherOptions"
      />

      <q-select
        v-model="form.class_id"
        label="Class"
        outlined
        dense
        :options="classesOptions"
      />
      
                <q-card-actions align="right" class="text-primary">
                <q-btn flat label="Cancel" v-close-popup />
                <q-btn flat label="Confirm" v-close-popup  @click="onSubmit()"/>
                </q-card-actions>
            </q-card>
            </q-dialog>
    </QuasarLayout>
</template>

<script setup>
import QuasarLayout from "@/Layouts/QuasarLayout.vue";
import {useForm, router, Link, Head} from "@inertiajs/vue3";
import { useQuasar } from "quasar";
import {ref} from 'vue';
const $q = useQuasar();
const prompt = ref(false);

const props = defineProps({
    subjects: Object,
    teacher: Object,
    classes:Object,
});

const form = useForm({
    class_id : "",
    teacher_id: "",
    name: '',
    subject_code: '',
    acadamic_year: '',
})

const creatPrompt = () => {
    prompt.value = true;
};
// Map teacher objects to dropdown options
const teacherOptions = props.teacher.map(teacher => ({
  label: teacher.user.name, // Assuming 'name' attribute in the 'user' relationship
  value: teacher.id,
}));

// Map teacher objects to dropdown options
const classesOptions = props.classes.map(classes => ({
  label: classes.description, 
  value: classes.id,
}));


const onSubmit = () => {
        form.post(route("subject.store"));
        $q.notify({
            message: "Class succesfully Created",
            color: "purple",
            position: "bottom",
            actions: [{ label: "Dismiss", color: "white" }],
        });
        form.name = "";
   
};

</script>
