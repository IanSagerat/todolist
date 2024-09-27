<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>
                    Todolist
                    <RouterLink to="/todolist/create" class="btn btn-primary float-end"> Add List </RouterLink>
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>List No.</th>
                            <th>List Name</th>
                            <th>List Description</th>
                            <th>List Status</th>
                            <th>List Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.todolist.length > 0">
                        <tr v-for="(list, index) in this.todolist" :key="index">
                            <td>{{ list.list_id }}</td>
                            <td>{{ list.list_name }}</td>
                            <td>{{ list.list_desc }}</td>
                            <td>{{ list.list_status }}</td>
                            <td>{{ list.created_at }}</td>
                            <td>
                                <RouterLink :to="{path: '/todolist/'+list.list_id+'/edit'}" class="btn btn-primary mx-1"> Edit </RouterLink>
                                <button class="btn btn-success mx-1"  @click="completedList(list.list_id)"> Completed </button>
                                <button type="button" class="btn btn-danger mx-1" @click="deleteList(list.list_id)"> Delete </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios'
export default {
    name: 'todolist',
    data() {
        return {
            todolist:[]
        }
    },
    mounted(){
        this.getList();
        // console.log(' iiiiii');

    },
    methods: {
        getList() {
            axios.get('http://localhost:8000/api/lists').then(res => {
                this.todolist = res.data.data
                console.log(this.todolist)
            });
        },

        deleteList(listId){
            if(confirm('Are You Sure You Want To Delete This Activity?'))
            {
                // console.log(listId)
                axios.delete(`http://localhost:8000/api/lists/${listId}`)
                .then(res => {
                    console.log(res.data);
                    alert("Activity Deleted Successfully");
                    // You can add any additional logic here, like redirecting or updating the UI
                })
                .catch(error => {
                    console.error(error);
                    alert("Failed to delete activity.");
                });
            }
        },

        completedList(list) {
            axios.patch(`http://localhost:8000/api/lists/${list}`, {
                list_status: 'Completed' // This can still be included or omitted
            })
            .then(res => {
                console.log(res.data);
                alert("Activity status updated to Completed successfully.");
                this.getList();
            })
            .catch(error => {
                if (error.response) {
                    console.error("Error response data:", error.response.data);
                    alert("Failed to update activity status: " + JSON.stringify(error.response.data.error));
                } else {
                    console.error("Error message:", error.message);
                    alert("Failed to update activity status: " + error.message);
                }
            });
        }






    }
}
</script>