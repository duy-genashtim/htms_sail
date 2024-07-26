import axios from 'axios';
import {defineStore} from "pinia";
import {ref} from "vue";

export const useAuthUserStore = defineStore("authUser", () => {
    const user = ref({
        name: "",
        email: "",
        id:"",
        avatar: "",
        roles :[],
    });
    const getAuthUser = async ()=>{
        await axios.get('/profile').then((response)=>{
            user.value = response.data
            console.log(user.value);
        }).catch((error)=>{
            console.log(error)
        })
    };
    return {user, getAuthUser};
});



