<template>
  <AuthenticatedLayoutVue>
      <Head title="Create post" />
      {{post}}

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

      <div v-if="post.username==`${$page.props.auth.user.username}`">
            <button @click="destroy()">Delete</button>

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
        post:Object
    },
    data(){

      return {
         form:this.$inertia.form({
        
          id:`${this.post.id}`,
          comment:'',
         })
        }
    },

    
  methods: {
     
    submit(){
      this.form.post('/post/comm',{
        onSuccess: () => this.form.comment = '',
      });
    },
    destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        this.$inertia.delete(`/post/${this.post.id}`)
      }
    },

  }

}
</script>
