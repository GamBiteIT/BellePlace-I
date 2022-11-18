<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm,  SelectInput } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({

    title: '',
    location : '',
    category: 'hello',
    pics: [],
    description: '',
    phone:'0540161398',
});

const submit = () => {
    form.post(route('offers.create'), {
        onFinish: () => form.reset('pics'),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create Offer" />

        <form @submit.prevent="submit">

            <div>
                <InputLabel for="title" value="Title" />
                <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required autofocus   />
                <InputError class="mt-2" :message="form.errors.title" />
            </div>
            <div>
                <InputLabel for="location" value="location" />
                <TextInput id="location" type="text" class="mt-1 block w-full" v-model="form.location" required  />
                <InputError class="mt-2" :message="form.errors.location" />
            </div>

            <div>
                <InputLabel for="description" value="Description" />
                <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" required   />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>
            <div class="mt-4">
               <input type="file" @input="form.pics = $event.target.files"  :multiple="true" accept="image/*"/>
               <InputError class="mt-2" :message="form.errors.pics" />

            </div>




            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create Offer
                </PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
