require("./bootstrap");
import Vue from "vue";
// window.Vue = require('vue');
import VueSweetalert2 from "vue-sweetalert2";
import VueTimepicker from 'vue2-timepicker/dist/VueTimepicker.common.js'
import en from './lang/en.json'
import mm from './lang/mm.json'
import Swal from "sweetalert2/dist/sweetalert2.js";


import { store } from "./Store";
import "tw-elements";

Vue.component(
    "example-component",
    require("./Components/exampleComponent.vue").default
);
Vue.component(
    "Createbtn",
    require("./Components/createButtonComponent.vue").default
);
Vue.component(
    "Searchbox",
    require("./Components/searchBoxComponent.vue").default
);
Vue.component(
    "apiLoading",
    require("./Components/apiLoadingComponent.vue").default
);
Vue.component(
    "TablePagination",
    require("./Components/tablePaginationComponent.vue").default
);

Vue.component("Category", require("./Pages/category.vue").default);
Vue.component("Users", require("./Pages/users.vue").default);
Vue.component("Color", require("./Pages/color.vue").default);
Vue.component("Brand", require("./Pages/brand.vue").default);
Vue.component("Occasion", require("./Pages/occasions.vue").default);
Vue.component("InventoryLists", require("./Pages/inventoryLists.vue").default);
Vue.component(
    "InventoryListsCreateEdit",
    require("./Pages/inventoryListsCreateEdit.vue").default
);
Vue.component(
    "supplierCreateEdit",
    require("./Pages/supplierCreateEdit.vue").default
);
Vue.component("supplierLists", require("./Pages/supplierLists.vue").default);
Vue.component(
    "subCategoryCreateEdit",
    require("./Pages/subCateogryCreateEdit.vue").default
);
Vue.component(
    "subCategoryLists",
    require("./Pages/subCategoryLists.vue").default
);
Vue.component(
    "variationCreateEdit",
    require("./Pages/variationCreateEdit.vue").default
);
Vue.component("variationLists", require("./Pages/variationLists.vue").default);

Vue.component(
    "productCreateEdit",
    require("./Pages/ProductCreateEdit.vue").default
);
Vue.component("productLists", require("./Pages/ProductLists.vue").default);

Vue.component(
    "subProductLists",
    require("./Pages/SubProductLists.vue").default
);
Vue.component(
    "styleCreateEdit",
    require("./Pages/StyleCreateEdit.vue").default
);
Vue.component(
    "styleCreateEditTagTwo",
    require("./Components/StyleCreateEditTagTwo.vue").default
);
Vue.component("styleLists", require("./Pages/StyleLists.vue").default);
Vue.component(
    "collectionCreateEdit",
    require("./Pages/CollectionCreateEdit.vue").default
);
Vue.component(
    "collectionLists",
    require("./Pages/CollectionLists.vue").default
);
Vue.component("reviewLists", require("./Pages/reviewLists.vue").default);

//web
// Vue.component(
//     "loginRegister",
//     require("./Pages/web/loginRegister.vue").default
// );
// Vue.component(
//     "Home",
//     require("./Pages/web/Home.vue").default
// );



Vue.component("ads", require("./Pages/Ads.vue").default);
Vue.component("adsCreateEdit", require("./Pages/adsCreateEdit.vue").default);
Vue.component("delivery", require("./Pages/Delivery.vue").default);
Vue.component(
    "deliveryCreateEdit",
    require("./Pages/DeliveryCreateEdit.vue").default
);
Vue.component("adminUsers", require("./Pages/AdminUsers").default);
Vue.component(
    "adminUserCreateEdit",
    require("./Pages/AdminUserCreateEdit.vue").default
);
Vue.component("StockCreate", require("./Pages/StockCreate.vue").default);
Vue.component("StockLists", require("./Pages/StockLists.vue").default);
Vue.component("DefectLists", require("./Pages/DefectLists.vue").default);
Vue.component("InvoiceLists", require("./Pages/InvoiceLists.vue").default);
Vue.component("InvoiceDetail", require("./Pages/InvoiceDetail.vue").default);
Vue.component("InvoiceEdit", require("./Pages/InvoiceEdit.vue").default);

