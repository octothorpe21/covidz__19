import Vue from 'vue';
import axios from 'axios';
import store from './store';
import VueProgressBar from "vue-progressbar";


// Routes imports:

// Guest Routes
import LoginPage from './components/LoginPage';
import RegisterPage from './components/RegisterPage';
import Welcome from './components/Welcome';
import IdeaPage from './components/Idee.vue'

// User Auth Routes
import Home from './components/user/pages/Home';
import Timeline from './components/user/Timeline';
import Profile from './components/user/Profile.vue';
import EditProfile from './components/user/EditProfile';
import Bookmarks from './components/user/Bookmarks.vue';
import Publications from './components/user/Publications.vue';



// Admin Routes
import adminHome from './components/admin/Home'
import adminUsers from './components/admin/Users'
import adminIdeas from './components/admin/Ideas'
import adminReports from './components/admin/Reports'
import adminPublications from './components/admin/Publications'
import adminCategories from './components/admin/Categories.vue'
import adminJobs from './components/admin/Jobs.vue'
import adminDiseases from './components/admin/Diseases.vue'



import VueRouter from 'vue-router';
Vue.use(VueRouter);
let router = new VueRouter({
    mode: 'history',
    routes: [
        // GUEST ROUTES:
        { path: '/' , component: Welcome, name: 'Welcome'},
        { path: '/login', component: LoginPage, name: 'login' },
        { path: '/register', component: RegisterPage, name: 'register' },
        { path: '/idee', component: IdeaPage, name: 'idea' },
        // { path: '/pub', component: PubPage, name: 'pub' },



        // USER ROUTES:
        { path: '/bookmarks' , component: Bookmarks, name: 'Bookmarks'},
        { path: '/home' , component: Home, name: 'Home'},
        { path: '/ideas' , component: Timeline, name: 'Ideas'},
        { path: '/publications' , component: Publications, name: 'Publications'},
        { path: "/:username" , component: Profile, name: 'Profile'},
        { path: "/:username/edit" , component: EditProfile, name: 'EditProfile'},



        // ADMIN ROUTES:
        { path: '/admin/home' , component: adminHome, name: 'Admin-Home'},
        { path: '/admin/users' , component: adminUsers, name: 'Manage Users'},
        { path: '/admin/ideas' , component: adminIdeas, name: 'Manage Ideas'},
        { path: '/admin/reports' , component: adminReports, name: 'Manage Reports'},
        { path: '/admin/publications' , component: adminPublications, name: 'Manage Publications'},
        { path: '/admin/categories' , component: adminCategories, name: 'Manage Categories'},
        { path: '/admin/jobs' , component: adminJobs, name: 'Manage Jobs'},
        { path: '/admin/diseases' , component: adminDiseases, name: 'Manage Diseases'},


    ],
});


router.beforeEach((to, from, next) => {
    // If this isn't an initial page load.
    if (to.name) {
        // Start the route progress bar.
        NProgress.start()
        // this.$Progress.start()    
    }
        next();
});

router.afterEach((to, from) => {
    // Complete the animation of the route progress bar.
    NProgress.done()
    // this.$Progress.finish();
  })

export default router;