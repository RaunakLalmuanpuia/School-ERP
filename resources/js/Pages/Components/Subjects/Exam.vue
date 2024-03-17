<template>
    <div>
        <h1>{{ title }}</h1>
        <p>{{ message }}</p>
    </div>
</template>

<script setup>
// Props declaration
const props = defineProps({
    title: String,
    message: String
});
</script>