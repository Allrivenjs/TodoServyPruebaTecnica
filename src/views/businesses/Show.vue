<template>
  <div class="flex justify-center py-20 h-screen w-full ">
    <div class="flex flex-col">
      <div class="flex gap-y-2">
        <div class="container mx-auto px-4 md:px-12">
          <div class="flex -mx-1 ">
            <!-- Column -->
            <div class="my-1 px-1 w-full h-screen" >
              <!-- Article -->
              <article class="overflow-hidden rounded-lg shadow-lg">
                <a href="#">
                  <img alt="Placeholder" class="block h-auto w-full max-h-96 object-cover" :src="business.images?.url">
                </a>
                <header class="flex items-center justify-between leading-tight p-3 ">
                  <h1 class="text-lg">
                    <a class="no-underline hover:underline text-black" >
                      {{business.name}}
                    </a>
                  </h1>
                  <p class="text-grey-darker text-sm">
                    {{business.created_at}}
                  </p>
                </header>
                <div class="flex items-start gap-y-2 flex-col p-3">
                  <div class="flex justify-between gap-x-24 ">
                    <p class="text-grey-darker flex text-sm">
                      Telefono:  {{business.phone}}
                    </p>
                    <star-rating class="flex" :item-rating="business.stars" :reviews_count="business.reviews_count"/>
                  </div>
                  <div class="w-full border-b border-gray-300"></div>
                  <p class="text-grey-darker text-sm ">
                    Acerca de:  {{business.about_it}}
                  </p>
                </div>
                <footer class="flex items-center justify-between leading-none p-2 md:p-4">
                  <a class="flex items-center no-underline hover:underline text-black" href="#">
                    <img alt="Placeholder" class="block rounded-full" src="https://picsum.photos/32/32/?random">
                    <p class="ml-2 text-sm">
                      {{ business.user?.name }}
                    </p>
                  </a>
                  <a class="no-underline text-grey-darker hover:text-red-dark" href="#">
                    <span class="hidden">Like</span>
                    <i class="fa fa-heart"></i>
                  </a>
                </footer>

              </article>
              <!-- END Article -->

            </div>
            <!-- END Column -->
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script setup>

import {useBusinessesStore} from "@/stores";
import {storeToRefs} from "pinia";
import router from "@/router";

const businessesList = useBusinessesStore();
const { business } = storeToRefs(businessesList);
const { id } = router.currentRoute.value.params;
businessesList.getById(id);
</script>

