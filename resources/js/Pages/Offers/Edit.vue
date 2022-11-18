<template>
    <Head :title="HHH" />
     <AuthenticatedLayout>
        <div class="py-12">
          <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
              <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
                <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description" />
                <text-input v-model="form.location" :error="form.errors.location" class="pb-8 pr-6 w-full lg:w-1/2" label="Location"  />
                <text-input v-model="form.category" :error="form.errors.category" class="pb-8 pr-6 w-full lg:w-1/2" type="text"  label="Category" />
                <text-input v-model="form.phone" :error="form.errors.phone" class="pb-8 pr-6 w-full lg:w-1/2" type="text"  label="Phone" />
                <div class="mt-4">
               <input type="file" @input="form.pics = $event.target.files"  :multiple="true" accept="image/*"/>
               <InputError class="mt-2" :message="form.errors.pics" />

            </div>
              </div>
              <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
    
                <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Offer</loading-button>
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
            offer:Object,
        },
        remember: 'form',
        data() {
        return {
          form: this.$inertia.form({
            _method: 'put',
            title: this.offer.title,
            location: this.offer.location,
            description:this.offer.description,
            phone : this.offer.phone,
            category : this.offer.category,
            pics: null,
          }),
        }
      },
      methods: {
        update() {
          this.form.post(`/offer/${this.offer.id}/update`, {
            onSuccess: () => this.form.reset('pics'),
          })
        },}
    
    }
    </script>
    