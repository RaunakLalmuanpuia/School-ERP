<template>
    <div>
      <h2>Timetable</h2>
      <div v-for="(classPeriods, classIndex) in periods" :key="classIndex">
        <h3> {{ classIndex}}</h3>
        <table>
          <thead>
            <tr>
              <th>Period</th>
              <th>Subject</th>
              <th>Teacher</th>
              <th>Room</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(period, periodIndex) in classPeriods" :key="periodIndex">
              <td>{{ periodIndex + 1 }}</td>
              <td>{{ period[0].subject }}</td>
              <td>{{ period[0].teacher }}</td>
              <td>{{ period[0].room }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  
  const props = defineProps({
    periods: Array,
  });
  </script>
  