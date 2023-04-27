<template>
    <div class="containe mt-2" >
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" class="form-control" id="search_input" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6 ">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:7%" data-toggle="modal" data-target="#addPostModal">Create Floor</Button> 
        </div>
        <div class="d-flex mt-4 mb-2">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Status</button>
                <div class="dropdown-menu">
                    <p class="dropdown-item" id="active" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="active_data()" >Active</p>
                    <p class="dropdown-item" id="deactive" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="deactive_data()">Deactive</p>
                </div>
            </div>
            <!-- <button class="btn btn-secondary ml-2 mb-2">Calendar</button> -->
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle ml-2" data-toggle="dropdown">Export</button>
                <div class="dropdown-menu">
                    <p class="dropdown-item" id="excel" style="cursor: pointer;" @click="excelExport">EXCEl</p>
                    <p class="dropdown-item" id="csv" style="cursor: pointer;" @click="csvExport">CSV</p>
                </div>
            </div>  
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="floorTable" class="table table-striped hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Floor Name</th>
                                <th>Floor Category</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='(item , index) in pagination' :key='index'>
                                <td>{{item.id}}</td>
                                <td>{{item.floor_name}}</td>
                                <td>{{item.floor_category}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a class="btn btn-primary" data-target="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button  class="btn text-white ml-3" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-1">
                    <!-- <pagination :data="list" @pagination-change-page="getResults"></pagination> -->
                    <VueTailwindPagination
                        :current="currentPage"
                        :total="total"
                        :per-page="perPage"
                        @page-changed="pageChange($event)"
                    ></VueTailwindPagination>
                </div>
            </div>
        </div>
        <!-- Add New Post Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Floor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-2">Floor Name</div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="add.floor_name">
                            </div>
                            <div class="col-sm-2 mt-3">Floor Category</div>
                            <div class="col-sm-10 mt-3">
                                <input type="text" class="form-control" v-model="add.floor_category">
                            </div>
                            <div class="col-sm-2 mt-3">Activation</div>
                            <div class="col-sm-10 mt-3">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio" v-bind:value="1" v-model="add.activation">Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio" v-bind:value="0" v-model="add.activation">No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" @click="addPost()">Create</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Post Modal -->
        <div class="modal fade" id="editPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Floor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-2">Floor Name</div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  v-model="update.floor_name">
                            </div>
                            <div class="col-sm-2 mt-3">Floor Category</div>
                            <div class="col-sm-10 mt-3">
                                <input type="text" class="form-control" v-model="update.floor_category">
                            </div>
                            <div class="col-sm-2 mt-3">Activation</div>
                            <div class="col-sm-10 mt-3">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="updateradio" v-bind:value="1" v-model="update.activation">Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="updateradio" v-bind:value="0" v-model="update.activation">No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" @click="updatePost()">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- searchModal -->
        <div class="modal fade" id="searchModal">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Search Result</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="floorTable" class="table table-striped hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Floor Name</th>
                                                <th>Floor Category</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in search_list' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td>{{item.floor_name}}</td>
                                                <td>{{item.floor_category}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button  class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
                                                    <!-- <button class="btn btn-danger btn-sm" onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()" @click="deletePost(item.id)"><i>Delete</i></button> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Floor Name</th>
                                                <th>Floor Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot> -->
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <!-- <pagination :data="list" @pagination-change-page="getResults"></pagination> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="refresh()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Active Or Deactive -->
        <div class="modal fade" id="activeModal">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="floorTable" class="table table-striped hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Floor Name</th>
                                                <th>Floor Category</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in activate_data' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td>{{item.floor_name}}</td>
                                                <td>{{item.floor_category}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button  class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
                                                    <!-- <button class="btn btn-danger btn-sm" onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()" @click="deletePost(item.id)"><i>Delete</i></button> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <!-- <pagination :data="list" @pagination-change-page="getResults"></pagination> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="refresh()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import exportFromJSON from "export-from-json";
    import VueTailwindPagination from "@ocrv/vue-tailwind-pagination"; 
    import  '@ocrv/vue-tailwind-pagination/styles'; 
    
    export default {
        created(){
            this.fetchFloor();
        },

        components: {
            VueTailwindPagination,
        },

        data(){
            return {
                list:{
                    type:Object,
                    default:null
                },
                search_name: "",
                search_list: [],
                activate_data: [],
                add: {
                    id: "",
                    floor_name: "",
                    floor_category: "",
                    activation: ""
                },
                update: {
                    id: "",
                    floor_name: "",
                    floor_category: "",
                    activation: ""
                },
                currentPage: 1,
                total: "",
                perPage: 4,
                pagination: [],                   
            }
        },
        watch:{},
        computed:{},
        methods:{
            fetchFloor(){
                axios.get('https://admin.globalshopping-mall.site/api/floors')
                .then(res => {
                    this.list = res.data;
                    this.total = res.data.data.length;
                    this.pageChange(this.currentPage);
                    // console.log("List before filter = ", this.list);
                }).catch(err => {console.log(err);});
            },

            find(){ 
                // console.log(this.search_name)
                axios.get('https://admin.globalshopping-mall.site/api/search_floor/'+this.search_name)
                .then(res => {
                    // console.log(res.data[0]);
                    this.search_list = res.data;
                    // console.log(this.search_list)
                }).catch(err => {console.log(err);});
            },
            
            refresh(){
                this.search_list = "";
                this.search_name = "";
            },

            pageChange(pageNumber){
                this.currentPage = pageNumber;
                let trimStart = (pageNumber - 1) * this.perPage;
                let trimEnd = (trimStart + this.perPage); 
                this.pagination = this.list.data.slice(trimStart, trimEnd);
                // console.log(this.pagination);
            },

            active_data(){
                let i = 0;
                let j = 0;
                this.activate_data = [];
                // console.log(this.list.data[1].activation)
                for(i=0; i<this.list.data.length; i++){
                    if(this.list.data[i].activation == 1){
                        this.activate_data[j] = this.list.data[i];
                        j++;
                    }
                }
            },

            deactive_data(){
                let i = 0;
                let j = 0;
                this.activate_data = [];
                // console.log(this.list.data[1].activation)
                for(i=0; i<this.list.data.length; i++){
                    if(this.list.data[i].activation == 0){
                        this.activate_data[j] = this.list.data[i];
                        j++;
                    }
                }
            },

            excelExport(){
                const data = this.list.data;
                const fileName = "Floor";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            csvExport(){
                // console.log(this.list.data)
                const data = this.list.data;
                const fileName = "Floor";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            addPost(){
                if(this.add.floor_name == '' || this.add.floor_category == ''){
                    return alert("Please fill-up all the fields");
                }
                axios.post('https://admin.globalshopping-mall.site/api/create_floor', this.add)
                .then(res => {
                    if(res.status == 201){
                        this.add.floor_name == "";
                        this.add.floor_category == "";
                        location.reload();
                    }
                }).catch(error => { console.log(error);});
            },
            editPost(id){
                // this.update.fill(id);
                axios.get('https://admin.globalshopping-mall.site/api/single_floor/'+id)
                .then(res => {
                    this.update.id = res.data.data.id,
                    this.update.floor_name = res.data.data.floor_name,
                    this.update.floor_category = res.data.data.floor_category,
                    this.update.activation = res.data.data.activation
                }).catch(error => {console.log(error);});
            },

            updatePost(){
                axios.put('https://admin.globalshopping-mall.site/api/update_floor/'+this.update.id, {floor_name:this.update.floor_name, floor_category:this.update.floor_category, activation:this.update.activation})
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },
            activation(id){
                let activationCode;
                let floor_name;
                let category;
                axios.get('https://admin.globalshopping-mall.site/api/single_floor/'+id)
                .then(res => {
                    //console.log("Response = "+res.data.data.activation);
                    floor_name = res.data.data.floor_name;
                    category = res.data.data.floor_category;
                    if(res.data.data.activation == 1){
                        activationCode = 0;
                        //console.log("Active Code = "+activationCode);
                    }else{
                        if(res.data.data.activation == 0){
                            activationCode = 1;
                            //console.log("Active Code = "+activationCode);
                        }
                    }
                })
                .then(res => {
                    axios.put('https://admin.globalshopping-mall.site/api/update_floor/' + id, {floor_name:floor_name, floor_category:category, activation: activationCode}).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
        }
    }
</script>

<style scoped>
    .pagination{
        margin-bottom: 0;
    }
    
    #editPostModal{
        z-index: 99999;
    }
    #activeModal{
        z-index: 999999;
    }
</style>