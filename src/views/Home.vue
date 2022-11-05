<script setup>
import {storeToRefs} from "pinia";
import {useBusinessesStore} from "@/stores";
import StarRating from "@/components/StarRating.vue";



const businessesList = useBusinessesStore();
const { businesses } = storeToRefs(businessesList);
businessesList.getAll();



</script>

<template>
  <!-- component -->
  <div class="flex justify-center py-20 h-screen w-full ">
    <div class="flex flex-col">
      <div class="flex gap-y-2">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-wrap  ">
              <!-- Column -->
              <router-link :to="'businesses/'+i.id" v-for="i in businesses" :key="i.id"

                 class="my-1 px-1 w-full " :class="businesses.length > 1 ? 'lg:w-1/2' : ''"  >

                <!-- Article -->
                <article class="overflow-hidden rounded-lg shadow-lg">
                  <a href="#">
                    <img alt="Placeholder"  class="block h-auto w-full max-h-96 object-cover" :src="i.images?.url">
                  </a>
                  <header class="flex items-center justify-between leading-tight p-3 ">
                    <h1 class="text-lg">
                      <a class="no-underline hover:underline text-black text-2xl" >
                        {{i.name}}
                      </a>
                    </h1>
                    <p class="text-grey-darker text-sm">
                      {{i.created_at}}
                    </p>
                  </header>
                  <div class="flex items-start gap-y-2 flex-col p-3">
                    <div class="flex justify-between w-full gap-x-24 ">
                      <p class="text-grey-darker flex text-sm">
                         Telefono:  {{i.phone}}
                      </p>
                      <star-rating class="flex" :item-rating="i.stars" :reviews_count="i.reviews_count"/>
                    </div>
                    <div class="w-full border-b border-gray-300"></div>
                    <p class="text-grey-darker break-all  text-sm ">
                      Acerca de:  {{i.about_it.substring(0, 80)}}...
                    </p>
                  </div>
                  <footer class="flex items-center justify-between leading-none p-2 md:p-4">
                    <a class="flex items-center no-underline hover:underline text-black" href="#">
                      <img alt="Placeholder" class="block rounded-full" src="https://picsum.photos/32/32/?random">
                      <p class="ml-2 text-sm">
                        {{ i.user?.name }}
                      </p>
                    </a>
                    <a class="no-underline text-grey-darker hover:text-red-dark" href="#">
                      <span class="hidden">Like</span>
                      <i class="fa fa-heart"></i>
                    </a>
                  </footer>




                </article>
                <!-- END Article -->

              </router-link>
              <!-- END Column -->
            </div>
            </div>
      </div>
    </div>
  </div>
</template>


