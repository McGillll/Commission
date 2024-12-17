import BaseAPIService from "./BaseAPIService";

class AuthService extends BaseAPIService {
    async login(params: object): Promise<any> {
        return await this.request(`auth/login`, "POST", params);
    }

    async logout(): Promise<any> {
        return await this.request(`auth/logout`, "POST");
    }

    async register(params: Object): Promise<any>{
        return await this.request(`user/register`, "POST", params)
    }
}

export const authService = new AuthService();