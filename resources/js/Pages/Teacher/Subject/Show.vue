<template>
   <QuasarLayout>
    <h2>{{subject_material.name}}</h2>
  <div class="overflow-x-auto">
    <h3>Students</h3>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            ID
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Student Name
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Phone Number
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Attendence
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(student, index) in students.data" :key="index">
          <td class="px-6 py-4 whitespace-nowrap">{{ student.id }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ student.user.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ student.phone_no }}</td>
          <!-- <td class="px-6 py-4 whitespace-nowrap">{{ subjects.data.name }}</td> -->
        </tr>
      </tbody>
    </table>
  </div>
  <div>
    <h3>Assingment</h3>
    <Assingment :title="'Assingment Component'" :message="'CRUD assingment'"/>
  </div>
  <div>
    <h3>Quizes</h3>
    <Quiz :title="'Quiz Component'" :message="'Quiz Crud'"/>
  </div>
  <div>
    <h3>Exams</h3>
    <Exam :title="'Exam Component'" :message="'Exam CRUD'"/>
  </div>
  <!-- {{ subjects }} -->
</QuasarLayout>
</template>

<script setup>
import QuasarLayout from "@/Layouts/QuasarLayout.vue";
import Quiz from '@/Pages/Components/Subjects/Quiz.vue';
import Assingment from '@/Pages/Components/Subjects/Assingment.vue';
import Exam from '@/Pages/Components/Subjects/Assingment.vue';


const props = defineProps({
  students: Object,
  subject_material: Object,
});

</script>
