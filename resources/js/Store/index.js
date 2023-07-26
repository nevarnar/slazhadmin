import Vue from "vue";
import Vuex from "vuex";
import Counts from "./modules/Counts";
import Category from "./modules/Category";
import Occasions from "./modules/Occasions";
import Colors from "./modules/Colors";
import Brands from "./modules/Brands";
import Suppliers from "./modules/Suppliers";
import SubCategory from "./modules/SubCatgory";
import Variations from "./modules/Variations";
import Products from "./modules/products";
import SubProducts from "./modules/SubProducts";
import CommonData from "./modules/common_data";
import Styles from "./modules/Styles";
import Collections from "./modules/Collections";
import Reviews from "./modules/Reviews";
import Ads from "./modules/Ads";
import Delivery from "./modules/Delivery";
import Users from "./modules/Users";
import InventoryLists from "./modules/InventoryLists";
import AdminUsers from "./modules/AdminUsers";
import Stocks from "./modules/Stocks";
import DefectLists from "./modules/DefectLists";
import Inventory from "./modules/Inventory";

import WebCommon from "./modules/web/WebCommon";
// import Auth from "./modules/web/Auth";
// import Home from "./modules/web/Home";
// import ProductDetail from "./modules/web/ProductDetail";
// import StyleDetail from "./modules/web/StyleDetail";
// import profileDetail from "./modules/web/profileDetail";
// import CollectionDetail from "./modules/web/CollectionDetail";
//start
import Discount from "./modules/Discount";
import DiscountList from "./modules/DiscountList";
import Campaign from "./modules/Campaign";
import Township from "./modules/Township";
import SupportTicket from "./modules/SupportTicket";
import TicketReply from "./modules/TicketReply";
import Order from "./modules/Order";
import AdsTypeList from "./modules/AdsType";
import SizeList from "./modules/Size";

//end

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        Counts: Counts,
        Category,
        Occasions,
        Colors,
        Brands,
        Suppliers,
        SubCategory,
        Variations,
        Products,
        CommonData,
        SubProducts,
        Styles,
        Collections,
        Reviews,

        // Auth,
        Ads,
        Delivery,
        Users,
        InventoryLists,
        AdminUsers,
        Stocks,
        DefectLists,
        Inventory,
        Order,

        // Home,
        WebCommon,
        // ProductDetail,
        // StyleDetail,
        // profileDetail,
        // CollectionDetail,

        Discount,
        DiscountList,
        Campaign,
        Township,
        SupportTicket,
        TicketReply,
        AdsTypeList,
        SizeList

    },
});

// export default store;
