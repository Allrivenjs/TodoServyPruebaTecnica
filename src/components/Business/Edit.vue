<script setup>
import { Form, Field } from 'vee-validate';
import {useBusinessesStore, useModalStore} from "@/stores";
import * as Yup from "yup";
import { ref } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {storeToRefs} from "pinia";


const schema = Yup.object().shape({
  name: Yup.string().required('Nombre es requerido'),
  phone: Yup.string().required('Telefono es requerido'),
  about_id: Yup.string().required('Acerca de es requerido'),
});

let namePhoto = ref(null);
const modelStore = useModalStore();
const { openModal, data } = storeToRefs(modelStore);
const businessesList = useBusinessesStore();

const onclose = () =>{
  modelStore.change();
  namePhoto.value = null;
}

async function onSubmit(values) {
  const businessesEdit = useBusinessesStore();
  const { name, phone ,about_it, images } = values;

  const send = new FormData();
  send.append('name', name);
  send.append('about_it', about_it);
  send.append('phone', phone);
  if (images && !images?.url) {
    send.append('image', images);
  }
  const headers = {
    'Content-Type': 'multipart/form-data'
  }
  data.value ? await businessesEdit.update(data.value.id, send, headers ) : await businessesEdit.store(send, headers);
  await businessesList.getAll();
  onclose();
}

function getFile() {
  document.getElementById("upfile").click();
}

function sub() {
  const file = document.getElementById("upfile").files[0];
  namePhoto.value = file.name;
}

</script>
<template>
    <TransitionRoot as="template" :show="openModal">
      <Dialog as="div" class="relative z-10" @close="onclose">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
              <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                <Form id="form" :validation-schema="schema" :initial-values="data" v-slot="{ errors, isSubmitting, values  }" >
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                          <div class="flex flex-col">
                            <label class=" font-semibold text-md  my-3 " >Nombre</label >
                            <Field name="name" type="text" placeholder="Nombre de tu negocio" :class="{ 'is-invalid': errors.name }"
                                   class="border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "

                            />
                            <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.name }}</div>
                          </div>
                          <div class="flex flex-col">
                            <label class=" font-semibold text-md  my-3 " >Telefono:</label >
                            <Field name="phone" type="text" placeholder="Telefono celular" :class="{ 'is-invalid': errors.phone }"
                                   class="border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "

                            />
                            <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.phone }}</div>
                          </div>
                          <div class="flex flex-col">
                            <label class=" font-semibold text-md  my-3 " >Acerca de:</label >
                            <Field name="about_it" as="textarea"  rows="8" placeholder="Cuentanos sobre tu negocio" :class="{ 'is-invalid': errors.about_it }"
                                      class="border-2 border-gray-300 h-auto p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "

                            />
                            <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.about_it }}</div>
                          </div>
                          <div class="flex flex-col ">
                            <label class=" font-semibold text-md  my-3 " >Foto: {{namePhoto}}</label >
                            <div id="yourBtn" @click="getFile()" class="w-full">click to upload a file</div>
                              <div style='height: 0px;width: 0px; overflow:hidden; ' >
                                <Field name="images" id="upfile" type="file" accept="image/*" @change="sub" :class="{ 'is-invalid': errors.images }"
                                       class="border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:border-indigo-500 shadow-sm "
                                />
                                <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.images }}</div>
                              </div>
                            </div>
                      </div>
                      <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button :disabled="isSubmitting" @click="onSubmit(values)"
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                          <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
                          {{ data ? 'Actualizar' : 'Guardar' }}
                        </button>
                        <!--                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="onclose" ref="cancelButtonRef">Cancel</button>-->
                      </div>
                </Form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>





</template>
<style scoped>
#yourBtn {
  position: relative;
  font-family: calibri;
  width: 250px;
  padding: 10px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border: 1px dashed #BBB;
  text-align: center;
  background-color: #DDD;
  cursor: pointer;
}
</style>
