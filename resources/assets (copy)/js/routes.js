window.Vue = require('vue');
import VueRouter from 'vue-router';


window.Vue.use(VueRouter);
let routes = [{
        path: '/',
        component: require('./components/Common/Home.vue')
    },
    {
        path: '/logout',
        component: require('./components/Auth/Login.vue')
    },
    {
        path: '/about',
        component: require('./components/Common/About.vue')
    },
	{
        path: '/Faq',
        component: require('./components/Common/Faq.vue')
    },
	{
        path: '/contact',
        component: require('./components/Common/Contact.vue')
    },
	{
        path: '/pricing',
        component: require('./components/Common/Pricing.vue')
    },
	{
        path: '/Terms-of-Service',
        component: require('./components/Common/Terms-of-Service.vue')
    },
    {
        path: '/login',
        component: require('./components/Auth/Login.vue'),
		meta: {
			showModal: true
		}
    },
    {
        path: '/dashboard',
        component: require('./components/Auth/Dashboard.vue'),
        meta: {
            middlewareAuth: true
        }

    },
    {
        path: '/profile',
        component: require('./components/Auth/Profile.vue'),
        meta: {
            middlewareAuth: true
        }

    },
    {
        path: '/multi',
        component: require('./components/Reusable/NewFileUpload.vue'),
        meta: {
            middlewareAuth: true
        }

    },
    {
        path: '/project/:id',
        component: require('./components/Projects/project.vue'),
        meta: {
            middlewareAuth: true
        }

    },
    {
        path: '/project_edit/:id',
        component: require('./components/Projects/ProjectEdit.vue'),
        meta: {
            middlewareAuth: true
        }

    },
    {
        path: '/buyproject',
        component: require('./components/Projects/BuyProject.vue'),
        meta: {
            middlewareAuth: true
        }

    },
    {
        path: '/buyproject/:id',
        component: require('./components/Projects/BuyProjectView.vue'),
        meta: {
            middlewareAuth: true
        }

    },
    {
        path: '/register',
        component: require('./components/Auth/Register.vue'),
        meta: {
            middlewareAuth: false
        }

    },
    {
        path: '/forget-password',
        component: require('./components/Auth/ForgetPassword.vue'),
        meta: {
            middlewareAuth: false
        }

    },
    {
        path: '/payment-pay',
        component: require('./components/Payments/Pay.vue'),
        meta: {
            middlewareAuth: false
        }

    },
    {
        path: '/shareimage/:id',
        component: require('./components/Reusable/ShareImage.vue'),
        meta: {
            middlewareAuth: false
        }

    },
    {
        path: '/shareproject/:id',
        component: require('./components/Projects/ShareProject.vue'),
        meta: {
            middlewareAuth: false
        }

    },
    {
        path: '/paymentsuccess',
        component: require('./components/Payments/PaymentSuccess.vue'),
        meta: {
            middlewareAuth: false
        }

    },
    {
        path: '/noticeDetail/:id',
        component: require('./components/Common/notificationDetails.vue'),
        meta: {
            middlewareAuth: false
        }
    },
    {
        path: '/ProjectLogin',
        component: require('./components/Payments/ProjectLogin.vue'),
		meta: {
			showModal: true
		}
    },
    ];

const router = new VueRouter({
    //mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.middlewareAuth)) {
        if (!auth.check()) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            });

            return;
        }
    }
    next();
})

export default router;
