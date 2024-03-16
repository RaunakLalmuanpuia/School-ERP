<template>
   <QuasarLayout>
  <div class="overflow-x-auto">
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
            Teacher Name
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(student, index) in students.data" :key="index">
          <td class="px-6 py-4 whitespace-nowrap">{{ student.id }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ student.user.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ subjects.data.name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  {{ subjects }}
</QuasarLayout>
</template>

<script setup>
import QuasarLayout from "@/Layouts/QuasarLayout.vue";

const props = defineProps({
  students: Object,
  subjects: Object,
});

</script>
