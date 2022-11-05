<template>
<Head :title="Post" />
    <AuthenticatedLayout>

         <div>
            {{post.username}}

           <img :src="`${post.images[1]}`" alt="">
         </div>
         <div v-if="post.username==`${$page.props.auth.user.username}`">
            <button @click="destroy()">Delete</button>

         </div>


    </AuthenticatedLayout>

</template>


<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link} from '@inertiajs/inertia-vue3';
// import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import FileInput from '@/Shared/FileInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'




export default {
    components:{
         FileInput,
         Head,
         Link,
         LoadingButton,
         TextInput,
         AuthenticatedLayout,
    },

    props :{
        post:Object
    },

//     data() {
//   },
  methods: {
    destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        this.$inertia.delete(`/post/${this.post.id}`)
      }
    },
   }

}
</script>
