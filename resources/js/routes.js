import {isLoggedIn} from './shared/utils/auth'
import store from './store'
import VueRouter from 'vue-router'
import ExampleComponent from './components/ExampleComponent'
import Bookables from './bookables/Bookables.vue'
import Bookable from './bookable/Bookable.vue'
import Review from './review/Review.vue'
import Cart from './cart/Cart.vue'
import Login from './auth/Login.vue'
import Register from './auth/Register.vue'
import Profile from './profile/Profile.vue'

const routes = [
    {
        path: "/",
        component: ExampleComponent,
        name: "home"
    },
    {
        path: "/bookables",
        component: Bookables,
        name: "bookables.index"
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookables.show"
    },
    {
        path: "/review/:id",
        component: Review,
        name: "review"
    },
    {
        path: "/cart",
        component: Cart,
        name: "cart"
    },
    {
        path: "/auth/login",
        component: Login,
        name: "login"
    },
    {
        path: "/auth/register",
        component: Register,
        name: "register"
    },
    {
        path: "/profile/:id",
        component: Profile,
        name: "profile"
    },
]

const router = new VueRouter({
    routes,
    mode: "history"
})

//protect routes
router.beforeEach((to, from, next) => {
    if (to.name != 'login' && to.name != 'register' && !isLoggedIn()) {
        next({ name: 'login' })
    }else if((to.name == 'login' || to.name == 'register') && isLoggedIn()){
        next({ name: 'home' })
    }
    else next()
  })
export default router;