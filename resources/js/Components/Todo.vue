<template>
  <div class="container mt-5">
    <h1 class="mb-4">Todo Manager</h1>
    <!-- Error Messages -->
    <div v-if="errors.length" class="alert alert-danger">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>
    <!-- Todo Form -->
    <form @submit.prevent="handleSubmit" class="mb-4">
      <div class="mb-3">
        <label for="title" class="form-label">Todo Title *</label>
        <input
            v-model="form.title"
            type="text"
            class="form-control"
            id="title"
            placeholder="Enter Todo Title"
        />
      </div>
      <div class="mb-3">
        <label for="title" class="form-label">Todo Description</label>
        <textarea
            v-model="form.description"
            class="form-control"
            id="description"
            placeholder="Enter Todo Description"
        ></textarea>
      </div>
      <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input
            v-model="form.due_date"
            type="date"
            class="form-control"
            id="due_date"
        />
      </div>
      <button type="submit" class="btn btn-primary">
        {{ editMode ? 'Update' : 'Create' }} Todo
      </button>
      <button v-if="editMode" type="button" @click="cancelEdit" class="btn btn-secondary ms-2">Cancel</button>
    </form>

    <!-- Todo List Table -->
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Due Date</th>
        <th scope="col">Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(todo, index) in todos" :key="todo.id">
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ todo.title }}</td>
        <td>{{ todo.due_date || 'No due date' }}</td>
        <td>
          <button @click="edit(todo)" class="btn btn-warning btn-sm">Edit</button>
          <button @click="deleteTodo(todo.id)" class="btn btn-danger btn-sm ms-2">Delete</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      todos: [],
      form: {
        title: '',
        due_date: ''
      },
      editMode: false,
      editId: null,
      errors: [] // To store validation errors
    };
  },
  created() {
    this.getTodos();
  },
  methods: {
    async getTodos() {
      let response = await axios.get('/api/todos');
      this.todos = response.data;
    },
    async handleSubmit() {
      try {
        if (this.editMode) {
          await this.updateTodo();
        } else {
          await this.createTodo();
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = Object.values(error.response.data.errors).flat();
        }
        this.scrollToTop();
      }
    }
    ,
    async createTodo() {
      const response = await axios.post('/api/todos', this.form);
      this.todos.push(response.data);
      this.resetForm();
    },
    async updateTodo() {
      await axios.put(`/api/todos/${this.editId}`, this.form);
      const updatedTodo = this.todos.find(todo => todo.id === this.editId);
      updatedTodo.title = this.form.title;
      updatedTodo.description = this.form.description;
      updatedTodo.due_date = this.form.due_date;
      this.resetForm();
    },
    edit(todo) {
      this.form.title = todo.title;
      this.form.due_date = todo.due_date;
      this.form.description = todo.description;
      this.editMode = true;
      this.editId = todo.id;
    },
    async deleteTodo(id) {
      await axios.delete(`/api/todos/${id}`);
      this.todos = this.todos.filter(todo => todo.id !== id);
    },
    resetForm() {
      this.form.title = '';
      this.form.due_date = '';
      this.form.description = '';
      this.editMode = false;
      this.editId = null;
      this.errors = [];
    },
    cancelEdit() {
      this.resetForm();
    },
    scrollToTop() {
      window.scrollTo(0,0);
    }
  }
};
</script>

<style scoped>
/* Add custom styling here if needed */
</style>
