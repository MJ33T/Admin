<template>
    <div class="containe mt-2" >
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="floorTable" class="table table-striped hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order Id</th>
                                <th>Customer Name</th>
                                <th>Contact Number</th>
                                <th>Date & Time</th>
                                <th>Delivary Status</th>
                                <th>Shipping Fee</th>
                                <th>Vouchar</th>
                                <th colspan="2" style="text-align:center">GSM</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>order-1</td>
                                <td>Test Customer</td>
                                <td>12345</td>
                                <td>9/6/2022 14:29:36</td>
                                <td>Order Placed</td>
                                <td>2</td>
                                <td>Test Vouchar</td>
                                <td>1</td>
                                <td>1</td>
                                <td>4</td>
                                <td><button class="btn btn-primary">View Details</button></td>
                            </tr> 
                            <tr>
                                <td>2</td>
                                <td>order-2</td>
                                <td>Test Customer 2</td>
                                <td>67890</td>
                                <td>9/6/2022 14:32:36</td>
                                <td>To Pay</td>
                                <td>2</td>
                                <td>Test Vouchar 1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>4</td>
                                <td><button class="btn btn-primary">View Details</button></td>
                            </tr>    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

