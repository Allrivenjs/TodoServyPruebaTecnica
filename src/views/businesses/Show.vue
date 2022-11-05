<template>
  <div class="flex justify-center py-20 w-full overflow-y-hidden ">
    <div class="flex  flex-col w-5/6">
      <div class="flex gap-y-2">
        <div class="container mx-auto w-full ">
          <div class="flex -mx-1 h-3/5 ">
            <!-- Column -->
            <div  class="flex w-full my-1 px-1 gap-x-12 " >
              <!-- Article -->
              <div class="w-4/6">
                <article class="  overflow-hidden rounded-lg shadow-lg">
                <a href="#">
                  <img alt="Placeholder"  class="block h-auto w-full max-h-96 object-cover" :src="business.images?.url">
                </a>
                <header class="flex items-center justify-between leading-tight p-3 ">
                  <h1 class="text-lg">
                    <a class="no-underline hover:underline text-black text-2xl" >
                      {{business.name}}
                    </a>
                  </h1>
                  <p class="text-grey-darker text-sm">
                    {{business.created_at}}
                  </p>
                </header>
                <div class="flex items-start gap-y-2 flex-col p-3">
                  <div class="flex justify-between w-full gap-x-24 ">
                    <p class="text-grey-darker flex text-sm">
                      Telefono:  {{business.phone}}
                    </p>
                    <star-rating class="flex" :item-rating="business.stars" :reviews_count="business.reviews_count"/>
                  </div>
                  <div class="w-full border-b border-gray-300"></div>
                  <p class="text-grey-darker break-all text-sm ">
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

                </footer>
              </article>
                <div class="flex  mt-4">
                  <Store :business_id="id"  />
                </div>

              </div>
              <!-- END Article -->

              <!--Reviews-->
              <div class=" w-1/3 h-auto overflow-y-scroll">
                <div class="pr-2 flex flex-col gap-y-4">
                  <div class=" mb-2 shadow-lg rounded-t-8xl rounded-3xl rounded-b-5xl overflow-hidden" v-for="r in reviews">
                    <div class="pt-3 pb-3  pl-4 bg-gray-200 bg-opacity-40">
                      <div class="flex w-full  items-center">
                        <div class="flex flex-wrap w-5/6 ">
                          <img class="mr-6 block rounded-full" src="https://picsum.photos/32/32/?random" alt="{{r.name}}">
                          <h4 class="w-full md:w-auto text-xl font-heading font-medium">{{r.name}}</h4>
                          <div class="w-full md:w-px  md:h-8 mx-4 bg-transparent md:bg-gray-200"></div>
                          <span class="mr-4 pb-0.5 text-xl mt-1.5 font-heading font-medium">{{ r.stars }}</span>
                          <star-rating class="flex pb-1.5" :item-rating="r.stars" />
                        </div>
                        <div class="flex w-1/12 justify-between items-center inline-flex">
                            <span @click="deleteReview(r.id)" class ="material-icons cursor-pointer" v-show="r.user_id === user.user.id ">
                            delete
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="px-4 overflow-hidden md:px-8 pt-6 bg-white">
                      <div class="flex flex-wrap">
                        <div class="w-full md:w-2/3 mb-6 md:mb-0">
                          <p class="mb-8 max-w-2xl text-darkBlueGray-400 leading-loose"> {{ r.comment }}</p>
                        </div>
                        <div class="w-full md:w-1/3 text-right">
                          <p class="mb-8 text-sm text-gray-300">{{ r.created_at }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!--END Reviews-->
            </div>
            <!-- END Column -->
          </div>

        </div>
      </div>
    </div>
  </div>

</template>

<script setup>

import {useAuthStore, useBusinessesStore, useReviewsStore} from "@/stores";
import {storeToRefs} from "pinia";
import router from "@/router";
import StarRating from "@/components/StarRating.vue";
import Store from "@/components/reviews/Store.vue";
const businessesList = useBusinessesStore();
const reviewsList = useReviewsStore();
const { reviews } = storeToRefs(reviewsList);
const { user } = useAuthStore();
const { business } = storeToRefs(businessesList);
const { id } = router.currentRoute.value.params;
businessesList.getById(id);
reviewsList.getAll(id);


const deleteReview = (id) => {
  reviewsList.delete(id);
};

</script>

