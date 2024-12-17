import BaseAPIService from "./BaseAPIService";

class UserService extends BaseAPIService {
    async getAllUser(): Promise<any>{
        return this.request('user', 'GET')
    }
    async getUser(uuid: any): Promise<any>{
        return this.request(`user/${uuid}`, 'GET')
    }
    async getCurrentUser(): Promise<any>{
        return this.request('current/user', 'GET')
    }
    async getuserExceptCurrentUser(id: number): Promise<any>{
        return this.request(`user/except/current/${id}`, 'GET')
    }
    async getUserByActive(status: string): Promise<any>{
        return this.request(`user/status/${status}`, 'GET')
    }
    async getUserByStatusExceptCurrent(status: string, id: number): Promise<any>{
        return this.request(`user/status/${status}/${id}`, 'GET')
    }
    async getUserByStatusAndName(status: string, name: string, id: number): Promise<any>{
        return this.request(`user/status/name/${status}/${name}/${id}`, 'GET')
    }
    async getUserByName(name: string, id: number): Promise<any>{
        return this.request(`user/name/${name}/${id}`, 'GET')
    }
    async changeUserStatus(id: number){
        return this.request(`user/${id}`, 'DELETE')
    }
    async updateUser(id: number, params: Object){
        return await this.request(`user/${id}?_method=PUT`, "POST", params)
    }

}

export const userService = new UserService();