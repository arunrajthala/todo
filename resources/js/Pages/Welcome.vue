
<script>
    import Card from "@/Components/Card.vue";

    export default {
      components: {Card},

        data() {
            return {
                tasks: [],
                task: '',
                boards: '',
                cards: []
            }
        },

        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                console.log(this.$route);
                let taskId = window.location.href.split('/').slice().pop();

                axios.get('/api/v1/tasks')
                    .then(res => res.data)
                    .then(data => {
                        this.task = data.task;
                        this.tasks = data.tasks;
                        this.cards = this.mergeStories(this.clone(data.tasks));
                    });
            },
            mergeStories(cards) {
                let uniqueStories = [];
                let result = [];
                let lastDay = [];
                let duplicate = false;
                let clone = this.clone;
                cards.forEach(function (task, index) {
                    if (task.story) {
                        uniqueStories.forEach(function (uniqueTask, j) {
                            if (task.story_id == uniqueTask.story_id) {
                                duplicate = true;
                                let uniqueIndex = result.indexOf(uniqueTask);
                                if (uniqueIndex >= 0) {
                                    lastDay.push([uniqueIndex, task.absolute_day]);
                                    result[uniqueIndex].tasks.push(task);
                                }
                            }
                        });
                        if (!duplicate) {
                            const theTask = clone(task);
                            theTask.tasks = [task];
                            result.push(theTask);
                            uniqueStories.push(theTask);
                        }
                    } else {
                        result.push(clone(task));
                    }
                })
                lastDay.forEach(function (data, index) {
                    result[data[0]].absolute_day += '-' + data[1];
                })
                return result;
            },
            clone(data) {
                return JSON.parse(JSON.stringify(data));
            },
            onMove(evt) {
                let updateTasksData = this.updateTasksData;
                console.log(this.task);
                updateTasksData(this.task, this.cards);
            },
            updateTasksData(task, cards) {
                let fetchData = this.fetchData;
                axios.put('/api/v1/tasks/' + task.id + '/manage-tasks', {
                    data: cards,
                })
                    .then(function (response) {
                        fetchData()
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        }

    }

</script>

<template>
    <div class="card">
        <div class="row">
            <div class="col-md-8">
                <h1>Arrange Tasks( {{task.name}})</h1>
                <div class="row">
                    <div class="col-md-12">

                        <a href="/">Back to home</a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        Day
                    </div>
                    <div class="col-md-3">
                        Type
                    </div>
                    <div class="col-md-5">
                        Task/Story name
                    </div>
                </div>
                <draggable v-model="cards" group="people" @start="drag=true" @end="onMove" handle=".fa-bars">
                    <div class="alert alert-secondary card-body" v-for='task in cards' :key='task.id'>
                        <card :task='task'></card>
                    </div>
                </draggable>
                <button type="submit" @click='onMove' class="btn btn-primary">Submit</button>
            </div>


            <div class="col-md-4">
                <h1>Preview</h1>
                <table class="preview">
                    <thead>
                    <th>Absolute Day</th>
                    <th>Name</th>
                    </thead>
                    <tbody>
                    <tr v-for='task in tasks' :key='task.id'>
                      <td>{{task.absolute_day}}</td>
                        <td>{{task.name}}
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
