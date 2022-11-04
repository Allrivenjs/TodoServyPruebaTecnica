import Layout from '@/views/businesses/Layout.vue';
import List from '@/views/businesses/List.vue';
import AddEdit from '@/views/businesses/AddEdit.vue';


export default {
    path: '/businesses',
    component: Layout,
    children: [
        { path: '', component: List },
        { path: 'add', component: AddEdit },
        // { path: 'edit/:id', component: AddEdit },
    ]
};