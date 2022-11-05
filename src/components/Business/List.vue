<script setup>
 import BussinessEdit from "@/components/Business/Edit.vue";
 import {useBusinessesStore, useModalStore} from "@/stores";
 import {storeToRefs} from "pinia";

 const businessesList = useBusinessesStore();
 const { businesses } = storeToRefs(businessesList);

 businessesList.getAll();
 const deleteBusiness = (i) => {
   businessesList.delete(i);
 }
 const open = (i) => {
   modelStore.change(i);
 }
 const modelStore = useModalStore();

</script>
<template>
  <div class="flex flex-col gap-y-2 justify-center items-center w-auto	">
    <div v-for="i in businesses" :key="i.id"
        class="flex font-semibold text-gray-400  justify-between items-center  border border-gray-600 py-2 px-6 text-gray-600  w-full rounded rounded-2xl">
      <router-link :to="'businesses/'+i.id" class="w-full">
        {{ i.name }}
      </router-link>
      <div class="flex gap-y-2 w-10">
        <a @click="open(i)" class="material-icons text-green-600 cursor-pointer">
          edit
        </a>
        <a @click="deleteBusiness(i.id)" class="material-icons text-red-600 cursor-pointer">
          delete
        </a>
      </div>
    </div>
  </div>
  <BussinessEdit />
</template>

