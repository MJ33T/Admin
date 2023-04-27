<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" id="search_input" class="form-control" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:5%" data-toggle="modal" data-target="#addPostModal">Create Merchant</Button>
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
                    <p class="dropdown-item" id="pdf" style="cursor: pointer;" @click="pdfExport">PDF</p>
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
                                <th>Merchant</th>
                                <!-- <th>Shop</th> -->
                                <th>Mall</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='(item , index) in pagination' :key='index'>
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <td>{{item.merchant_name}}</td>
                                <!-- <td></td> -->
                                <td>{{(item.belongs_to == 1)? 'GSM' : 'Other Mall'}}</td>
                                <td>{{item.country}}</td>
                                <td>{{item.city}}</td>
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
                <div class="d-flex justify-content-end mt-5">
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
                    <h4 class="modal-title">Create Merchant</h4>
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
                                    <div class="col-sm-3">Merchant Name</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="add.merchant_name">
                                    </div>
                                    <div class="col-sm-3 mt-3">SSM Register No</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.ssm_no">
                                    </div>
                                    <div class="col-sm-3 mt-3">Contact</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" id="pri_phone" v-model="add.primary_contact_no" placeholder="Primary">
                                    </div>
                                    <div class="col-sm-3 mt-3"></div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" id="sec_phone" v-model="add.secondary_contact_no" placeholder="Secondary">
                                    </div>
                                    <div class="col-sm-3 mt-3">Email Address</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.email">
                                    </div>
                                    <div class="col-sm-3 mt-3">Address</div>
                                    <div class="col-sm-9 mt-3" >
                                        <!-- <input type="text" class="form-control" v-model="add.category"> -->
                                        <textarea class="form-control" id="" cols="30" rows="5" v-model="add.address"></textarea>
                                    </div>
                                    <div class="col-sm-3 mt-3">Zip/Postal Code</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.zip_code">
                                    </div>
                                    <div class="col-sm-3 mt-3">City</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.city">
                                    </div>
                                    <div class="col-sm-3 mt-3">State</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.state">
                                    </div>
                                    <div class="col-sm-3 mt-3">Country</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.country">
                                    </div>
                                    <div class="col-sm-3 mt-3">Bank Name</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.bank_name">
                                    </div>
                                    <div class="col-sm-3 mt-3">Account No</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="add.bank_acc_no">
                                    </div>
                                    <div class="col-sm-3 mt-3">Activation</div>
                                    <div class="col-sm-9 mt-3">
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
                        <div class="row">
                            <div class="col-sm-12">
                                <hr>
                                <h5 class="modal-title">Belongs to: </h5>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio_belong" v-bind:value="1" v-model="add.belongs_to">GSM Mall
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio_belong" v-bind:value="0" v-model="add.belongs_to">Other Mall
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="text" class="form-control"  v-model="add.belog_mall">
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
                    <h4 class="modal-title">Edit Merchant</h4>
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
                                    <input type="file" name="file"  v-on:change="updatehandleFileUpload($event)"/>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">Merchant Name</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="update.merchant_name">
                                    </div>
                                    <div class="col-sm-3 mt-3">SSM Register No</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.ssm_no">
                                    </div>
                                    <div class="col-sm-3 mt-3">Contact</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.primary_contact_no" placeholder="Primary">
                                    </div>
                                    <div class="col-sm-3 mt-3"></div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.secondary_contact_no" placeholder="Secondary">
                                    </div>
                                    <div class="col-sm-3 mt-3">Email Address</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.email">
                                    </div>
                                    <div class="col-sm-3 mt-3">Address</div>
                                    <div class="col-sm-9 mt-3" >
                                        <!-- <input type="text" class="form-control" v-model="add.category"> -->
                                        <textarea class="form-control" id="" cols="30" rows="5" v-model="update.address"></textarea>
                                    </div>
                                    <div class="col-sm-3 mt-3">Zip/Postal Code</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.zip_code">
                                    </div>
                                    <div class="col-sm-3 mt-3">City</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.city">
                                    </div>
                                    <div class="col-sm-3 mt-3">State</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.state">
                                    </div>
                                    <div class="col-sm-3 mt-3">Country</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.country">
                                    </div>
                                    <div class="col-sm-3 mt-3">Bank Name</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.bank_name">
                                    </div>
                                    <div class="col-sm-3 mt-3">Account No</div>
                                    <div class="col-sm-9 mt-3" >
                                        <input type="text" class="form-control" v-model="update.bank_acc_no">
                                    </div>
                                    <div class="col-sm-3 mt-3">Activation</div>
                                    <div class="col-sm-9 mt-3">
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
                        <div class="row">
                            <div class="col-sm-12">
                                <hr>
                                <h5 class="modal-title">Belongs to: </h5>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio_belong" v-bind:value="1" v-model="update.belongs_to">GSM Mall
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio_belong" v-bind:value="0" v-model="update.belongs_to">Other Mall
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="text" class="form-control"  v-model="update.belog_mall">
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
                                                <th>Merchant</th>
                                                <th>Shop</th>
                                                <th>Mall</th>
                                                <th>Country</th>
                                                <th>City</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in activate_data' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.merchant_name}}</td>
                                                <td></td>
                                                <td>{{(item.belongs_to == 1)? 'GSM' : 'Other Mall'}}</td>
                                                <td>{{item.country}}</td>
                                                <td>{{item.city}}</td>
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
            this.fetchMerchant();
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
                    image: "",
                    merchant_name: "",
                    ssm_no: "",
                    primary_contact_no: "",
                    secondary_contact_no: "",
                    email: "",
                    address: "",
                    zip_code: "",
                    city: "",
                    state: "",
                    country: "",
                    bank_name: "",
                    bank_acc_no: "",
                    belongs_to: "",
                    activation: ""
                },
                update: {
                    id: "",
                    image: "",
                    view_image:"",
                    merchant_name: "",
                    ssm_no: "",
                    primary_contact_no: "",
                    secondary_contact_no: "",
                    email: "",
                    address: "",
                    zip_code: "",
                    city: "",
                    state: "",
                    country: "",
                    bank_name: "",
                    bank_acc_no: "",
                    belongs_to: "",
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
            fetchMerchant(){
                axios.get('https://admin.globalshopping-mall.site/api/merchants')
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

            updatehandleFileUpload(event){
                this.update.image = event.target.files[0];
                // console.log(this.add.image);
            },

            pageChange(pageNumber){
                this.currentPage = pageNumber;
                let trimStart = (pageNumber - 1) * this.perPage;
                let trimEnd = (trimStart + this.perPage); 
                this.pagination = this.list.data.slice(trimStart, trimEnd);
                console.log(this.pagination);
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
                const fileName = "Merchant";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            csvExport(){
                // console.log(this.list.data)
                const data = this.list.data;
                const fileName = "Merchant";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            addPost(){
                if(this.add.merchant_name == '' || this.add.ssm_no == ''){
                    return alert("Please fill-up all the fields");
                }
                // console.log(this.add);
                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('merchant_name', this.add.merchant_name);
                formData.append('ssm_no', this.add.ssm_no);
                formData.append('primary_contact_no', this.add.primary_contact_no);
                formData.append('secondary_contact_no', this.add.secondary_contact_no);
                formData.append('email', this.add.email);
                formData.append('address', this.add.address);
                formData.append('zip_code', this.add.zip_code);
                formData.append('city', this.add.city);
                formData.append('state', this.add.state);
                formData.append('country', this.add.country);
                formData.append('bank_name', this.add.bank_name);
                formData.append('bank_acc_no', this.add.bank_acc_no);
                formData.append('belongs_to', this.add.belongs_to);
                formData.append('activation', this.add.activation);
                // console.log(formData.entries);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                // console.log(formData.image);
                axios.post('https://admin.globalshopping-mall.site/api/create_merchant', formData, config)
                    .then(res => { 
                    if(res.status == 201){
                        location.reload();
                    }
                }).catch(error => { console.log(error);});
            },

            editPost(id){
                let i = 0;  
                axios.get('https://admin.globalshopping-mall.site/api/single_merchant/'+id)
                .then(res => {
                    // console.log(res.data.data.city);
                    this.update.id = res.data.data.id,
                    this.update.image = res.data.data.image,
                    this.update.view_image = res.data.data.image,
                    this.update.merchant_name = res.data.data.merchant_name,
                    this.update.ssm_no = res.data.data.ssm_no,
                    this.update.primary_contact_no = res.data.data.primary_contact_no,
                    this.update.secondary_contact_no = res.data.data.secondary_contact_no,
                    this.update.email = res.data.data.email,
                    this.update.address = res.data.data.address,
                    this.update.zip_code = res.data.data.zip_code,
                    this.update.state = res.data.data.state,
                    this.update.country = res.data.data.country,
                    this.update.city = res.data.data.city,
                    this.update.bank_name = res.data.data.bank_name,
                    this.update.bank_acc_no = res.data.data.bank_acc_no,
                    this.update.belongs_to = res.data.data.belongs_to,
                    this.update.activation = res.data.data.activation
                    
                    // console.log(this.update.floor);
                }).catch(error => {console.log(error);});
            },

            updatePost(){
                console.log(this.update);
                let formData = new FormData();
                formData.append('image', this.update.image);
                formData.append('merchant_name', this.update.merchant_name);
                formData.append('ssm_no', this.update.ssm_no);
                formData.append('primary_contact_no', this.update.primary_contact_no);
                formData.append('secondary_contact_no', this.update.secondary_contact_no);
                formData.append('email', this.update.email);
                formData.append('address', this.update.address);
                formData.append('zip_code', this.update.zip_code);
                formData.append('city', this.update.city);
                formData.append('state', this.update.state);
                formData.append('country', this.update.country);
                formData.append('bank_name', this.update.bank_name);
                formData.append('bank_acc_no', this.update.bank_acc_no);
                formData.append('belongs_to', this.update.belongs_to);
                formData.append('activation', this.update.activation);
                formData.append('_method', this.update._method);
                // console.log(formData.entries);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/update_merchant/'+this.update.id, formData, config)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },

            activation(id){
                let activationCode;
                let merchant_name;
                let ssm_no;
                let primary_contact_no;
                let secondary_contact_no;
                let email;
                let address;
                let zip_code;
                let state;
                let country;
                let city;
                let bank_name;
                let bank_acc_no;
                let belongs_to;

                axios.get('https://admin.globalshopping-mall.site/api/single_merchant/'+id)
                .then(res => {
                    console.log(res.data.data);
                    merchant_name = res.data.data.merchant_name;
                    ssm_no = res.data.data.ssm_no;
                    primary_contact_no = res.data.data.primary_contact_no;
                    secondary_contact_no = res.data.data.secondary_contact_no;
                    email = res.data.data.email;
                    address = res.data.data.address;
                    zip_code = res.data.data.zip_code;
                    state = res.data.data.state;
                    country = res.data.data.country;
                    city = res.data.data.city;
                    bank_name = res.data.data.bank_name;
                    bank_acc_no = res.data.data.bank_acc_no;
                    belongs_to = res.data.data.belongs_to;

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
                    axios.put('https://admin.globalshopping-mall.site/api/update_merchant/' + id, {
                        activation: activationCode,
                        merchant_name: merchant_name,
                        ssm_no: ssm_no,
                        primary_contact_no: primary_contact_no,
                        secondary_contact_no: secondary_contact_no,
                        email:  email,
                        address:  address,
                        zip_code:  zip_code,
                        state: state,
                        country:  country,
                        city:  city,
                        bank_name:  bank_name,
                        bank_acc_no:  bank_acc_no,
                        belongs_to:  belongs_to,
                        }).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
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
</style>