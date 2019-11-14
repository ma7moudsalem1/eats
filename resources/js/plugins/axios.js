import Vue from 'vue'

// Lib imports
import axios from 'axios'
import store from '../store/index'

let apiBaseUrl = document.head.querySelector('meta[name="api-base-url"]').content;

// Vue.prototype.$http = axios

Vue.prototype.$http = axios.create({
  baseURL: apiBaseUrl,
  headers: {
  }
})

Vue.prototype.$http_noauth = axios.create({
  baseURL: apiBaseUrl
})