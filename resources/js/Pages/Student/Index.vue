<template>
    <QuasarLayout>
        <Head title="Student" />
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
            <q-btn label="Add Student" color="primary" @click="creatPrompt()" />
        </div>
            <div
                class="p-4 border border-gray-200 rounded-md shadow-sm dark:border-gray-800 dark:text-gray-300"
            >
                <div
                    class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3"
                >
                    <div
                        v-for="student in student.data"
                        :key="student.id"
                    >
                        <div class="p-4 mb-4 border border-gray-300 rounded-md">
                            <Link
                                v-if="student.id"
                                :href="route('student.show', student.id)"
                            >
                                <div class="flex flex-col items-start gap-2">
                                    <img class="h-20 w-20 rounded-full object-cover" :src="'/storage/' + student.photo" :alt="$page.props.auth.user.name">
                                    <!-- <q-img
                                    :src="'/storage/' + teacher.photo"
                                /> -->
                                    <span class="font-bold">{{
                                        student.user.name
                                    }}</span>
                                    <span>{{ student.user.email }}</span>
                                    <span>{{ student.address }}</span>
                                    <span>{{ student.class.description }}</span>
                                    <span v-for="subject in student.class.subject">
                                        {{ subject.name }}a
                                    </span>
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
                        v-for="(link, index) in student.links"
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
            <q-card style="min-width: 500px">
                <q-card-section>
                <div class="text-h6">Add Student</div>
                </q-card-section>
            <q-input
            v-model="formData.name"
            label="Name"
            outlined
            dense
            clearable
          />
          <q-input
            v-model="formData.email"
            label="Email"
            outlined
            dense
            clearable
          />
          <q-input
            v-model="formData.password"
            label="Password"
            outlined
            dense
            clearable
          />
            <q-input
            v-model="formData.admission_no"
            label="Admission No"
            outlined
            dense
            clearable
          />
          <q-input
            v-model="formData.father_name"
            label="Father's Name"
            outlined
            dense
            clearable
          />
          <q-input
            v-model="formData.mother_name"
            label="Mother's Name"
            outlined
            dense
            clearable
          />
          <q-select
            v-model="formData.gender"
            :options="['male', 'female']"
            label="Gender"
            outlined
            dense
            clearable
          />
          <!-- <q-date
            v-model="formData.date_of_birth"
            label="Date of Birth"
            outlined
            dense
            clearable
          /> -->
          <label class="block text-gray-700 text-sm font-bold mb-2">Date of Birth</label>
          <input
          type="date"
          v-model="formData.date_of_birth"
          class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
         
          
          <q-input
            v-model="formData.address"
            label="Address"
            outlined
            dense
            clearable
          />
          <q-input
            v-model="formData.phone_no"
            label="Phone No"
            outlined
            dense
            clearable
          />
          <q-select
        v-model="formData.class_id"
        label="Class"
        outlined
        dense
        :options="classesOptions"
      />
         <label class="block text-gray-700 text-sm font-bold mb-2">Academic Year</label>
          <input
          type="date"
          v-model="formData.academic_year"
          class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

          <q-file
            v-model="formData.photo"
            label="Photo"
            outlined
            dense
            accept="image/*"
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
    student: Object,
    classes: Object,
});
const formData = useForm({
    class_id: null,
    name: null,
    email: null,
    password: null,
    admission_no: null,
    father_name: null,
    mother_name: null,
    gender: null,
    date_of_birth: null,
    acadamic_year: null,
    address: null,
    phone_no: null,
    photo: null,
      
})
const creatPrompt = () => {
    prompt.value = true;
};
// Map teacher objects to dropdown options
const classesOptions = props.classes.map(classes => ({
  label: classes.description, 
  value: classes.id,
}));
const onSubmit = () => {
        formData.post(route("student.store"));
        $q.notify({
            message: "Class succesfully Created",
            color: "purple",
            position: "bottom",
            actions: [{ label: "Dismiss", color: "white" }],
        });
        formData.name = "";
   
};
</script>
