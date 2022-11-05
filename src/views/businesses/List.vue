<script setup>

import BusinessList from "@/components/Business/List.vue";
import {useModalStore} from "@/stores";

const modelStore = useModalStore();
const open = () => {
  modelStore.change();
}
</script>

<template>
  <div class="flex justify-center items-center h-screen w-full ">
    <div class="flex flex-col gap-y-10 w-4/12">
      <div class="flex flex-col gap-y-2">
        <h1  class="flex justify-between   items-center font-semibold text-4xl ">
          Negocios
          <button @click="open" class="material-icons text-blue-600">
            add_box
          </button>
        </h1>
      </div>
      <BusinessList />
    </div>
  </div>
</template>