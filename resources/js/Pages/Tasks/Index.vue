<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
  tasks: {
    type: Array,
    required: true,
  },
});

</script>
<script>
import { router } from "@inertiajs/vue3";

const emailRegEx =
  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
const urlRegex = /(http[s]?:\/\/)?([^\s(["<,>]*\.[^\s[",><]*)/gi;

export default {
  data() {
    return {
      taskList: [],
      content: '',
      showPreview: false,
      selectedTask: null,
    }
  },
  mounted() {
    this.taskList = this.tasks;
  },
  computed: {
    showPreviewMenu() {
      return this.showPreview || !this.isEmpty(this.content);
    },
    isDisabled() {
      return this.content === ''
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

      router.post('/store', newTask)
    },
    getHtmlContent(content) {
      let arrayMap = content.split(' ')
      for (let [index, word] of Object.entries(arrayMap)) {
        if (word.charAt(0) === '#') {
          arrayMap[index] = '<span class="important">' + word + '</span>'
        } else if (word.charAt(0) === '@') {
          arrayMap[index] = '<span class="somebody">' + word + '</span>'
        } else if (emailRegEx.test(word)) {
          arrayMap[index] = '<span class="email">Mail</span>'
        } else if (urlRegex.test(word)) {
          arrayMap[index] = '<span class="link">Link</span>'
        }
      }

      return arrayMap.join(' ');
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
      <img src="../../../img/plus-square.svg" alt="add" />
      <input type="text" placeholder="Type to add new task"
        v-model="content"
        v-on:focus="onFocus($event)"
        v-on:blur="onBlur($event)" />
      <img v-if="showPreviewMenu && isDisabled" alt="add"
        src="../../../img/avatar-disabled.svg" />
      <img v-else-if="showPreviewMenu" alt="add"
        src="../../../img/avatar.svg" />
    </div>
    <div class="actions" v-if="showPreviewMenu">
      <div class="shortcuts">
        <button class="btn btn-secondary has-border open-btn"
          v-bind:class="{ 'disabled': isDisabled }">
          <img src="../../../img/maximize.svg" alt="Open" />
          Open
        </button>
        <button class="btn has-border"
          v-bind:class="{ 'disabled': isDisabled }">
          <img src="../../../img/calendar.svg" alt="Today" />
          Today
        </button>
        <button class="btn has-border"
          v-bind:class="{ 'disabled': isDisabled }">
          <img src="../../../img/unlock.svg" alt="Public" />
          Public
        </button>
        <button class="btn has-border"
          v-bind:class="{ 'disabled': isDisabled }">
          <img src="../../../img/highlight.svg" alt="Highlight" />
          Highlight
        </button>
        <button class="btn has-border"
          v-bind:class="{ 'disabled': isDisabled }">
          <img src="../../../img/count-circle.svg" alt="Estimation" />
          Estimation
        </button>
      </div>
      <div class="action-buttons">
        <button class="btn btn-secondary" v-on:click="cancel()">Cancel</button>
        <button v-if="isDisabled" class="btn btn-primary">Ok</button>
        <button v-else v-on:click="add()" class="btn btn-primary">Add</button>
      </div>
    </div>
    <ul>
      <li v-for="(task, index) in taskList" :key="task.id">
        <input type="checkbox">
        <span v-html="getHtmlContent(task.content)"></span>
      </li>
    </ul>
  </div>
</template>
