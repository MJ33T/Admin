<template>
    <div class="containe mt-5">
        <div class="d-flex">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Status</button>
                <div class="dropdown-menu">
                <p class="dropdown-item" id="active" style="cursor: pointer;">Active</p>
                <p class="dropdown-item" id="deactive" style="cursor: pointer;">Deactive</p>
                <!-- <a class="dropdown-item" href="#" >Deactive</a> -->
                </div>
            </div>
            <!-- <button class="btn btn-secondary ml-2">Calendar</button> -->
        </div>
        <div class="d-flex justify-content-end">
            <Button class="btn btn-success mb-5" data-toggle="modal" data-target="#addPostModal">Create Advertise</Button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="allAdsTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad Name</th>
                                <th>Selling Identity</th>
                                <th>Ad Caption</th>
                                <th>Ad Client</th>
                                <th>Merchant</th>
                                <th>Client Name</th>
                                <th>Ad Duration</th>
                                <th>Visual Identity</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in list.data' :key='item.id'>
                                <td>{{item.id}}</td>
                                <td>{{item.ad_name}}</td>
                                <td>{{item.selling_identity}}</td>
                                <td>{{item.ad_caption}}</td>
                                <td>{{item.ad_client}}</td>
                                <td>{{item.merchant}}</td>
                                <td>{{item.client_name}}</td>
                                <td>{{item.ad_duration}}</td>
                                <td>{{item.visual_identity}}</td>
                                <td>{{(item.activation == 1)? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a class="btn btn-primary" href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">View / Edit</a>
                                    <button class="btn text-white" :style="[item.activation == 1 ? {'background-color' : 'green'} : {'background-color' : 'red'}]" onclick="confirm('Confirm want to change activation?') || event.stopImmediatePropagation()" @click="activation(item.id);">Active / Deactive</button>
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
        <!-- Add New Advertise Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Advertise</h4>
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
                                    <div class="col-sm-2 mt-3">Ad Name</div>
                                    <div class="col-sm-10 mt-3">
                                        <input type="text" class="form-control" v-model="add.ad_name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Selling Identity</div>
                                    <div class="col-sm-10 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.selling_identity">
                                                <option v-for="(selling_identity, index) in selling_identities" :key="index" v-bind:value="selling_identity.id">{{ selling_identity.selling_identity }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Ad Caption</div>
                                    <div class="col-sm-10 mt-3">
                                        <input type="text" class="form-control" v-model="add.ad_caption">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Ad Client</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.ad_client">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Merchant</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Client Name</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.client_name">
                                                <option v-for="(client, index) in clients" :key="index" v-bind:value="client.id">{{ client.client_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Ad Duration</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="add.ad_duration">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Visual Identity</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.visual_identity">
                                                <option v-bind:value="1">A</option>
                                                <option v-bind:value="2">B</option>
                                                <option v-bind:value="3">C</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Activation</div>
                                    <div class="col-sm-10 mt-3">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="updateradio" v-bind:value="1" v-model="add.activation">Yes
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="updateradio" v-bind:value="0" v-model="add.activation">No
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

        <!-- Edit Advertise Modal -->
        <div class="modal fade" id="editPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Advertise</h4>
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
                                    <div class="col-sm-2 mt-3">Ad Name</div>
                                    <div class="col-sm-10 mt-3">
                                        <input type="text" class="form-control" v-model="update.ad_name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Selling Identity</div>
                                    <div class="col-sm-10 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.selling_identity">
                                                <option v-for="(selling_identity, index) in selling_identities" :key="index" v-bind:value="selling_identity.id">{{ selling_identity.selling_identity }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Ad Caption</div>
                                    <div class="col-sm-10 mt-3">
                                        <input type="text" class="form-control" v-model="update.ad_caption">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Ad Client</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.ad_client">
                                                <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Merchant</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.merchant">
                                                <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Client Name</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.client_name">
                                                <option v-for="(client, index) in clients" :key="index" v-bind:value="client.id">{{ client.client_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 mt-3">Ad Duration</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="update.ad_duration">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-2 mt-3">Visual Identity</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.visual_identity">
                                                <option v-bind:value="1">A</option>
                                                <option v-bind:value="2">B</option>
                                                <option v-bind:value="3">C</option>
                                            </select>
                                        </div>
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
                    <button class="btn btn-success" @click="updatePost()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            this.fetchAllAds();
            this.fetchAdClient();
            this.fetchMall();
            this.fetchMerchant();
            this.fetchSellingIdentity();
            //this.getResults(); //pagination result
        },
        data(){
            return {
                list:{},
                clients:{},
                malls:{},
                merchants:{},
                selling_identities:{},
                add: {
                    id: "",
                    image: "",
                    ad_name: "",
                    ad_client: "",
                    merchant: "",
                    client_name: "",
                    selling_identity: "",
                    ad_duration: "",
                    visual_identity: "",
                    ad_caption: "",
                    activation: ""
                },
                update: {
                    id: "",
                    ad_name: "",
                    ad_client: "",
                    merchant: "",
                    client_name: "",
                    selling_identity: "",
                    ad_duration: "",
                    visual_identity: "",
                    ad_caption: "",
                    activation: ""
                },
            }
        },
        methods:{
            fetchAllAds(){
                axios.get('https://admin.globalshopping-mall.site/api/ads')
                .then(res => {
                    this.list = res.data;
                    console.log(this.list);
                }).then(res => {
                    
                }).catch(err => {console.log(err);});
            },
            
            fetchAdClient(){
                axios.get('https://admin.globalshopping-mall.site/api/ad_clients')
                .then(res => {
                    this.clients = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchMall(){
                axios.get('https://admin.globalshopping-mall.site/api/malls')
                .then(res => {
                    this.malls = res.data.data;
                }).catch(err => {console.log(err);});
            },

            fetchMerchant(){
                axios.get('https://admin.globalshopping-mall.site/api/merchants')
                .then(res => {
                    this.merchants = res.data.data;
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

            addPost(){
                if(this.add.ad_name == '' || this.add.merchant == '' || this.add.client_name == '' || this.add.selling_identity == '' || this.add.ad_caption == '' || this.add.ad_duration == '' || this.add.visual_identity == '' || this.add.ad_client == ''){
                    return alert("Please fill-up all the fields");
                }
                let formData = new FormData();
                formData.append('image', this.add.image);
                formData.append('ad_name', this.add.ad_name);
                formData.append('ad_client', this.add.ad_client);
                formData.append('merchant', this.add.merchant);
                formData.append('client_name', this.add.client_name);
                formData.append('selling_identity', this.add.selling_identity);
                formData.append('ad_duration', this.add.ad_duration);
                formData.append('visual_identity', this.add.visual_identity);
                formData.append('ad_caption', this.add.ad_caption);
                // formData.append('activation', this.add.activation);
                let config = 
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                axios.post('https://admin.globalshopping-mall.site/api/create_ad', formData, config)
                .then(res => {
                    if(res.status == 201){
                        location.reload();
                    }
                }).catch(error => {console.log(error); });
            },
            editPost(id){
                let i=0;
                axios.get('https://admin.globalshopping-mall.site/api/single_ad/'+id)
                .then(res => {
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            this.update.merchant = this.merchants[i].id;
                            }
                    };
                    // for(i=0; i<this.malls.length; i++){
                    //     if(this.malls[i].mall_name == res.data.data[0].ad_client){
                    //         this.update.ad_client = this.malls[i].id;
                    //     }
                    // };
                    // for(i=0; i<this.list.length; i++){
                    //     if(this.list[i].ad_name == res.data.data[0])
                    // }

                    // console.log(res.data.data)
                    this.update.id = res.data.data[0].id,
                    // this.update.ad_client = res.data.data[0].ad_client,
                    // this.update.merchant = res.data.data[0].merchant,
                    this.update.client_name = res.data.data[0].client_name,
                    this.update.selling_identity = res.data.data[0].selling_identity,
                    this.update.ad_name = res.data.data[0].ad_name,
                    this.update.ad_caption = res.data.data[0].ad_caption,
                    this.update.ad_duration = res.data.data[0].ad_duration,
                    this.update.visual_identity = res.data.data[0].visual_identity
                    this.update.activation = res.data.data[0].activation
                }).catch(error => {console.log(error);});
            },
            updatePost(){
                axios.put('https://admin.globalshopping-mall.site/api/update_ad/' + this.update.id, this.update)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                    }
                }).catch(err => {console.log(err);});
            },
            activation(id){
                let activationCode;
                let ad_client;
                let merchant;
                let client_name;
                let selling_identity;
                let ad_name;
                let ad_caption;
                let ad_duration;
                let visual_identity;
                axios.get('https://admin.globalshopping-mall.site/api/single_ad/'+id)
                .then(res => {
                    //console.log("Response = "+res.data.data.activation);
                    ad_client = res.data.data[0].ad_client;
                    merchant = res.data.data[0].merchant;
                    client_name = res.data.data[0].client_name;
                    selling_identity = res.data.data[0].selling_identity;
                    ad_name = res.data.data[0].ad_name;
                    ad_caption = res.data.data[0].ad_caption;
                    ad_duration = res.data.data[0].ad_duration;
                    visual_identity = res.data.data[0].visual_identity;

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
                    axios.put('https://admin.globalshopping-mall.site/api/update_ad/' + id, {ad_client:ad_client, merchant:merchant, client_name:client_name, selling_identity:selling_identity, ad_name:ad_name, ad_caption:ad_caption, ad_duration:ad_duration, visual_identity:visual_identity, activation: activationCode}).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
            
        }
    }
</script>