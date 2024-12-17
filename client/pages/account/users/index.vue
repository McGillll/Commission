<template>
    <NuxtLayout name="main" >
        <template #header>
            <p  class="text-3xl font-bold tracking-tight text-white">Users</p>
        </template>
        <template #main>
            
            <div class="flex items-center gap-4">
                <div>
                    <label for="search" class="block text-xs font-medium text-gray-900">Quick search</label>
                    <div class="mt-2">
                        <div class="flex rounded-md bg-white outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                            <input
                            @input="(val: any)=>{
                            state.searchName = val?.target?.value
                            fetchUserByName()
                        }"
                        type="text" 
                        name="search" 
                        id="search" 
                        class="block min-w-0 grow px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" />
                        <div class="flex py-1.5 pr-1.5">
                            <kbd class="inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">⌘K</kbd>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <label for="location" class="block text-xs font-medium text-gray-900">Status</label>
                <div class="mt-2 grid grid-cols-1">
                    <select
                    @change="(val: any)=>{
                        state.filterStatus = val?.target?.value
                        filterAplly()
                    }"
                    id="location" 
                    name="location" 
                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    <option value=""></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <ChevronDownIcon class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" aria-hidden="true" />
            </div>
        </div>
    </div>
    <div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
              <thead>
              <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                      <p class="ml-4">
                          Name
                        </p>
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="person in state.users" :key="person.email">
                    <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ person.name }}</div>
                                <div class="mt-1 text-gray-500">{{ person.email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                        <span v-if="person.status === 'Active'" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                        <span v-else class="inline-flex items-center rounded-md bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">Inactive</span>
                    </td>
                    <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <button @click="navigateTo(`/account/users/${person.uuid}`)" type="button" class="mr-4 text-indigo-600 hover:text-indigo-900">
                            View
                        </button>          
                </td>
            </tr>
        </tbody>
    </table>
        </div>
      </div>
    </div>
</div>
</template>
</NuxtLayout>
</template>

<script setup lang="ts">
import { ChevronDownIcon } from '@heroicons/vue/16/solid'
import { userService } from '~/components/api/UserService';

const refreshing = ref(false)
const refreshAll = async () => {
  refreshing.value = true
  try {
    await refreshNuxtData()
  } finally {
    refreshing.value = false
  }
}

const state = reactive({
    users: [] as any,
    currentUser: [] as any,
    searchName:'',
    filterStatus: ''
})

onMounted(async()=>{
    await fetchCurrentUser()
})

async function fetchCurrentUser() {
    try{
        const response = await userService.getCurrentUser()
        if(response){
            state.currentUser = response.data
            fetchUsers()

        }
    }catch(error){}
}
async function fetchUsers() {
    try{
        const response = await userService.getuserExceptCurrentUser(state.currentUser.id)
        if(response){
            state.users = response.data
        }
    }catch(error){}
}

async function fetchUserByName() {
    if(state.filterStatus === ''){
            if(state.searchName == ''){
                fetchUsers()
            }else{
                try{
                    const response = await userService.getUserByName(state.searchName, state.currentUser.id);
                    if(response){
                        state.users = response.data
                        refreshAll            
                    }
                } catch (error: any) {
                    
                }
            }
        }else{
            if(state.searchName == ''){
                fetchUsers()
            }else{
                fetchAllUserByStatusAndName()
            }
        }
}

function filterAplly(){
        if(state.filterStatus === '' && state.searchName.length == 0 ){
            fetchUsers()
            refreshAll
        }else{
            if(state.searchName.length == 0){
                fetchUserBySatus()
                refreshAll
            }else{
                fetchAllUserByStatusAndName()
            }
        }
    }

async function fetchUserBySatus() {
    try{
        const response = await userService.getUserByStatusExceptCurrent(state.filterStatus, state.currentUser.id)
        if(response){
            state.users = response.data
            refreshAll
        }
    }catch(error){}

}

async function fetchAllUserByStatusAndName() {
    try{
        const response = await userService.getUserByStatusAndName(state.filterStatus, state.searchName, state.currentUser.id)
        if(response){
            state.users = response.data
            refreshAll
        }
    }catch(error){}

}
</script>
