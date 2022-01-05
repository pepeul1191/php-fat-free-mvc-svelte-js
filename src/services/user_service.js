import axios from 'axios';
import { CSRF } from '../components/Stores/csrf.js';

export const getUser = () => {
  return new Promise((resolve, reject) => {
    axios.get('user', {
      params: {},
      headers:{
        [CSRF.key]: CSRF.value,
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Dentista no encontrado')
      }else{
        console.error(error.response.data);
      }
      reject(error.response);
    })
    .then(function () {
      // todo?
    });
  });
}
