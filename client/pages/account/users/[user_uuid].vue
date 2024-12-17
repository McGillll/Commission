<template>
    <NuxtLayout name="main">
        <template #header>
            <p  class="text-3xl font-bold tracking-tight text-white">Profile</p>
        </template>
        <template #main>
            <div class="w-full flex justify-center">
                <div class="bg-gray-50 outline outline-gray-100 w-5/12 flex flex-col items-center rounded-lg p-5 shadow-2xl">
                    <div class="w-full flex mb-10">
                        <div class="ml-auto">
                            <span v-if="state.user.status === 'Active'" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                            <span v-else class="inline-flex items-center rounded-md bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">Inactive</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <p class="text-xl font-medium text-gray-600">{{ state.user.name }}</p>
                        <p class="text-sm font-medium text-gray-600">{{ state.user.email }}</p>
                    </div>
                    <div class="my-10">
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
    user: [] as any,
})

const router = useRouter()
const userUuid = router?.currentRoute?.value?.params?.user_uuid 

onMounted(()=>{
    fetchUser()
})

async function fetchUser() {
    try{
        const response = await userService.getUser(userUuid);
        if(response){
            state.user = response.data
        }
    }catch(error){

    }
}
</script>