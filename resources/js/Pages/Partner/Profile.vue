<template>
    <Head :title="`${$page.props.user.name}`" />
     <AuthenticatedLayout>
        <div class="py-12">
          <div class="flex justify-start mb-8 max-w-3xl">
            <h1 class="text-3xl font-bold">
              {{ form.name }}
              {{user.partner}}
            </h1>
            <img v-if="user.pic" class="block ml-4 w-8 h-8 rounded-full" :src="user.pic" />
          </div>
          <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
              <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
                <text-input v-model="form.username" :error="form.errors.username" class="pb-8 pr-6 w-full lg:w-1/2" label="Username" />
                <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" autocomplete="username" />
                <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />

              </div>
             
            </form>
          </div>
        </div>
    </AuthenticatedLayout>
    </template>
    
    <script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link} from '@inertiajs/inertia-vue3';
    import TextInput from '@/Shared/TextInput.vue'
    import FileInput from '@/Shared/FileInput.vue'
    import LoadingButton from '@/Shared/LoadingButton.vue'
    
    
    
    
    export default {
        components:{
             FileInput,
             Head,
             Link,
             LoadingButton,
            //  SelectInput,
             TextInput,
             AuthenticatedLayout,
        },
    
        props :{
            user:Object,
        },
        remember: 'form',
        data() {
        return {
          form: this.$inertia.form({
            _method: 'put',
            name: this.user.name,
            email: this.user.email,
            username:this.user.username,
            password: '',
            pic: null,
          }),
        }
      },
      methods: {
        update() {
          this.form.post(`/profile/${this.user.id}/update`, {
            onSuccess: () => this.form.reset('password', 'pic'),
          })
        },}
    
    }
    </script>
    