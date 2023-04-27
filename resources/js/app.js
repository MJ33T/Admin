import './bootstrap';

import { createApp } from 'vue';
import floor from './components/FloorComponent.vue';
import category from './components/CategoryComponent.vue';
import product from './components/ProductComponent.vue';
import brand from './components/BrandComponent.vue';
import subBrand from './components/SubBrandComponent.vue';
import mall from './components/MallComponent.vue';
import merchant from './components/MerchantComponent.vue';
import subBrandDetail from './components/SubBrandDetailComponent.vue';
import newShop from './components/NewShopComponent.vue';
import usedShop from './components/UsedShopComponent.vue';
import otherMall from './components/OtherMallShopComponent.vue';
import sellingIdentity from './components/SellingIdentityComponent.vue';
import promotion from './components/PromotionUpdateComponent.vue';
import voucher from './components/VoucherComponent.vue';
import adsClient from './components/AdClientComponent.vue';
import createAds from './components/CreateAdsComponent.vue';
import adsSchedule from './components/AdsScheduleComponent.vue';
import manageAdmin from './components/ManageAdminComponent.vue';
import dashboard from './components/DashboardComponent.vue';
import merchantDashboard from './components/MerchantDashboardComponent.vue';
// import merchantProduct from './components/MerchantPortalProductComponent.vue';
import sales from './components/SalesComponent.vue';
import transaction from './components/TransactionComponent.vue';
import report from './components/ReportsComponent.vue';
import merchant_brand from './components/MerchantBrandComponent';
import merchant_sub_brand from './components/MerchantSubBrandComponent';
import merchant_sub_brand_detail from './components/MerchantSubBrandDetailComponent';
import merchant_voucher from './components/MerchantVoucherComponent';
import merchant_promotion from './components/MerchantPromotionUpdateComponent';


let Floor = createApp(floor);
Floor.mount("#floor");

let Category = createApp(category);
Category.mount("#category");

let Product = createApp(product);
Product.mount("#product");

let Brand = createApp(brand);
Brand.mount("#brand");

let SubBrand = createApp(subBrand);
SubBrand.mount("#subBrand");

let Mall = createApp(mall);
Mall.mount("#mall");

let Merchant = createApp(merchant);
Merchant.mount("#merchant");

let SubBrandDetail = createApp(subBrandDetail);
SubBrandDetail.mount("#subBrandDetail");

let NewShop = createApp(newShop);
NewShop.mount("#newShop");

let UsedShop = createApp(usedShop);
UsedShop.mount("#usedShop");

let OtherMall = createApp(otherMall);
OtherMall.mount("#otherMall");

let SellingIdentity = createApp(sellingIdentity);
SellingIdentity.mount("#sellingIdentity");

let Promotion = createApp(promotion);
Promotion.mount("#promotion");

let Voucher = createApp(voucher);
Voucher.mount("#voucher");

let AdsClient = createApp(adsClient);
AdsClient.mount("#adsClient");

let CreateAds = createApp(createAds);
CreateAds.mount("#createAds");

let AdsSchedule = createApp(adsSchedule);
AdsSchedule.mount("#adsSchedule");

let ManageAdmin = createApp(manageAdmin);
ManageAdmin.mount("#manageAdmin");

let Dashboard = createApp(dashboard);
Dashboard.mount('#dashboard');

let Sales = createApp(sales);
Sales.mount("#sales");

let Transaction = createApp(transaction);
Transaction.mount("#transaction");

let Report = createApp(report);
Report.mount("#report");




let MerchantDashboard = createApp(merchantDashboard);
MerchantDashboard.mount('#merchantDashboard');

// let MerchantProduct = createApp(merchantProduct);
// MerchantProduct.mount('#merchantProduct');

let MerchantBrand = createApp(merchant_brand);
MerchantBrand.mount('#merchantBrand');

let MerchantSubBrand = createApp(merchant_sub_brand);
MerchantSubBrand.mount('#merchantSubBrand');

let MerchantSubBrandDetail = createApp(merchant_sub_brand_detail);
MerchantSubBrandDetail.mount('#merchantSubBrandDetail');

let MerchantVoucher = createApp(merchant_voucher);
MerchantVoucher.mount('#merchantVoucher');

let MerchantPromotion = createApp(merchant_promotion);
MerchantPromotion.mount('#merchantPromotion');