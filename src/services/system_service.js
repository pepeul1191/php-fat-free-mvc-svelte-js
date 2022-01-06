import axios from 'axios';

export const getSystemById = (id) => {
  return new Promise((resolve, reject) => {
    axios.get('system/get', {
      params: {id: id}
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Sistema no encontrado')
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

export const saveSystemDetail = (params) => {
  return new Promise((resolve, reject) => {
    axios.post('system/detail/save', JSON.stringify(params), {
      headers: {
        'Content-Type': 'application/json',
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Guardar detalle de sistema no existe en el servidor')
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
