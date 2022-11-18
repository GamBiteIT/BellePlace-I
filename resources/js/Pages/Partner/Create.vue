<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm,  SelectInput } from '@inertiajs/inertia-vue3';

const form = useForm({

    placeName: '',
     location: '',
     category: '',
     phone: '',
   
});

const submit = () => {
    form.post(route('partner.create'), {
        onFinish: () => form.reset('placeName'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register Parnter" />

        <form @submit.prevent="submit">

            <div>
                <InputLabel for="placeName" value="PlaceName" />
                <TextInput id="placeName" type="text" class="mt-1 block w-full" v-model="form.placeName" required autofocus  />
                <InputError class="mt-2" :message="form.errors.placeName" />
            </div>

            <div>
                <InputLabel for="location" value="Location" />
                <TextInput id="location" type="text" class="mt-1 block w-full" v-model="form.location" required   />
                <InputError class="mt-2" :message="form.errors.location" />
            </div>

            <div>
                <InputLabel for="category" value="Category" />
                <TextInput id="category" type="text" class="mt-1 block w-full" v-model="form.category" required   />
                <InputError class="mt-2" :message="form.errors.category" />
            </div>
            <div>
                <InputLabel for="phone" value="Phone" />
                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required   />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>



 



           
            <div class="flex items-center justify-end mt-4">

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
