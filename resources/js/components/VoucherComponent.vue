
<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" class="form-control" id="search_input" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:6%" data-toggle="modal" data-target="#addPostModal">Create Voucher</Button>
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
                    <table id="voucherTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Voucher Title</th>
                                <th>Voucher By</th>
                                <th>Voucher Start Date</th>
                                <th>Voucher Expiry Date</th>
                                <th>Duration of Voucher (days)</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in list.data' :key='item.id'>
                                <td>{{item.id}}</td>
                                <td>{{item.voucher_title}}</td>
                                <td>{{item.merchant_name}}</td>
                                <td>{{item.start_date}}</td>
                                <td>{{item.end_date}}</td>
                                <td>{{dayCalculate(item.start_date, item.end_date)+" Days"}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button class="btn text-white ml-2" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <!-- <pagination :data="list" @pagination-change-page="getResults"></pagination> -->
                </div>
            </div>
        </div>
        <!-- Add New Voucher Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Voucher</h4>
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
                                    <div class="col-sm-2">Voucher Title</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="add.voucher_title">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Mall</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.mall">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Merchant</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Shop</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.shop">
                                                <option v-for="(shop, index) in shops" :key="index" v-bind:value="shop.id">{{ shop.shop_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Sub Brand</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.sub_brand">
                                                <option v-for="(sub_brand, index) in sub_brands" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.sub_brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Voucher Code</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="add.voucher_code">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Voucher Start Date</div>
                                    <div class="col-sm-5 mt-3">
                                        <input type="date" class="form-control" v-model="add.start_date">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Voucher End Date</div>
                                    <div class="col-sm-5 mt-3">
                                        <input type="date" class="form-control" v-model="add.end_date">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Minimum Spend</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="number" id="min" name="min" min="0" max="100" class="form-control" v-model="add.min_spend">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Discount Amount</div>
                                    <div class="col-sm-6 mt-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="number" id="discount" name="discount" min="0" max="100" class="form-control" v-model="add.discount_amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Maximum Usage</div>
                                    <div class="col-sm-3 mt-3">
                                        <input type="number" id="max" name="max" min="0" max="100" class="form-control" v-model="add.maximum_usage">
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

        <!-- Edit Voucher Modal -->
        <div class="modal fade" id="editPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Voucher</h4>
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
                                    <div class="col-sm-2">Voucher Title</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="update.voucher_title">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Mall</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.mall">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Merchant</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Shop</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.shop">
                                                <option v-for="(shop, index) in shops" :key="index" v-bind:value="shop.id">{{ shop.shop_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Sub Brand</div>
                                    <div class="col-sm-8 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.sub_brand">
                                                <option v-for="(sub_brand, index) in sub_brands" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.sub_brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Voucher Code</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="update.voucher_code">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Voucher Start Date</div>
                                    <div class="col-sm-5 mt-3">
                                        <input type="date" class="form-control" v-model="update.start_date">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Voucher End Date</div>
                                    <div class="col-sm-5 mt-3">
                                        <input type="date" class="form-control" v-model="update.end_date">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Minimum Spend</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="number" id="min" name="min" min="0" max="100" class="form-control" v-model="update.min_spend">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Discount Amount</div>
                                    <div class="col-sm-5 mt-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="number" id="discount" name="discount" min="0" max="100" class="form-control" v-model="update.discount_amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Maximum Usage</div>
                                    <div class="col-sm-2 mt-3">
                                        <input type="number" id="max" name="max" min="0" max="100" class="form-control" v-model="update.maximum_usage">
                                    </div>
                                </div>
                                <div class="row">
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
                                    <table id="voucherTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Voucher Title</th>
                                                <th>Voucher By</th>
                                                <th>Voucher Start Date</th>
                                                <th>Voucher Expiry Date</th>
                                                <th>Duration of Voucher (days)</th>
                                                <th>Activation</th>
                                                <th  style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in search_list' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td>{{item.voucher_title}}</td>
                                                <td>{{item.merchant_name}}</td>
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
                                    <table id="voucherTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Voucher Title</th>
                                                <th>Voucher By</th>
                                                <th>Voucher Start Date</th>
                                                <th>Voucher Expiry Date</th>
                                                <th>Duration of Voucher (days)</th>
                                                <th>Activation</th>
                                                <th  style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in activate_data' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td>{{item.voucher_title}}</td>
                                                <td>{{item.merchant_name}}</td>
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
    export default {
        mounted() {
            // console.log('Component mounted.');
            this.fetchVoucher();
            this.fetchNewShop();
            this.fetchMerchant();
            this.fetchSubBrand();
            this.fetchMall();
            //this.getResults(); //pagination result
        },
        data(){
            return {
                list:{},
                merchants:{},
                sub_brands:{},
                shops:{},
                malls:{},
                gsm: "GSM",
                merchant: "Merchant",
                by_other_mall: "By Other Mall", 
                search_list: [],
                search_name: "",
                activate_data: [],
                add: {
                    id: "",
                    image: "",
                    voucher_title: "",
                    merchant: "",
                    mall: "",
                    shop: "",
                    sub_brand: "",
                    voucher_code: "",
                    start_date: "",
                    end_date: "",
                    min_spend: "",
                    discount_amount: "",
                    maximum_usage: "",
                    activation: "",
                    voucher_belongs_to: 1
                },
                update : {
                    id: "",
                    image: "",
                    view_image: "",
                    voucher_title: "",
                    merchant: "",
                    mall: "",
                    shop: "",
                    sub_brand: "",
                    voucher_code: "",
                    start_date: "",
                    end_date: "",
                    min_spend: "",
                    discount_amount: "",
                    maximum_usage: "",
                    activation: "",
                    voucher_belongs_to: "",
                    _method: "PUT"
                },
            }
        },

        methods:{
            fetchVoucher(){
                axios.get('https://admin.globalshopping-mall.site/api/vouchers')
                .then(res => {
                    // console.log(res.data)
                    this.list = res.data;
                    // console.log(res.data.data)
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
                    //console.log("Brand = ", this.list );
                }).catch(err => {console.log(err);});
            },

            fetchMall(){
                axios.get('https://admin.globalshopping-mall.site/api/malls')
                .then(res => {
                    this.malls = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchSubBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/sub_brands')
                .then(res => {
                    this.sub_brands = res.data.data;
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
                this.search_list = [];
                axios.get('https://admin.globalshopping-mall.site/api/search_voucher/'+this.search_name)
                .then(res => {
                    // console.log("HI");
                    this.search_list = res.data.data;
                    console.log(this.search_list)
                }).catch(err => {console.log(err);});
            },

            refresh(){
                this.search_list = [];
                this.search_name = "";
            },   

            excelExport(){
                const data = this.list.data;
                const fileName = "Voucher";
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({ data, fileName, exportType });
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

            csvExport(){
                const data = this.list.data;
                const fileName = "Voucher";
                const exportType = exportFromJSON.types.csv;

                if (data) exportFromJSON({ data, fileName, exportType });
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

            addPost(){
                console.log(this.add);
                if(this.add.image == '' || this.add.voucher_title == '' || this.add.voucher_code == '' || this.add.start_date == '' || this.add.end_date == '' || this.add.min_spend == '' || this.add.merchant == '' || this.add.shop == '' || this.add.mall == '' || this.add.discount_amount == '' || this.add.sub_brand == '' || this.add.maximum_usage == '' || this.add.activation == ''){
                    return alert("Please fill-up all the fields");
                }
                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('voucher_title', this.add.voucher_title);
                formData.append('mall', this.add.mall);
                formData.append('merchant', this.add.merchant);
                formData.append('shop', this.add.shop);
                formData.append('sub_brand', this.add.sub_brand);
                formData.append('voucher_code', this.add.voucher_code);
                formData.append('start_date', this.add.start_date);
                formData.append('end_date', this.add.end_date);
                formData.append('min_spend', this.add.min_spend);
                formData.append('discount_amount', this.add.discount_amount);
                formData.append('maximum_usage', this.add.discount_amount);
                formData.append('voucher_belongs_to', this.add.voucher_belongs_to);
                formData.append('activation', this.add.activation);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/create_voucher', formData, config)
                .then(res => {
                    if(res.status == 201){
                        location.reload();
                    }
                }).catch(error => {console.log(error); });
            },

            editPost(id){
                let i = 0;

                axios.get('https://admin.globalshopping-mall.site/api/single_voucher/'+id)
                .then(res => {
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            this.update.merchant = this.merchants[i].id;
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
                    this.update.voucher_title = res.data.data[0].voucher_title,
                    this.update.voucher_code = res.data.data[0].voucher_code,
                    this.update.start_date = res.data.data[0].start_date,
                    this.update.end_date = res.data.data[0].end_date,
                    this.update.min_spend = res.data.data[0].min_spend,
                    this.update.discount_amount = res.data.data[0].discount_amount,
                    this.update.maximum_usage = res.data.data[0].maximum_usage,
                    this.update.activation = res.data.data[0].activation,
                    this.update.view_image = res.data.data[0].image,
                    this.update.image = res.data.data[0].image,
                    this.update.voucher_belongs_to = res.data.data[0].voucher_belongs_to

                
                }).catch(error => {console.log(error);});
                console.log(this.update);
            },

            updatePost(){
                let formData = new FormData();
                formData.append('image', this.update.image);
                formData.append('voucher_title', this.update.voucher_title);
                formData.append('mall', this.update.mall);
                formData.append('merchant', this.update.merchant);
                formData.append('shop', this.update.shop);
                formData.append('sub_brand', this.update.sub_brand);
                formData.append('voucher_code', this.update.voucher_code);
                formData.append('start_date', this.update.start_date);
                formData.append('end_date', this.update.end_date);
                formData.append('min_spend', this.update.min_spend);
                formData.append('discount_amount', this.update.discount_amount);
                formData.append('maximum_usage', this.update.discount_amount);
                formData.append('voucher_belongs_to', this.update.voucher_belongs_to);
                formData.append('activation', this.update.activation);
                formData.append('_method', this.update._method);
                
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/update_voucher/' + this.update.id, formData, config)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },
            
            activation(id){
                let i;
                let activationCode;
                let voucher_title;
                let voucher_code;
                let start_date;
                let end_date;
                let min_spend;
                let merchant;
                let shop;
                let mall;
                let discount_amount;
                let sub_brand;
                let maximum_usage;
                let voucher_belongs_to;
                axios.get('https://admin.globalshopping-mall.site/api/single_voucher/'+id)
                .then(res => {

                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            merchant = this.merchants[i].id;
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
                    for(i=0; i<this.sub_brands.length; i++){
                        if(this.sub_brands[i].sub_brand == res.data.data[0].sub_brand){
                            sub_brand = this.sub_brands[i].id;
                        }
                    }

                    voucher_title = res.data.data[0].voucher_title;
                    voucher_code = res.data.data[0].voucher_code;
                    start_date = res.data.data[0].start_date;
                    end_date = res.data.data[0].end_date;
                    min_spend = res.data.data[0].min_spend;
                    discount_amount = res.data.data[0].discount_amount;
                    maximum_usage = res.data.data[0].maximum_usage;
                    voucher_belongs_to = res.data.data[0].voucher_belongs_to;

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
                    axios.put('https://admin.globalshopping-mall.site/api/update_voucher/' + id, {voucher_title:voucher_title, voucher_code:voucher_code, start_date:start_date, end_date:end_date, min_spend:min_spend, mall:mall, merchant:merchant, shop:shop, discount_amount:discount_amount, sub_brand:sub_brand, maximum_usage:maximum_usage, voucher_belongs_to:voucher_belongs_to, activation: activationCode}).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
        }
    }
</script>

