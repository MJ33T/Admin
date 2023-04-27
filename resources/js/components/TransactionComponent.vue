<template>
    <div class="containe mt-2" >
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="floorTable" class="table table-striped hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Transaction Id</th>
                                <th>Date</th>
                                <th>Shop</th>
                                <th>Customer</th>
                                <th>SST</th>
                                <th>GST</th>
                                <th>Shipping Cost</th>
                                <th>Payment Gateway</th>
                                <th>Payment Mode</th>
                                <th>Voucher</th>
                                <th>Net Total</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>trans-1</td>
                                <td>9/6/2022</td>
                                <td>Test Shop</td>
                                <td>Test Customer</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1.5</td>
                                <td>Test Gateway</td>
                                <td>online</td>
                                <td>Test Voucher</td>
                                <td>5</td>
                                <td><button class="btn btn-primary">View Details</button></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>trans-2</td>
                                <td>9/6/2022</td>
                                <td>Test Shop 2</td>
                                <td>Test Customer 2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2.5</td>
                                <td>Test Gateway 2</td>
                                <td>online</td>
                                <td>Test Voucher 2</td>
                                <td>8</td>
                                <td><button class="btn btn-primary">View Details</button></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

