import axios from 'axios';

export function register(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/register', credentials)
        .then((response) => {
            res(response.data);
        })
        .catch((err) => {
            rej(err)
        })
    })
} 

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/login', credentials)
        .then((response) => {
            res(response.data);
        })
        // Always return success(200) response since we are using API 
    })
} 

export function getLocalUser() {
    const userStr = localStorage.getItem('user');
    if(!userStr) {
        return null;
    }

    return JSON.parse(userStr);
}