import Layout from '@/views/businesses/Layout.vue';
import List from '@/views/businesses/List.vue';
import Show from "@/views/businesses/Show.vue";



export default {
    path: '/businesses',
    component: Layout,
    children: [
        { path: '', component: List },
        { path: ':id', component: Show, props: true }
        // { path: 'edit/:id', component: AddEdit },
    ]
};