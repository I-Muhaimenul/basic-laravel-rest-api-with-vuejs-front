import Home from '../components/phonebook/Home.vue'
import About from '../components/phonebook/About.vue'

export const routes = [
    {
        path: '/',
        component: Home,
    },
    {
        path: '/home',
        component: Home,
        name: 'home'
    },
    {
        path: '/about',
        component: About,
        name: 'about'
    }
];