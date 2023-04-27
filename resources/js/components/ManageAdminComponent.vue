<template>
    <div class="containe mt-5">
        <div class="d-flex">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Status</button>
                <div class="dropdown-menu">
                <p class="dropdown-item" id="active" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="active_data()">Active</p>
                <p class="dropdown-item" id="deactive" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="deactive_data()">Deactive</p>
                <!-- <a class="dropdown-item" href="#" >Deactive</a> -->
                </div>
            </div>
            <!-- <button class="btn btn-secondary ml-2">Calendar</button> -->
        </div>
        <div class="d-flex justify-content-end">
            <Button class="btn btn-success mb-5" data-toggle="modal" data-target="#addPostModal">Create Admin</Button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="manageAdminTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in pagination' :key='item.id'>
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <td>{{item.name}}</td>
                                <td>{{item.phone_no}}</td>
                                <td>{{item.email}}</td>
                                <td>{{item.password}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button class="btn text-white ml-3" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
        <!-- Add New Admin Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Admin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png" style="width: 120px; height: 100px">
                                    </label>
                                    <input type="file" name="file"  v-on:change="handleFileUpload($event)"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-3"> Name</div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" v-model="add.name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Phone Number</div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" v-model="add.phone_no">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Email</div>
                            <div class="col-sm-5 mt-3">
                                <input type="email" class="form-control" v-model="add.email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Password</div>
                            <div class="col-sm-5 mt-3">
                                <input type="password" class="form-control" v-model="add.password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Activation</div>
                            <div class="col-sm-7 mt-3">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" v-bind:value="1" v-model="add.activation">Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" v-bind:value="0" v-model="add.activation">No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <div><h5><strong>Authentication Access</strong></h5></div>
                                <div class="row mt-4">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.dashboard">Dashboard
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.floor">Floor
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.product">Product
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.merchant">Merchant
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.customer">Customer
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.stock">Stock
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.voucher">Voucher
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.advertisement">Advertisement
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.promotion">Promotion / Updates
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.manage_admin">Manage Admin
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.setting">Setting
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.mall">Mall
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.sales">Sales
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.transaction">Transaction
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="add.reports">Reports
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
                    <button class="btn btn-success" @click="addPost()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Admin Modal -->
        <div class="modal fade" id="editPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Admin</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png" style="width: 120px; height: 100px">
                                    </label>
                                    <input type="file" name="file"  v-on:change="updatehandleFileUpload($event)" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-3"> Name</div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" v-model="update.name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Phone Number</div>
                            <div class="col-sm-4 mt-3">
                                <input type="text" class="form-control" v-model="update.phone_no">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Email</div>
                            <div class="col-sm-5 mt-3">
                                <input type="email" class="form-control" v-model="update.email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Password</div>
                            <div class="col-sm-5 mt-3">
                                <input type="password" class="form-control" v-model="update.password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Activation</div>
                            <div class="col-sm-7 mt-3">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" v-bind:value="1" v-model="update.activation">Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" v-bind:value="0" v-model="update.activation">No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <div><h5><strong>Authentication Access</strong></h5></div>
                                <div class="row mt-4">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.dashboard">Dashboard
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.floor">Floor
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.product">Product
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.merchant">Merchant
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.customer">Customer
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.stock">Stock
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.voucher">Voucher
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.advertisement">Advertisement
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.promotion">Promotion / Updates
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.manage_admin">Manage Admin
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.setting">Setting
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.mall">Mall
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.sales">Sales
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.transaction">Transaction
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" v-bind:value="1" v-model="update.reports">Reports
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
                                    <table id="manageAdminTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Phone Number</th>
                                                <th>Level</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in activate_data' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.name}}</td>
                                                <td>{{item.phone_no}}</td>
                                                <td></td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white ml-3" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
    import VueTailwindPagination from "@ocrv/vue-tailwind-pagination"; 
    import  '@ocrv/vue-tailwind-pagination/styles';
    export default {
        mounted() {
            this.fetchAdmin();
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
                activate_data: [],
                add: {
                    id: "",
                    image:"",
                    name: "",
                    phone_no: "",
                    email: "",
                    password: "",
                    activation: "",
                    dashboard: "",
                    floor: "",
                    merchant: "",
                    product: "",
                    customer: "",
                    stock: "",
                    voucher: "",
                    advertisement: "",
                    promotion: "",
                    manage_admin: "",
                    setting: "",
                    mall: "",
                    sales: "",
                    transaction: "",
                    reports: "",
                },
                update: {
                    id: "",
                    image:"",
                    name: "",
                    phone_no: "",
                    email: "",
                    password: "",
                    activation: "",
                    dashboard: "",
                    floor: "",
                    merchant: "",
                    product: "",
                    customer: "",
                    stock: "",
                    voucher: "",
                    advertisement: "",
                    promotion: "",
                    manage_admin: "",
                    setting: "",
                    mall: "",
                    sales: "",
                    transaction: "",
                    reports: "",
                    _method: "PUT"
                },
                currentPage: 1,
                total: "",
                perPage: 4,
                pagination: []
            }
        },
        methods:{
            fetchAdmin(){
                axios.get('https://admin.globalshopping-mall.site/api/admins')
                .then(res => {
                    this.list = res.data;
                    this.total = res.data.data.length;
                    this.pageChange(this.currentPage);
                    // console.log("List before filter = ", this.list);
                }).catch(err => {console.log(err);});
            },
            

            //Handles a change on the file upload
            handleFileUpload(event){
                this.add.image = event.target.files[0];
                // console.log(this.add.image);
            },

            updatehandleFileUpload(event){
                this.update.image = event.target.files[0];
                // console.log(this.add.image);
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


            addPost(){
                //console.log(this.add.dashboard);
                if( this.add.name == '' || this.add.phone_no == '' || this.add.email == '' || this.add.password == ''){
                    return alert("Please fill-up all the fields");
                }

                this.add.dashboard = (this.add.dashboard == true)? 1 : 0;
                this.add.floor = (this.add.floor == true)? 1 : 0;
                this.add.merchant = (this.add.merchant == true)? 1 : 0;
                this.add.product = (this.add.product == true)? 1 : 0;
                this.add.customer = (this.add.customer == true)? 1 : 0;
                this.add.stock = (this.add.stock == true)? 1 : 0;
                this.add.voucher = (this.add.voucher == true)? 1 : 0;
                this.add.advertisement = (this.add.advertisement == true)? 1 : 0;
                this.add.promotion = (this.add.promotion == true)? 1 : 0;
                this.add.manage_admin = (this.add.manage_admin == true)? 1 : 0;
                this.add.setting = (this.add.setting == true)? 1 : 0;
                this.add.mall = (this.add.mall == true)? 1 : 0;
                this.add.sales = (this.add.sales == true)? 1 : 0;
                this.add.transaction = (this.add.transaction == true)? 1 : 0;
                this.add.reports = (this.add.reports == true)? 1 : 0; 
                
                // console.log(this.add);
                
                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('name', this.add.name);
                formData.append('phone_no', this.add.phone_no);
                formData.append('email', this.add.email);
                formData.append('password', this.add.password);
                formData.append('activation', this.add.activation);
                formData.append('dashboard', this.add.dashboard);
                formData.append('floor', this.add.floor);
                formData.append('merchant', this.add.merchant);
                formData.append('product', this.add.product);                
                formData.append('customer', this.add.customer);                
                formData.append('stock', this.add.stock);                
                formData.append('voucher', this.add.voucher);                
                formData.append('advertisement', this.add.advertisement);               
                formData.append('promotion', this.add.promotion);               
                formData.append('manage_admin', this.add.manage_admin);               
                formData.append('setting', this.add.setting);                
                formData.append('mall', this.add.mall);                
                formData.append('sales', this.add.sales);                
                formData.append('transaction', this.add.transaction);             
                formData.append('reports', this.add.reports);

                axios.post('https://admin.globalshopping-mall.site/api/create_admin', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(res => {
                    if(res.status == 201){
                        location.reload();
                    }
                }).catch(error => {console.log(error); });
            },
            editPost(id){
                axios.get('https://admin.globalshopping-mall.site/api/single_admin/'+id)
                .then(res => {
                    console.log(res.data.data)
                    this.update.id = res.data.data.id,
                    this.update.name = res.data.data.name,
                    this.update.phone_no = res.data.data.phone_no,
                    this.update.email = res.data.data.email,
                    this.update.password = res.data.data.password,
                    this.update.activation = res.data.data.activation,
                    this.update.dashboard = (res.data.data.dashboard == 1)? true : false;
                    this.update.floor = (res.data.data.floor == 1)? true : false;
                    this.update.merchant = (res.data.data.merchant == 1)? true : false;
                    this.update.product = (res.data.data.product == 1)? true : false;
                    this.update.customer = (res.data.data.customer == 1)? true : false;
                    this.update.stock = (res.data.data.stock == 1)? true : false;
                    this.update.voucher = (res.data.data.voucher == 1)? true : false;
                    this.update.advertisement = (res.data.data.advertisement == 1)? true : false;
                    this.update.promotion = (res.data.data.promotion == 1)? true : false;
                    this.update.manage_admin = (res.data.data.manage_admin == 1)? true : false;
                    this.update.setting = (res.data.data.setting == 1)? true : false;
                    this.update.mall = (res.data.data.mall == 1)? true : false;
                    this.update.sales = (res.data.data.sales == 1)? true : false;
                    this.update.transaction = (res.data.data.transaction == 1)? true : false;
                    this.update.reports = (res.data.data.reports == 1)? true : false;

                }).catch(error => {console.log(error);});
            },
            updatePost(){
                this.update.dashboard = (this.update.dashboard == true)? 1 : 0;
                this.update.floor = (this.update.floor == true)? 1 : 0;
                this.update.merchant = (this.update.merchant == true)? 1 : 0;
                this.update.product = (this.update.product == true)? 1 : 0;
                this.update.customer = (this.update.customer == true)? 1 : 0;
                this.update.stock = (this.update.stock == true)? 1 : 0;
                this.update.voucher = (this.update.voucher == true)? 1 : 0;
                this.update.advertisement = (this.update.advertisement == true)? 1 : 0;
                this.update.promotion = (this.update.promotion == true)? 1 : 0;
                this.update.manage_admin = (this.update.manage_admin == true)? 1 : 0;
                this.update.setting = (this.update.setting == true)? 1 : 0;
                this.update.mall = (this.update.mall == true)? 1 : 0;
                this.update.sales = (this.update.sales == true)? 1 : 0;
                this.update.transaction = (this.update.transaction == true)? 1 : 0;
                this.update.reports = (this.update.reports == true)? 1 : 0; 
                
                
                let formData = new FormData();
                formData.append('image', this.update.image);
                formData.append('name', this.update.name);
                formData.append('phone_no', this.update.phone_no);
                formData.append('email', this.update.email);
                formData.append('password', this.update.password);
                formData.append('activation', this.update.activation);
                formData.append('dashboard', this.update.dashboard);
                formData.append('floor', this.update.floor);
                formData.append('merchant', this.update.merchant);
                formData.append('product', this.update.product);                
                formData.append('customer', this.update.customer);                
                formData.append('stock', this.update.stock);                
                formData.append('voucher', this.update.voucher);                
                formData.append('advertisement', this.update.advertisement);               
                formData.append('promotion', this.update.promotion);               
                formData.append('manage_admin', this.update.manage_admin);               
                formData.append('setting', this.update.setting);                
                formData.append('mall', this.update.mall);                
                formData.append('sales', this.update.sales);                
                formData.append('transaction', this.update.transaction);             
                formData.append('reports', this.update.reports);
                formData.append('_method', this.update._method);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/update_admin/' + this.update.id, formData, config)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },
            activation(id){
                let activationCode;
                let name;
                let phone_no;
                let email;
                let password;
                let dashboard;
                let floor;
                let merchant;
                let product;
                let customer;
                let stock;
                let voucher;
                let advertisement;
                let promotion;
                let manage_admin;
                let setting;
                let mall;
                let sales;
                let transaction;
                let reports;
                axios.get('https://admin.globalshopping-mall.site/api/single_admin/'+id)
                .then(res => {
                    //console.log("Response = "+res.data.data.activation);
                    name = res.data.data.name;
                    phone_no = res.data.data.phone_no;
                    email = res.data.data.email;
                    password = res.data.data.password;
                    dashboard = res.data.data.dashboard;
                    floor = res.data.data.floor;
                    merchant = res.data.data.merchant;
                    product = res.data.data.product;
                    customer = res.data.data.customer;
                    stock = res.data.data.stock;
                    voucher = res.data.data.voucher;
                    advertisement = res.data.data.advertisement;
                    promotion = res.data.data.promotion;
                    manage_admin = res.data.data.manage_admin;
                    setting = res.data.data.setting;
                    mall = res.data.data.mall;
                    sales = res.data.data.sales;
                    transaction = res.data.data.transaction;
                    reports = res.data.data.reports;

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
                    axios.put('https://admin.globalshopping-mall.site/api/update_admin/' + id, {name:name, phone_no:phone_no, email:email, password:password, dashboard:dashboard, floor:floor, merchant:merchant, product:product, customer:customer, stock:stock, voucher:voucher, advertisement:advertisement, promotion:promotion, manage_admin:manage_admin, setting:setting, mall:mall, sales:sales, transaction:transaction, reports:reports, activation: activationCode}).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
            deletePost(id){
                console.log(id);
                axios.delete('https://admin.globalshopping-mall.site/api/admins/'+id)
                .then(res => {
                    console.log("deleted", res.data);
                }).catch(err => {console.log(err); });
            }
        }
    }
</script>

<style scoped>
    .pagination{
        margin-bottom: 0;
    }
</style>