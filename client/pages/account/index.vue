<template>
    <NuxtLayout name="main">
        <template #header>
            <p  class="text-3xl font-bold tracking-tight text-white">Dashboard</p>
        </template>
        <template #main>
            
            <div class="h-fit p-8">
                <div class="bg-gray-900 rounded-md py-24 sm:py-32">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
                            <div v-for="stat in state.stats" :key="stat.id" class="mx-auto flex max-w-xs flex-col gap-y-4">
                                <dt class="text-base/7 text-gray-400">{{ stat.name }}</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white sm:text-5xl">{{ stat.value }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </template>
    </NuxtLayout>
    
</template>

<script setup lang="ts">
import { userService } from '~/components/api/UserService';


const state = reactive({
    stats: [
        { id: 1, name: 'Current Users', value: '' },
        { id: 2, name: 'Active Users', value: '' },
        { id: 3, name: 'Deactivated Users', value: '' },
    ]
})

onMounted(()=>{
    fetchUsers()
    fetchUsersByActive('Active')
    fetchUsersByActive('Inactive')
})

async function fetchUsers() {
    try{
        const response = await userService.getAllUser()
        if(response){
            state.stats[0].value = response.data.length
        }
    }catch(error){}
}
async function fetchUsersByActive(active: string) {
    try{
        const response = await userService.getUserByActive(active)
        if(response){
            if(active === 'Active'){
                state.stats[1].value = response.data.length
            }
            if(active === 'Inactive'){
                state.stats[2].value = response.data.length
            }
        }
    }catch(error){}
}
</script>
