<template>
  <Head :title="Posts"/>
  <AuthenticatedLayout>
<div class="py-12">
    <search-filter-vue v-model="form.search"></search-filter-vue>

</div>
<div>{{posts}}</div>
  </AuthenticatedLayout>
</template>



<script>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3'
import pickBy from 'lodash.pickby'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination.vue';
import SearchFilterVue from '@/Shared/SearchFilter.vue';







export default {
    components :{
        Head,Link,Pagination,SearchFilterVue,

         AuthenticatedLayout,
    },
    props :{
        filters: Object,
     posts : Object,
    },
    data() {
    return {
      form: {
        search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/dashboard', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },


}

</script>
