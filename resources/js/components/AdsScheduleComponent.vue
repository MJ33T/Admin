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
            <Button class="btn btn-success mb-5" data-toggle="modal" data-target="#createAdScheduleModal">Create AD.Schedule</Button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="adScheduleTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AD Image</th>
                                <th>Slot No</th>
                                <th>AD. ID. No.</th>
                                <th>AD Name</th>
                                <th>AD. Caption</th>
                                <th>Client No.</th>
                                <th>Number of Weeks</th>
                                <th>Total</th>
                                <th>Activation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='item in list.data' :key='item.id'>
                            <a  href="#editPostModal" data-toggle="modal" @click="editPost(item.id);">
                                <td>{{item.id}}</td>
                            </a>
                                <td></td>
                                <td></td>
                                <td>{{item.ad_ID}}</td>
                                <td>{{item.ad_name}}</td>
                                <td>{{item.ad_caption}}</td>
                                <td>{{item.client_no}}</td>
                                <td>{{item.number_of_week}}</td>
                                <td>{{item.total}}</td>
                                <td></td>
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

        <!-- Add New AD Schedule Modal -->
        <div class="modal fade" id="createAdScheduleModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Slot {{slot_index}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <!-- <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png"/>
                                    </label>
                                    <input type="file" name="file"  v-on:change="handleFileUpload($event)" />
                                </div>
                            </div> -->
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-3 mt-3">Create Date</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="add.created_date" readonly>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">AD. ID No.</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="add.ad_ID">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">AD. Name</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="add.ad_name">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">AD. Caption</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="add.ad_caption">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Client No.</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.client_no">
                                                <option v-for="(client, index) in clients" :key="index" v-bind:value="client.id">{{ client.client_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 mt-3">AD. Description</div>
                                    <div class="col-sm-9 mt-3">
                                        <textarea class="form-control" rows="5" v-model="add.description"></textarea>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Visual Identity</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="add.visual_identity">
                                                <option v-for="(visual_identity, index) in visual_identities" :key="index" v-bind:value="visual_identity.id">{{ visual_identity.visual_identity }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Start Date</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="date" class="form-control" v-model="add.start_date">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">End Date</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="date" class="form-control" v-model="add.end_date">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Rate Card</div>
                                    <div class="col-sm-4 mt-3">
                                        <input type="text" class="form-control" :placeholder="rateCard" disabled>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <button class="btn btn-secondary" data-toggle="modal" data-target="#rateCardModal">Click Here</button>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Number of Weeks</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="add.number_of_week">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Slots</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="add.slot">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Cost</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="add.cost">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Discount</div>
                                    <div class="col-sm-3 mt-3">
                                        <input type="text" class="form-control" v-model="add.percent" placeholder="%">
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <input type="text" class="form-control" v-model="add.discount">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Tax/SST</div>
                                    <div class="col-sm-3 mt-3">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="addradio" v-bind:value="1" v-model="add.tax">Yes
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="addradio" v-bind:value="0" v-model="add.tax">No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">
                                        <input type="text" class="form-control" v-model="add.total">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Total</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="add.total">
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

        <!-- Rate Card Modal -->
        <div class="modal fade" id="rateCardModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Rate Card</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div >
                            <label for="page">Page</label>
                            <div class="form-group">
                                <select class="form-control" name="page" v-model="add.page">
                                    <option v-bind:value="1">Page 1 | Login</option>
                                    <option v-bind:value="2">Page 2 | Sign Up</option>
                                </select>
                            </div>
                            <label for="second">Seconds</label>
                            <div class="form-group">
                                <select class="form-control" name="second" v-model="add.seconds">
                                    <option v-bind:value="5">5s</option>
                                    <option v-bind:value="10">10s</option>
                                    <option v-bind:value="15">15s</option>
                                    <option v-bind:value="20">20s</option>
                                    <option v-bind:value="25">25s</option>
                                    <option v-bind:value="30">30s</option>
                                </select>
                            </div>
                            <label for="rate">Rate</label>
                            <input type="text" class="form-control" name="rate" v-model="add.rate">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" data-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Ad Schedule Modal -->
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
                            <!-- <div class="col-sm-4">
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img src="../logos/Upload.png"/>
                                    </label>
                                    <input type="file" name="file"  v-on:change="handleFileUpload($event)" />
                                </div>
                            </div> -->
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3 mt-3">Create Date</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="dateTime" readonly>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">AD. ID No.</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="update.ad_ID">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">AD. Name</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="update.ad_name">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">AD. Caption</div>
                                    <div class="col-sm-9 mt-3">
                                        <input type="text" class="form-control" v-model="update.ad_caption">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Client No.</div>
                                    <div class="col-sm-7 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.client_no">
                                                <option v-for="(client, index) in clients" :key="index" v-bind:value="client.id">{{ client.client_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 mt-3">AD. Description</div>
                                    <div class="col-sm-9 mt-3">
                                        <textarea class="form-control" rows="5" v-model="update.description"></textarea>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Visual Identity</div>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-group">
                                            <select class="form-control" v-model="update.visual_identity">
                                                <option v-for="(visual_identity, index) in visual_identities" :key="index" v-bind:value="visual_identity.id">{{ visual_identity.visual_identity }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Start Date</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="date" class="form-control" v-model="update.start_date">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">End Date</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="date" class="form-control" v-model="update.end_date">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Rate Card</div>
                                    <div class="col-sm-4 mt-3">
                                        <input type="text" class="form-control" :placeholder="editRateCard" disabled>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <button class="btn btn-secondary" data-toggle="modal" data-target="#editrateCardModal">Click Here</button>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Number of Weeks</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="update.number_of_week">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Slots</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="update.slot">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Cost</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="update.cost">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Discount</div>
                                    <div class="col-sm-3 mt-3">
                                        <input type="text" class="form-control" v-model="update.percent" placeholder="%">
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <input type="text" class="form-control" v-model="update.discount">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Tax/SST</div>
                                    <div class="col-sm-4 mt-3">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="addradio" v-bind:value="1" v-model="update.tax">Yes
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="addradio" v-bind:value="0" v-model="update.tax">No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-3">
                                        <input type="text" class="form-control" v-model="update.total">
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col-sm-3 mt-3">Total</div>
                                    <div class="col-sm-7 mt-3">
                                        <input type="text" class="form-control" v-model="update.total">
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
        <!-- Rate Card Modal -->
        <div class="modal fade" id="editrateCardModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Rate Card</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div >
                            <label for="page">Page</label>
                            <div class="form-group">
                                <select class="form-control" name="page" v-model="update.page">
                                    <option v-bind:value="1">Page 1 | Login</option>
                                    <option v-bind:value="2">Page 2 | Sign Up</option>
                                </select>
                            </div>
                            <label for="editsecond">Seconds</label>
                            <div class="form-group">
                                <select class="form-control" name="editsecond" v-model="update.seconds">
                                    <option v-bind:value="5">5s</option>
                                    <option v-bind:value="10">10s</option>
                                    <option v-bind:value="15">15s</option>
                                    <option v-bind:value="20">20s</option>
                                    <option v-bind:value="25">25s</option>
                                    <option v-bind:value="30">30s</option>
                                </select>
                            </div>
                            <label for="rate">Rate</label>
                            <input type="text" class="form-control" name="rate" v-model="update.rate">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" data-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.fetchAdSchedule();
            this.currentDateTime();
            this.fetchAdClient();
            this.fetchAllAds();
        },

        data(){
            return {
                slot_index:"",
                dateTime:"",
                list:{},
                clients:{},
                visual_identities:{},
                add: {
                    id: "",
                    created_date: "",
                    ad_ID: "",
                    ad_name: "",
                    ad_caption: "",
                    client_no: "",
                    description: "",
                    visual_identity: "",
                    start_date: "",
                    end_date: "",
                    page: "",
                    seconds: "",
                    rate: "",
                    number_of_week: "",
                    slot: "",
                    cost: "",
                    discount: "",
                    tax: "",
                    total: "",
                },
                update: {
                    id: "",
                    ad_ID: "",
                    ad_name: "",
                    ad_caption: "",
                    client_no: "",
                    description: "",
                    visual_identity: "",
                    start_date: "",
                    end_date: "",
                    page: "",
                    seconds: "",
                    rate: "",
                    number_of_week: "",
                    slot: "",
                    cost: "",
                    discount: "",
                    tax: "",
                    total: "",
                },
            }
        },

        computed: {
            rateCard(){
                //console.log(this.add.page, this.add.seconds, this.add.rate);
                return 'Page '+ this.add.page +'. '+ this.add.seconds +'S.'+' RM '+ this.add.rate;
            },
            editRateCard(){
                return 'Page '+ this.update.page +'. '+ this.update.seconds +'S.'+' RM '+ this.update.rate;
            }
        },

        methods:{
            fetchAdSchedule(){
                axios.get('https://admin.globalshopping-mall.site/api/ad_schedules')
                .then(res => {
                    this.list = res.data;
                    //console.log(this.list);
                }).catch(err => {console.log(err);});
            },

            slotNumber(index){
                this.slot_index = index;
            },

            currentDateTime() {
                const current = new Date();
                const date = current.getDate()+'-'+(current.getMonth()+1)+'-'+current.getFullYear();
                //const time = current.getHours() + ":" + current.getMinutes() + ":" + current.getSeconds();
                //this.dateTime = date +' '+ time;
                this.dateTime = date;
                this.add.created_date = this.dateTime;
                //console.log(this.dateTime);

                return this.dateTime;
            },

            fetchAdClient(){
                axios.get('https://admin.globalshopping-mall.site/api/ad_clients')
                .then(res => {
                    this.clients = res.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },

            fetchAllAds(){
                axios.get('https://admin.globalshopping-mall.site/api/ads')
                .then(res => {
                    this.visual_identities = res.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },

            addPost(){
                if(this.add.ad_ID == '' || this.add.ad_name == '' || this.add.ad_caption == '' || this.add.client_no == '' || this.add.description == '' || this.add.visual_identity == '' || this.add.start_date == '' || this.add.end_date == '' || this.add.rate == '' || this.add.number_of_week == '' || this.add.slot == '' || this.add.cost == '' || this.add.discount == '' || this.add.tax == '' || this.add.total == ''){
                    return alert("Please fill-up all the fields");
                }
                // console.log(this.add)
                axios.post('https://admin.globalshopping-mall.site/api/create_ad_schedule', this.add)
                .then(res => {
                    
                    if(res.status == 201){
                        
                        location.reload();
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            editPost(id){
                axios.get('https://admin.globalshopping-mall.site/api/single_ad_schedule/'+id)
                .then(res => {
                    // console.log(res.data.data.client_no)
                    this.update.id = res.data.data.id,
                    this.update.ad_ID = res.data.data.ad_ID,
                    this.update.ad_name = res.data.data.ad_name,
                    this.update.ad_caption = res.data.data.ad_caption,
                    this.update.client_no = res.data.data.client_no,
                    this.update.description = res.data.data.description,
                    this.update.visual_identity = res.data.data.visual_identity,
                    this.update.start_date = res.data.data.start_date,
                    this.update.end_date = res.data.data.end_date,
                    this.update.page = res.data.data.page,	
                    this.update.seconds = res.data.data.seconds,	
                    this.update.rate = res.data.data.rate,	
                    this.update.number_of_week = res.data.data.number_of_week,	
                    this.update.slot = res.data.data.slot,	
                    this.update.cost = res.data.data.cost,	
                    this.update.discount = res.data.data.discount,	
                    this.update.tax = res.data.data.tax,	
                    this.update.total = res.data.data.total

                    //this.add.activation = res.data.data.activation
                }).catch(error => {
                    console.log(error);
                });
            },
            updatePost(){
                console.log(this.update)
                axios.put('https://admin.globalshopping-mall.site/api/update_ad_schedule/' + this.update.id, this.update)
                .then(res => {
                    if(res.status == 200){
                        location.reload();
                        //alert("Successfully Updated");
                    }
                   // this.fetchAPI();
                }).catch(err => {
                    console.log(err);
                });
            },
            
        }
    }
</script>