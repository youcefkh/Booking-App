import axios from "axios";
import { isLoggedIn, logOut } from "./shared/utils/auth";
export default {
    state: {
        lastSearch: {
            from: null,
            to: null,
        },
        cart: {
            items: [],
        },
        isLoggedIn: false,
        user: {
            profile:{
                cropped: null,
                original: null,
            },
            cover:{
                cropped: null,
                original: null,
            },
        },
    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },
        addItem(state, payload) {
            state.cart.items.push(payload);
        },
        removeItem(state, payload) {
            const items = state.cart.items.filter(
                item => {
                    return item.bookable_id != payload
                }
            );
            state.cart.items = items;
        },
        setCart(state, payload) {
            state.cart.items = payload;
        },
        setUser(state, payload) {
            state.user = payload;
        },
        setIsLoggedIn(state, payload) {
            state.isLoggedIn = payload;
        },
    },
    actions: {
        setLastSearch(context, payload) {
            context.commit("setLastSearch", payload);
            localStorage.setItem("lastSearch", JSON.stringify(payload));
        },

        loadStoredState(context) {
            const lastSearch = localStorage.getItem("lastSearch");
            if (lastSearch) {
                context.commit("setLastSearch", JSON.parse(lastSearch));
            }

            
            //set the isLoggedIn to avoid delay
            context.commit('setIsLoggedIn', isLoggedIn())

            //load cart items
            if(context.state.isLoggedIn){
                axios.get(`/api/cart`)
                .then((result) => {
                    if(result.status == 200 && result.data){
                        context.commit("setCart", result.data);
                    }
                }).catch((err) => {
                    console.log(err)
                });
            }
        },

        addToCart({ commit, state }, payload) {
            //context.commit, context.state
            axios.post(`/api/cart/${payload.bookable_id}/create`, {
                price: payload.price.total,
                from: payload.date.from,
                to: payload.date.to,
            })
            .then((result) => {
                if(result.status == 200){
                    commit("addItem", result.data);
                }
            }).catch((err) => {
                console.log(err)
            });
        },

        async removeFromCart({ commit, state }, payload) {
            //context.commit, context.state
            try {
                await axios.post(`/api/cart/${payload.bookable_id}/delete`)
                commit("removeItem", payload.bookable_id);
                
            } catch (error) {
                console.log(error)
            }
        },

        clearCart({ commit, state }, payload) {
            commit("setCart", { items: [] });
            localStorage.setItem("cart", JSON.stringify(state.cart));
        },

        async loadUser({ commit, dispatch }) {
            if (isLoggedIn()) {
                //function is in the utils/auth.js
                try {
                    const user = (await axios.get("/user")).data;
                    commit("setUser", user);
                    commit("setIsLoggedIn", true);
                    return user;
                } catch (error) {
                    if(error.response && error.response.status == 401){
                        dispatch("logout");
                    }
                }
            }
        },

        logout({ commit }) {
            commit("setUser", {});
            commit("setIsLoggedIn", false);
            logOut(); //function is in the utils/auth.js
        },
    },
    getters: {
        itemsInCart: (state) => state.cart.items.length,

        // check if the bookable is already in the cart
        isInCart: (state) => (bookable) => {
            if (bookable == null) {
                return;
            }
            return state.cart.items.reduce(
                (result, item) => result || item.bookable_id == bookable.id,
                false
            );
        },
    },
};
