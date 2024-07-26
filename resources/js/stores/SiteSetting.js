import axios from 'axios';
import {defineStore} from "pinia";
import {ref} from "vue";

// export const useAuthUserStore = defineStore("siteSetting", () => {
//     const user = ref({
//         name: "",
//         email: "",
//     });
//     const getAuthUser = async ()=>{
//         await axios.get('/settings').then((response)=>{
//             user.value = response.data
//             console.log(user.value);
//         }).catch((error)=>{
//             console.log(error)
//         })
//     };
//     return {user, getAuthUser};
// });



