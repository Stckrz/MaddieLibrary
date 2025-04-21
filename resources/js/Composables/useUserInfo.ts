// src/composables/useUserInfo.ts
import { ref, onMounted } from 'vue'
import Cookies from 'js-cookie'
import type { UserInfoCookieObject } from '../models/auth/authModels'

/** module‑scoped so it’s shared across all callers */
const userInfo = ref<UserInfoCookieObject | null>(null)

/** read cookie → userInfo */
function loadUserInfo() {
  const cookie = Cookies.get('userInfo')
  userInfo.value = cookie ? JSON.parse(cookie) : null
}

/** write both cookie & ref */
function setUserInfo(payload: UserInfoCookieObject) {
  userInfo.value = payload
  Cookies.set('userInfo', JSON.stringify(payload), {
    expires: 7,
    secure: true,
    sameSite: 'Strict',
  })
}

/** clear both cookie & ref */
function clearUserInfo() {
  userInfo.value = null
  Cookies.remove('userInfo')
}

export function useUserInfo() {
  onMounted(loadUserInfo)        // load on mount
  return { userInfo, loadUserInfo, setUserInfo, clearUserInfo }
}

