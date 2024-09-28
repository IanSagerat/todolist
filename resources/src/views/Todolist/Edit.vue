<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit List</h4>
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
                <div class="mb-3">
                    <label for="">List Status</label>
                    <select name="list_status" v-model="model.todolist.list_status" class="form-control" id="">
                        <option value="Incomplete">Incomplete</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="button" @click="updateList" class="btn btn-primary float-end">Update</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'todolistEdit',
    data() {
        return {
            errorList: {}, // Initialize as an empty object
            model: {
                todolist: {
                    list_name: '',
                    list_desc: '',
                    list_status: '',
                }
            }
        };
    },
    mounted() {
        this.getList(this.$route.params.list_id);
    },
    methods: {
        getList(list_id) {
            axios.get(`http://s8ogsogwook400gsw044so48.207.148.119.27.sslip.io/api/lists/${list_id}`).then(res => {
                this.model.todolist = res.data.data; 
            }).catch(error => {
                console.log(error);
                if (error.response && error.response.status === 404) {
                    alert("List not found.");
                }
            });
        },

        updateList() 
        {
            var $this = this;
            const list_id = this.$route.params.list_id;
            axios.put(`http://s8ogsogwook400gsw044so48.207.148.119.27.sslip.io/api/lists/${list_id}`, this.model.todolist)
                .then(res => {
                    console.log(res.data);
                    alert(res.data.message);

                    this.errorList = {}; // Clear errors after successful submission
                })
                .catch(function (error) 
                {
                    if (error.response) 
                    {
                        if (error.response.status === 422) 
                        {
                            $this.errorList = error.response.data.errors;
                        }
                    } 
                    else if (error.request) 
                    {
                        console.log(error.request);
                    } 
                    else 
                    {
                        console.log('Error', error.message);
                    }
                });
        }
    }
};
</script>
