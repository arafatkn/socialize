import Axios from 'axios';

const axios = Axios.create({
  // baseURL: import.meta.env.VITE_API_URL || '',
  headers: {
    // Authorization: localStorage.token ? `Bearer ${localStorage.token}` : '',
    'X-Requested-With': 'XMLHttpRequest',
    // Accept: 'application/json',
  },
  withCredentials: true,
});

// Intercept Request & Response
// axios.interceptors.response.use(
//   (response) => {
//     return new Promise((resolve, reject) => {
//       resolve(response);
//     });
//   },
//   (error) => {
//     if (error.response.status === 401) {
//       authStore.removeLogin();
//       window.location.href = '/auth/login';
//     } else {
//       return new Promise((resolve, reject) => {
//         reject(error);
//       });
//     }
//   }
// );

export default axios;
