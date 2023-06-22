import axios from 'axios';
import store from '../store';
export const HTTP = axios.create({
  baseURL: `http://127.0.0.1:8000/api/v1/`,
  headers: {
    Authorization: `Bearer ${localStorage.getItem('token')}`
  }
})