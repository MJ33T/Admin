<template>
    <div class="containe mt-2">
        <div class="d-flex">
            <div class="col-md-4">
                <input type="text" id="search_input" class="form-control" placeholder="Search" v-model="search_name">
            </div>
            <div class="col-md-5">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#searchModal" @click="find()">Search</button>
            </div>
            <Button class="btn btn-success" style="margin-left:8%" data-toggle="modal" data-target="#addPostModal">Create Sub Brand (Details)</Button>
        </div>
        <div class="d-flex mt-4 mb-2">
            <!-- <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Status</button>
                <div class="dropdown-menu">
                <p class="dropdown-item" id="active" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="active_data()">Active</p>
                <p class="dropdown-item" id="deactive" data-toggle="modal" data-target="#activeModal" style="cursor: pointer;" @click="deactive_data()">Deactive</p>
                
                </div>
            </div> -->
            <!-- <button class="btn btn-secondary ml-2 mb-2">Calendar</button> -->
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle ml-2" data-toggle="dropdown">Export</button>
                <div class="dropdown-menu">
                <p class="dropdown-item" id="active" style="cursor: pointer;">PDF</p>
                <p class="dropdown-item" id="deactive" style="cursor: pointer;">XCEl</p>
                <p class="dropdown-item" id="deactive" style="cursor: pointer;">CSV</p>

                <!-- <a class="dropdown-item" href="#" >Deactive</a> -->
                </div>
            </div>  
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="subBrandDetailsTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <!-- <th>Category</th> -->
                                <th>Product Type</th>
                                <th>Brand</th>
                                <th>Sub Brand</th>
                                <th>Price (RM)</th>
                                <th>Stock</th>
                                <th>Discount Price</th>
                                <th>Variation</th>
                                <th>Shipping Method</th>
                                <th>Commission</th>
                                <th>SST</th>
                                <th>GST</th>
                                <th>Activation</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in pagination' :key='item.id'>
                                
                                <td>{{item.id}}</td>
                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                <!-- <td></td> -->
                                <td>{{item.product_type==1?'New' : 'Used'}}</td>
                                <td>{{item.brand}}</td>
                                <td>{{item.sub_brand}}</td>
                                <td>{{item.price}}</td>
                                <td>{{item.stock}}</td>
                                <td>{{item.discount_price}}</td>
                                <td><a class="btn btn-secondary" href="#showVariationModal" data-toggle="modal" @click="showVariation(item.GUID);">Show</a></td>
                                <td>{{item.shipping}}</td>
                                <td>{{item.commission}}</td>
                                <td>{{item.sst}}</td>
                                <td>{{item.gst}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td style="text-align:center">
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button class="btn btn-info mt-3 mb-3">Update Shipping Method</button>
                                    <button class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activationUpdate(item.id);">Active / Deactive</button>
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
        <!-- Create Sub Brand Details Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Sub Brand (Details)</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="file1" v-on:change="handleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="file2" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="file3" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="file4" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="file5" v-on:change="handleFileUpload"/>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Uploadvdo.png" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="file6" v-on:change="handleFileUpload"/>
                                </div>
                            </div>  
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-5 mt-1">Sub Brand Name</div>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <select class="form-control" v-model="sub_brand_name" @change="selectVariation()">
                                                <option v-for="(sub_brand, index) in sub_brands" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.sub_brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-4 mt-1"> Brand Name</div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control" v-model="brand_name">
                                                <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">    
                                    <div class="col-sm-4 mt-1">Product Type</div>
                                    <div class="col-sm-8 mt-1">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="productType" v-bind:value="1" v-model="product_type">New
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="productType" v-bind:value="0" v-model="product_type">Used
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-5 mt-1">Shop Name</div>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <select class="form-control" v-model="shop_name">
                                                <option v-for="(shop, index) in shops" :key="index" v-bind:value="shop.id">{{ shop.shop_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-4 mt-1">Merchant</div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control" v-model="merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-2 mt-1">Mall</div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select class="form-control" v-model="mall">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">Stock</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Stock" v-model="stock" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm">
                                <div class="row">    
                                    <div class="col-sm-5 mt-1">Commission</div>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" placeholder="%" v-model="commission">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="row">    
                                    <div class="col-sm-2 mt-1">SST</div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="%" v-model="sst">
                                    </div>
                                    <div class="col-sm-2 mt-1">GST</div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="%" v-model="gst">
                                    </div>
                                </div>    
                            </div>
                            
                            <div class="col-sm">
                                <div class="row">    
                                    <div class="col-sm-2 mt-1">Price</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="RM" v-model="price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="row">
                                    <div class="col-sm-6 mt-1">Discount Price</div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="RM" v-model="discount_price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-1 mt-3">Description</div>
                            <div class="col-sm-11 mt-3">
                                <textarea class="form-control" rows="5" v-model="description"></textarea>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">UOM</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="uom">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-3 mt-1">Height</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="height">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">Weight</div>
                                    <div class="col-sm-9 ">
                                        <input type="text" class="form-control" v-model="weight">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">Fragile</div>
                                    <div class="col-sm-9 ">
                                        <input type="text" class="form-control" v-model="fragile">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-4 mt-1">Shipping</div>
                                    <div class="col-sm-8 ">
                                        <input type="text" class="form-control" v-model="shipping">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>    
                        <div class="row">
                            <div class="col-sm-12"><h5><strong>Add Variation</strong></h5></div>
                            <div class="col-sm-12 mt-3" >
                                <div class="form-group" v-for="(input,k) in variations" :key="k">
                                    <div class="row">
                                        <div class="col-sm">
                                            <select class="form-control" v-model="input.variation">
                                                <option value="" disabled>Variation</option>
                                                <option v-for="(sub_brand, index) in sub_brand_variation" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" class="form-control" placeholder="Attribute" v-model="input.attribute">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" class="form-control" placeholder="Surcharge/Extra" v-model="input.surcharge">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" class="form-control" placeholder="Stock" v-model="input.stock">
                                        </div>
                                        <div class="col-sm">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <span>
                                                        <button class="btn btn-danger" @click="remove(k)" v-show="k || ( !k && variations.length > 1)">-</button>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <span>
                                                        <button class="btn btn-success" @click="add(k)" v-show="k == variations.length-1">+</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-sm-2 ">Activation</div>
                            <div class="col-sm-10">
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
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Sub Brand</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file1)" alt="image" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="update_file1" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file2)" alt="image" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="update_file2" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file3)" alt="image" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="update_file3" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file4)" alt="image" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="update_file4" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file5)" alt="image" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="update_file5" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(this.update_view_file6)" alt="image" style="width:50%; height: 50%"/>
                                    </label>
                                    <input type="file" id="file" ref="update_file6" v-on:change="UpdatehandleFileUpload" />
                                </div>
                            </div>  
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-5 mt-1">Sub Brand Name</div>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update_sub_brand_name" disabled>
                                                <option v-for="(sub_brand, index) in sub_brands" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.sub_brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-4 mt-1"> Brand Name</div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update_brand_name">
                                                <option v-for="(brand, index) in brands" :key="index" v-bind:value="brand.id">{{ brand.brand }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">    
                                    <div class="col-sm-4 mt-1">Product Type</div>
                                    <div class="col-sm-8 mt-1">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="productType" v-bind:value="1" v-model="update_product_type">New
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="productType" v-bind:value="0" v-model="update_product_type">Used
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-5 mt-1">Shop Name</div>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update_shop_name">
                                                <option v-for="(shop, index) in shops" :key="index" v-bind:value="shop.id">{{ shop.shop_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-4 mt-1">Merchant</div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update_merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-2 mt-1">Mall</div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update_mall">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">Stock</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Stock" v-model="update_stock" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm">
                                <div class="row">    
                                    <div class="col-sm-5 mt-1">Commission</div>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" placeholder="%" v-model="update_commission">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="row">    
                                    <div class="col-sm-2 mt-1">SST</div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="%" v-model="update_sst">
                                    </div>
                                    <div class="col-sm-2 mt-1">GST</div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="%" v-model="update_gst">
                                    </div>
                                </div>    
                            </div>
                            
                            <div class="col-sm">
                                <div class="row">    
                                    <div class="col-sm-2 mt-1">Price</div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="RM" v-model="update_price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="row">
                                    <div class="col-sm-6 mt-1">Discount Price</div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="RM" v-model="update_discount_price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-1 mt-3">Description</div>
                            <div class="col-sm-11 mt-3">
                                <textarea class="form-control" rows="5" v-model="update_description"></textarea>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">UOM</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="update_uom">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-3 mt-1">Height</div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="update_height">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">Weight</div>
                                    <div class="col-sm-9 ">
                                        <input type="text" class="form-control" v-model="update_weight">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-3 mt-1">Fragile</div>
                                    <div class="col-sm-9 ">
                                        <input type="text" class="form-control" v-model="update_fragile">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">    
                                    <div class="col-sm-4 mt-1">Shipping</div>
                                    <div class="col-sm-8 ">
                                        <input type="text" class="form-control" v-model="update_shipping">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>    
                        <div class="row">
                            <div class="col-sm-12"><h5><strong>Edit Variation</strong></h5></div>
                            <div class="col-sm-12 mt-3" >
                                <div class="form-group" v-for="(input,k) in update_variations" :key="k">
                                    <div class="row">
                                        <!-- <div class="col-sm">
                                            <select class="form-control" v-model="input.variation">
                                                <option value="" disabled>Variation</option>
                                                <option v-for="(sub_brand, index) in sub_brand_variation" :key="index" v-bind:value="sub_brand.id">{{ sub_brand.sub_brand }}</option>
                                            </select>
                                        </div> -->
                                        <div class="col-sm">
                                            <input type="text" class="form-control" placeholder="Variation" v-model="input.name" disabled>
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" class="form-control" placeholder="Attribute" v-model="input.attribute">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" class="form-control" placeholder="Surcharge/Extra" v-model="input.surcharge">
                                        </div>
                                        <div class="col-sm">
                                            <input type="text" class="form-control" placeholder="Stock" v-model="input.stock">
                                        </div>
                                        <div class="col-sm">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <span>
                                                        <button class="btn btn-danger" @click="update_remove(k)" v-show="k || ( !k && variations.length > 1)">-</button>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <span>
                                                        <button class="btn btn-success" @click="update_add(k)" v-show="k == variations.length-1">+</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-sm-2 ">Activation</div>
                            <div class="col-sm-10">
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
                                    <table id="subBrandDetailsTable" class="table table-striped" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Brand</th>
                                                <th>Sub Brand</th>
                                                <th>Price (RM)</th>
                                                <th>Stock</th>
                                                <th>Discount Price</th>
                                                <th>Variation (Yes/No)</th>
                                                <th>Shipping Method</th>
                                                <th>Commission</th>
                                                <th>SST</th>
                                                <th>GST</th>
                                                <th>Activation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in activate_data' :key='item.id'>
                                                <td>{{item.id}}</td>
                                                <td style="width: 50px;"><img :src="'https://admin.globalshopping-mall.site/../storage/'+imagePath(item.image)" alt="image" ></td>
                                                <td></td>
                                                <td>{{item.product_type}}</td>
                                                <td>{{item.brand}}</td>
                                                <td>{{item.sub_brand}}</td>
                                                <td>{{item.price}}</td>
                                                <td>{{item.stock}}</td>
                                                <td>{{item.discount_price}}</td>
                                                <td></td>
                                                <td>{{item.shipping}}</td>
                                                <td>{{item.commission}}</td>
                                                <td>{{item.sst}}</td>
                                                <td>{{item.gst}}</td>
                                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                                    <button class="btn btn-info mt-3 mb-3">Update Shipping Method</button>
                                                    <button class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activationUpdate(item.id);">Active / Deactive</button>
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

        <div class="modal fade" id="showVariationModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
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
                                    <table id="subBrandDetailsTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Variation</th>
                                                <th>Attributes</th>
                                                <th>Surcharge</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='item in show_variations' :key='item.id'>
                                                <td>{{item.name}}</td>
                                                <td>{{item.attribute}}</td>
                                                <td>{{item.surcharge}}</td>
                                                <td>{{item.stock}}</td> 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
            this.fetchSubBrandDetails();
            this.fetchMerchant();
            this.fetchBrand();
            this.fetchNewShop();
            this.fetchSubBrand();
            this.fetchMall();
            // this.getResults(); //pagination result
        },

        components: {
            VueTailwindPagination,
        },

        data(){
            return {
                list:{},
                sub_brands:{},
                brands:{},
                merchants:{},
                malls:{},
                shops:{},
                sub_brand_variation:{},
                activate_data: [],

                id: "",
                GUID:"",
                file1:"",
                file2:"",
                file3:"",
                file4:"",
                file5:"",
                file6:"",
                brand_name: "",
                sub_brand_name: "",
                shop_name:"",
                merchant:"",
                mall:"",
                product_type:"",
                stock:"",
                commission:"",
                sst:"",
                gst:"",
                price:"",
                discount_price:"",
                description:"",
                uom:"",
                height:"",
                weight:"",
                fragile:"",
                shipping:"",
                activation: "",
                admin_approval: "",
                variations:[
                    {
                        variation:"",
                        attribute:"",
                        surcharge:"",
                        stock:"",
                    }
                ],
                
                update_id: "",
                update_GUID:"",
                update_view_file1: "",
                update_view_file2: "",
                update_view_file3: "",
                update_view_file4: "",
                update_view_file5: "",
                update_view_file6: "",
                update_file1:"",
                update_file2:"",
                update_file3:"",
                update_file4:"",
                update_file5:"",
                update_file6:"",
                update_brand_name: "",
                update_sub_brand_name: "",
                update_shop_name:"",
                update_merchant:"",
                update_mall:"",
                update_product_type:"",
                update_stock:"",
                update_commission:"",
                update_sst:"",
                update_gst:"",
                update_price:"",
                update_discount_price:"",
                update_description:"",
                update_uom:"",
                update_height:"",
                update_weight:"",
                update_fragile:"",
                update_shipping:"",
                update_activation: "",
                update_admin_approval: "",
                _method: 'PUT',
                update_variations:[
                    {
                        id:"",
                        GUID:"",
                        variation:"",
                        attribute:"",
                        surcharge:"",
                        stock:"",
                    }
                ],
                show_variations:[
                    {
                        id:"",
                        GUID:"",
                        variation:"",
                        attribute:"",
                        surcharge:"",
                        stock:"",
                    }
                ],
                currentPage: 1,
                total: "",
                perPage: 2,
                pagination: [] 
            }
        },
        methods:{
            fetchSubBrandDetails(){
                axios.get('https://admin.globalshopping-mall.site/api/sub_brand_details')
                .then(res => {
                    this.list = res.data;
                    // console.log(this.list)
                    this.total = res.data.data.length;
                    this.pageChange(this.currentPage);
                }).catch(err => {console.log(err);});
            },
            add(index) {
                this.variations.push({ variation: '', attribute:'', surcharge:'', stock:'' });
            },
            remove(index) {
                this.variations.splice(index, 1);
            },
            update_add(index) {
                this.variations.push({ variation: '', attribute:'', surcharge:'', stock:'' });
            },
            update_remove(index) {
                this.variations.splice(index, 1);
            },
            selectVariation(){
                // console.log("google:"+this.sub_brand_name)
                axios.get('https://admin.globalshopping-mall.site/api/single_sub_brand/'+this.sub_brand_name)
                .then(res => {
                    // console.log(res.data.data[0].GUID);
                    this.GUID = res.data.data[0].GUID;
                    axios.get('https://admin.globalshopping-mall.site/api/sub_brand_variations/'+res.data.data[0].GUID)
                    .then(res => {
                        // console.log(res.data.data)
                        this.sub_brand_variation = res.data.data;
                    })
                })
            },

            fetchBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/brands')
                .then(res => {
                    this.brands = res.data.data;
                }).catch(err => {console.log(err);});
            },
            

            fetchSubBrand(){
                axios.get('https://admin.globalshopping-mall.site/api/sub_brands')
                .then(res => {
                    this.sub_brands = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchMerchant(){
                axios.get('https://admin.globalshopping-mall.site/api/merchants')
                .then(res => {
                    this.merchants = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchMall(){
                axios.get('https://admin.globalshopping-mall.site/api/malls')
                .then(res => {
                    this.malls = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchNewShop(){
                axios.get('https://admin.globalshopping-mall.site/api/new_shops')
                .then(res => {
                    this.shops = res.data.data;
                    // console.log("Shop = ", this.shops );
                }).catch(err => {console.log(err);});
            },

            //Handles a change on the file upload
            handleFileUpload(res){
                // console.log(this.$refs.file1.files[0])
                //this.files = this.$refs.files.files;
                this.file1 = this.$refs.file1.files[0];
                this.file2 = this.$refs.file2.files[0];
                this.file3 = this.$refs.file3.files[0];
                this.file4 = this.$refs.file4.files[0];
                this.file5 = this.$refs.file5.files[0];
                this.file6 = this.$refs.file6.files[0];
            },
            UpdatehandleFileUpload(res){
                this.update_file1 = this.$refs.update_file1.files[0];
                this.update_file2 = this.$refs.update_file2.files[0];
                this.update_file3 = this.$refs.update_file3.files[0];
                this.update_file4 = this.$refs.update_file4.files[0];
                this.update_file5 = this.$refs.update_file5.files[0];
                this.update_file6 = this.$refs.update_file6.files[0];
                console.log(this.update_file2);
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

            showVariation(id){
                axios.get('https://admin.globalshopping-mall.site/api/sub_brand_detail_variations/'+ id)
                    .then(res => {
                        // console.log(res.data.data);
                        this.show_variations = res.data.data;
                        console.log(this.show_variation)
                        
                    }).catch(err => {console.log(err);})
            },

            addPost(){
                this.admin_approval = 1;
                let formData = new FormData();
                formData.append('GUID', this.GUID);
                formData.append('image', this.file1);
                formData.append('image1', this.file2);
                formData.append('image2', this.file3);
                formData.append('image3', this.file4);
                formData.append('image4', this.file5);
                formData.append('video', this.file6);
                formData.append('brand_name', this.brand_name);
                formData.append('sub_brand_name', this.sub_brand_name);
                formData.append('shop_name', this.shop_name);
                formData.append('merchant', this.merchant);
                formData.append('mall', this.mall);
                formData.append('product_type', this.product_type);
                formData.append('stock', this.stock)
                formData.append('commission', this.commission)
                formData.append('sst', this.sst)
                formData.append('gst', this.gst)
                formData.append('price', this.price)
                formData.append('discount_price', this.discount_price)
                formData.append('description', this.description)
                formData.append('uom', this.uom)
                formData.append('height', this.height)
                formData.append('weight', this.weight)
                formData.append('fragile', this.fragile)
                formData.append('shipping', this.shipping)
                formData.append('activation', this.activation)
                formData.append('admin_approval', this.admin_approval)
                let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/create_sub_brand_details', formData, config)
                .then(res => {
                    
                    this.variations.forEach(element => {
                        //console.log(element.name);
                        axios.post('https://admin.globalshopping-mall.site/api/create_sub_brand_detail_variation', {GUID:this.GUID, variation:element.variation, attribute:element.attribute, surcharge:element.surcharge, stock:element.stock})
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
                axios.get('https://admin.globalshopping-mall.site/api/single_sub_brand_detail/'+id)
                .then(res => {
                    // console.log(res.data.data[0])
                    
                    for(i=0; i<this.brands.length; i++){
                        if(this.brands[i].brand == res.data.data[0].brand){
                            this.update_brand_name = this.brands[i].id;
                        }
                    };
                    for(i=0; i<this.shops.length; i++){
                        if(this.shops[i].shop_name == res.data.data[0].shop_name){
                            this.update_shop_name = this.shops[i].id;
                        }
                    };
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            this.update_merchant = this.merchants[i].id;
                        }
                    };
                    for(i=0; i<this.malls.length; i++){
                        if(this.malls[i].mall_name == res.data.data[0].mall_name){
                            this.update_mall = this.malls[i].id;
                        }
                    };
                    // console.log(this.update_brand_name)
                    this.update_id = res.data.data[0].id,
                    this.update_GUID = res.data.data[0].GUID;
                    this.update_sub_brand_name = res.data.data[0].sub_brand_name,
                    this.update_product_type = res.data.data[0].product_type,
                    this.update_stock = res.data.data[0].stock,
                    this.update_commission = res.data.data[0].commission,
                    this.update_sst = res.data.data[0].sst,
                    this.update_gst = res.data.data[0].gst,
                    this.update_price = res.data.data[0].price,
                    this.update_discount_price = res.data.data[0].discount_price,
                    this.update_description = res.data.data[0].description,
                    this.update_uom = res.data.data[0].uom,
                    this.update_height = res.data.data[0].height,
                    this.update_weight = res.data.data[0].weight,
                    this.update_fragile = res.data.data[0].fragile,
                    this.update_shipping = res.data.data[0].shipping,
                    this.update_activation = res.data.data[0].activation,
                    this.update_admin_approval = res.data.data[0].admin_approval,
                    this.update_view_file1 = res.data.data[0].image,
                    this.update_view_file2 = res.data.data[0].image1,
                    this.update_view_file3 = res.data.data[0].image2,
                    this.update_view_file4 = res.data.data[0].image3,
                    this.update_view_file5 = res.data.data[0].image4,
                    this.update_view_file6 = res.data.data[0].video
                }).then(res => {
                    axios.get('https://admin.globalshopping-mall.site/api/sub_brand_detail_variations/'+this.update_GUID)
                    .then(res => {
                        // console.log(res.data.data);
                        this.update_variations = res.data.data;
                        
                    }).catch(err => {console.log(err);})
                }).catch(err => {console.log(err);})
                .catch(error => {console.log(error);});
            },
            updatePost(){
                console.log(this.update_file2)
                let formData = new FormData();
                formData.append('GUID', this.update_GUID);
                formData.append('image', this.update_file1);
                formData.append('image1', this.update_file2);
                formData.append('image2', this.update_file3);
                formData.append('image3', this.update_file4);
                formData.append('image4', this.update_file5);
                formData.append('video', this.update_file6);
                formData.append('brand_name', this.update_brand_name);
                formData.append('sub_brand_name', this.update_sub_brand_name);
                formData.append('shop_name', this.update_shop_name);
                formData.append('merchant', this.update_merchant);
                formData.append('mall', this.update_mall);
                formData.append('product_type', this.update_product_type);
                formData.append('stock', this.update_stock)
                formData.append('commission', this.update_commission)
                formData.append('sst', this.update_sst)
                formData.append('gst', this.update_gst)
                formData.append('price', this.update_price)
                formData.append('discount_price', this.update_discount_price)
                formData.append('description', this.update_description)
                formData.append('uom', this.update_uom)
                formData.append('height', this.update_height)
                formData.append('weight', this.update_weight)
                formData.append('fragile', this.update_fragile)
                formData.append('shipping', this.update_shipping)
                formData.append('activation', this.update_activation)
                formData.append('admin_approval', this.update_admin_approval)
                formData.append('_method', this._method)
                let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/update_sub_brand_detail/' + this.update_id, formData, config)
                .then(res => {
                    // console.log(this.sub_brand_variation)
                    this.update_variations.forEach(element => {
                        // console.log(element)
                        axios.put('https://admin.globalshopping-mall.site/api/update_sub_brand_detail_variation/'+element.id, {
                            GUID:element.GUID,
                            attribute:element.attribute, 
                            stock:element.stock, 
                            surcharge:element.surcharge
                        })
                        .catch(err => {console.log(err);});
                    });
                    if(res.status == 200){
                        location.reload();
                    } 
                }).catch(err => {console.log(err);});
            },
            activationUpdate(id){
                let i = 0;
                let activationCode;
                let GUID;
                let sub_brand;
                let brand;
                let shop;
                let merchant;
                let mall;
                let product_type;
                let stock;
                let commission;
                let sst;
                let gst;
                let price;
                let discount_price;
                let description;
                let uom;
                let height;
                let weight;
                let fragile;
                let shipping;
                let admin_approval;
                let variations = [];
                axios.get('https://admin.globalshopping-mall.site/api/single_sub_brand_detail/'+id)
                .then(res => {
                    console.log(res.data.data);
                    for(i=0; i<this.brands.length; i++){
                        if(this.brands[i].brand == res.data.data[0].brand){
                            brand = this.brands[i].id;
                        }
                    }
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
                    for(i=0; i<this.malls.length; i++){
                        if(this.malls[i].mall_name == res.data.data[0].mall_name){
                            mall = this.malls[i].id;
                        }
                    }
                    
                    
                       
                    
                    GUID = res.data.data[0].GUID;
                    sub_brand = 1;
                    // sub_brand_name = res.data.data[0].sub_brand_name;
                    // brand_ = res.data.data[0].brand_name;
                    // shop_name = res.data.data[0].shop_name;
                    // merchant = res.data.data[0].merchant;
                    // mall = res.data.data[0].mall;
                    product_type = res.data.data[0].product_type;
                    stock = res.data.data[0].stock;
                    commission = res.data.data[0].commission;
                    sst = res.data.data[0].sst;
                    gst = res.data.data[0].gst;
                    price = res.data.data[0].price;
                    discount_price = res.data.data[0].discount_price;
                    description = res.data.data[0].description;
                    uom = res.data.data[0].uom;
                    height = res.data.data[0].height;
                    weight = res.data.data[0].weight;
                    fragile = res.data.data[0].fragile;
                    shipping = res.data.data[0].shipping;
                    admin_approval = res.data.data[0].admin_approval
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
                    axios.put('https://admin.globalshopping-mall.site/api/update_sub_brand_detail/' + id, {
                        GUID:GUID, 
                        sub_brand_name:sub_brand, 
                        brand_name:brand, 
                        shop_name:shop, 
                        merchant:merchant, 
                        mall:mall, 
                        product_type:product_type, 
                        stock:stock, 
                        commission:commission, 
                        sst:sst, gst:gst, 
                        price:price,
                        discount_price:discount_price, 
                        description:description,
                        uom:uom, 
                        height:height, 
                        weight:weight, 
                        fragile:fragile, 
                        shipping:shipping, 
                        activation:activationCode,
                        admin_approval:admin_approval
                    })
                    .then(res => {
                        if(res.status == 200){
                            location.reload();
                        }
                    }).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
            
        }
    }
</script>
<style scoped>
    #showVariationModal{
        z-index: 9999;
    }
</style>