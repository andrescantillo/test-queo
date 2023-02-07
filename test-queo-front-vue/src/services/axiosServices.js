import axios from "axios"
import store from "@/store/index.js"

const oApiClient = axios.create({
  baseURL: `http://127.0.0.1:8000/api/`
})

const oConfigBase = {
  headers: {
    'Content-Type': 'application/json',
    'Authorization': `Bearer ${store.state.token}`
  }
}

oApiClient.interceptors.request.use(config => {
  return config
})
oApiClient.interceptors.response.use(response => {
  return response
}, (error) => {
  switch(error.response.status) {
    case 401: 
    case 404: {
      store.dispatch('onSetLogin', false).then(() => {
        window.localStorage.clear()
        sessionStorage.clear()
        let sUrlDomain = window.location
        window.location.href = `${sUrlDomain}`
      })
      break
    }
  }
  return error.response
})
export default {
  //Metodo GET
  onAxiosGet(sUrl) {
    return oApiClient.get(`${sUrl}`, oConfigBase).then(aGetData => aGetData.data)
  },
  //Metodo POST
  onAxiosPost(sUrl, oBody) {
    oConfigBase.headers['Content-Type'] = 'application/json'; 
    return oApiClient.post(`${sUrl}`, oBody, oConfigBase).then(aGetData => aGetData.data)
  },
  //Metodo POST
  onAxiosPostWithfile(sUrl, oBody) {
    oConfigBase.headers['Content-Type'] = 'multipart/form-data'; 
    return oApiClient.post(`${sUrl}`, oBody, oConfigBase).then(aGetData => aGetData.data)
  },
  //Metodo PUT
  onAxiosPut(sUrl, oBody) {
    oConfigBase.headers['Content-Type'] = 'application/json'; 
    return oApiClient.put(`${sUrl}`, oBody, oConfigBase).then(aGetData => aGetData.data)
  },
  //Metodo PUT
  onAxiosPutWithfile(sUrl, oBody) {
    oConfigBase.headers['Content-Type'] = 'application/json'; 
    return oApiClient.put(`${sUrl}`, oBody, oConfigBase).then(aGetData => aGetData.data)
  },
  onAxiosDelete(sUrl) {
    oConfigBase.headers['Content-Type'] = 'application/json'; 
    return oApiClient.delete(`${sUrl}`, oConfigBase).then(aGetData => aGetData.data)
  },
  //Metodo POST login
  onAxiosPostLogin(sUrl, oBody) {
    oConfigBase.headers.Authorization = '';
    return oApiClient.post(`${sUrl}`, oBody, oConfigBase).then(aGetData => aGetData.data)
  },
}