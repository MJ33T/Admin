<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" id="search_input" class="form-control" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:5%" data-toggle="modal" data-target="#addPostModal">Create Category</Button>
        </div>
        <div class="d-flex mt-4 mb-2">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Status</button>
                <div class="dropdown-menu">
                    <p class="dropdown-item" id="active" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="active_data()">Active</p>
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
                                <th>Image</th>
                                <th>Category</th>
                                <th>Floor</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='(item , index) in pagination' :key='index'>
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <td>{{item.category}}</td>
                                <td>{{item.floor_name}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button class="btn text-white ml-3" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
                                    <!-- <button class="btn btn-danger btn-sm" onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()" @click="deletePost(item.id)"><i>Delete</i></button> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
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
                    <h4 class="modal-title">Create Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png"/>
                                    </label>
                                    <input type="file" name="file"  v-on:change="handleFileUpload($event)"/>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-2">Category Name</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="add.category">
                                    </div>
                                    <div class="col-sm-2 mt-3">Floor Name</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="add.floor">
                                        <option class="form-control"  v-for='(floor , index) in floor_name_list' :key='index' :value="floor.id">{{ floor.floor_name }}</option>
                                        </select>
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
        <div class="modal fade" id="editPostModal" data-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update.view_image)" alt="image" >
                                    </label>
                                    <input type="file" name="file"  v-on:change="UpdatehandleFileUpload($event)"/>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-2">Category Name</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="update.category">
                                    </div>
                                    <div class="col-sm-2 mt-3">Floor Name</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="update.floor">
                                        <option class="form-control"  v-for='(floor , index) in floor_name_list' :key='index' :value="floor.id" >{{ floor.floor_name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mt-3">Activation</div>
                                    <div class="col-sm-10 mt-3">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="addradio" v-bind:value="1" v-model="update.activation">Yes
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="addradio" v-bind:value="0" v-model="update.activation">No
                                            </label>
                                        </div>
                                    </div>
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
                                                <th>Image</th>
                                                <th>Category</th>
                                                <th>Floor</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in search_list' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <!-- <td></td> -->
                                                <td>{{item.category}}</td>
                                                <td>{{item.floor_name}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
        <!-- Active or Deactive -->
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
                                                <th>Image</th>
                                                <th>Category</th>
                                                <th>Floor</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in activate_data' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.category}}</td>
                                                <td>{{item.floor_name}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
            
            this.fetchCategory();
            this.fetchFloor();

        },

        components: {
            VueTailwindPagination,
        },

        data(){
            return {
                list:[],
                selectedImage: [],
                floor_name_list:[],
                search_list: [],
                search_name: "",
                activate_data: [],
                add: {
                    id: "",
                    image: "",
                    category: "",
                    floor: "",
                    activation: ""
                },
                update: {
                    id: "",
                    view_image:"",
                    image:"",
                    category: "",
                    floor: "",
                    activation: "",
                    _method: "PUT"
                },
                currentPage: 1,
                total: "",
                perPage: 4,
                pagination: []

            }
        },
        watch:{},
        computed:{},
        methods:{
            fetchCategory(){
                axios.get('https://admin.globalshopping-mall.site/api/product_categories')
                .then(res => {
                    this.list = res.data;
                    this.total = res.data.data.length;
                    this.pageChange(this.currentPage);
                }).catch(err => {console.log(err);});
            },

            handleFileUpload(event){
                this.add.image = event.target.files[0];
                // console.log(this.add.image);
            },

            UpdatehandleFileUpload(event){
                this.update.image = event.target.files[0];
            },

            fetchFloor(){
                axios.get('https://admin.globalshopping-mall.site/api/floors')
                .then(res => {
                    this.floor_name_list = res.data.data;
                }).catch(err => {console.log(err);});
            },

            find(){ 
                // console.log(this.search_name)
                axios.get('https://admin.globalshopping-mall.site/api/search_product_category/'+this.search_name)
                .then(res => {
                    // console.log(res.data.data);
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

            imagePath(data){
                let impath = data.slice(7);
                // console.log(impath)
                return impath;   
            },

            excelExport(){
                const data = this.list.data;
                const fileName = "Category";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            csvExport(){
                // console.log(this.list.data)
                const data = this.list.data;
                const fileName = "Category";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            addPost(){
                if(this.add.category == '' || this.add.floor == ''){
                    return alert("Please fill-up all the fields");
                }
                // console.log(this.add.image);
                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('category', this.add.category);
                formData.append('floor', this.add.floor);
                formData.append('activation', this.add.activation);
                // console.log(formData.entries);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                // console.log(formData.image);
                axios.post('https://admin.globalshopping-mall.site/api/create_product_category', formData, config)
                    .then(res => { 
                    if(res.status == 201){
                        this.add.category == "";
                        this.add.floor == "";
                        this.add.image == "";
                        location.reload();
                    }
                }).catch(error => { console.log(error);});
            },

            editPost(id){
                let i = 0;
                
                axios.get('https://admin.globalshopping-mall.site/api/single_product_category/'+id)
                .then(res => {
                    console.log(res.data.data[0]);
                    
                    this.update.id = res.data.data[0].id,
                    this.update.image = res.data.data[0].image,
                    this.update.view_image = res.data.data[0].image,
                    this.update.category = res.data.data[0].category,
                    // this.update.floor = res.data.data[0].floor_name,
                    this.update.activation = res.data.data[0].activation
                    for(i=0; i<this.floor_name_list.length; i++){
                        if(this.floor_name_list[i].floor_name == res.data.data[0].floor_name){
                            this.update.floor = this.floor_name_list[i].id;
                        }
                    }
                    
                    
                    // console.log(this.update.floor);
                }).catch(error => {console.log(error);});
                // console.log(this.update.image);
            },
            
            updatePost(){
                // console.log(this.update);
                let updateFormData = new FormData();
                 
                updateFormData.append('image', this.update.image);
                updateFormData.append('category', this.update.category);
                updateFormData.append('floor', this.update.floor);
                updateFormData.append('activation', this.update.activation);
                updateFormData.append('_method', this.update._method);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                console.log(updateFormData.get('id'))
                axios.post('https://admin.globalshopping-mall.site/api/update_product_category/'+this.update.id, updateFormData, config)
                .then(res => {
                    console.log(res.data)
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },

            activation(id){
                let activationCode;
                let floor;
                let category;
                let i = 0;
                console.log(id);
                axios.get('https://admin.globalshopping-mall.site/api/single_product_category/'+id)
                .then(res => {
                    console.log(res.data.data[0]);
                    for(i=0; i<this.floor_name_list.length; i++){
                        if(this.floor_name_list[i].floor_name == res.data.data[0].floor_name){
                            floor = this.floor_name_list[0].id;
                        }
                    }
                    category = res.data.data[0].category;
                    if(res.data.data[0].activation == 1){
                        activationCode = 0;
                        //console.log("Active Code = "+activationCode);
                    }else{
                        if(res.data.data[0].activation == 0){
                            activationCode = 1;
                            //console.log("Active Code = "+activationCode);
                        }
                    }
                })
                .then(res => {
                    axios.put('https://admin.globalshopping-mall.site/api/update_product_category/' + id, {floor:floor, category:category, activation: activationCode}).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
        }
            
    }
</script>
<style>
    #editPostModal{
        z-index: 999999;
    }
    #activeModal{
        z-index: 99999;
    }
</style>