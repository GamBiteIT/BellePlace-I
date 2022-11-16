<template>
    <Head :title="pdare" />
     <AuthenticatedLayout>
        <div class="py-12">
          <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="update">
              <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
                <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description" />
                <text-input v-model="form.location" :error="form.errors.location" class="pb-8 pr-6 w-full lg:w-1/2" label="Location"  />
                <text-input v-model="form.tags" :error="form.errors.tags" class="pb-8 pr-6 w-full lg:w-1/2" type="text"  label="Tags" />
                <div class="mt-4">
               <input type="file" @input="form.pics = $event.target.files"  :multiple="true" accept="image/*"/>
               <InputError class="mt-2" :message="form.errors.pics" />

            </div>
              </div>
              <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
    
                <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update User</loading-button>
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
        post:Object
    },
    remember: 'form',
    data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        title : this.post.title,
        description : this.post.description,
        categories : this.post.categories,
        location : this.post.location,
        tags: this.post.tags,
        rate : this.post.rate,
        pics : null,

        
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/post/${this.post.id}/update/`, {
        onSuccess: () => this.form.reset( 'pics'),
      })
    },}

}
</script>
