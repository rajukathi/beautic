import { createRouter, createWebHistory } from "vue-router";

import Category from '@/components/Category/Category.vue'
import Tags from '@/components/Tags/Tags.vue'
import Product from '@/components/Product/Product.vue'

const routes = [
    {
        path: '/',
        name: 'home.index',
        component: Category
    },
    {
        path: '/category',
        name: 'category.index',
        component: Category
    },
    {
        path: '/tags',
        name: 'tags.index',
        component: Tags
    },
    {
        path: '/products',
        name: 'products.index',
        component: Product,
    }
]

export default createRouter({
    history: createWebHistory(),
    routes
})