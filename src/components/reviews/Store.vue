<template>
  <div class="w-1/3 flex flex-col  gap-y-6 ">
    <div class=" mb-2 shadow-lg rounded-t-8xl rounded-3xl rounded-b-5xl overflow-hidden">
      <div class="pt-3 pb-3 md:pb-1 px-2 md:px-4 bg-gray-200 bg-opacity-40">
        <div class="flex flex-wrap  py-2 items-center">
          <span class="text-semibold ">Nueva reseña</span>
          <div class="w-full md:w-px  md:h-8 mx-4 bg-transparent md:bg-gray-200"></div>
          <span class="mr-4 text-xl mt-1.5 font-heading font-medium"></span>
          <div class="inline-flex">
            <star-rating class="flex" @rating-selected="star_select"  :read-only="false" />
          </div>
        </div>
      </div>
      <Form id="form" @submit="onSubmit" :validation-schema="schema" v-slot="{ errors, isSubmitting, values  }" >
        <Field name="comment" as="textarea" id="message" rows="4" class="block p-2.5 py-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500
        focus:border-blue-500"
                  placeholder="Your message..."></Field>
        <div class="invalid-feedback mt-2 text-sm text-red-400 font-semibold">{{ errors.comment }}</div>
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
          <button :disabled="isSubmitting"
                  class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
            <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
            Enviar
          </button>
        </div>
      </Form>
    </div>
  </div>
</template>

<script setup>
import StarRating from "@/components/StarRating.vue";
import { Form, Field } from 'vee-validate';
import * as Yup from "yup";
import {storeToRefs} from "pinia";
import {useReviewsStore} from "@/stores";
const reviewsList = useReviewsStore();
const { reviews } = storeToRefs(reviewsList);

const props = defineProps({
  business_id: {
    type: Number,
    required: true,
  },
})
let starC = 0;

const schema = Yup.object().shape({
  comment: Yup.string().required('Comentario es requerido'),

});
const star_select = (star) => {
  starC = star();
}

const onSubmit = (values) => {
  const { comment } = values;
  const { business_id } = props;
  starC === 0 ? starC = 1 : starC;
  const send = JSON.stringify({comment, stars:starC, business_id})
  const headers = {
    'Content-Type': 'application/json',
  }
  reviewsList.store(send, headers);
  //sleep 1 second
  setTimeout(() => {
    reviewsList.getAll(business_id);
  }, 500);
}

</script>

