<script setup>
import { Form, Field } from 'vee-validate';
import * as Yup from 'yup';
import { useRoute } from 'vue-router';
import { storeToRefs } from 'pinia';

import { useBusinessesStore, useAlertStore } from '@/stores';
import router from '@/router';

const businessesStore = useBusinessesStore();
const alertStore = useAlertStore();
const route = useRoute();
const id = route.params.id;

let title = 'Add Business';
let business = null;
if (id) {
  // edit mode
  title = 'Edit Business';
  ({ business } = storeToRefs(businessesStore));
  businessesStore.getById(id);
}

const schema = Yup.object().shape({
  name: Yup.string()
      .required('Nombre es requerido'),
  about_it: Yup.string()
      .required('Acerca de es requerido'),
  phone: Yup.string()
      .required('Telefono es requerdio'),
  photo: Yup.string()
      .transform(x => x === '' ? undefined : x)
      // password optional in edit mode
      .concat(business ? null : Yup.string().required('Foto es requerida')),
});

async function onSubmit(values) {
  try {
    let message;
    if (business) {
      await businessesStore.update(user.value.id, values)
      message = 'business actulizado';
    } else {
      await businessesStore.store(values);
      message = 'business creado';
    }
    await router.push('/businesses');
    alertStore.success(message);
  } catch (error) {
    alertStore.error(error);
  }
}
</script>

<template>
  <h1>{{title}}</h1>
  <template v-if="!(business?.loading || business?.error)">
    <Form @submit="onSubmit" :validation-schema="schema" :initial-values="business" v-slot="{ errors, isSubmitting }">
      <div class="form-row">
        <div class="form-group col">
          <label>Nombre</label>
          <Field name="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }" />
          <div class="invalid-feedback">{{ errors.name }}</div>
        </div>
        <div class="form-group col">
          <label>Phone</label>
          <Field name="username" type="text" class="form-control" :class="{ 'is-invalid': errors.phone }" />
          <div class="invalid-feedback">{{ errors.phone }}</div>
        </div>

      </div>
      <div class="form-row">
        <div class="form-group col">
          <label>Acerca de</label>
          <Field name="lastName" type="text" class="form-control" :class="{ 'is-invalid': errors.about_it }" />
          <div class="invalid-feedback">{{ errors.about_it }}</div>
        </div>
        <div class="form-group col">
          <label>
            Imagen
            <em v-if="business">(Leave blank to keep the same password)</em>
          </label>
          <Field name="photo" type="image"  class="form-control" :class="{ 'is-invalid': errors.photo }" />
          <div class="invalid-feedback">{{ errors.photo }}</div>
        </div>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" :disabled="isSubmitting">
          <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
          Save
        </button>
        <router-link to="/businesses" class="btn btn-link">Cancel</router-link>
      </div>
    </Form>
  </template>
  <template v-if="business?.loading">
    <div class="text-center m-5">
      <span class="spinner-border spinner-border-lg align-center"></span>
    </div>
  </template>
  <template v-if="business?.error">
    <div class="text-center m-5">
      <div class="text-danger">Error al cargar negocio: {{business.error}}</div>
    </div>
  </template>
</template>