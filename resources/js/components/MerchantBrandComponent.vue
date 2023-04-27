
<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" class="form-control" id="search_input" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:7%" data-toggle="modal" data-target="#addPostModal">Create Brand</Button>
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
                                <th>Product</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Merchant</th>
                                <th>Shop</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='(item , index) in pagination' :key='index'>
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <td>{{item.product_name}}</td>
                                <td>{{item.category}}</td>
                                <td>{{item.brand}}</td>
                                <td>{{item.merchant_name}}</td>
                                <td>{{item.shop_name}}</td>
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
                    <h4 class="modal-title">Create Brand</h4>
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
                                    <div class="col-sm-2">Brand Name</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="add.brand">
                                    </div>
                                    <!-- <div class="col-sm-2 mt-3">Merchant</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="add.merchant">
                                        <option class="form-control"  v-for='(items , index) in merchants_name_list' :key='index' :value="items.id">{{ items.merchant_name }}</option>
                                        </select>
                                    </div> -->
                                    <div class="col-sm-2 mt-3">Shop</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="add.shop">
                                        <option class="form-control"  v-for='(items , index) in shops_name_list' :key='index' :value="items.id">{{ items.shop_name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mt-3">Product</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="add.product" v-on:click="productSelect()">
                                        <option class="form-control"  v-for='(items , index) in products_name_list' :key='index' :value="items.id">{{ items.product_name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mt-3">Category</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="add.category" disabled>
                                        <option class="form-control"  >{{ add.category }}</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-2 mt-3">Floor</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="add.floor" disabled>
                                        <option class="form-control">{{ add.floor }}</option>
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
        <div class="modal fade" id="editPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Brand</h4>
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
                                    <div class="col-sm-2">Brand Name</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="update.brand">
                                    </div>
                                    <!-- <div class="col-sm-2 mt-3">Merchant</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="update.merchant">
                                        <option class="form-control"  v-for='(merchant , index) in merchants_name_list' :key='index' :value="merchant.id"  >{{ merchant.merchant_name }}</option>
                                        </select>
                                    </div> -->
                                    <div class="col-sm-2 mt-3">Shop</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="update.shop">
                                        <option class="form-control"  v-for='(shop , index) in shops_name_list' :key='index' :value="shop.id">{{ shop.shop_name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mt-3">Product</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="update.product">
                                        <option class="form-control"  v-for='(items , index) in products_name_list' :key='index' :value="items.id">{{ items.product_name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mt-3">Category</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="update.category" >
                                        <option class="form-control"  v-for='(items , index) in category_name_list' :key='index' :value="items.id">{{ items.category }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mt-3">Floor</div>
                                    <div class="col-sm-10 mt-3" >
                                        <select class="form-control" v-model="update.floor" >
                                        <option class="form-control"  v-for='(items , index) in floors_name_list' :key='index' :value="items.id">{{ items.floor_name }}</option>
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
                    <button type="button" class="close" @click="refresh()" data-dismiss="modal">&times;</button>
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
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Merchant</th>
                                                <th>Shop</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in search_list' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.product_name}}</td>
                                                <td>{{item.category}}</td>
                                                <td>{{item.brand}}</td>
                                                <td>{{item.merchant_name}}</td>
                                                <td>{{item.shop_name}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Merchant</th>
                                                <th>Shop</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='(item , index) in activate_data' :key='index'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.product_name}}</td>
                                                <td>{{item.category}}</td>
                                                <td>{{item.brand}}</td>
                                                <td>{{item.merchant_name}}</td>
                                                <td>{{item.shop_name}}</td>
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
            this.loadSession();
            this.fetchBrand();
            this.fetchMerchant();
            this.fetchFloor();
            this.fetchProduct();
            this.fetchNewShop(); 
            this.fetchCategory();
            
        },

        components: {
            VueTailwindPagination,
        },

        data(){
            return {
                
                list:[],
                category_name_list:[],
                merchants_name_list:[],
                floors_name_list:[],
                products_name_list:[],
                shops_name_list:[],
                search_list: [],
                search_name: "",
                activate_data: [],
                session: [],
                merchant_sort: [],
                

                add: {
                    id: "",
                    image: "",
                    brand: "",
                    merchant: "",
                    shop: "",
                    product: "",
                    category_id: "",
                    floor_id: "",
                    category: "",
                    floor: "",
                    activation: ""
                },
                update: {
                    id: "",
                    image: "",
                    brand: "",
                    merchant: "",
                    shop: "",
                    category: "",
                    product: "",
                    view_image: "",
                    floor_id: "",
                    floor: "",
                    activation: "",
                    _method: "PUT"
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
            loadSession(){
                axios.get('merchat_session')
                .then( (response) => {
                    this.session = response.data.merchant.id;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            async fetchBrand(){
                let i = 0;
                let j = 0;
                axios.get('https://admin.globalshopping-mall.site/api/brands')
                .then(res => {
                    
                    // this.list = res.data;
                    // console.log(this.session);
                    this.merchant_sort = res.data.data
                    // console.log(this.merchant_sort);
                    for(i=0; i<this.merchant_sort.length; i++){
                        if(this.merchant_sort[i].merchant_id == this.session){
                            this.list[j] = this.merchant_sort[i];
                            j++;
                        }
                    }
                    // console.log(this.list);
                    this.total = this.list.length;
                    this.pageChange(this.currentPage);
                }).catch(err => {console.log(err);});
            },

            fetchMerchant(){
                axios.get('https://admin.globalshopping-mall.site/api/merchants')
                .then(res => {
                    this.merchants_name_list = res.data.data;
                    // console.log(this.merchants_name_list);
                }).catch(err => {console.log(err);});
            },

            fetchFloor(){
                axios.get('https://admin.globalshopping-mall.site/api/floors')
                .then(res => {
                    this.floors_name_list = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchProduct(){
                axios.get('https://admin.globalshopping-mall.site/api/products')
                .then(res => {
                    this.products_name_list = res.data.data;
                    // console.log(this.products_name_list);
                    
                }).catch(err => {console.log(err);});
            },

            fetchNewShop(){
                axios.get('https://admin.globalshopping-mall.site/api/new_shops')
                .then(res => {
                    this.shops_name_list = res.data.data;
                    // console.log(this.shops_name_list);
                    
                }).catch(err => {console.log(err);});
            },

            fetchCategory(){
                axios.get('https://admin.globalshopping-mall.site/api/product_categories')
                .then(res => {
                    // console.log(res.data.data)
                    this.category_name_list = res.data.data;
                    
                }).catch(err => {console.log(err);});
            },

            productSelect(){
                let i = 0;

                for(i=0; i<this.products_name_list.length; i++){
                    if(this.products_name_list[i].id == this.add.product){
                        this.add.category = this.products_name_list[i].category;
                        
                    }
                }
                for(i=0; i<this.category_name_list.length; i++){
                    if(this.category_name_list[i].category == this.add.category){
                        this.add.floor = this.category_name_list[i].floor_name;
                    }
                }
            },
            

            handleFileUpload(event){
                this.add.image = event.target.files[0];
                // console.log(this.add.image);
            },

            updatehandleFileUpload(event){
                this.update.image = event.target.files[0];
                // console.log(this.add.image);
            },

            find(){ 
                let i;
                let j=0;
                this.search_list = [];
                // console.log(this.search_name)
                axios.get('https://admin.globalshopping-mall.site/api/search_brand/'+this.search_name)
                .then(res => {
                    console.log(res.data.data);
                    // this.search_list = res.data;
                    for(i=0; i<res.data.data.length; i++){
                        if(res.data.data[i].merchant_id == this.session){
                            this.search_list[j] = res.data.data[i];
                            j++;
                            // console.log(this.search_list[j])
                        }
                    }
                    // console.log(this.search_list)
                }).catch(err => {console.log(err);});
            },

            refresh(){
                this.search_list = [];
                this.search_name = "";
            },

            pageChange(pageNumber){
                this.currentPage = pageNumber;
                let trimStart = (pageNumber - 1) * this.perPage;
                let trimEnd = (trimStart + this.perPage); 
                this.pagination = this.list.slice(trimStart, trimEnd);
                // console.log(this.pagination);
            },

            active_data(){
                let i = 0;
                let j = 0;
                this.activate_data = [];
                // console.log(this.list.data[1].activation)
                for(i=0; i<this.list.length; i++){
                    if(this.list[i].activation == 1){
                        this.activate_data[j] = this.list[i];
                        j++;
                    }
                }
            },

            deactive_data(){
                let i = 0;
                let j = 0;
                this.activate_data = [];
                // console.log(this.list.data[1].activation)
                for(i=0; i<this.list.length; i++){
                    if(this.list[i].activation == 0){
                        this.activate_data[j] = this.list[i];
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
                const data = this.list;
                const fileName = "Brand";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            csvExport(){
                // console.log(this.list.data)
                const data = this.list;
                const fileName = "Brand";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });

            },

            addPost(){
                let i=0;
                if(this.add.product == '' || this.add.category == ''){
                    return alert("Please fill-up all the fields");
                }
                for(i=0; i<this.category_name_list.length; i++){
                    if(this.category_name_list[i].category == this.add.category){
                        this.add.category_id = this.category_name_list[i].id;
                    }
                }

                for(i=0; i<this.floors_name_list.length; i++){
                    if(this.floors_name_list[i].floor_name == this.add.floor){
                        this.add.floor_id = this.floors_name_list[i].id;
                    }
                }
                
                // console.log(this.add.floor);
                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('product', this.add.product);
                formData.append('shop', this.add.shop);
                formData.append('brand', this.add.brand);
                formData.append('merchant', this.session);
                formData.append('category', this.add.category_id);
                formData.append('floor', this.add.floor_id);
                formData.append('activation', this.add.activation);
                // console.log(formData.entries);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                // console.log(formData.image);
                axios.post('https://admin.globalshopping-mall.site/api/create_brand', formData, config)
                    .then(res => { 
                    if(res.status == 201){
                        location.reload();
                    }
                }).catch(error => { console.log(error);});
            },

            editPost(id){
                let i = 0;
                axios.get('https://admin.globalshopping-mall.site/api/single_brand/'+id)
                .then(res => {
                    // console.log(res.data.data);
                    // console.log(this.list);
                    this.update.id = res.data.data[0].id;
                    this.update.image = res.data.data[0].image;
                    this.update.view_image = res.data.data[0].image;
                    this.update.brand = res.data.data[0].brand;
                    
                    for(i=0; i<this.products_name_list.length; i++){
                        if(this.products_name_list[i].product_name == res.data.data[0].product_name){
                            this.update.product = this.products_name_list[i].id;
                        }
                    }
                    for(i=0; i<this.shops_name_list.length; i++){
                        if(this.shops_name_list[i].shop_name == res.data.data[0].shop_name){
                            this.update.shop = this.shops_name_list[i].id;
                            console.log(this.update.shop)
                        }
                    }
                    for(i=0; i<this.merchants_name_list.length; i++){
                        if(this.merchants_name_list[i].merchant_name == res.data.data[0].merchant_name){
                            this.update.merchant = this.merchants_name_list[i].id;
                        }
                    }
                    for(i=0; i<this.category_name_list.length; i++){
                        if(this.category_name_list[i].category == res.data.data[0].category){
                            this.update.category = this.category_name_list[i].id;
                        }
                    }
                    for(i=0; i<this.floors_name_list.length; i++){
                        if(this.floors_name_list[i].floor_name == res.data.data[0].floor_name){
                            this.update.floor = this.floors_name_list[i].id;
                        }
                    }
                    this.update.activation = res.data.data[0].activation
                    // console.log(this.update);
                }).catch(error => {console.log(error);});
            },

            updatePost(){
                console.log(this.update);
                let formData = new FormData();
                formData.append('image', this.update.image);
                formData.append('product', this.update.product);
                formData.append('shop', this.update.shop);
                formData.append('brand', this.update.brand);
                formData.append('merchant', this.session);
                formData.append('category', this.update.category);
                formData.append('activation', this.update.activation);
                formData.append('floor', this.update.floor);
                formData.append('_method', this.update._method);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/update_brand/'+this.update.id, formData, config)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },

            activation(id){
                let activationCode;
                let brand;
                let category;
                let product;
                let merchant;
                let shop;
                let floor;
                let i = 0;
                // console.log(this.category_name_list);
                axios.get('https://admin.globalshopping-mall.site/api/single_brand/'+id)
                .then(res => {
                    
                    brand = res.data.data[0].brand;
                    for(i=0; i<this.products_name_list.length; i++){
                        if(this.products_name_list[i].product_name == res.data.data[0].product_name){
                            product = this.products_name_list[i].id;
                        }
                    }
                    for(i=0; i<this.shops_name_list.length; i++){
                        if(this.shops_name_list[i].shop_name == res.data.data[0].shop_name){
                            shop = this.shops_name_list[i].id;
                        }
                    }
                    // for(i=0; i<this.merchants_name_list.length; i++){
                    //     if(this.merchants_name_list[i].merchant_name == res.data.data[0].merchant_name){
                    //         merchant = this.merchants_name_list[i].id;
                    //     }
                    // }
                    for(i=0; i<this.category_name_list.length; i++){
                        if(this.category_name_list[i].category == res.data.data[0].category){
                            category = this.category_name_list[i].id;
                        }
                    }
                    for(i=0; i<this.floors_name_list.length; i++){
                        if(this.floors_name_list[i].floor_name == res.data.data[0].floor_name){
                            floor = this.floors_name_list[i].id;
                        }
                    }
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
                    axios.put('https://admin.globalshopping-mall.site/api/update_brand/' + id, {
                        brand: brand, 
                        product: product, 
                        shop: shop, 
                        merchant: this.session, 
                        category: category,
                        floor: floor, 
                        activation: activationCode
                        }).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
        }
            
    }
</script>
