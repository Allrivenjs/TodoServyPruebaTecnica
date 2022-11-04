<script setup>
import { storeToRefs } from 'pinia';

import { useBusinessesStore } from '@/stores';
import BusinessList from "@/components/BusinessList.vue";

const businessesList = useBusinessesStore();
const { businesses } = storeToRefs(businessesList);

businessesList.getAll();

console.log(businesses);
</script>

<template>
  <div class="flex justify-center items-center h-screen w-full ">
    <div class="flex flex-col gap-y-10">
      <div>
        <h1 class="font-semibold text-4xl ">CRUD de negocios</h1>
      </div>
      <BusinessList :businesses="businesses" />
    </div>
  </div>
</template>