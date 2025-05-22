import { defineStore } from "pinia";
import { api } from "../boot/axios";
import { currentUserData } from "../composable/globalVariables";

const backendBaseUrl = import.meta.env.VITE_BACK_END_BASE_URL;

export const useAuthStore = defineStore("auth", {
  state: () => ({ authUser: null, authToken: null }),
  getters: {
    user: (state) => state.authUser,
    token: (state) => state.authToken,
  },

  actions: {
    async login(form) {
      try {
        const resp = await api.post(
          `${backendBaseUrl}/auth`,
          form
        );
        this.authUser = resp.data.user;
        this.authToken = resp.data.access_token;
        const tokenType = resp.data.token_type;
        api.defaults.headers.common.Authorization = `${tokenType} ${ this.authToken}`;
        
        currentUserData.value = resp.data.user;

        return resp.data;
      } catch (error) {
        return error;
      }
    },
    async logout() {
      try {
        api.defaults.headers.common.Authorization = `Bearer ${this.authToken}`;
        const resp = await api.post(
          `${backendBaseUrl}/auth/logout`,
          { token: this.authToken }
        );

        // Limpar estado do store no logout
        this.authToken = null;
        this.authUser = null;
        currentUserData.value = {};

        localStorage.clear();

        return resp.data;
      } catch (error) {
        return error;
      }
    }
    
  },
  persist: true,
});
