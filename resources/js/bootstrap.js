import axios from 'axios';
import './sweetalert-helpers.js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
