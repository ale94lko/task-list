<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
//import { Icon } from '@iconify/vue';

defineProps({
  tasks: {
    type: Array,
    required: true,
  },
});

const page = usePage()
const showPreview = computed(() => page.showPreview || !isEmpty(page.content))

function onFocus(event) {
  page.showPreview = true;
}

function onBlur(event) {
  page.showPreview = false;
}

function isEmpty(val) {
  return val == undefined || val == null || val.trim() === '';
}

</script>

<template>
  <Head title="Task list" />
  <div class="content">
    <div class="add">
      <!-- <Icon icon="mdi-light:home" /> -->
      <input type="text" placeholder="Type to add new task"
        v-model="page.content"
        v-on:focus="onFocus($event)"
        v-on:blur="onBlur($event)" />
    </div>
    <div class="actions" v-if="showPreview">
      <div class="shortcuts">
        <button class="btn">Open</button>
      </div>
      <div class="action-buttons">
        <button class="btn btn-secondary">Cancel</button>
        <button v-if="page.content === ''" class="btn btn-primary">Ok</button>
        <button v-else class="btn btn-primary">Add</button>
      </div>
    </div>
    <ul>
      <li v-for="task in tasks" :key="task.id">
        {{ task.content }}
      </li>
    </ul>
  </div>
</template>
