import Vue from 'vue';
import VueRouter from 'vue-router';
import AppLayout from './layouts/App.vue';
import GuestLayout from './layouts/Guest.vue';
import LandingLayout from './layouts/landing.vue';

import login from './views/auth/login.vue';
import forbiden from './views/auth/forbiden.vue';
import forgot from './views/auth/forgot.vue';
import reset from './views/auth/reset.vue';
import userRegister from './views/auth/register.vue';
import completeProfile from './views/auth/completeProfile.vue';
import confirmEmail from './views/auth/confirmEmail.vue';
import confirmPhone from './views/auth/confirmPhone.vue';
import confirmEmail2 from './views/auth/confirmEmail2.vue';
import confirmPhone2 from './views/auth/confirmPhone2.vue';
import changeEmail from './views/auth/changeEmail.vue';
import makePayment from './views/auth/makePayment.vue';
import changePhone from './views/auth/changePhone.vue';
import subscriptionPackage from './views/auth/subscriptionPackage.vue';
import updateSubscription from './views/auth/updateSubscription.vue';
import getStarted from './views/auth/getStarted.vue';
import createCompany from './views/auth/createCompany.vue';

import home from './views/auth/home.vue';

import farmIndex from './views/farm/index.vue';
import farmCreate from './views/farm/create.vue';
import farmShow from './views/farm/show.vue';
import farmEdit from './views/farm/edit.vue';

import productIndex from './views/product/index.vue';
import productCreate from './views/product/create.vue';
import productShow from './views/product/show.vue';
import productEdit from './views/product/edit.vue';

import categoryIndex from './views/category/index.vue';
import categoryCreate from './views/category/create.vue';
import categoryShow from './views/category/show.vue';
import categoryEdit from './views/category/edit.vue';

import orderIndex from './views/order/index.vue';
import orderCreate from './views/order/create.vue';
import orderShow from './views/order/show.vue';
import orderEdit from './views/order/edit.vue';

import orderItemIndex from './views/orderItem/index.vue';
import orderItemCreate from './views/orderItem/create.vue';
import orderItemShow from './views/orderItem/show.vue';
import orderItemEdit from './views/orderItem/edit.vue';

import reviewIndex from './views/review/index.vue';
import reviewCreate from './views/review/create.vue';
import reviewShow from './views/review/show.vue';
import reviewEdit from './views/review/edit.vue';

import deliveryIndex from './views/delivery/index.vue';
import deliveryCreate from './views/delivery/create.vue';
import deliveryShow from './views/delivery/show.vue';
import deliveryEdit from './views/delivery/edit.vue'

import userIndex from './views/user/index.vue';
import userCreate from './views/user/create.vue';
import userShow from './views/user/show.vue';
import userEdit from './views/user/edit.vue';

import store from './app';



Vue.use(VueRouter);

if(localStorage.getItem('user') !='undefined'){var user=JSON.parse(localStorage.getItem('user'));}
else{var user=null;}

function refreshUser() {
    store.commit('getUser');
    user=JSON.parse(localStorage.getItem('user'));
}

function checkPermission(next, permission, blockFree) {
	refreshUser();
    if(user && user.permissions.includes(permission)){next();}else{next('/forbidden');}  
}

