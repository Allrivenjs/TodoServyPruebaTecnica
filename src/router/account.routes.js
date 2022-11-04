import Layout from '@/views/account/Layout.vue';
import Login from '@/views/account/Login.vue';

export default  {
    path: '/',
    component: Layout,
    children: [
        { path: '', redirect: 'login' },
        { path: 'login', component: Login },
    ]
};