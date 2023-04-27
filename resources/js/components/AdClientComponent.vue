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
            <Button class="btn btn-success mb-5" data-toggle="modal" data-target="#addPostModal">Create Ad.Client</Button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="adClientTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AD Client</th>
                                <th>Merchant</th>
                                <th>Client Name</th>
                                <th>Selling Identity</th>
                                <th>Reference No</th>
                                <th>Contact Number</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in list.data' :key='item.id'>
                                <td>{{item.id}}</td>
                                <td>{{item.ad_client}}</td>
                                <td>{{item.merchant}}</td>
                                <td>{{item.client_name}}</td>
                                <td>{{item.selling_identity}}</td>
                                <td>{{item.reference_no}}</td>
                                <td>{{item.contact_number}}</td>
                                <td>{{item.contact_person}}</td>
                                <td>{{item.email}}</td>
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
        <!-- Add New Ad Client Modal -->
        <div class="modal fade" id="addPostModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Ad.Client</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">AD.Client</div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.ad_client">
                                        <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Merchant</div>
                            <div class="col-sm-5 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.merchant">
                                        <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Client Name</div>
                            <div class="col-sm-5 mt-3">
                                <input type="text" class="form-control" v-model="add.client_name">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Selling Identity</div>
                            <div class="col-sm-5 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="add.selling_identity">
                                        <option v-for="(selling_identity, index) in selling_identities" :key="index" v-bind:value="selling_identity.id">{{ selling_identity.selling_identity }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Reference No</div>
                            <div class="col-sm-5 mt-3">
                                <input type="text" class="form-control" v-model="add.reference_no">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Contact Number</div>
                            <div class="col-sm-5 mt-3">
                                <input type="number" class="form-control" v-model="add.contact_number">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Contact Person</div>
                            <div class="col-sm-5 mt-3">
                                <input type="text" class="form-control" v-model="add.contact_person">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Email</div>
                            <div class="col-sm-5 mt-3">
                                <input type="email" class="form-control" v-model="add.email">
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
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Ad.Client</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">AD.Client</div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.ad_client">
                                        <option v-for="(mall, index) in malls" :key="index" v-bind:value="mall.id">{{ mall.mall_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Merchant</div>
                            <div class="col-sm-5 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.merchant">
                                        <option v-for="(merchant, index) in merchants" :key="index" v-bind:value="merchant.id">{{ merchant.merchant_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-3">Client Name</div>
                            <div class="col-sm-5 mt-3">
                                <input type="text" class="form-control" v-model="update.client_name">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Selling Identity</div>
                            <div class="col-sm-5 mt-3">
                                <div class="form-group">
                                    <select class="form-control" v-model="update.selling_identity">
                                        <option v-for="(selling_identity, index) in selling_identities" :key="index" v-bind:value="selling_identity.id">{{ selling_identity.selling_identity }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Reference No</div>
                            <div class="col-sm-5 mt-3">
                                <input type="text" class="form-control" v-model="update.reference_no">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Contact Number</div>
                            <div class="col-sm-5 mt-3">
                                <input type="number" class="form-control" v-model="update.contact_number">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Contact Person</div>
                            <div class="col-sm-5 mt-3">
                                <input type="text" class="form-control" v-model="update.contact_person">
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-3 mt-3">Email</div>
                            <div class="col-sm-5 mt-3">
                                <input type="email" class="form-control" v-model="update.email">
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
            this.fetchAdClient();
            this.fetchMall();
            this.fetchMerchant();
            this.fetchSellingIdentity();
            //this.getResults(); //pagination result
        },
        data(){
            return {
                list:{},
                malls:{},
                merchants:{},
                selling_identities:{},
                add: {
                    id: "",
                    ad_client: "",
                    merchant: "",
                    client_name: "",
                    selling_identity: "",
                    reference_no: "",
                    contact_number: "",
                    contact_person: "",
                    email: "",
                    activation: ""
                },
                update: {
                    id: "",
                    ad_client: "",
                    merchant: "",
                    client_name: "",
                    selling_identity: "",
                    reference_no: "",
                    contact_number: "",
                    contact_person: "",
                    email: "",
                    activation: ""
                },
            }
        },
        methods:{
            fetchAdClient(){
                axios.get('https://admin.globalshopping-mall.site/api/ad_clients')
                .then(res => {
                    this.list = res.data;
                }).then(res => {
                    
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

            addPost(){
                if(this.add.ad_client == '' || this.add.merchant == '' || this.add.client_name == '' || this.add.selling_identity == '' || this.add.reference_no == '' || this.add.contact_number == '' || this.add.contact_person == '' || this.add.email == ''){
                    return alert("Please fill-up all the fields");
                }
                axios.post('https://admin.globalshopping-mall.site/api/create_ad_client', this.add)
                .then(res => {
                    if(res.status == 201){
                       
                        location.reload();
                    }
                }).catch(error => {console.log(error); });
            },

            editPost(id){
                let i = 0;
                axios.get('https://admin.globalshopping-mall.site/api/single_ad_client/'+id)
                .then(res => {
                    // console.log(res.data.data)
                    for(i=0; i<this.merchants.length; i++){
                        if(this.merchants[i].merchant_name == res.data.data[0].merchant_name){
                            this.update.merchant = this.merchants[i].id;
                        }
                    }
                    this.update.id = res.data.data[0].id,
                    this.update.ad_client = res.data.data[0].ad_client,
                    // this.update.merchant = res.data.data[0].merchant,
                    this.update.client_name = res.data.data[0].client_name,
                    this.update.selling_identity = res.data.data[0].selling_identity,
                    this.update.reference_no = res.data.data[0].reference_no,
                    this.update.contact_number = res.data.data[0].contact_number,
                    this.update.contact_person = res.data.data[0].contact_person,
                    this.update.email = res.data.data[0].email
                    this.update.activation = res.data.data[0].activation
                }).catch(error => {console.log(error);});
            },
            updatePost(){
                axios.put('https://admin.globalshopping-mall.site/api/update_ad_client/' + this.update.id, this.update)
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
                let reference_no;
                let contact_number;
                let contact_person;
                let email;
                axios.get('https://admin.globalshopping-mall.site/api/single_ad_client/'+id)
                .then(res => {
                    //console.log("Response = "+res.data.data.activation);
                    ad_client = res.data.data[0].ad_client;
                    merchant = res.data.data[0].merchant;
                    client_name = res.data.data[0].client_name;
                    selling_identity = res.data[0].data.selling_identity;
                    reference_no = res.data.data[0].reference_no;
                    contact_number = res.data.data[0].contact_number;
                    contact_person = res.data.data[0].contact_person;
                    email = res.data.data[0].email;

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
                    axios.put('https://admin.globalshopping-mall.site/api/update_ad_client/' + id, {ad_client:ad_client, merchant:merchant, client_name:client_name, selling_identity:selling_identity, reference_no:reference_no, contact_number:contact_number, contact_person:contact_person, email:email, activation: activationCode}).then(res => {location.reload();}).catch(err => {console.log("Error = "+err);})
                }).catch(err => {console.log("Error = "+err);})
                .catch(err => {console.log("Error = "+err);})
            },
            
        }
    }
</script>