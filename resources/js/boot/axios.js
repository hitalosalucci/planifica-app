import axios from 'axios'
import { useAuthStore } from '../stores/auth'
import useNotify from '../composable/useNotify';

const api = axios.create({
  baseURL: import.meta.env.VITE_BACK_END_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

api.interceptors.request.use(
  async (config) => {
    const auth = useAuthStore()
    if (auth.authToken) {
      config.headers.Authorization = `Bearer ${auth.authToken}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

export { api }
