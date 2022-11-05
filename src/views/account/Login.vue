<script setup>
import { Form, Field } from 'vee-validate';
import * as Yup from 'yup';
import { useAuthStore } from '@/stores';

const schema = Yup.object().shape({
  email: Yup.string().required('Email es requerido'),
  password: Yup.string().required('Password es requerido')
});

async function onSubmit(values) {
  const authStore = useAuthStore();
  const { email, password } = values;
  await authStore.login(email, password);
}
</script>

<template>
<div class="w-full h-screen flex justify-center items-center">

  <div class="flex justify-center items-center shadow-lg p-10 rounded-lg shadow-blue-500/50">
      <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors, isSubmitting }" >
        <div class="flex flex-col">
          <label class=" font-semibold text-md  my-3 " >Email</label >
          <Field name="email" type="email" placeholder="Email" :class="{ 'is-invalid': errors.email }"
            class="border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "
          />
          <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.email }}</div>
        </div>
        <div class="flex flex-col">
          <label class=" font-semibold text-md  my-3 " >Password</label >
          <Field name="password" type="password" placeholder="*********" :class="{ 'is-invalid': errors.password }"
                 class="border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "
          />
          <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.password }}</div>
        </div>
        <div class="flex justify-center items-center">
          <button :disabled="isSubmitting" class="bg-blue-500 text-white px-4 py-2 rounded font-medium w-1/2 my-3" >
            <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
            Login
          </button >
        </div>
      </Form>
  </div>

</div>


</template>