export default new VueRouter ({
    mode:"history",
    routes:[

        {component:LandingLayout, 
            path: '',
            children:[
                {path:'/', component: login},
            ] 
        },

    /*FrontEnd Routes*/
    {component:GuestLayout, 
            path: '',
            children:[
                {path:'/login/', component: login},
                {path:'/register/', component: userRegister},
                {path:'/complete-profile/', component: completeProfile},
                {path:'/confirm-email/', component: confirmEmail},
                {path:'/confirm-phone/', component: confirmPhone},
                {path:'/email-confirmation/', component: confirmEmail2},
                {path:'/phone-confirmation/', component: confirmPhone2},
                {path:'/change-email/', component: changeEmail},
                {path:'/change-phone/', component: changePhone},
                {path:'/make-payment', component: makePayment},
                {path:'/subscription-package/', component: subscriptionPackage},
                {path:'/forbiden/', component: forbiden},
                {path:'/forgot/', component: forgot},
                {path:'/password/reset/:token', component: reset},
                {path:'/get-started', component: getStarted},
                {path:'/update-subscription', component: updateSubscription},
                {path:'/create-company', component: createCompany},
                //{path:'/profile',component:profile,},
                //{path:'/account',component:account,},
            ] 
        },

    /*Admin Routes*/
    {component:AppLayout, 
        path: '',
        children:[
            {path:'/home', component: home},

            {path:'/farm',component:farmIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View farm', false); }},
            {path:'/farm/create', component:farmCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create farm', false); }},
            {path:'/farm/:id', component:farmShow, async beforeEnter(to, from, next) {checkPermission(next, 'View farm', false); }},
            {path:'/farm/:id/edit', component:farmEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit farm', false); }},

            {path:'/product',component:productIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View product', false); }},
            {path:'/product/create', component:productCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create product', false); }},
            {path:'/product/:id', component:productShow, async beforeEnter(to, from, next) {checkPermission(next, 'View product', false); }},
            {path:'/product/:id/edit', component:productEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit product', false); }},

            {path:'/order',component:orderIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View order', false); }},
            {path:'/order/create', component:orderCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create order', false); }},
            {path:'/order/:id', component:orderShow, async beforeEnter(to, from, next) {checkPermission(next, 'View order', false); }},
            {path:'/order/:id/edit', component:orderEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit order', false); }},

            {path:'/orderItem',component:orderItemIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View order item', false); }},
            {path:'/orderItem/create', component:orderItemCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create order item', false); }},
            {path:'/orderItem/:id', component:orderItemShow, async beforeEnter(to, from, next) {checkPermission(next, 'View order item', false); }},
            {path:'/orderItem/:id/edit', component:orderItemEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit order item', false); }},

            {path:'/review',component:reviewIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View review', false); }},
            {path:'/review/create', component:reviewCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create review', false); }},
            {path:'/review/:id', component:reviewShow, async beforeEnter(to, from, next) {checkPermission(next, 'View review', false); }},
            {path:'/review/:id/edit', component:reviewEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit review', false); }},
  
            {path:'/delivery',component:deliveryIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View delivery', false); }},
            {path:'/delivery/create', component:deliveryCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create delivery', false); }},
            {path:'/delivery/:id', component:deliveryShow, async beforeEnter(to, from, next) {checkPermission(next, 'View delivery', false); }},
            {path:'/delivery/:id/edit', component:deliveryEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit delivery', false); }},

            {path:'/category',component:categoryIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View category', false); }},
            {path:'/category/create', component:categoryCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create category', false); }},
            {path:'/category/:id', component:categoryShow, async beforeEnter(to, from, next) {checkPermission(next, 'View category', false); }},
            {path:'/category/:id/edit', component:categoryEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit category', false); }},

            // {path:'/package',component:packageIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View package', false); }},
            // {path:'/package/create', component:packageCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create package', false); }},
            // {path:'/package/:id', component:packageShow, async beforeEnter(to, from, next) {checkPermission(next, 'View package', false); }},
            // {path:'/package/:id/edit', component:packageEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit package', false); }},


            // {path:'/subscription',component:subscriptionIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View subscription', false); }},
            // {path:'/subscription/create', component:subscriptionCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create subscription', false); }},
            // {path:'/subscription/:id', component:subscriptionShow, async beforeEnter(to, from, next) {checkPermission(next, 'View subscription', false); }},
            // {path:'/subscription/:id/edit', component:subscriptionEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit subscription', false); }},

            // {path:'/bill',component:billIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View bill', false); }},
            // {path:'/bill/create', component:billCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create bill', false); }},
            // {path:'/bill/:id', component:billShow, async beforeEnter(to, from, next) {checkPermission(next, 'View bill', false); }},
            // {path:'/bill/:id/edit', component:billEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit bill', false); }},

            // {path:'/payment',component:paymentIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View payment', false); }},
            // {path:'/payment/create', component:paymentCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create payment', false); }},
            // {path:'/payment/:id', component:paymentShow, async beforeEnter(to, from, next) {checkPermission(next, 'View payment', false); }},
            // {path:'/payment/:id/edit', component:paymentEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit payment', false); }},

            {path:'/user',component:userIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View user', false); }},
            {path:'/user/create', component:userCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create user', false); }},
            {path:'/user/:id', component:userShow, async beforeEnter(to, from, next) {checkPermission(next, 'View user', false); }},
            {path:'/user/:id/edit', component:userEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit user', false); }},
], 
        async beforeEnter(to, from, next) {
            next();
            // if(user && user.role_id==1){next();}else{next('/forbiden');}
        }
    },
    
],
    scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});