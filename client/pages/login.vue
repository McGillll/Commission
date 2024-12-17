<template>
    <ClientOnly>

        <NuxtLayout name="home">

            
            <div class="h-screen bg-gray-900">
                <div class="flex min-h-full  flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                        <img class="mx-auto object-contain size-20" src="assets/img/vultify.png" alt="Your Company" />
                        <h2 class=" text-center text-2xl/9 font-bold tracking-tight text-white">Sign in your account</h2>
                </div>
                
                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form @submit.prevent="login" class="space-y-6" method="POST">
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
                }
                " 
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
                    <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
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
                }
                "
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
    Not a member?
    <button @click="navigateTo('register')" class="font-semibold text-indigo-400 hover:text-indigo-300">Create an account</button>
</p>
</div>
</div>

</div>
</NuxtLayout>
</ClientOnly>
</template>

<script setup lang="ts">
import { authService } from '~/components/api/AuthService';

onMounted(async ()=>{
    if(localStorage.getItem('_token')){
        await authService.logout()
        localStorage.clear()
    }
})
    
const state = reactive({
    email:'',
    password:'',
    errors:[] as any
})

async function login() {
    try{
        const param = {
            email: state.email,
            password: state.password
        }
        const response = await authService.login(param);
        if(response){
            localStorage.setItem("_token", response?.token)
            navigateTo('account')
        }
    }catch(error: any){
        state.errors = error
    }
}

</script>
  