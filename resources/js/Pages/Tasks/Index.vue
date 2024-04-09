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
<script>
export default {
  data() {
    return {
      taskList: [],
      content: '',
      showPreview: false,
    }
  },
  mounted() {
    this.taskList = this.tasks;
  },
  computed: {
    showPreviewMenu() {
      return this.showPreview || !this.isEmpty(this.content);
    },
  },
  methods: {
    onFocus(event) {
      this.showPreview = true;
    },
    onBlur(event) {
      this.showPreview = false;
    },
    cancel() {
      this.content = '';
      this.showPreview = false;
    },
    add() {
      if (this.isEmpty(this.content)) {
        return;
      }

      // Add task
      const newTask = {
        id: this.taskList.length + 1,
        content: this.content,
      };
      this.taskList.push(newTask)
      this.content = '';
      this.showPreview = false;
    },
    isEmpty(val) {
      return val === undefined || val === null || val.trim() === '';
    },
  },
}
</script>
<template>
  <Head title="Task list" />
  <div class="content">
    <div class="add">
      <!-- <Icon icon="mdi-light:home" /> -->
      <input type="text" placeholder="Type to add new task"
        v-model="content"
        v-on:focus="onFocus($event)"
        v-on:blur="onBlur($event)" />
    </div>
    <div class="actions" v-if="showPreviewMenu">
      <div class="shortcuts">
        <button class="btn">Open</button>
      </div>
      <div class="action-buttons">
        <button class="btn btn-secondary" v-on:click="cancel()">Cancel</button>
        <button v-if="content === ''" class="btn btn-primary">Ok</button>
        <button v-else v-on:click="add()" class="btn btn-primary">Add</button>
      </div>
    </div>
    <ul>
      <li v-for="task in taskList" :key="task.id">
        {{ task.content }}
      </li>
    </ul>
  </div>
</template>
