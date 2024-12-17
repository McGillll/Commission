<template>
    <!--
      This example requires updating your template:
  
      ```
      <html class="h-full bg-gray-900">
      <body class="h-full">
      ```
    -->

    <NuxtLayout name="home">

        
        <div class="h-screen bg-gray-900">
            <div class="flex h-full  flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <Notification :show="state.isCreated" @cancel-click="state.isCreated=false"/>
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto object-contain size-20" src="assets/img/vultify.png" alt="Your Company" />
                    <h2 class=" text-center text-2xl/9 font-bold tracking-tight text-white">Register your account</h2>
                </div>
                
                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form @submit.prevent="register" class="space-y-6" method="POST">
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
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
    </div>
</form>

<p class="mt-10 text-center text-sm/6 text-gray-400">
    Already have an account?
    <button @click="navigateTo('login')" class="font-semibold text-indigo-400 hover:text-indigo-300">Login</button>
</p>
</div>
</div>

</div>
</NuxtLayout>
</template>

<script setup lang="ts">
import { authService } from '~/components/api/AuthService';

    
const state = reactive({
    email:'',
    password:'',
    name: '',
    errors:[] as any,
    isCreated: false
})

function clearForm(){
    state.email = ''
    state.password = ''
    state.name = ''
}

async function register() {
    try{
        const param = {
            name: state.name,
            email: state.email,
            password: state.password
        }
        const response = await authService.register(param);
        if(response){
            state.isCreated = true
            clearForm()
        }
    }catch(error: any){
        state.errors = error
    }
}

</script>
  