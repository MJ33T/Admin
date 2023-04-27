<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" id="search_input" class="form-control" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:4%" data-toggle="modal" data-target="#addPostModal">Create Sub Brand</Button>
        </div>
        <div class="d-flex mt-4 mb-2">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Status</button>
                <div class="dropdown-menu">
                <p class="dropdown-item" id="active" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="active_data()">Active</p>
                <p class="dropdown-item" id="deactive" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="deactive_data()">Deactive</p>
                <!-- <a class="dropdown-item" href="#" >Deactive</a> -->
                </div>
            </div>
            <!-- <button class="btn btn-secondary ml-2 mb-2">Calendar</button> -->
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle ml-2" data-toggle="dropdown">Export</button>
                <div class="dropdown-menu">
                    <p class="dropdown-item" id="excel" style="cursor: pointer;" @click="excelExport">EXCEl</p>
                    <p class="dropdown-item" id="csv" style="cursor: pointer;" @click="csvExport">CSV</p>

                <!-- <a class="dropdown-item" href="#" >Deactive</a> -->
                </div>
            </div>  
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="subBrandTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Brand</th>
                                <th>Sub Brand</th>
                                <th>Merchant</th>
                                <th>Shop</th>
                                <th>Activation</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in pagination' :key='item.id'>
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <td>{{item.category}}</td>
                                <td>{{item.product_name}}</td>
                                <td>{{item.brand}}</td>
                                <td>{{item.sub_brand}}</td>
                                <td>{{item.merchant_name}}</td>
                                <td>{{item.shop_name}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td style="text-align:center">
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button class="btn text-white ml-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activationUpdate(item.id);">Active / Deactive</button>
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
        <!-- Create Sub Brand Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Sub Brand</h4>
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
                                    <input type="file" id="file_add" ref="add_file1" v-on:change="handleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png"/>
                                    </label>
                                    <input type="file" id="file_add" ref="add_file2" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png"/>
                                    </label>
                                    <input type="file" id="file_add" ref="add_file3" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png"/>
                                    </label>
                                    <input type="file" id="file_add" ref="add_file4" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png"/>
                                    </label>
                                    <input type="file" id="file_add" ref="add_file5" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Uploadvdo.png"/>
                                    </label>
                                    <input type="file" id="file_add" ref="add_file6" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                            <!-- <input type="file" id="file" ref="files" v-for="index in 6" :key="index" v-on:change="handleFileUpload (index)"/> -->
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Sub Brand</div>
                            <div class="col-sm-7 mt-3">
                                <input type="text" class="form-control" name="" id="" v-model="sub_brand">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3"> Brand</div>
                            <div class="col-sm-7 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="brand">
                                        <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-2">Category</div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <select class="form-control" v-model="category">
                                        <option v-for="(category, index) in categories" :key="index" v-bind:value="category.id">{{ category.category }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">Merchant</div>
                            <div class="col-sm-7" >
                                <div class="form-group">
                                    <select class="form-control" v-model="merchant">
                                        <option v-for='(merchant , index) in merchants' :key='index' v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-2">Add Variation</div>
                            <div class="col-sm-8" >
                                <div class="form-group" v-for="(input,k) in variation" :key="k">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" v-model="input.name">
                                        </div>
                                        <div class="col-sm-1">
                                            <span>
                                                <button class="btn btn-danger" @click="remove(k)" v-show="k || ( !k && variation.length > 1)">-</button> 
                                            </span>
                                        </div>
                                        <div class="col-sm-1">
                                            <span>
                                                <button class="btn btn-success" @click="add(k)" v-show="k == variation.length-1">+</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>    
                            <!-- <div class="col-sm-2">Description</div>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" v-model="add.description"></textarea>
                            </div> -->
                        <div class="row">
                            <div class="col-sm-2 mt-3">Activation</div>
                            <div class="col-sm-10 mt-3">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio" v-bind:value="1" v-model="activation">Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio" v-bind:value="0" v-model="activation">No
                                    </label>
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

        <!-- Edit Sub Brand Modal -->
        <div class="modal fade" id="editPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Sub Brand</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file1)" alt="image" style="width:50%; height: 50%">
                                    </label>
                                    <input type="file" id="file" ref="file1" v-on:change="UpdatehandleFileUpload"  />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file2)" alt="image" style="width:50%; height: 50%">
                                    </label>
                                    <input type="file" id="file" ref="file2" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file3)" alt="image" style="width:50%; height: 50%">
                                    </label>
                                    <input type="file" id="file" ref="file3" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file4)" alt="image" style="width:50%; height: 50%">
                                    </label>
                                    <input type="file" id="file" ref="file4" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file5)" alt="image" style="width:50%; height: 50%">
                                    </label>
                                    <input type="file" id="file" ref="file5" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file6)" alt="image" style="width:50%; height: 50%" >
                                    </label>
                                    <input type="file" id="file" ref="file6" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <!-- <input type="file" id="file" ref="files" v-for="index in 6" :key="index" v-on:change="handleFileUpload (index)"/> -->
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Sub Brand</div>
                            <div class="col-sm-7 mt-3">
                                <input type="text" class="form-control" name="" id="" v-model="update_sub_brand">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3"> Brand</div>
                            <div class="col-sm-7 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update_brand">
                                        <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-2">Category</div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <select class="form-control" v-model="update_category">
                                        <option v-for="(category, index) in categories" :key="index" v-bind:value="category.id">{{ category.category }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">Merchant</div>
                            <div class="col-sm-7" >
                                <div class="form-group">
                                    <select class="form-control" v-model="update_merchant">
                                        <option v-for='(merchant , index) in merchants' :key='index' v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-2">Add Variation</div>
                            <div class="col-sm-8" >
                                <div class="form-group" v-for="(input,k) in update_variation" :key="k">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" v-model="input.name">
                                        </div>
                                        <div class="col-sm-1">
                                            <span>
                                                <!-- <button class="btn btn-danger" @click="update_remove(k)" v-show="k || ( !k && update_variation.length > 1)">-</button>  -->
                                            </span>
                                        </div>
                                        <div class="col-sm-1">
                                            <span>
                                                <button class="btn btn-success" @click="update_add(k)" v-show="k == update_variation.length-1">+</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>    
                            <!-- <div class="col-sm-2">Description</div>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" v-model="add.description"></textarea>
                            </div> -->
                        <div class="row">
                            <div class="col-sm-2 mt-3">Activation</div>
                            <div class="col-sm-10 mt-3">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio" v-bind:value="1" v-model="update_activation">Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="addradio" v-bind:value="0" v-model="update_activation">No
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
                                    <table id="subBrandTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Brand</th>
                                                <th>Sub Brand</th>
                                                <th>Merchant</th>
                                                <th>Shop</th>
                                                <th>Activation</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in search_list' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.category}}</td>
                                                <td>{{item.product_name}}</td>
                                                <td>{{item.brand}}</td>
                                                <td>{{item.sub_brand}}</td>
                                                <td>{{item.merchant_name}}</td>
                                                <td>{{item.shop_name}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td style="text-align:center">
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white mt-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activationUpdate(item.id);">Active / Deactive</button>
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
        <!-- Active / Deactive Modal -->
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
                                    <table id="subBrandTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Brand</th>
                                                <th>Sub Brand</th>
                                                <th>Merchant</th>
                                                <th>Shop</th>
                                                <th>Activation</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in activate_data' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.category}}</td>
                                                <td>{{item.product_name}}</td>
                                                <td>{{item.brand}}</td>
                                                <td>{{item.sub_brand}}</td>
                                                <td>{{item.merchant_name}}</td>
                                                <td>{{item.shop_name}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td style="text-align:center">
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white mt-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activationUpdate(item.id);">Active / Deactive</button>
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
    import exportFromJSON from "export-from-json"; 
    export default {
        mounted() {
            this.fetchSubBrand();
            this.fetchCategory();
            this.fetchBrand();
            this.fetchNewShop();
            this.fetchMerchant();
            this.fetchProduct();
            // this.getResults(); //pagination result
        },

        components: {
            VueTailwindPagination,
        },

        data(){
            return {
                list:[],
                products:[],
                shops:[],
                merchants:[],
                categories:[],
                floors: [],
                brands:[],
                search_list: [],
                search_name: "",
                activate_data: [],
                fetch_update_variation:[],

                id: "",
                GUID:"",
                file1:"",
                file2:"",
                file3:"",
                file4:"",
                file5:"",
                file6:"",
                category: "",
                brand: "",
                sub_brand: "",
                admin_approval: "",
                activation: "",
                product: "",
                merchant: "",
                shop: "", 
                variation:[
                    {
                        name:""
                    }
                ],

                update_id: "",
                update_GUID: "",
                update_file1:"",
                update_file2:"",
                update_file3:"",
                update_file4:"",
                update_file5:"",
                update_file6:"",
                update_view_file1:"",
                update_view_file2:"",
                update_view_file3:"",
                update_view_file4:"",
                update_view_file5:"",
                update_view_file6:"",
                update_category:"",
                update_brand: "",
                update_sub_brand: "",
                update_admin_approval: "",
                update_activation: "",
                update_product: "",
                update_merchant: "",
                update_shop: "",
                _method: "PUT", 
                update_variation:[
                    {
                        id: "",
                        GUID: "",
                        name:""
                    }
                ],
                currentPage: 1,
                total: "",
                perPage: 4,
                pagination: [] 
            }
        },
        methods:{

            fetchSubBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/sub_brands')
                .then(res => {
                    this.list = res.data;
                    this.total = res.data.data.length;
                    this.pageChange(this.currentPage);
                }).catch(err => {console.log(err);});
            },

            add(index) {
                this.variation.push({ name: '' });
            },
            remove(index) {
                this.variation.splice(index, 1);
            },
            update_add(index){
                this.update_variation.push({ name: '' });
            },
            update_remove(index) {
                this.update_variation.splice(index, 1);
            },
            

            fetchCategory(){
                axios.get('https://admin.globalshopping-mall.site/api/product_categories')
                .then(res => {
                    this.categories = res.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },

            fetchBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/brands')
                .then(res => {
                    this.brands = res.data.data;
                    // console.log(res.data)
                }).catch(err => {
                    console.log(err);
                });
            },

            fetchNewShop(){
                axios.get('https://admin.globalshopping-mall.site/api/new_shops')
                .then(res => {
                    this.shops = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchProduct(){
                axios.get('https://admin.globalshopping-mall.site/api/products')
                .then(res => {
                    this.products = res.data.data;
                    // console.log(this.products_name_list);
                    
                }).catch(err => {console.log(err);});
            },

            fetchMerchant(){
                axios.get('https://admin.globalshopping-mall.site/api/merchants')
                .then(res => {
                    this.merchants = res.data.data;
                    // console.log(this.merchants_name_list);
                }).catch(err => {console.log(err);});
            },
            // fetchFloor(){
            //     axios.get('https://admin.globalshopping-mall.site/api/floors')
            //     .then(res => {
            //         this.floors = res.data.data;
            //         // console.log(this.merchants_name_list);
            //     }).catch(err => {console.log(err);});
            // },

            //Handles a change on the file upload
            handleFileUpload(res){
                // console.log(this);
                // this.files = this.$refs.files.files;
                this.file1 = this.$refs.add_file1.files[0];
                this.file2 = this.$refs.add_file2.files[0];
                this.file3 = this.$refs.add_file3.files[0];
                this.file4 = this.$refs.add_file4.files[0];
                this.file5 = this.$refs.add_file5.files[0];
                this.file6 = this.$refs.add_file6.files[0];
            },
            UpdatehandleFileUpload(res){
                // console.log(this);
                // this.files = this.$refs.files.files;
                this.update_file1 = this.$refs.file1.files[0];
                this.update_file2 = this.$refs.file2.files[0];
                this.update_file3 = this.$refs.file3.files[0];
                this.update_file4 = this.$refs.file4.files[0];
                this.update_file5 = this.$refs.file5.files[0];
                this.update_file6 = this.$refs.file6.files[0];
                
            },

            find(){ 
                // console.log(this.search_name)
                axios.get('https://admin.globalshopping-mall.site/api/search_sub_brand/'+this.search_name)
                .then(res => {
                    // console.log(res.data);
                    this.search_list = res.data.data;
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
                const fileName = "SubBrand";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            csvExport(){
                // console.log(this.list.data)
                const data = this.list.data;
                const fileName = "SubBrand";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });

            },
            

            addPost(){
                let i;
                if(this.file1 == null || this.file2 == null || this.file3 == null || this.file4 == null || this.file5 == null || this.file6 == null){
                    return alert("Please Add 6 Image");
                }

                //create GUID
                var dt = new Date().getTime();
                var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = (dt + Math.random()*16)%16 | 0;
                    dt = Math.floor(dt/16);
                    return (c=='x' ? r :(r&0x3|0x8)).toString(16);
                });

                for(i=0; i<this.brands.length; i++){
                    if(this.brands[i].id == this.brand){
                        this.product = this.brands[i].product_id;
                    }
                }
                
                this.GUID = uuid;
                this.shop = 1; 
                this.admin_approval = 1;
                let formData = new FormData();
                formData.append('GUID', this.GUID);
                formData.append('image', this.file1);
                formData.append('image1', this.file2);
                formData.append('image2', this.file3);
                formData.append('image3', this.file4);
                formData.append('image4', this.file5);
                formData.append('video', this.file6);
                formData.append('category', this.category);
                formData.append('product', this.product);
                formData.append('brand', this.brand);
                formData.append('sub_brand', this.sub_brand);
                formData.append('merchant', this.merchant);
                formData.append('shop', this.shop);
                formData.append('admin_approval', this.admin_approval)
                formData.append('activation', this.activation);
                
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                
                axios.post('https://admin.globalshopping-mall.site/api/create_sub_brand', formData, config)
                .then(res => {
                    this.variation.forEach(element => {
                        //console.log(element.name);
                        axios.post('https://admin.globalshopping-mall.site/api/create_sub_brand_variation', {GUID:this.GUID, name:element.name})
                        .then(res => {
                            if(res.status == 201){
                                location.reload();
                            }
                        }).catch(err => {console.log(err);});
                    });
                }).catch(error => {console.log(error);});
            },

            editPost(id){
                let i = 0;
                let temp;
                axios.get('https://admin.globalshopping-mall.site/api/single_sub_brand/'+id)
                .then(res => {
                    
                    // console.log(this.products)
                    // console.log(res.data.data)
                    for(i=0; i<this.shops.length; i++){
                        if(this.shops[i].shop_name == res.data.data[0].shop_name){
                            this.update_shop = this.shops[i].id;
                            
                        }
                    }
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            this.update_merchant = this.merchants[i].id;
                        }
                    }
                    for(i=0; i<this.brands.length; i++){
                        if(this.brands[i].brand == res.data.data[0].brand){
                            this.update_brand = this.brands[i].id;
                        }
                    }
                    for(i=0; i<this.brands.length; i++){
                        if(this.brands[i].id == this.update_brand){
                            this.update_product = this.brands[i].product_id;
                        }
                    }
                    // console.log(this.update_brand)
                    for(i=0; i<this.categories.length; i++){
                        if(this.categories[i].category == res.data.data[0].category){
                            this.update_category = this.categories[i].id;
                        }
                    }
                    
                    this.update_id = res.data.data[0].id,
                    this.update_GUID = res.data.data[0].GUID;
                    this.update_sub_brand = res.data.data[0].sub_brand,
                    this.update_activation = res.data.data[0].activation,
                    this.update_admin_approval = res.data.data[0].admin_approval,
                    this.update_view_file1 = res.data.data[0].image
                    this.update_view_file2 = res.data.data[0].image1
                    this.update_view_file3 = res.data.data[0].image2
                    this.update_view_file4 = res.data.data[0].image3
                    this.update_view_file5 = res.data.data[0].image4
                    this.update_view_file6 = res.data.data[0].video
               

                    // console.log(this.update_view_file1);
                }).then(res => {
                    axios.get('https://admin.globalshopping-mall.site/api/sub_brand_variations/'+this.update_GUID)
                    .then(res => {
                        this.update_variation = res.data.data;  
                    }).catch(err => {console.log(err);})
                }).catch(err => {console.log(err);})
                .catch(error => {console.log(error);});
            },

            updatePost(){
                // console.log(this.update_variation)
                // console.log(this.fetch_update_variation)

                let formData = new FormData();
                formData.append('GUID', this.update_GUID);
                formData.append('image', this.update_file1);
                formData.append('image1', this.update_file2);
                formData.append('image2', this.update_file3);
                formData.append('image3', this.update_file4);
                formData.append('image4', this.update_file5);
                formData.append('video', this.update_file6);
                formData.append('category', this.update_category);
                formData.append('product', this.update_product);
                formData.append('brand', this.update_brand);
                formData.append('sub_brand', this.update_sub_brand);
                formData.append('merchant', this.update_merchant);
                formData.append('shop', this.update_shop);
                formData.append('admin_approval', this.update_admin_approval)
                formData.append('activation', this.update_activation);
                formData.append('_method', this._method);
                
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                console.log(this.update_GUID);
                
                axios.post('https://admin.globalshopping-mall.site/api/update_sub_brand/' + this.update_id, formData, config)
                .then(res => {
                    // console.log(this.update_variation);
                    this.update_variation.forEach(element => {
                        // console.log(element.name, element.GUID, element.id);
                        if(element.id == null){
                            axios.post('https://admin.globalshopping-mall.site/api/create_sub_brand_variation', {GUID:this.update_GUID, name:element.name})
                            .catch(err => {console.log(err);});
                        } 
                        
                        axios.put('https://admin.globalshopping-mall.site/api/update_sub_brand_variation/'+element.id, {name:element.name})
                        .then(res => {
                            axios.get('https://admin.globalshopping-mall.site/api/single_sub_brand_detail/'+ this.update_GUID)
                            .then(res => {
                                if(res.data.data != null){
                                    let formDataTwo = new FormData();
                                    let custom_config = 
                                    {
                                        headers: {
                                            'Content-Type': 'multipart/form-data',
                                        }
                                    }
                                    
                                    
                                    formDataTwo.append('image', this.update_file1);
                                    formDataTwo.append('image1', this.update_file2);
                                    formDataTwo.append('image2', this.update_file3);
                                    formDataTwo.append('image3', this.update_file4);
                                    formDataTwo.append('image4', this.update_file5);
                                    formDataTwo.append('video', this.update_file6);
                                    formDataTwo.append('_method', this._method);

                                    axios.post('https://admin.globalshopping-mall.site/api/update_sub_brand_detail_image/'+res.data.data[0].id, formDataTwo, custom_config)
                                    .then(res =>{
                                        if(res.status == 200){
                                            location.reload();
                                        }
                                    });
                                }
                            }).catch(err => {console.log(err);});
                            
                        }).catch(err => {console.log(err);}); 
                    });
                }).catch(err => {console.log(err);});
            },
            activationUpdate(id){
                let i = 0;
                let activationCode;
                let GUID;
                let category;
                let product;
                let brand;
                let sub_brand;
                let merchant;
                let shop;
                let floor;
                let admin_approval;
                axios.get('https://admin.globalshopping-mall.site/api/single_sub_brand/'+id)
                .then(res => {
                    console.log(res.data.data);
                    for(i=0; i<this.shops.length; i++){
                        if(this.shops[i].shop_name == res.data.data[0].shop_name){
                            shop = this.shops[i].id;
                                 
                        }
                    }
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            merchant = this.merchants[i].id;  
                        }
                    }
                    for(i=0; i<this.products.length; i++){
                        if(this.products[i].product_name == res.data.data[0].product_name){
                            product = this.products[i].id;
                        }
                    }
                    for(i=0; i<this.brands.length; i++){
                        if(this.brands[i].brand == res.data.data[0].brand){
                            brand = this.brands[i].id;
                        }
                    }
                    for(i=0; i<this.categories.length; i++){
                        if(this.categories[i].category == res.data.data[0].category){
                            category = this.categories[i].id;
                        }
                    }
                    // console.log(brand);
                    GUID = res.data.data[0].GUID;
                    sub_brand = res.data.data[0].sub_brand;
                    admin_approval = res.data.data[0].admin_approval;
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
                    axios.put('https://admin.globalshopping-mall.site/api/update_sub_brand/' + id, {
                        GUID:GUID, category:category, 
                        product:product, 
                        brand:brand, 
                        sub_brand:sub_brand, 
                        merchant:merchant, 
                        shop:shop,
                        admin_approval: admin_approval, 
                        activation:activationCode
                    }).then(res => {
                        if(res.status == 200){
                            location.reload();
                        }
                    }).catch(err => {console.log(err);})
                }).catch(err => {console.log(err)})
               
            },
        }
    }
</script>
