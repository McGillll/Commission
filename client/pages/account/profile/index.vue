<template>
    <NuxtLayout name="main">
        <template #header>
            <p  class="text-3xl font-bold tracking-tight text-white">Profile</p>
        </template>
        <template #main>
            <div class="w-full flex justify-center">
                <div class=" relative">
                    <div class="absolute left-5 -top-4">
                        <div class="rounded-md bg-green-50 p-4" v-if="state.isUpdated">
                            <div class="flex">
                                <div class="shrink-0">
                                    <CheckCircleIcon class="size-5 text-green-400" aria-hidden="true" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">Successfully updated</p>
                                </div>
                                <div class="ml-auto pl-3">  
                                    <div class="-mx-1.5 -my-1.5">
                                        <button type="button" @click="()=>{state.isUpdated=false}" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                                            <span class="sr-only">Dismiss</span>
                                            <XMarkIcon class="size-5" aria-hidden="true" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="state.show" class="w-screen p-5 max-w-md flex-auto overflow-hidden rounded-3xl bg-gray-900 text-sm/6 shadow-lg ring-2 ring-gray-900/5">
                            <div class="container flex justify-end">
                                <button @click="()=>{
                                    state.show = false
                                    state.isUpdated = false
                                    }" type="button">
                                    <XMarkIcon class="text-white size-4" />
                                </button>
                            </div>
                            <div class="flex flex-col items-center font-semibold text-white text-base my-4">
                                <div>
                                    Update Information
                                </div>
                            </div>
                            <form @submit.prevent="update" class="space-y-6" method="POST">
                                <div>
                                    <label for="name" class="block text-sm/6 font-medium text-white">Name</label>
                                    <div class="mt-2">
                                        <input 
                                        v-model="state.name" 
                                        type="name" 
                                        name="name" 
                                        id="name" 
                                        autocomplete="name"
                                        @focus="()=>{
                                            if(state.errors?.errors?.['name']){
                                                delete state.errors?.errors['name']
                                            }
                                        }" 
                                        class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                        <p class="text-sm text-red-500" v-if="state?.errors?.errors?.name">
                                            {{ state.errors.errors.name[0] }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm/6 font-medium text-white">Email address</label>
                                    <div class="mt-2">
                                        <input 
                                        v-model="state.email" 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        autocomplete="email"
                                        @focus="()=>{
                                            if(state.errors?.errors?.['email']){
                                                delete state.errors?.errors['email'] 
                                            }
                                        }"
                                        class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                        <p class="text-sm text-red-500" v-if="state?.errors?.errors?.email">
                                            {{ state.errors.errors.email[0] }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
                                            <div class="text-sm">
                                            </div>
                                        </div>
                                    <div class="mt-2">
                                        <input 
                                        v-model="state.password" 
                                        type="password" 
                                        name="password" 
                                        id="password" 
                                        @focus = "()=>{
                                            if(state.errors?.errors?.['password']){
                                                delete state.errors?.errors['password'] 
                                            }
                                        }"
                                        autocomplete="current-password" 
                                        class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                        <p class="text-sm text-red-500" v-if="state?.errors?.errors?.password">
                                            {{ state.errors.errors.password[0] }}
                                        </p>
                                    </div>
                                </div>
            
                                <div>
                                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 outline outline-gray-100 w-5/12 flex flex-col items-center rounded-lg p-5 shadow-2xl">
                    <div class="w-full flex mb-10">
                        <div>
                            <button @click="async()=>{
                                await changeUserStatus()
                                fetchCurrentUser()
                            }" 
                            type="button" v-if="state.currentUser.status === 'Active'" 
                            class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium  ring-1 ring-inset">
                                <ShieldExclamationIcon class="size-4 mr-1"/>
                                Deactivate Account
                            </button>
                            <button @click="async()=>{
                                await changeUserStatus()
                                fetchCurrentUser()
                            }" 
                            type="button" v-else 
                            class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium  ring-1 ring-inset">
                                <ShieldCheckIcon class="size-4 mr-1"/>
                                Activate Account
                            </button>
                        </div>
                        <div class="ml-auto">
                            <span v-if="state.currentUser.status === 'Active'" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                            <span v-else class="inline-flex items-center rounded-md bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">Inactive</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <p class="text-xl font-medium text-gray-600">{{ state.currentUser.name }}</p>
                        <p class="text-sm font-medium text-gray-600">{{ state.currentUser.email }}</p>
                    </div>
                    <div class="my-10">
                        <button @click="state.show = true" type="button" class="rounded-full bg-gray-800 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800">
                            Edit profile
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </NuxtLayout>
</template>

<script setup lang="ts">
import { userService } from '~/components/api/UserService';
import { ShieldCheckIcon, ShieldExclamationIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { CheckCircleIcon } from '@heroicons/vue/20/solid';

const state = reactive({
    name:'',
    email:'',
    password:'',
    currentUser: [] as any,
    errors: [] as any,
    isUpdated:false,
    show: false,
})

onMounted(async()=>{
    await fetchCurrentUser()
    state.name = state.currentUser.name
    state.email = state.currentUser.email
})

async function fetchCurrentUser() {
    try{
        const response = await userService.getCurrentUser()
        if(response){
            state.currentUser = response.data
        }
    }catch(error){}
}

async function changeUserStatus() {
    try{
        const response = await userService.changeUserStatus(state.currentUser.id)
    }catch(error){}
}

async function update() {
    try{
        let canUpdate = false
        const param = {
            name: state.currentUser.name,
            email: state.currentUser.email,
            password: state.currentUser.password
        }
        if(state.name.trim().length !== 0 && state.name !== param.name){
            param.name = state.name
            canUpdate = true
        }
        if(state.email.trim().length !== 0 && state.email !== param.email){
            param.email = state.email
            canUpdate = true
        }
        if(state.password.trim().length !== 0){
            param.password = state.password
            canUpdate = true
        }
        if(canUpdate){
            const response = await userService.updateUser(state.currentUser.id, param);
            if(response){
                state.currentUser = response.data
                state.isUpdated = true
            }
        }
        
    }catch(error){}
}
</script>