<script setup>
 import BussinessEdit from "@/components/BussinessEdit.vue";

 defineProps({
   businesses: {
     type: Array,
     required: true
   }
 })

 let businessEdit = false;


</script>

<template>
  <div class="flex flex-col gap-y-2 justify-center items-center">
    <label class="flex font-semibold text-gray-400  justify-between items-center  border border-gray-600 py-2 px-6 text-gray-600  w-full rounded rounded-2xl"
           v-for="i in businesses " :key="i.id" >
      {{ i.name }}
      <div class="flex gap-y-2">
        <button onclick="" class="material-icons text-green-600">
          edit
        </button>
        <button onclick="" class="material-icons text-red-600">
          delete
        </button>
      </div>
    </label>
  </div>

  <BussinessEdit v-show="businessEdit"/>

</template>