Vue.component(
    "InventoryTrasferCreate",
    require("./Pages/InventoryTrasferCreate.vue").default
);
Vue.component(
    "InventoryTransferLists",
    require("./Pages/InventoryTransferLists.vue").default
);
Vue.component(
    "InventoryTransferDetail",
    require("./Pages/InventoryTransferDetail.vue").default
);
Vue.component(
    "InventoryTransferAccept",
    require("./Pages/InventoryTransferAccept.vue").default
);
Vue.component(
    "OrderLists",
    require("./Pages/OrderLists.vue").default
);
Vue.component(
    "SaleReturnLists",
    require("./Pages/SaleReturnLists.vue").default
);
Vue.component(
    "OrderListsByInventory",
    require("./Pages/OrderListsByInventory.vue").default
);
Vue.component(
    "CouponCreateEdit",
    require("./Pages/CouponCreateEdit.vue").default
);
Vue.component(
    "CouponLists",
    require("./Pages/CouponLists.vue").default
);

Vue.component(
    "Notifications",
    require("./Components/Notifications.vue").default
);

// Vue.component(
//     "forgetPassword",
//     require("./Pages/web/forgetPassword.vue").default
// );
// Vue.component("ProductListsWeb", require("./Pages/web/ProductLists.vue").default);
// Vue.component("Navbar", require("./Components/web/Navbar.vue").default);
// Vue.component("ProductDetail", require("./Pages/web/ProductDetail.vue").default);
// Vue.component("StyleDetail", require("./Pages/web/StyleDetail.vue").default);
// Vue.component("CollectionDetail", require("./Pages/web/CollectionDetail.vue").default);
// Vue.component("profile", require("./Pages/web/profile.vue").default);
// Vue.component("CategorySidebar", require("./Components/web/CategorySidebar.vue").default);
// Vue.component("StyleListsWeb", require("./Pages/web/StyleListsWeb.vue").default);
// Vue.component("CollectionListsWeb", require("./Pages/web/CollectionListsWeb.vue").default);
// Vue.component("AllBrandLists", require("./Pages/web/AllBrandLists.vue").default);
// Vue.component("Cart", require("./Pages/web/Cart.vue").default);
// Vue.component("FlashSaleDetail", require("./Pages/web/FlashSaleDetail.vue").default);
// Vue.component("TimeCount", require("./Components/web/Home/TimeCount.vue").default);


//start
//#region discount
// Vue.component("OldDiscountCreate", require("./Pages/OldDiscountCreate.vue").default);
// Vue.component("OldDiscountList", require("./Pages/OldDiscountList.vue").default);

Vue.component("DiscountCreateEdit", require("./Pages/DiscountCreateEdit.vue").default);
Vue.component("DiscountTest", require("./Pages/DiscountTest.vue").default);
Vue.component("DiscountList", require("./Pages/DiscountList.vue").default);
Vue.component("FlashSaleCreateEdit", require("./Pages/FlashSaleCreateEdit.vue").default);
Vue.component("FlashSaleLists", require("./Pages/FlashSaleLists.vue").default);
//#endregion

//#region campaign
Vue.component("CampaignCreateEdit", require("./Pages/CampaignCreateEdit.vue").default);
Vue.component("CampaignList", require("./Pages/CampaignList.vue").default);


//#region township
Vue.component("TownshipList", require("./Pages/TownshipList.vue").default);
Vue.component("TownshipCreateEdit", require("./Pages/TownshipCreateEdit.vue").default);
//end

//#region support Ticket
Vue.component("SupportTicketList", require("./Pages/SupportTicketList.vue").default);
Vue.component("SupportTicketReply", require("./Pages/SupportTicketReply.vue").default);
//end

//#size guide
Vue.component("SizeGuideCreate", require("./Pages/SizeGuideCreate.vue").default);
Vue.component("SizeGuideLists", require("./Pages/SizeGuideLists.vue").default);

//Customer chats
Vue.component("ChatsViewInitialize", require("./Pages/ChatsViewInitialize.vue").default);

// #ads_type
Vue.component("AdsType", require("./Pages/AdsType.vue").default);
Vue.component("SizeList", require("./Pages/SizeList.vue").default);

// import { i18nVue } from 'laravel-vue-i18n'
import VueI18n from 'vue-i18n'

Vue.use(VueTimepicker);
Vue.use(VueSweetalert2);
Vue.use(VueI18n)

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  timer: 5000,
  timerProgressBar: true,
  showConfirmButton: false
});
//salva a configuração global na palavra "Toast"
window.Toast = Toast;

import { languages } from './i18n/index'
import { defaultLocale } from './i18n/index.js'
const messages = Object.assign(languages)

const i18n = new VueI18n({
    locale: defaultLocale,
    fallbackLocale: 'mm',
    messages
    // locale: 'en', // set locale
    // messages, // set locale messages
})

const app = new Vue({
    el: "#app",
    store,
    i18n
});
// app.component(VueCountdown.name, VueCountdown);

