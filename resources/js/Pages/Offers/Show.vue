<template>
    <AuthenticatedLayoutVue>
        <Head title="Create Offer" />
        {{offer}}
  
        <form @submit.prevent="submit">
  
            <div>
                <InputLabel for="comment" value="comment" />
                <TextInput id="comment" type="text" class="mt-1 block w-full" v-model="form.comment" required autofocus   />
                <InputError class="mt-2" :message="form.errors.comment" />
            </div>
       
  
  
  
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create
                </PrimaryButton>
            </div>
        </form>
  
        <div v-if="offer.partner.user_id==`${$page.props.auth.user.id}`">
              <button @click="destroy()">Delete</button>
              <a :href="`/offer/${this.offer.id}/edit`">Edit</a>
  
           </div>
    </AuthenticatedLayoutVue>
  </template>
  
  
  <script>
  
  import InputError from '@/Components/InputError.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import TextInput from '@/Components/TextInput.vue';
  import { Head } from '@inertiajs/inertia-vue3';
  import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
  
  
  
  
  export default {
      components:{
          InputError,
          InputLabel,
          PrimaryButton,
          TextInput,
          AuthenticatedLayoutVue
      },
  
      props :{
          offer:Object
      },
      data(){
  
        return {
           form:this.$inertia.form({
          
            id:`${this.offer.id}`,
            comment:'',
           })
          }
      },
  
      
    methods: {
       
      destroy() {
        if (confirm('Are you sure you want to delete this offer?')) {
          this.$inertia.delete(`/offer/${this.offer.id}`)
        }
      },
  
    }
  
  }
  </script>
  