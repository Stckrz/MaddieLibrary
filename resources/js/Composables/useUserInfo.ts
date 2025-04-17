import { ref, onMounted } from 'vue';
import Cookies from 'js-cookie';
import { UserInfoCookieObject } from '../models/auth/authModels';

export function useUserInfo() {
    const userInfo = ref<UserInfoCookieObject | null>(null);

    const fetchUserInfo = () => {
        const cookieValue = Cookies.get('userInfo');
        if (cookieValue) {
            userInfo.value = JSON.parse(cookieValue);
        }
    };

    onMounted(fetchUserInfo);

    return { userInfo, fetchUserInfo };
}
