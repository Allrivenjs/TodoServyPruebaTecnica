<script setup>
import { Form, Field } from 'vee-validate';
import {useBusinessesStore} from "@/stores";
import * as Yup from "yup";

const schema = Yup.object().shape({
  email: Yup.string().required('Email is required'),
  password: Yup.string().required('Password is required')
});

async function onSubmit(values) {
  const businessesEdit = useBusinessesStore();
  const { name, about_it, phone, images } = values;
  await businessesEdit.store({name, about_it, phone, images});
}

</script>



<template>
  <div class="w-full h-screen flex justify-center items-center">

    <div class="flex justify-center items-center shadow-lg p-10 rounded-lg shadow-blue-500/50">
      <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors, isSubmitting }" >
        <div class="flex flex-col">
          <label class=" font-semibold text-md  my-3 " >Email</label >
          <Field name="name" type="text" placeholder="Email" :class="{ 'is-invalid': errors.name }"
                 class="border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "
          />
          <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.name }}</div>
        </div>
        <div class="flex flex-col">
          <label class=" font-semibold text-md  my-3 " >Password</label >
          <textarea name="about_it" type="text"  :class="{ 'is-invalid': errors.about_it }"
                 class="border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "
          />
          <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.about_it }}</div>
        </div>
        <div class="flex justify-center items-center">
          <button :disabled="isSubmitting" class="bg-blue-500 text-white px-4 py-2 rounded font-medium w-1/2 my-3" >
            <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
            Crear
          </button >
        </div>
      </Form>
    </div>

  </div>


</template>

