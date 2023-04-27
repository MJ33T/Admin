<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" class="form-control" id="search_input" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:5%" data-toggle="modal" data-target="#addPostModal">Create New Shop</Button>
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
                                <th>Shop</th>
                                <th>Merchant</th>
                                <th>Selling Identity</th>
                                <th>Category</th>
                                <th>Floor</th>
                                <th>Mall</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='(item , index) in pagination' :key='index'>
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <td>{{item.shop_name}}</td>
                                <td>{{item.merchant_name}}</td>
                                <td>{{item.selling_identity}}</td>
                                <td>{{item.category}}</td>
                                <td>{{item.floor_name}}</td>
                                <td>{{item.mall_name}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button  class="btn text-white ml-3" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active/Deactive</button>
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
                    <h4 class="modal-title">Create New Shop for Othermall</h4>
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
                                    <input type="file" name="file"  v-on:change="handleFileUpload($event)" />
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">Shop</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="add.shop_name">
                                    </div>
                                    <div class="col-sm-3 mt-3">Merchant</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Brand</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.brand" v-on:click="brandSelect()">
                                                <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Category</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.category">
                                                <option>{{ add.category }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Floor</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.floor">
                                                <option>{{ add.floor }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Mall</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.mall">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Selling Identity</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.selling_identity">
                                                <option v-for="(selling_identity, index) in selling_identities" :key="index" v-bind:value="selling_identity.id">{{ selling_identity.selling_identity }}</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-sm-3 mt-3">City</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="add.city">
                                    </div>
                                    <div class="col-sm-3 mt-3">Free Shipping Minimum Amount</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="number" class="form-control" v-model="add.free_shipping_min_amount">
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <input type="checkbox" id="ship" name="ship" v-bind:value="1" v-model="add.free_shipping_for_all">
                                        <label for="ship">Free Shipping For All Product</label><br>
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
                    <h4 class="modal-title">Edit New Shop for Othermall</h4>
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
                                    <div class="col-sm-3">Shop</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="update.shop_name">
                                    </div>
                                    <div class="col-sm-3 mt-3">Merchant</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Brand</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.brand">
                                                <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Category</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.category">
                                                <option v-for="(category, index) in categories" :key="index" v-bind:value="category.id">{{ category.category }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Floor</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.floor">
                                                <option v-for="(floor, index) in floors" :key="index" v-bind:value="floor.id">{{ floor.floor_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Mall</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.mall">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">Selling Identity</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.selling_identity">
                                                <option v-for="(selling_identity, index) in selling_identities" :key="index" v-bind:value="selling_identity.id">{{ selling_identity.selling_identity }}</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-sm-3 mt-3">City</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="update.city">
                                    </div>
                                    <div class="col-sm-3 mt-3">Free Shipping Minimum Amount</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="number" class="form-control" v-model="update.free_shipping_min_amount">
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <input type="checkbox" id="ship" name="ship" v-bind:value="1" v-model="update.free_shipping_for_all">
                                        <label for="ship">Free Shipping For All Product</label><br>
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
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" @click="updatePost()">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Modal -->
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
                                                <th>Shop</th>
                                                <th>Merchant</th>
                                                <th>Selling Identity</th>
                                                <th>Category</th>
                                                <th>Floor</th>
                                                <th>Mall</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in search_list.data' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.shop_name}}</td>
                                                <td>{{item.merchant_name}}</td>
                                                <td>{{item.selling_identity}}</td>
                                                <td>{{item.category}}</td>
                                                <td>{{item.floor_name}}</td>
                                                <td>{{item.mall_name}}</td>
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
                                                <th>Shop</th>
                                                <th>Merchant</th>
                                                <th>Selling Identity</th>
                                                <th>Category</th>
                                                <th>Floor</th>
                                                <th>Mall</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in activate_data' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.shop_name}}</td>
                                                <td>{{item.merchant_name}}</td>
                                                <td>{{item.selling_identity}}</td>
                                                <td>{{item.category}}</td>
                                                <td>{{item.floor_name}}</td>
                                                <td>{{item.mall_name}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button  class="btn text-white ml-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
            this.fetchothermall();
            this.fetchMerchant();
            this.fetchBrand();
            this.fetchCategory();
            this.fetchFloor();
            this.fetchMall();
            this.fetchSellingIdentity();
        },

        components: {
            VueTailwindPagination,
        },
       
        data(){
            return {
                list:[],
                merchants:[],
                brands:[],
                categories:[],
                floors:[],
                malls:[],
                selling_identities:[],
                search_list: [],
                search_name: "",
                activate_data: [],
                add: {
                    id: "",
                    image:"",
                    shop_name: "",
                    merchant: "",
                    brand: "",
                    category: "",
                    category_id: "",
                    floor: "",
                    floor_id: "",
                    mall:"",
                    selling_identity: "",
                    city:"",
                    free_shipping_min_amount: 0,
                    free_shipping_for_all:"",
                    activation:""
                },
                update: {
                    id: "",
                    image: "",
                    view_image: "",
                    shop_name: "",
                    merchant: "",
                    brand: "",
                    category: "",
                    floor: "",
                    mall:"",
                    selling_identity:"",
                    city:"",
                    free_shipping_min_amount: 0,
                    free_shipping_for_all:"",
                    activation:"",
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
            fetchothermall(){
                axios.get('https://admin.globalshopping-mall.site/api/other_malls')
                .then(res => {
                    this.list = res.data;
                    this.total = res.data.data.length;
                    this.pageChange(this.currentPage);
                    //console.log("List before filter = ", this.list);
                }).catch(err => {console.log(err);});
            },

            fetchMerchant(){
                axios.get('https://admin.globalshopping-mall.site/api/merchants')
                .then(res => {
                    this.merchants = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/brands')
                .then(res => {
                    this.brands = res.data.data;
                    // console.log(this.brands);
                }).catch(err => {console.log(err);});
            },

            fetchCategory(){
                axios.get('https://admin.globalshopping-mall.site/api/product_categories')
                .then(res => {
                    this.categories = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchFloor(){
                axios.get('https://admin.globalshopping-mall.site/api/floors')
                .then(res => {
                    this.floors = res.data.data;
                    // console.log(this.floors)
                }).catch(err => {console.log(err);});
            },

            fetchMall(){
                axios.get('https://admin.globalshopping-mall.site/api/malls')
                .then(res => {
                    this.malls = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchSellingIdentity(){
                axios.get('https://admin.globalshopping-mall.site/api/selling_identities')
                .then(res => {
                    this.selling_identities = res.data.data;
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

            brandSelect(){
                let i = 0;
                for(i=0; i<this.brands.length; i++){
                    if(this.brands[i].id == this.add.brand){
                        this.add.category = this.brands[i].category;
                        
                    }
                }
                // console.log(this.categories);
                for(i=0; i<this.categories.length; i++){
                    if(this.categories[i].category == this.add.category){
                        this.add.floor = this.categories[i].floor_name;
                    }
                }
                // console.log(this.add.floor);
            },

            find(){ 
                console.log(this.search_name)
                axios.get('https://admin.globalshopping-mall.site/api/search_other_mall/'+this.search_name)
                .then(res => {
                    console.log("HI");
                    this.search_list = res.data;
                    console.log(this.search_list)
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
                const fileName = "OtherMallShop";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            csvExport(){
                // console.log(this.list.data)
                const data = this.list.data;
                const fileName = "OtherMallShop";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            addPost(){
                let i=0;
                let free;
                
                if(this.add.shop_name == '' || this.add.image == ''){
                    return alert("Please fill-up all the fields");
                }
                for(i=0; i<this.categories.length; i++){
                    if(this.categories[i].category == this.add.category){
                        this.add.category_id = this.categories[i].id;
                    }
                }
                for(i=0; i<this.floors.length; i++){
                    if(this.floors[i].floor_name == this.add.floor){
                        this.add.floor_id = this.floors[i].id;
                    }
                }
                
                if(this.add.free_shipping_for_all == true){
                    this.add.free_shipping_for_all = 1;
                }
                else{
                    this.add.free_shipping_for_all = 0;
                }
                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('shop_name', this.add.shop_name);
                formData.append('merchant', this.add.merchant);
                formData.append('brand', this.add.brand);
                formData.append('category', this.add.category_id);
                formData.append('floor', this.add.floor_id);
                formData.append('mall', this.add.mall);
                formData.append('selling_identity', this.add.selling_identity);
                formData.append('city', this.add.city);
                formData.append('free_shipping_min_amount', this.add.free_shipping_min_amount);
                formData.append('free_shipping_for_all', this.add.free_shipping_for_all);
                formData.append('activation', this.add.activation);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                // console.log(this.add)
                axios.post('https://admin.globalshopping-mall.site/api/create_other_mall', formData, config)
                .then(res => {
                    if(res.status == 201){
                                       
                        location.reload();
                    }
                }).catch(error => { console.log(error);});
            },
            editPost(id){
                // console.log(res.data.data);
                let i = 0;
                axios.get('https://admin.globalshopping-mall.site/api/single_other_mall/'+id)
                .then(res => {
                    // console.log(res.data.data);
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            this.update.merchant = this.merchants[i].id;
                        }
                    }
                    for(i=0; i<this.categories.length; i++){
                        if(this.categories[i].category == res.data.data[0].category){
                            this.update.category = this.categories[i].id;
                        }
                    }
                    for(i=0; i<this.floors.length; i++){
                        if(this.floors[i].floor_name == res.data.data[0].floor_name){
                            this.update.floor = this.floors[i].id;
                        }
                    }
                    for(i=0; i<this.brands.length; i++){
                        if(this.brands[i].brand == res.data.data[0].brand){
                            this.update.brand = this.brands[i].id;
                        }
                    }
                    for(i=0; i<this.malls.length; i++){
                        if(this.malls[i].mall_name == res.data.data[0].mall_name){
                            this.update.mall = this.malls[i].id;
                        }
                    }
                    for(i=0; i<this.selling_identities.length; i++){
                        if(this.selling_identities[i].selling_identities == res.data.data[0].selling_identities){
                            this.update.selling_identity = this.selling_identities[i].id;
                        }
                    }
                    this.update.id = res.data.data[0].id;
                    this.update.image = res.data.data[0].image;
                    this.update.view_image = res.data.data[0].image;
                    this.update.shop_name = res.data.data[0].shop_name
                    this.update.free_shipping_min_amount = res.data.data[0].free_shipping_min_amount
                    if(res.data.data[0].free_shipping_for_all == 1){
                        this.update.free_shipping_for_all = true;
                    }
                    else if(res.data.data[0].free_shipping_for_all == 0){
                        this.update.free_shipping_for_all = false;
                    }
                    this.update.city = res.data.data[0].city
                    this.update.activation = res.data.data[0].activation
                    
                }).catch(error => {console.log(error);});
            },
            updatePost(){
                // console.log(this.update)
                if(this.update.free_shipping_for_all == true){
                    this.update.free_shipping_for_all = 1
                }
                else if(this.update.free_shipping_for_all == false){
                    this.update.free_shipping_for_all = 0
                }
                let formData = new FormData();
                formData.append('image', this.update.image);
                formData.append('shop_name', this.update.shop_name);
                formData.append('merchant', this.update.merchant);
                formData.append('brand', this.update.brand);
                formData.append('category', this.update.category);
                formData.append('floor', this.update.floor);
                formData.append('mall', this.update.mall);
                formData.append('selling_identity', this.update.selling_identity);
                formData.append('city', this.update.city);
                formData.append('free_shipping_min_amount', this.update.free_shipping_min_amount);
                formData.append('free_shipping_for_all', this.update.free_shipping_for_all);
                formData.append('activation', this.update.activation);
                formData.append('_method', this.update._method);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/update_other_mall/'+this.update.id, formData, config)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },
            activation(id){
                let activationCode;
                let shop_name;
                let merchant;
                let brand;
                let category;
                let floor;
                let mall;
                let selling_identity;
                let city;
                let free_shipping_min_amount;
                let free_shipping_for_all;
                let i = 0;

                axios.get('https://admin.globalshopping-mall.site/api/single_other_mall/'+id)
                .then(res => {
                    console.log(res.data.data);
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            merchant = this.merchants[i].id;
                        }
                    }
                    for(i=0; i<this.categories.length; i++){
                        if(this.categories[i].category == res.data.data[0].category){
                            category = this.categories[i].id;
                        }
                    }
                    for(i=0; i<this.floors.length; i++){
                        if(this.floors[i].floor_name == res.data.data[0].floor_name){
                            floor = this.floors[i].id;
                        }
                    }
                    for(i=0; i<this.brands.length; i++){
                        if(this.brands[i].brand == res.data.data[0].brand){
                            brand = this.brands[i].id;
                        }
                    }
                    for(i=0; i<this.malls.length; i++){
                        if(this.malls[i].mall_name == res.data.data[0].mall_name){
                            mall = this.malls[i].id;
                        }
                    }
                    for(i=0; i<this.selling_identities.length; i++){
                        if(this.selling_identities[i].selling_identities == res.data.data[0].selling_identities){
                            selling_identity = this.selling_identities[i].id;
                        }
                    }
                    shop_name = res.data.data[0].shop_name
                    free_shipping_min_amount = res.data.data[0].free_shipping_min_amount
                    free_shipping_for_all = res.data.data[0].free_shipping_for_all
                    city = res.data.data[0].city

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
                    axios.put('https://admin.globalshopping-mall.site/api/update_other_mall/'+id,{
                        merchant: merchant,
                        shop_name: shop_name,
                        free_shipping_min_amount: free_shipping_min_amount,
                        free_shipping_for_all: free_shipping_for_all,
                        city: city,
                        selling_identity: selling_identity,
                        mall: mall,
                        brand: brand,
                        floor: floor,
                        category: category,
                        activation: activationCode
                    }).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})

                
            },
        }
    }
</script>