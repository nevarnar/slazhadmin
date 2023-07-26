import { forEach } from "lodash";

export default {
    state: {
        inventories: [],
        transfer_items: [],
        transfer_items_for_api: [],
        inventory_transfer_lists: [],
        transfer_accept_list: {},
    },
    getters: {
        myInventories(state) {
            return state.inventories;
        },
        myTransferItems(state) {
            return state.transfer_items;
        },
        myTransferItemsForApi(state) {
            return state.transfer_items_for_api;
        },
        myInventoryTransferLists(state) {
            return state.inventory_transfer_lists;
        },
        transferAcceptLists(state) {
            return state.transfer_accept_list;
        },
    },
    mutations: {
        setInventories(state, inventories) {
            state.inventories = inventories;
        },
        setInventory(state, inventory) {
            state.inventories.unshift(inventory);
        },
        setTransferItem(state, item) {
            console.log("vuex", item);
            state.transfer_items.push(item);
        },
        setTransferItems(state, items) {
            state.transfer_items = items;
        },
        setTransferItemForApi(state, item) {
            state.transfer_items_for_api.unshift(item);
        },
        setInventoryTransferLists(state, lists) {
            state.inventory_transfer_lists = lists;
        },
        setTransferAcceptLists(state, lists) {
            state.transfer_accept_list = lists;
        },
        addRecommendShelf(state, payload) {
            var found = state.transfer_accept_list.sub_products.find(function(
                subproduct
            ) {
                return subproduct.id == payload.id;
            });
            found.recommended_floor.push(payload.shelf);
        },
        deleteShelf(state, payload) {
            var found = state.transfer_accept_list.sub_products.find(function(
                subproduct
            ) {
                return subproduct.id == payload.id;
            });
            let leftShelf = found.recommended_floor.filter(function(floor) {
                return floor.id !== payload.shelf_id;
            });
            found.recommended_floor = leftShelf;
            console.log("found", found);
        },
        setUpdateInventory(state, updateInventory) {
            state.inventories = state.inventories.filter((inventory) => {
                return inventory.id != updateInventory.id;
            });
            state.inventories.unshift(updateInventory);
        },
        removeInventory(state, removeId) {
            state.inventories = state.inventories.filter((inventory) => {
                return inventory.id != removeId;
            });
        },
        removeTransferItem(state, removeId) {
            console.log('removid', removeId);
            let filterItems = state.transfer_items.filter(function(item) {
                return item.item.id != removeId;
            });
            console.log('filter', filterItems)
            this.commit("setTransferItems", filterItems)
                // state.transfer_items = leftShelf;
                // state.transfer_items.forEach((element, index) => {
                //     console.log(element.item.id, removeId);
                //     console.log('sersdf', state.transfer_items)
                //     if (element.item.id == removeId) {
                //         console.log('todelete', index, element.item);
                //         state.transfer_items.splice(index, 1);
                //     }
                // });
                // found.recommended_floor = leftShelf;
                // let deleteIndex = state.transfer_items.findIndex(
                //     (i) => i.item.id === removeId
                // );
                // console.log(deleteIndex);
                // state.transfer_items.splice(deleteIndex, 1);

            // let transferItems = state.transfer_items.filter((i) => {
            //     return i.item.id !== removeId;
            // });
            // state.transfer_items = transferItems;
        },
    },
    actions: {
        async getInventoryLists({ commit }) {
            let res = await axios.get("/api/colors");
            let inventories = res.data.data;
            commit("setInventories", inventories);
        },
        async deleteInventory(context, removeId) {
            await axios.delete(`/colors/${removeId}`);
            context.commit("removeInventory", removeId);
        },
        async updateOrCreateInventory({ commit, dispatch }, payload) {
            let res = await axios.post(
                `/colors/create_or_update`,
                payload.form_data
            );
            let inventory = res.data.data;
            // dispatch('getCategoriesLists');
            if (payload.type == "update") {
                commit("setUpdateInventory", inventory);
            } else {
                commit("setInventory", inventory);
            }
            return inventory;
        },
    },
};
