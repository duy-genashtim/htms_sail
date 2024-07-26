import axios from 'axios';
window.axios = axios;

// import Jquery after npm install jquery
import jquery from 'jquery';
window.$ = window.jQuery = jquery;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
