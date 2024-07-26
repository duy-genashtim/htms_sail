import admin from './components/admin.vue';
import Dashboard from './pages/dashboard/Dashboard.vue';
import DepartmentList from './pages/department/DepartmentList.vue';
import DepartmentAddEdit from './pages/department/DepartmentAddEdit.vue';
import DepartmentEmployee from './pages/department/DepartmentEmployee.vue';
import EmployeeList from './pages/employee/EmployeeList.vue';
import EmployeeAdd from './pages/employee/EmployeeAdd.vue';
import EmployeeProfile from './pages/employee/EmployeeProfile.vue';
import EmployeeEmergency from './pages/employee/EmployeeEmergency.vue';
export default [
    {
        path: "/admin",
        component: admin,
        children: [
            {
                path: 'dashboard',
                name: 'admin-dashboard',
                component: Dashboard,
                meta: { title: 'Dashboard' },
            },
            {
                path: 'departments',
                name: 'admin-departments',
                component: DepartmentList,
                meta: { title: 'List of Department' },
            },
            {
                path: 'departments/add',
                name: 'admin-department-add',
                component: DepartmentAddEdit,
                meta: { title: 'Add new Department' },
            },
            {
                path: 'departments/:id/edit',
                name: 'admin-department-edit',
                component: DepartmentAddEdit,
                meta: { title: 'Update Department Information' },
            },
            {
                path: 'departments/:id/employees',
                name: 'admin-department-employees',
                component: DepartmentEmployee,
                meta: { title: 'Department Information and Employees' },
            },
            {
                path: 'employees',
                name: 'admin-employees',
                component: EmployeeList,
                meta: { title: 'List of Employee' },
            },
            {
                path: 'employees/add',
                name: 'admin-employee-add',
                component: EmployeeAdd,
                meta: { title: 'Add new employee' },
            },
            {
                path: 'employees/:id/view',
                name: 'admin-employee-view',
                component: EmployeeProfile,
                meta: { title: 'Employee Profile' },
            },
            {
                path: 'employees/:id/edit',
                name: 'admin-employee-edit',
                component: EmployeeAdd,
                meta: { title: 'Edit employee profile' },
            },
            {
                path: 'employees/emergency/:id/add',
                name: 'admin-employee-emergency-add',
                component: EmployeeEmergency,
                meta: { title: 'Add new employee emergency contact' },
            },
        ]
    },
];