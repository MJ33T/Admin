<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" class="form-control" id="search_input" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" data-toggle="modal" data-target="#addPostModal">Create Promotion/Update</Button>
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
                    <table id="promotionUpdateTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Brand</th>
                                <th>Sub Brand</th>
                                <th>Promotion Caption</th>
                                <th>Promotion By</th>
                                <th>Start Date</th>
                                <th>Expiry Date</th>
                                <th>Duration (days)</th>
                                <th>Activation</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in pagination' :key='item.id'>
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <td>{{item.brand}}</td>
                                <td>{{item.sub_brand}}</td>
                                <td>{{item.promotion_title}}</td>
                                <td>{{item.promotion_by}}</td>
                                <td>{{item.start_date}}</td>
                                <td>{{item.end_date}}</td>
                                <td >{{dayCalculate(item.start_date, item.end_date)+" Days"}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td style="text-align:center">
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button class="btn text-white ml-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
        <!-- Add New Promotion Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Promotion / Updates</h4>
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
                            <div class="col-sm-2">Promotion Caption</div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" v-model="add.promotion_title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Description</div>
                            <div class="col-sm-10 mt-3">
                                <textarea class="form-control" rows="5" v-model="add.description"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Start Date</div>
                            <div class="col-sm-4 mt-3">
                                <input type="date" class="form-control" v-model="add.start_date">
                            </div>
                            <div class="col-sm-1 mt-3">End Date</div>
                            <div class="col-sm-4 mt-3">
                                <input type="date" class="form-control" v-model="add.end_date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Url</div>
                            <div class="col-sm-8 mt-3">
                                <input type="text" class="form-control" v-model="add.url">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Merchant</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.merchant">
                                        <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-3">Shop</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.shop">
                                        <option v-for="(shop, index) in shops" :key="index" v-bind:value="shop.id">{{ shop.shop_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-3">Mall</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.mall">
                                        <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Brand</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.brand">
                                        <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-3">Sub Brand</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.sub_brand">
                                        <option v-for="(sub_brand, index) in sub_brands" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.sub_brand }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <div><h5><strong>Promotion By</strong></h5></div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input"  :value="this.gsm" v-model="add.promotion_by">GSM
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" :value="this.merchant" v-model="add.promotion_by">Merchant
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" :value="this.by_other_mall" v-model="add.promotion_by">By Other Mall
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="text" class="form-check-input" disabled>
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

        <!-- Edit Post Modal -->
        <div class="modal fade" id="editPostModal">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Promotion / Updates</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update.view_image)" style="width: 120px; height: 100px">
                                    </label>
                                    <input type="file" name="file"  v-on:change="updatehandleFileUpload($event)"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-2">Promotion Caption</div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" v-model="update.promotion_title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Description</div>
                            <div class="col-sm-10 mt-3">
                                <textarea class="form-control" rows="5" v-model="update.description"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Start Date</div>
                            <div class="col-sm-4 mt-3">
                                <input type="date" class="form-control" v-model="update.start_date">
                            </div>
                            <div class="col-sm-1 mt-3">End Date</div>
                            <div class="col-sm-4 mt-3">
                                <input type="date" class="form-control" v-model="update.end_date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Url</div>
                            <div class="col-sm-8 mt-3">
                                <input type="text" class="form-control" v-model="update.url">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Merchant</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.merchant">
                                        <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-3">Shop</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.shop">
                                        <option v-for="(shop, index) in shops" :key="index" v-bind:value="shop.id">{{ shop.shop_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-3">Mall</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.mall">
                                        <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-3">Brand</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.brand">
                                        <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-3">Sub Brand</div>
                            <div class="col-sm-2 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.sub_brand">
                                        <option v-for="(sub_brand, index) in sub_brands" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.sub_brand }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <div><h5><strong>Promotion By</strong></h5></div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input"  :value="this.gsm" v-model="update.promotion_by">GSM
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" :value="this.merchant" v-model="update.promotion_by">Merchant
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" :value="this.by_other_mall" v-model="update.promotion_by">By Other Mall
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="text" class="form-check-input" disabled>
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
                                    <table id="promotionUpdateTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Brand</th>
                                                <th>Sub Brand</th>
                                                <th>Promotion Caption</th>
                                                <th>Promotion By</th>
                                                <th>Start Date</th>
                                                <th>Expiry Date</th>
                                                <th>Duration (days)</th>
                                                <th>Activation</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in search_list' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.brand}}</td>
                                                <td>{{item.sub_brand}}</td>
                                                <td>{{item.promotion_title}}</td>
                                                <td>{{item.promotion_by}}</td>
                                                <td>{{item.start_date}}</td>
                                                <td>{{item.end_date}}</td>
                                                <td>{{dayCalculate(item.start_date, item.end_date)+" Days"}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td style="text-align:center">
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white mt-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
        <!-- Active or Deactive Modal -->
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
                                    <table id="promotionUpdateTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Brand</th>
                                                <th>Sub Brand</th>
                                                <th>Promotion Caption</th>
                                                <th>Promotion By</th>
                                                <th>Start Date</th>
                                                <th>Expiry Date</th>
                                                <th>Duration (days)</th>
                                                <th>Activation</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in activate_data' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td>{{item.brand}}</td>
                                                <td>{{item.sub_brand}}</td>
                                                <td>{{item.promotion_title}}</td>
                                                <td>{{item.promotion_by}}</td>
                                                <td>{{item.start_date}}</td>
                                                <td>{{item.end_date}}</td>
                                                <td>{{dayCalculate(item.start_date, item.end_date)+" Days"}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td style="text-align:center">
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn text-white mt-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
    import exportFromJSON from "export-from-json"; 
    import VueTailwindPagination from "@ocrv/vue-tailwind-pagination"; 
    import  '@ocrv/vue-tailwind-pagination/styles';

    export default {
        mounted() {
            this.fetchPromotionUpdate();
            this.fetchNewShop();
            this.fetchMerchant();
            this.fetchBrand();
            this.fetchSubBrand();
            this.fetchMall();
            //this.getResults(); //pagination result
        },

        components: {
            VueTailwindPagination,
        },

        data(){
            return {
                list:[],
                merchants:[],
                brands:[],
                sub_brands:[],
                shops:[],
                malls:[],
                gsm: "GSM",
                merchant: "Merchant",
                by_other_mall: "By Other Mall", 
                search_list: [],
                search_name: "",
                activate_data: [],
                add: {
                    id: "",
                    image:"",
                    promotion_title: "",
                    description: "",
                    start_date: "",
                    end_date: "",
                    url: "",
                    merchant: "",
                    mall: "",
                    shop: "",
                    brand: "",
                    sub_brand: "",
                    promotion_by: [],
                    activation: "",
                },
                update: {
                    id: "",
                    image: "",
                    view_image: "",
                    promotion_title: "",
                    description: "",
                    start_date: "",
                    end_date: "",
                    url: "",
                    merchant: "",
                    mall: "",
                    shop: "",
                    brand: "",
                    sub_brand: "",
                    promotion_by: [],
                    activation: "",
                    _method: "PUT"
                },
                currentPage: 1,
                total: "",
                perPage: 3,
                pagination: []
            }
        },

        methods:{
            fetchPromotionUpdate(){
                axios.get('https://admin.globalshopping-mall.site/api/promotions')
                .then(res => {
                    this.list = res.data;
                    this.total = res.data.data.length;
                    this.pageChange(this.currentPage);
                }).then(res => {
                }).catch(err => {console.log(err);});
            },

            fetchMerchant(){
                axios.get('https://admin.globalshopping-mall.site/api/merchants')
                .then(res => {
                    this.merchants = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchNewShop(){
                axios.get('https://admin.globalshopping-mall.site/api/new_shops')
                .then(res => {
                    this.shops = res.data.data;
                    // console.log(this.shops);
                    //console.log("Brand = ", this.list );
                }).catch(err => {console.log(err);});
            },

            fetchMall(){
                axios.get('https://admin.globalshopping-mall.site/api/malls')
                .then(res => {
                    this.malls = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/brands')
                .then(res => {
                    this.brands = res.data.data;
                }).catch(err => {    console.log(err);});
            },

            fetchSubBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/sub_brands')
                .then(res => {
                    this.sub_brands = res.data.data;
                    // console.log(this.sub_brands);
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

            find(){ 
                // console.log(this.search_name)
                this.search_list = [];
                axios.get('https://admin.globalshopping-mall.site/api/search_promotion/'+this.search_name)
                .then(res => {
                    this.search_list = res.data.data;
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
                this.pagination = this.list.data.slice(trimStart, trimEnd);
                // console.log(this.pagination);
            },

            dayCalculate(start, end){
                let days = moment(end, 'YYYY.MM.DD').diff(moment(start, 'YYYY.MM.DD'), "days")
                // console.log(days);
                return days;
            },

            imagePath(data){
                let impath = data.slice(7);
                // console.log(impath)
                return impath;   
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
                const fileName = "Promotion";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
            },
            

            csvExport(){
                // console.log(this.list.data)
                const data = this.list.data;
                const fileName = "Promotion";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });
            },

            addPost(){
                //console.log( this.add.promotion_by);
                if(this.add.image == '' || this.add.promotion_title == '' || this.add.description == '' || this.add.start_date == '' || this.add.end_date == '' || this.add.url == '' || this.add.merchant == '' || this.add.shop == '' || this.add.mall == '' || this.add.brand == '' || this.add.sub_brand == ''){
                    return alert("Please fill-up all the fields");
                }

                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('promotion_title', this.add.promotion_title);
                formData.append('description', this.add.description);
                formData.append('start_date', this.add.start_date);
                formData.append('end_date', this.add.end_date);
                formData.append('url', this.add.url);
                formData.append('merchant', this.add.merchant);
                formData.append('shop', this.add.shop);
                formData.append('mall', this.add.mall);
                formData.append('brand', this.add.brand);
                formData.append('sub_brand', this.add.sub_brand);
                formData.append('promotion_by', this.add.promotion_by);
                formData.append('activation', this.add.activation);

                axios.post('https://admin.globalshopping-mall.site/api/create_promotion', formData,
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
                let i = 0;
                axios.get('https://admin.globalshopping-mall.site/api/single_promotion/'+id)
                .then(res => {
                    console.log( res.data.data);
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            this.update.merchant = this.merchants[i].id;
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
                    for(i=0; i<this.shops.length; i++){
                        if(this.shops[i].shop_name == res.data.data[0].shop_name){
                            this.update.shop = this.shops[i].id;
                        }
                    }
                    for(i=0; i<this.sub_brands.length; i++){
                        if(this.sub_brands[i].sub_brand == res.data.data[0].sub_brand){
                            this.update.sub_brand = this.sub_brands[i].id;
                        }
                    }
                    this.update.id = res.data.data[0].id,
                    this.update.promotion_title = res.data.data[0].promotion_title,
                    this.update.description = res.data.data[0].description,
                    this.update.start_date = res.data.data[0].start_date,
                    this.update.end_date = res.data.data[0].end_date,
                    this.update.url = res.data.data[0].url,
                    this.update.activation = res.data.data[0].activation,
                    this.update.promotion_by = res.data.data[0].promotion_by,
                    this.update.view_image = res.data.data[0].image
                }).catch(error => {console.log(error);});
            },

            updatePost(){
                let formData = new FormData();
                formData.append('image', this.update.image);
                formData.append('promotion_title', this.update.promotion_title);
                formData.append('description', this.update.description);
                formData.append('start_date', this.update.start_date);
                formData.append('end_date', this.update.end_date);
                formData.append('url', this.update.url);
                formData.append('merchant', this.update.merchant);
                formData.append('shop', this.update.shop);
                formData.append('mall', this.update.mall);
                formData.append('brand', this.update.brand);
                formData.append('sub_brand', this.update.sub_brand);
                formData.append('promotion_by', this.update.promotion_by);
                formData.append('activation', this.update.activation);
                formData.append('_method', this.update._method);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/update_promotion/' + this.update.id, formData, config)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },

            activation(id){
                let activationCode;
                let promotion_title;
                let description;
                let start_date;
                let end_date;
                let url;
                let merchant;
                let shop;
                let mall;
                let brand;
                let sub_brand;
                let promotion_by;
                let i = 0;
                axios.get('https://admin.globalshopping-mall.site/api/single_promotion/'+id)
                .then(res => {
                    // console.log(res.data.data[0]);
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                           merchant = this.merchants[i].id;
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
                    for(i=0; i<this.shops.length; i++){
                        if(this.shops[i].shop_name == res.data.data[0].shop_name){
                            shop = this.shops[i].id;
                        }
                    }
                    promotion_title = res.data.data[0].promotion_title;
                    description = res.data.data[0].description;
                    start_date = res.data.data[0].start_date;
                    end_date = res.data.data[0].end_date;
                    url = res.data.data[0].url;
                    sub_brand = 1;
                    promotion_by = res.data.data[0].promotion_by;
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
                    axios.put('https://admin.globalshopping-mall.site/api/update_promotion/' + id, {promotion_title:promotion_title, description:description, start_date:start_date, end_date:end_date, url:url, merchant:merchant, shop:shop, mall:mall, brand:brand, sub_brand:sub_brand, promotion_by:promotion_by, activation: activationCode}).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
        }
    }
</script>