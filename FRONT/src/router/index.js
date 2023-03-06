import {
    createMemoryHistory,
    createRouter,
    // createWebHistory
} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import About from '../views/AboutView.vue'
import ExamnationViewVue from '../views/Exam&AffairsView.vue'
import StudentVue from '../views/AffairsService/Student.vue'
import Administrative from '../views/Administration/AdministrativeView.vue'
import Graduates from '../views/AffairsService/Graduates.vue'
import NewStudent from '../views/AffairsService/NewStudent.vue'
import PublicRecord from '../views/PublicRecord.vue'
import UsersVue from '../views/Administration/UsersVue.vue'
import Stop from '../views/AffairsService/Stop.vue'
import AddUserVue from '../views/Administration/AddUser.vue'
import Logs from '../views/Administration/Logs.vue'
import UserPerm from '../views/Administration/UserPerm.vue'
import Container from '../views/ExamService/Container.vue'
import ExamStudent from '../views/ExamService/ExamStudent.vue'
import Distr from '../views/ExamService/Distr.vue'
import ExaDocuments from '../views/ExamService/Documents.vue'
import AffDocuments from '../views/AffairsService/Documents.vue'
import HallsDistr from '../views/ExamService/HallsDistr.vue'
import Lectures from '../views/ExamService/Lectures.vue'
import Stopped from '../views/AffairsService/Stopped.vue'
import NotFound from '../views/NotFound.vue'



const routes = [{

        path: '/',
        name: 'Home',
        component: HomeView
    },
    {
        path: '/about',
        name: 'About',
        component: About
    },
    {
        path: '/Examination/:dept',
        name: 'Examination',
        component: ExamnationViewVue,
        props: true
    },
    {
        path: '/Student',
        name: 'Student',
        component: StudentVue

    },
    {
        path: '/administrtive',
        name: 'administrative',
        component: Administrative
    },
    {
        path: '/graduates',
        name: 'Graduates',
        component: Graduates
    },
    {
        path: '/newstudent',
        name: 'newstudent',
        component: NewStudent
    },


    {
        path: '/publicrecord',
        name: 'publicrecord',
        component: PublicRecord
    },
    {
        path: '/Users',
        name: 'Users',
        component: UsersVue
    }, {
        path: '/Stop',
        name: 'Stop',
        component: Stop
    },
    {
        path: '/addUser',
        name: 'addUser',
        component: AddUserVue
    }, {
        path: '/log',
        name: 'log',
        component: Logs
    }, {
        path: '/userperm',
        name: 'userperm',
        component: UserPerm
    }, {
        path: '/container/:sec',
        name: 'container',
        component: Container,
        props: true
    }, {
        path: '/examstudent',
        name: 'examstudent',
        component: ExamStudent,

    }, {
        path: '/distr',
        name: 'distr',
        component: Distr,

    }, {
        path: '/HallsDistr',
        name: 'hallsdistr',
        component: HallsDistr
    }, {
        path: '/exaDocuments',
        name: 'exaDocuments',
        component: ExaDocuments
    }, {
        path: '/affDocuments',
        name: 'affDocuments',
        component: AffDocuments
    }, {
        path: '/lectures',
        name: 'lectures',
        component: Lectures
    }, {
        path: '/stopped',
        name: 'stopped',
        component: Stopped
    }, {
        path: "/:catchAll(.*)",
        component: NotFound

    },

]
const router = createRouter({
    // history: createWebHistory(),
    history: createMemoryHistory(),
    routes

})

export default router