<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Add List</h4>
            </div>
            <div class="card-body">

                <!-- Error display -->
                <ul class="alert alert-warning" v-if="Object.keys(errorList).length > 0">
                    <li class="mb-0 ms-3" v-for="(errors, field) in errorList" :key="field">
                        {{ errors[0] }}
                    </li>
                </ul>

                <div class="mb-3">
                    <label for="">List Name</label>
                    <input type="text" name="list_name" v-model="model.todolist.list_name" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="">List Description</label>
                    <input type="text" name="list_desc" v-model="model.todolist.list_desc" class="form-control" id="">
                </div>
                <input type="hidden" name="list_status" v-model="model.todolist.list_status" class="form-control" id="" value="Incomplete">

                <div class="mb-3">
                    <button type="button" @click="saveList" class="btn btn-primary float-end">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'todolistCreate',
    data() {
        return {
            errorList: {}, // Initialize as an empty object
            model: {
                todolist: {
                    list_name: '',
                    list_desc: '',
                    list_status: 'Incomplete',
                }
            }
        };
    },
    methods: {
        saveList() {
            var $this = this;
            axios.post('http://p08c4o8g8k8kcg8kg88gwsso.207.148.119.27.sslip.io/api/lists', this.model.todolist)
                .then(res => {
                    console.log(res.data);
                    alert(res.data.message);
                    // Reset the form
                    this.model.todolist = {
                        list_name: '',
                        list_desc: '',
                        list_status: 'Incomplete'
                    };
                    this.errorList = {}; // Clear errors after successful submission
                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status === 422) {
                            $this.errorList = error.response.data.errors;  // Assign the errors to errorList
                        }
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
        }
    }
};
</script>
