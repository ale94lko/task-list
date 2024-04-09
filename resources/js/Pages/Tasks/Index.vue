<script setup>
import { Head } from '@inertiajs/vue3';
//import { Icon } from '@iconify/vue';

defineProps({
  tasks: {
    type: Array,
    required: true,
  },
});

</script>

<template>
    <Head title="Task list" />
    <div class="container">
        <div class="add">
            <button class="add-button"></button>
            <!-- <Icon icon="mdi-light:home" /> -->
            <input type="text" placeholder="Type to add new task" />
        </div>
        <ul>
            <li v-for="task in tasks" :key="task.id">
                {{ task.content }}
            </li>
        </ul>
    </div>
</template>
